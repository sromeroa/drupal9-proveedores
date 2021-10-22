<?php

namespace Drupal\bm_actualizardatos;

use Drupal\bm_actualizardatos\ActualNodoRevision;
use Drupal\bm_actualizardatos\ActualNodo;
use Drupal\Core\Entity;

/**
 * Class ActualInfoUsuario
 *
 * @package Drupal\bm_actualizardatos
 *
 *
 */
class ActualInfoUsuario {

  /**
   * int
   */
  private $uid = 0;

  /**
   * ActualNodoRevision constructor.
   *
   * @param $uid
   */
  function __construct($uid = 0) {
    $this->uid = $uid;
  }

  /**
   * getRevision
   *
   */  
  public function getContenidoUsuario($nid = 0) {
    
    $contenido = [];

    $nodo = new ActualNodo($nid);

    if ($nodo->existeInformacionValida()) {

      $contenido = $nodo->getContenidoNodo();

  

    } else {

      $nodo_revision = new ActualNodoRevision($nid, $this->uid);
      $contenido = $nodo_revision->getContenidoRevision();
      
  
    } // end if

    
    
    return $contenido;
  }

  /**
   * existeInformacionValida
   */
  public function getUserNID() {

    $nid = 0;
    try {
      $query = \Drupal::entityQuery('node')
      ->condition('type', 'user_revision')
      ->condition('field_proveedor', $this->uid);
      $results = $query->execute();

      $array_values = array_values($results);
      $nid = (isset($array_values[0])) ? $array_values[0] : $nid;

    } catch (\Exception $e) {
    } // try - catch

    return $nid;
  }
  

  

}