<?php

namespace Drupal\bm_import\Plugin\Importer;

use Drupal\bm_import\Plugin\Importer\NodeImporter;
use PDO;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Core\Entity;
use Drupal\node\Entity\Node;

/**
 * Class ParserImporter.
 */
class ParserImporter
{

  /**
   * 
   */
  private $catalog_name = [];

  /**
   * 
   */
  public $reference_nid_position;

  /**
   * 
   */
  private $reference_email_position;

    /**
   * 
   */
  private $reference_pais;
     /**
   * 
   */
  private $reference_categoria;
     /**
   * 
   */
  private $reference_subcategoria;

  /**
   * 
   */
  private $reference_razon;

  /**
   * 
   */
  private $reference_proveedor_position;

  
  /**
   * 
   */
  public $csv_fields = [];

  /**
   * 
   */
  private $rows_counter = 0;

  /**
   * 
   */
  public $rfcs = [];

  /**
   * 
   */
  private $emails = [];

  /**
   * 
   */
  public $csv_key_complement;

  public function __construct()
  {
  }

  /**
   * 
   */
  public function setCSV($csv = [])
  {
    $this->csv_fields = $csv;
    return $this->csv_fields;
  }

  /**
   * getCSV()
   * 
   */
  public function getCSV()
  {
    return $this->csv_fields;
  }

  /**
   * setCatalogList($catalog_list = [])
   * 
   * Carga todos los valores de los catalogos (taxonomia categoria, subcategoria, pais)
   */
  public function setCatalogList($catalog_list = [])
  {
    $this->catalog_list = $catalog_list;
    return $this->catalog_list;
  }

  /**
   * getUpdatedCSV()
   * 
   * Obtener los valores de reemplazo para las columnas que contienen: catalogos, nids, uids, etc
   * para registrar correctamente los nodos
   */
  public function getUpdatedCSV()
  {

    $this->replaceFirstRowValues()
      ->attachFirstRowComplementFields()
      ->replaceCatalogsValues()
      ->replaceNodeValues();
if(isset($_GET["deb"])){
  echo "<pre>";
  print_r($this);
  echo "</pre>";
  die;
}
    return $this->csv_fields;
  }

  /**
   * replaceFirstRowValues()
   * 
   * Obtener las equivalencias de la primera fila del arreglo csv y renombrarlas a nombres de campos Drupal para almacenarlas en el nodo
   */
  public function replaceFirstRowValues()
  {
    $fields_reference = [];
    try {

      $csv_parse = array_values($this->csv_fields[0]);
      $query = \Drupal::database()->select('taxonomy_term_field_data', 'tfd')
        ->fields('tfd', ['name', 'description__value']);

      $query->condition('tfd.vid', 'equivalencias_campos_importador');
      $query->condition('tfd.name', $csv_parse, 'IN');
      $results = $query->execute()
        ->fetchAll(PDO::FETCH_ASSOC);

      if (count($results)) {
        $i = 0;

        foreach ($results as $result) {

          $key = (array_search($result['name'], $csv_parse));
          $fields_reference[$key] = $result['description__value'];

          // Obtenemos la posicion de la columna donde se encotraran los valores a buscar en el arreglo csv
          // Para posteriormente validar los nids y uids y actualizar el arreglo con dichos valores
          switch ($result['description__value']) {
            case 'field_dc_relacion_comercial':
            case 'field_dc_distribucion':
              $this->catalog_name[$i] = "pais";
              break;
            case 'field_dc_categoria':
              $this->reference_categoria = $key;
              break;
            case 'field_dc_subcategoria':
              $this->reference_subcategoria = $key;
              break;
            case 'field_ct_email':
              $this->reference_email_position = $key;
              break;
          } // end switch

          $i++;
        } // end foreach
      } // end if

      // ordenar de a cuerdo al arreglo csv
      ksort($fields_reference);

      $this->rows_counter = $i;
    } catch (\Exception $e) {
    } // end try catch

    // Reemplazamos la fila 0 del arreglo de csv, por los campos Drupal que se usaran como identificadores para agregar/actualizar los nodos
    $this->csv_fields[0] = $fields_reference;

    return $this;
  }

  /**
   * Adjuntar campos complementarios en el arreglo CSV
   */
  //public function attachFirstRowComplementFields($complement = "proveedor_csv")
  public function attachFirstRowComplementFields()
  {

    $i = $this->rows_counter;
    /*
    $this->csv_key_complement = $complement;
    switch ($this->csv_key_complement) {
      case 'proveedor_csv':
        */
        // Se agregan las columnas necesarias para crear/actualizar los nodos
        $this->csv_fields[0][] = "field_informacion_valida";
        $this->csv_fields[0][] = "field_dc_razon_social";
        $this->csv_fields[0][] = "title";
        $this->csv_fields[0][] = "nid";  // posicion 0 despues del contador $i
        $this->csv_fields[0][] = "field_proveedor";  // posicion 3 despues del contador $i

        // Se obtienen las posiciones de las columnas que se agregaron anteriormente
        $this->reference_nid_position = ($i +2);
        $this->reference_razon_social = ($i+1);
        $this->reference_proveedor_position = ($i +3);
        /*
        break;
      case 'producto_csv':
        $this->csv_fields[0][] = "nid";  // posicion 0 despues del contador $i
        $this->reference_nid_position = $i;
        break;
    } // end switch
    */
    
    return $this;
  }

