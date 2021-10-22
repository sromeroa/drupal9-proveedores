<?php

namespace Drupal\bm_actualdatos;

use PDO;

/**
 * Class ActualCatalogos
 *
 * @package Drupal\ts_actualdatos
 *
 *
 */
class ActualCatalogos {

  /**
   *
   * @param $uid
   */
  function __construct() {
  }

  /**
   * getPais
   *
   */  
  public function getPais() {    
    $contenido = [];

    try {

      $query = \Drupal::database()->select('taxonomy_term_field_data', 'tfd')
        ->fields('tfd', ['tid', 'name']);

      $query->condition('tfd.vid', 'pais');
      $contenido = $query->execute()
        ->fetchAll(PDO::FETCH_ASSOC);

    } catch(\Exception $e) {      
    } // end try catch

    return $contenido;
  }

  /**
   * getCategoria
   */
  public function getCategoria() {
    $contenido = [];

    try {

      $query = \Drupal::database()->select('taxonomy_term_field_data', 'tfd')
        ->fields('tfd', ['tid', 'name']);

      $query->condition('tfd.vid', 'categoria');
      $contenido = $query->execute()
        ->fetchAll(PDO::FETCH_ASSOC);

    } catch(\Exception $e) {      
    } // end try catch
    
    return $contenido;
  }

  /**
   * getSubCategoria()
   */
  public function getSubCategoria() {
    $contenido = [];

    try {

      $query = \Drupal::database()->select('taxonomy_term_field_data', 'tfd')
        ->fields('tfd', ['tid', 'name']);

      $query->condition('tfd.vid', 'subcategoria');
      $contenido = $query->execute()
        ->fetchAll(PDO::FETCH_ASSOC);

    } catch(\Exception $e) {      
    } // end try catch
    
    return $contenido;
  }  
  
}