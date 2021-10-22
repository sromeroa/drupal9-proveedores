<?php

namespace Drupal\bm_actualizardatos;

/**
 * Class ActualMapaCampos
 *
 * @package Drupal\bm_actualizardatos
 *
 *
 */
class ActualListadoCampos {

  /**
   * ListadoCampos constructor.
   *
   */
  function __construct() {
  }    

  /**
   * ListadoCampos
   * 
   * Listado de campos por tipo (bundle)
   */
  public function getListadoCampos($type = "") {

    $user_revision_fields = [];
    $field_map = \Drupal::service('entity_field.manager')->getFieldMap();
  
    foreach ($field_map['node'] as $key_field => $map) {      
      if (isset($map['bundles'][$type])) {
        $strpos = strpos($key_field, 'field_');
        if ($strpos !== false && !in_array($key_field, $this->excluirCampos())) {
          $user_revision_fields[] = $key_field;
        } // end if
      } // end if
    } // end foreach

  
    return $user_revision_fields;
  }

  private function excluirCampos() {
    return ['field_proveedor'];
  }
  
}