  /**
   * replaceCatalogsValues()
   * 
   * Reemplazar los valores de texto de las columnas referentes a catalogos (Taxonomia categoria, subcategoria, pais) y reemplazarlo por su respectivo tid
   */
  public function replaceCatalogsValues()
  {

    // Se descuenta la primera fila
    $count = (count($this->csv_fields) - 1);
   
    // Se recorre el total de items en el arreglo del csv
    for ($i = 0; $i <= (int)$count; $i++) {
      if ($i > 0) {

        /*owComplementFields()
  {

        switch ($this->csv_key_complement) {
          case 'proveedor_csv':
            */
            // Se recorren los catalogos para encontrar coincidencias con la columna (field_dc_relacion_comercial, field_dc_distribucion, field_dc_categoria, field_dc_subcategoria)
            foreach ($this->catalog_name as $key_c => $cname) {
              // Si encuentra la columna 
              if (isset($this->csv_fields[$i][$key_c])) {
                // Cambia los valores de la columa actual por el tid del catalogo correspondiente
                $this->csv_fields[$i][$key_c] = $this->catalog_list[$cname][$this->csv_fields[$i][$key_c]];
              } // end if
            } // end foreach

           $this->csv_fields[$i][$this->reference_categoria]= $this->replaceCatalog("categoria",$this->csv_fields[$i][$this->reference_categoria ]);
           $this->csv_fields[$i][$this->reference_subcategoria]= $this->replaceCatalog("subcategoria",$this->csv_fields[$i][$this->reference_subcategoria ]);
            // Se agregan las columnas necesarias para crear/actualizar los nodos
            $this->csv_fields[$i][] = 1;
            $this->csv_fields[$i][] = "sss";
            
            // Actualiazndo columna nid, por default a 0 mas adelante se actualizara a su valor correspondiente
            // Actualiazndo columna title, por default es el valor del RFC del proveedor
            $this->csv_fields[$i][] = $this->csv_fields[$i][0];

            $this->csv_fields[$i][] = 0;
          
            $this->csv_fields[$i][] = $this->rfcs[$i];
            // Obteniendo los valores de las columas rfc
            $this->rfcs[$i] = $this->csv_fields[$i][0];
            // Obteniendo los valores de las columas email
            $this->emails[$i] = $this->csv_fields[$i][$this->reference_email_position];

            /*
            break;

          case 'producto_csv':
            // Obteniendo los valores de las columas rfc
            $this->rfcs[$i] = $this->csv_fields[$i][0];
            break;
        } // end switch
        */

      } // end if
    } // end foreach
   
    return $this;
  }



  /**
   * replaceCatalog()
   * 
   * Reemplazando los valores de nodos en el arreglo csv
   */
  private function replaceCatalog($vid=null, $position=null)
  {

    $query = \Drupal::database()->select('taxonomy_term_field_data', 'tfd')
    ->fields('tfd', ['tid','name', 'description__value']);
  $query->condition('tfd.vid', $vid);
 $query->condition('tfd.name',$position);

  $results = $query->execute()
    ->fetchAll(PDO::FETCH_ASSOC);


    
    return $results[0]["tid"];
  }

  /**
   * replaceNodeValues()
   * 
   * Reemplazando los valores de nodos en el arreglo csv
   */
  private function replaceNodeValues()
  {

    $node_importer = new NodeImporter();
    $node_importer->setNodePosition($this->reference_nid_position);
    $node_importer->setRFCS($this->rfcs);
    $node_importer->setProveedorPosition($this->reference_proveedor_position);
    $node_importer->setEmails($this->emails);

    $nodes_content = $node_importer->getContent();

    $count = (count($this->csv_fields) - 1);
    for ($i = 1; $i <= (int)$count; $i++) {
      $razon="";
     foreach ($this->csv_fields[0] as $key => $value) {
       if($value=="field_dc_nombre_comercial"){
        $razon=$key;
      }
    }
       $this->csv_fields[$i][(int)$this->reference_razon_social] = $this->csv_fields[$i][$razon];
       $this->csv_fields[$i][(int)$this->reference_nid_position+1] = $nodes_content[$i][(int)$this->reference_nid_position];
      $this->csv_fields[$i][(int)$this->reference_proveedor_position+1] = $nodes_content[$i][(int)$this->reference_proveedor_position];
    } // end for

    return $this;
  }


  /**
   * replaceNodeValues()
   * 
   * Reemplazando los valores de nodos en el arreglo csv
   */
  public function replaceProductosNodeValues()
  {

    $node_importer = new NodeImporter();
    $node_importer->setNodePosition($this->reference_nid_position);
    $node_importer->setRFCS($this->rfcs);
    $node_importer->findNodes();
    $nodes_content = $node_importer->getContentArray();

    $test = [];
    $count = (count($this->csv_fields) - 1);
    for ($i = 1; $i <= (int)$count; $i++) {
      $nid = $nodes_content[$i][(int)$this->reference_nid_position];

      if (!empty($nid)) {
        $test[$this->csv_fields[$i][0]]["nid"] = $nid;
      } // end if

      $context = [];
      foreach ($this->csv_fields[$i] as $key => $product) {
        $context[] = [
          'field' => $this->csv_fields[0][$key],
          'value' => $product
        ];  
      }

      $test[$this->csv_fields[$i][0]][] = $context;
    } // end for

    $paragraph = Paragraph::create(['type' => 'ps_productos',]);

    /*
    foreach ($this->fields['ps_productos'] as $field_value) {      
      foreach ($field_value as $key => $val) {
        $field_name = "field_". $key;
        $paragraph->set($field_name, $val);   
      } // end foreach
    } // end foreach
    */

    $paragraph->set('field_ps_nombre_producto', 'prod_ya2');

    $paragraph->isNew();
    $paragraph->save();

    $current[] = array(
      'target_id' => $paragraph->id(),
      'target_revision_id' => $paragraph->getRevisionId(),
    );

    $node = Node::load(68);
    $node->field_ps_productos = $current;

    $node->save();
    
    //print_r($this->csv_fields);
    echo "<p>";
    print_r($test);
    die();

    return $this;
  }
}
