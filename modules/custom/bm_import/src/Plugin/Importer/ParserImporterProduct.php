<?php

namespace Drupal\bm_import\Plugin\Importer;

use Drupal\bm_import\Plugin\Importer\NodeImporter;
use Drupal\bm_import\Plugin\Importer\ParserImporter;
use PDO;

/**
 * Class ParserImporter.
 */
class ParserImporterProduct extends ParserImporter
{

  public function __construct()
  {
      parent::__construct();
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
    ->replaceProductosNodeValues();

    return $this->csv_paragraph_fields;
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
  public function attachFirstRowComplementFields()
  {
    $i = $this->rows_counter;
    $this->csv_fields[0][] = "nid";  // posicion 0 despues del contador $i
    $this->reference_nid_position = $i;

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
        // Obteniendo los valores de las columas rfc
        $this->rfcs[$i] = $this->csv_fields[$i][0];
      } // end if
    } // end foreach

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

    $count = (count($this->csv_fields) - 1);
    for ($i = 1; $i <= (int)$count; $i++) {
      $nid = (isset($nodes_content[$i][(int)$this->reference_nid_position])) ? $nodes_content[$i][(int)$this->reference_nid_position] : "";

      if (!empty($nid)) {
        $this->csv_paragraph_fields[$this->csv_fields[$i][0]]["nid"] = $nid;
      } // end if

      $context = [];
      foreach ($this->csv_fields[$i] as $key => $product) {
        if ($key > 0) {
          $context[] = [
            'field' => $this->csv_fields[0][$key],
            'value' => ($product == "si") ? 1 : $product,
          ];  
        } // end if
      } // end foreach

      if (empty($nid)) {
        if (isset($this->csv_paragraph_fields[$this->csv_fields[$i][0]]['nid'])){
          $prev_nid = $this->csv_paragraph_fields[$this->csv_fields[$i][0]]['nid'];
          $this->csv_paragraph_fields[$this->csv_fields[$i][0]][$prev_nid][] = $context;
        } // end if        
      } else {
        $this->csv_paragraph_fields[$this->csv_fields[$i][0]][$nid][] = $context;
      }      

    } // end for

    return $this;
  }

}
