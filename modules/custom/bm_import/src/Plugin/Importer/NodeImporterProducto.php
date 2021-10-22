<?php

namespace Drupal\bm_import\Plugin\Importer;

use PDO;
use Drupal\bm_actualdatos\ActualCrearUsuario;
use Drupal\bm_actualdatos\ActualCrearRevision;

/**
 * Class NodeImporter.
 */
class NodeImporterProducto
{

  /**
   * @private
   */
  private $user;

  /**
   * @private
   */  
  private $revision;

  /**
   * @private
   */
  private $rfcs = [];

  /**
   * @private
   */
  private $unregistered_rfcs = [];

  /**
   * @private
   */
  private $node_position = 0;

  /**
   * @private
   */
  private $emails = [];

  /**
   * @private
   */
  private $content = [];

  /**
   * __construct()
   */
  public function __construct()
  {
    $this->user = new ActualCrearUsuario();
    $this->revision = new ActualCrearRevision();
  }

  /**
   * setNodePosition($node_position)
   * 
   * Obtener la posicion del campo nodo (nid) dentro del arreglo csv
   */
  public function setNodePosition($node_position)
  {
    $this->node_position = $node_position;
  }

  /**
   * setRFCS($rfcs)
   * 
   * Obtener el arreglo de rfcs
   *
   */
  public function setRFCS($rfcs)
  {
    $this->rfcs = $rfcs;
    $this->unregistered_rfcs = $rfcs;
  }

  /**
   * setProveedorPosition($proveedor_position)
   * 
   * Obtener la posicion del campo proveedor (field_proveedor) dentro del arreglo csv
   */
  public function setProveedorPosition($proveedor_position)
  {
    $this->proveedor_position = $proveedor_position;
  }

  /**
   * setEmails($emails)
   * 
   * Obtener el arreglo de mails
   *
   */
  public function setEmails($emails)
  {
    $this->emails = $emails;
  }

  /**
   * getContent()
   * 
   * Obtener el arreglo a partir de getNodes() y getUsers()
   */
  public function getContent() {

    // Buscar los nodos a partir de los rfcs
    $this->findNodes();

    // Si hay rfcs sin nodos
    if ($this->isUnregistered()) {
      // Crea los usuarios a partir de los emails comparados con los rfcs que no existen registrados
      $this->createNewUsers();
    } // end if

    // Busca todos los usuarios a partir de los emails
    $this->findUsers();

    return $this->content;
  }

  /**
   * Obtener los id de nodo en la posicion correspindiente a la columna de nid en el arreglo csv
   */
  public function findNodes()
  {
    try {

      // Listado de todos los rfcs registrados en el tipo de contenido "user_revision"
      $nodes = $this->getNIDByRegisteredRFCs();

      if (count($nodes)) {
        // Si tiene nids se ciclan los valores 
        foreach ($nodes as $node) {

          // Utilizando el campo de "field_dc_rfc_value" buscamos la posicion del valor del "rfc" en el arreglo $this->rfcs
          $key = array_search($node['field_dc_rfc_value'], $this->rfcs);

          // Una vex obtenida la posicion la agregamos al arreglo contenido el cual posteriormete se unira con el arreglo principal en la misma posicion de nid del arreglo csv
          $this->content[$key][$this->node_position] = $node['nid'];

          // Borramos del arreglo "unregistered_rfcs" la posicion actual, puesto que si existe el valor
          // El arreglo "unregistered_rfcs" registrara todos los rfcs que no estan registrados en el tipo de contenido "user_revision"
          unset($this->unregistered_rfcs[$key]);
        } // end foreach

      } else {
        // En caso de haber un solo registro pero este no se encuentra registrado se procede a generar el usuario y posteriomente el nodo
        // con los valores de email y rfc

        // Crear usuario
        // Para los arrglos $this->rfcs y $this->emails, siempre se inicializa en la posicion 1, puesto que la posicion 0 siempre sera la primera fila con los valores de los identificadores de campos en el csv
        $this->user->setFields([
          'ct_email' => $this->emails[1], // Se obtiene el email del arreglo $this->emails
          'usr_password_confirmacion' => user_password(), // Se genera un password aleatorio para el nuevo usuario
        ]);
        $uid = $this->user->crearUsuario();

        // Crear nodo
        $this->revision->setCampos(['dc_razon_social' => $this->rfcs[1], 'dc_rfc' => $this->rfcs[1]]);
        $this->revision->setIDUsuario($uid);
        $nid = $this->revision->crearRevision();

        // Adignamos el nodo a la unica posicion que posteriomente sea unida al arreglo principal en la misma posicion del archivo csv
        $this->content[1][$this->node_position] = $nid;

      } // end if

    } catch (\Exception $e) {
      print_r($e->getMessage());
    } // end try catch    

    return;
  }

