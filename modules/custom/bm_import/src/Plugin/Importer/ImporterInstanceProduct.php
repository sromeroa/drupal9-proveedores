<?php

namespace Drupal\bm_import\Plugin\Importer;

use PDO;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\node\Entity\Node;


/**
 * Class ImporterInstanceProduct
 */
/*
  Uso:
    // Generar el salvado de los productos
    $importer_prod = new ImporterInstanceProduct();
    $importer_prod->setFields($current_csv);
    $importer_prod->createInstance();
*/

class ImporterInstanceProduct
{

  public $fields = [];

  public function setFields($fields = [])
  {
    $this->fields = $fields;
    return $this;
  }

  /**
   * createInstance()
   * 
   */
  public function createInstance()
  {
    foreach ($this->fields as $parse_csv) {
        unset($parse_csv['nid']);
        
        foreach ($parse_csv as $nid => $fields_container) {
          
          foreach ($fields_container as $fields) {
            $paragraph = Paragraph::create(['type' => 'ps_productos',]);
            foreach ($fields as $field) {
                $value = (isset($field['value']) && !empty($field['value'])) ? $field['value'] : "";
                $paragraph->set($field['field'], $value);
            }

            $paragraph->isNew();
            $paragraph->save();
              
            $current[$nid][] = array(
              'target_id' => $paragraph->id(),
              'target_revision_id' => $paragraph->getRevisionId(),
            );
          } // end if

          $node = Node::load($nid);
          $node->field_ps_productos = $current[$nid];    
          $node->save();                

        }
    } // end foreach

    return $this;
  }
}
