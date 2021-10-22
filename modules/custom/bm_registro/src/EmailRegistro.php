<?php

namespace Drupal\bm_registro;

use PDO;

/**
 * Class BlockImporter.
 */
class EmailRegistro
{

  private $categories;

  private $emails;

  public function setCategories($categories = "") {
    $this->categories = $categories;
    return $this;
  }

  public function processSendEmails() {

    if (!empty($this->emails)) {
      $this->getMailsFromCategories();
      // TODO Acoplar con Clase de envio
    } // end if

    return $this->catalog;
  }

  private function getMailsFromCategories()
  {

    $this->emails = [];
    try {

      $query = \Drupal::database()->select('taxonomy_term__field_mail', 'tfm')
        ->fields('tfm', ['field_mail_value']);

      $query->condition('tfm.entity_id', (int)$this->categories);

      $this->emails = $query->execute()
        ->fetchAll(PDO::FETCH_ASSOC);

    } catch(\Exception $e) {      
    } // end try catch


    return $this;
  }

}
