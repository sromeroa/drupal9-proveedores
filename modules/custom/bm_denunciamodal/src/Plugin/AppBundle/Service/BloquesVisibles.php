<?php

namespace Drupal\bm_denunciamodal\AppBundle\Service;

use Drupal\Core\Session\AccountInterface;

class BloquesVisibles
{
  private $current_user;

  private $uid;

  public function __construct(AccountInterface $currentUser)
  {
    $this->current_user = $currentUser;
    //$this->uid = $this->current_user->id();
    $this->uid = 43;
  }

  public function blov() {
    return "test";
  }

}
