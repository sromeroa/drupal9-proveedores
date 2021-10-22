<?php

namespace Drupal\bm_actualdatos;

use Drupal\node\Entity\Node;
use Drupal\bm_actualdatos\ActualListadoCampos;
use Drupal\bm_actualdatos\Plugin\Block\Actualdatosblock;

/**
 * Class ActualNodo
 *
 * @package Drupal\ts_actualdatos
 *
 *
 */
class ActualNodo {

  /**
   * @var int
   */
  private $nid = 0;

  /**
   * @var int
   */  
  private $results = 0;

  /**
   * ActualNodoRevision constructor.
   *
   * @param $nid
   */
  function __construct($nid = 0) {
    $this->nid = $nid;
  }    

  /**
   * getContenidoRevision()
   *
   */  
  public function getContenidoNodo() {

    $contenido = [];

    try { 

      $node = Node::load($this->nid);
    
      $list = new ActualListadoCampos();
      $map_fields = $list->getListadoCampos('user_revision');
  
      foreach ($map_fields as $field) {
        $clean_key = str_replace('field_', '', $field);
        $contenido[$clean_key] = $node->{$field}->value;
      } // end foreach

    } catch (\Exception $e) {
    } // end try - catch
    
    return $contenido;
  }

  /**
   * existeInformacionValida
   */
  public function existeInformacionValida() {

    $nid = 0;
    try {
      $query = \Drupal::entityQuery('node')
      ->condition('type', 'user_revision')
      ->condition('nid', $this->nid)
      ->condition('field_informacion_valida', 1);
      $nid = $query->execute();

    } catch (\Exception $e) {
    } // try - catch

    return $nid;
  }

}