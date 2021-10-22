<?php

namespace Drupal\bm_actualizardatos;

use Drupal\node\Entity\Node;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class ActualEditar
 *
 * @package Drupal\bm_actualizardatos
 *
 *
 */
class ActualEditar {

  /**
   * @var int
   */
  private $uid = 0;

  /**
   * @var array
   */  
  private $fields = [];

  /**
   * @var int
   */
  private $result = 0;

  /**
   * @var int
   */
  private $nid = 0;

  /**
   * ActualEditar constructor.
   *
   * @param $uid
   */
  function __construct($nid = 0, $uid = 0, $fields = []) {
    $this->uid = $uid;
    $this->nid = $nid;
    $this->fields = $fields;
  }    

  /**
   * EditarUsuario
   *
   * @param $uid
   * @param $fieldsg
   */  
  public function EditarProveedor() {

    try {

      $node = Node::load($this->nid);
    
      foreach ($this->fields as $key => $field_value) {
        $field_name = "field_". $key;
        if ($node->hasField($field_name)) {
            $node->set('field_' . $key, $field_value);
        } // end if
      } // end foreach

      // Actualizacion del autor (requerido para validar el contenido a desplegar en caso de haber revision)
      $node->setNewRevision(TRUE);
      $node->revision_log = 'Created revision for node' . $this->nid;
      $d = \DateTime::createFromFormat(
        'd-m-Y H:i:s',
        date('d-m-Y H:i:s'),
        new \DateTimeZone('UTC')
      );      
      
      $node->setRevisionCreationTime($d->getTimestamp());
      $node->setRevisionUserId($this->uid);

      $node->save();

    } catch(\Exception $e) {      
    } // end try catch

    return;
  }

  /**
   * Response
   *
   * @param $result
   */  
  public function Response() {
    return ($this->result == 2) ? TRUE : $this->result;
  }
  

}