<?php

namespace Drupal\bm_actualdatos;

use Drupal\Core\Entity;
use Drupal\user\Entity\User;

/**
 * Class ActualInfoUsuario
 *
 * @package Drupal\ts_actualdatos
 *
 *
 */
class ActualCrearUsuario {

  /**
   * @var array
   */  
  private $fields = [];

  /**
   * ActualEditar constructor.
   *
   * @param $fields
   */
  function __construct() {
  }

  public function setFields($fields = []) {
    $this->fields = $fields;
  }

  /**
   * getRevision
   *
   */  
  public function crearUsuario() {
    
    $uid = 0;

    try {

      $user = \Drupal\user\Entity\User::create();
      
      $pass = (isset($this->fields['usr_password_confirmacion'])) ? $this->fields['usr_password_confirmacion'] : "";
      // $user->setPassword($pass);
      $user->setPassword("Bimbo#2021");

      $email = (isset($this->fields['ct_email'])) ? $this->fields['ct_email'] : "";
      $user->setEmail($email);

      $username = (isset($this->fields['ct_email'])) ? $this->fields['ct_email'] : "";
      $user->setUsername($username);
      
      $user->addRole('proveedor');
      $user->activate();      

      $user->save();      

      $uid = $user->id();

    } catch (\Exception $e) {
    } // end try - catch


    return $uid;
  }

 

}