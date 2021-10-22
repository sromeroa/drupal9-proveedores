<?php

namespace Drupal\bm_actualdatos;

use Drupal\bm_actualdatos\ActualListadoCampos;

/**
 * Class ActualNodoRevision
 *
 * @package Drupal\ts_actualdatos
 *
 *
 */
class ActualNodoRevision {

  /**
   * @var int
   */
  private $uid = 0;

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
   * @param $uid
   */
  function __construct($nid = 0, $uid = 0) {
    $this->uid = $uid;
    $this->nid = $nid;
  }    

  /**
   * getContenidoRevision()
   *
   */  
  public function getContenidoRevision() {

    $contenido = [];

    try { 
      
      $revision_id = $this->getIDVersionRevisada();      
      if (empty($revision_id)) {
        return $contenido;
      } // end if

      $node = \Drupal::entityTypeManager()->getStorage('node')->loadRevision($revision_id);
      
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
   * UltimaRevisionSupervisor
   *
   */  
  private function getIDVersionRevisada() {
    $vid = 0;

    $revision_supervisor = $this->UltimaRevisionSupervisor();
    if (!empty($revision_supervisor)) {
      $vid = $revision_supervisor;
      return $vid;
    } // end if
    
    $revision_admin = $this->UltimaRevisionAdmin();
    if (!empty($revision_admin)) {
      $vid = $revision_admin;
      return $vid;
    } // end if

    $revision_user = $this->UltimaRevisionUser();
    if (!empty($revision_user)) {
      $vid = $revision_user;
      return $vid;
    } // end if

    return $vid;
  }

  /**
   * UltimaRevisionSupervisor
   *
   */  
  private function UltimaRevisionSupervisor() {

    $results = 0;

    try {

      $query = \Drupal::database()->select('node_revision', 'nr')
        ->fields('nr', ['vid']);

      $query->condition('nr.nid', (int)$this->nid);
      $query->condition('nr.revision_uid', (int)$this->uid, '!=');
      $query->condition('nr.revision_uid', 1, '!=');

      $query->orderBy('nr.vid', 'DESC');
      $query->range(0, 1);
      $results = $query->execute()
        ->fetchField();

    } catch(\Exception $e) {      
    } // end try catch

    return $results;
  }

  /**
   * UltimaRevisionAdmin
   *
   */  
  private function UltimaRevisionAdmin() {

    $results = 0;

    try {

      $query = \Drupal::database()->select('node_revision', 'nr')
        ->fields('nr', ['vid']);

      $query->condition('nr.nid', (int)$this->nid);
      $query->condition('nr.revision_uid', 1);

      $query->orderBy('nr.vid', 'DESC');
      $query->range(0, 1);
      $results = $query->execute()
        ->fetchField();

    } catch(\Exception $e) {      
    } // end try catch

    return $results;
  }  

  /**
   * UltimaRevisionUser
   *
   */  
  private function UltimaRevisionUser() {

    $results = 0;

    try {
      $query = \Drupal::database()->select('node_revision', 'nr')
        ->fields('nr', ['vid']);

      $query->condition('nr.nid', (int)$this->nid);
      $query->condition('nr.revision_uid', (int)$this->uid);

      $query->orderBy('nr.vid', 'DESC');
      $query->range(0, 1);
      $results = $query->execute()
        ->fetchField();

    } catch(\Exception $e) {      
    } // end try catch

    return $results;
  }  

}