  /**
   * findUsers()
   * 
   * Obtener los id de usuario en la posicion correspindiente a la columna de field_proveedor en el arreglo csv
   */
  public function findUsers()
  {
    $users = $this->getUIDReisteredEmails();

    if (count($users)) {
      foreach ($users as $user) {

        // Utilizando el campo de "mail" buscamos la posicion del valor del "email" en el arreglo $this->emails
        $key = array_search($user['mail'], $this->emails);

        // Una vex obtenida la posicion la agregamos al arreglo contenido el cual posteriormete se unira con el arreglo principal en la misma posicion de nid del archivo csv
        $this->content[$key][$this->proveedor_position] = $user['uid'];
      } // end foreach        
    } // end if

    return;
  }

  /**
   * isUnregistered()
   * 
   * Valida si existe rfcs que no estan registrados en el tipo de contenido "user_revision" 
   * que previamente fueron registrados en el metodo findNodes()
   * 
   * @see findNodes()
   */
  public function isUnregistered()
  {

    $unregistered = FALSE;

    if (count($this->unregistered_rfcs) >= 1) {
      $unregistered = TRUE;
    } // end if

    return $unregistered;
  }

  /**
   * createNewUsers()
   * 
   * Crea los usuarios a partir de los rfc que no existen en el tipo de contenido "user_revision" 
   * 
   * @see Drupal\bm_actualdatos\ActualCrearUsuario
   */
  public function createNewUsers()
  {
    try {
      // S
      foreach ($this->unregistered_rfcs as $ukey => $urfc) {

        $this->content[$ukey][$this->node_position] = 0;

        // Crear Usuario
        $this->user->setFields([
          'ct_email' => $this->emails[$ukey],
          'usr_password_confirmacion' => user_password(),
        ]);

        $this->user->crearUsuario();
      } // end foreach

    } catch (\Exception $e) {
    } // end try - catch

  }

  /**
   * getNIDByRegisteredRFCs
   * 
   * Se genera una consulta hacia el tipo de contenido "user_revision"
   * que contengan los valores de rfc del arreglo $this->rfcs
   * devolviendo los nid (id nodo) relacionados
   * 
   * @see $this->rfcs
   * 
   */
  private function getNIDByRegisteredRFCs()
  {

    $resultados = [];
    try {
      $query = \Drupal::database()->select('node', 'n')
        ->fields('n', ['nid'])
        ->fields('frfc', ['field_dc_rfc_value']);

      $query->leftJoin('node__field_dc_rfc', 'frfc', 'frfc.entity_id = n.nid');

      $query->condition('frfc.field_dc_rfc_value', $this->rfcs, 'IN');

      $resultados = $query->execute()
        ->fetchAll(PDO::FETCH_ASSOC);
    } catch (\Exception $e) {
    } // end try - catch

    return $resultados;
  }

  /**
   * getUIDReisteredEmails()
   * 
   * Se genera una consulta hacia el tipo de contenido "user_revision"
   * que contengan los valores de rfc del arreglo $this->emails
   * devolviendo los uid (id usuario) relacionados
   * 
   * @see $this->emails
   * 
   */
  private function getUIDReisteredEmails()
  {
    $uids = [];
    try {
      $query = \Drupal::database()->select('users_field_data', 'ufd')
      ->fields('ufd', ['uid', 'mail']);

    $query->condition('ufd.mail', $this->emails, 'IN');

    $uids = $query->execute()
      ->fetchAll(PDO::FETCH_ASSOC);

    } catch (\Exception $e) {      
    } // end try -catch

    return $uids;
  }

}
