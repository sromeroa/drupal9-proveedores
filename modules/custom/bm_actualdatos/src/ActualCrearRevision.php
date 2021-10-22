<?php

namespace Drupal\bm_actualdatos;

use Drupal\Core\Entity;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Class ActualCrearRevision
 *
 * @package Drupal\ts_actualdatos
 *
 *
 */
class ActualCrearRevision {

  /**
   * @var array
   */  
  private $fields = [];

  /**
   * @var array
   */  
  private $node_info = [];

  /**
   * @var array
   */  
  private $uid = 0;

  /**
   * ActualEditar constructor.
   *
   * @param $uid
   */
  function __construct() {        
  }

  public function setCampos($fields = []) {
    $this->fields = $fields;
    \Drupal::logger('$this->fields')->notice(print_r($this->fields,true));
  }

  public function setIDUsuario($uid = 0) {
    $this->uid = $uid;    
  }

  /**
   * getRevision
   *
   */  
  public function crearRevision() {
    
    $contenido = 0;
        
    $this->pushDefaultInfo();
    $this->pushFieldsInfo();
    $this->pushParagraphs();

    $node = Node::create($this->node_info);
    $node->save();
    $contenido = $node->id();

    return $contenido;
  }

  /**
   * pushFieldsInfo
   *
   */   
  private function pushFieldsInfo() {
    if (count($this->fields) <= 0) {
      return $this->node_info;
    } // end if

    foreach ($this->fields as $key => $field_value) {      
      $field_name = "field_". $key;
      $this->node_info = array_merge([$field_name => $field_value], $this->node_info);
    } // end foreach

    // Remove paragraph
    unset($this->node_info['field_ps_productos']);
    unset($this->node_info['field_dc_distribucion']);
    unset($this->node_info['field_dc_categoria']);    

  }

  /**
   * pushDefaultInfo
   *
   */   
  private function pushDefaultInfo() {

    $this->node_info = array_merge([
      'type' => 'user_revision',
      'title' => $this->fields['dc_razon_social'],
      'langcode' => 'en',
      'uid' => 1,
      'status' => 0,
      'field_informacion_valida' => 1,
      'field_proveedor' => $this->uid,
    ], $this->node_info);

    return;
  }

  /**
   * pushParagraphs()
   *
   */   
  private function pushParagraphs() {

    if (empty($this->fields['ps_productos']) && count($this->fields['ps_productos']) <= 0) {
      return $this->node_info;
    } // end if

    $paragraph = Paragraph::create(['type' => 'ps_productos',]);

    foreach ($this->fields['ps_productos'] as $field_value) {      
      foreach ($field_value as $key => $val) {
        $field_name = "field_". $key;
        
        \Drupal::logger('$registro_$field_name')->notice(print_r($field_name,true));
        \Drupal::logger('$registro_$val')->notice(print_r($val,true));
        $val = ($val == "Si")? 1 : $val;
        $paragraph->set($field_name, $val);   
      } // end foreach
    } // end foreach

    $paragraph->isNew();
    $paragraph->save();

    $current[] = array(
      'target_id' => $paragraph->id(),
      'target_revision_id' => $paragraph->getRevisionId(),
    );

    $this->node_info = array_merge(['field_ps_productos' => $current], $this->node_info);

    return;    
  }

}