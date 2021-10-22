<?php

use Drupal\Component\Uuid\Php;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\node\Entity\Node;

/**
 * Batch execution.
 *
 * @param $total
 *   Numero de iteraciones totales
 * 
 * @param $csv_data
 *   CSV procesado
 * 
 * @param array $context
 *   An array of contextual key/value information for rebuild batch process.
 */
function bm_import_producto($total, $csv_data, &$context)
{

  if (($total > 0) && is_numeric($total)) {
    $message = \Drupal::translation()->formatPlural(
      $total,
      'Total of indexing items:',
      '@count'
    );
    drupal_set_message($message);

    // Inicializa el contador del batch
    if (empty($context['sandbox'])) {
      $context['sandbox']['progress'] = 0;
      $context['sandbox']['max'] = $total;
    } // end if

    // Por default porcesa 100 items si el total esta vacio,
    // En caso contrario procesa el total de items.
    $batch_size = 100;
    $max = $context['sandbox']['progress'] + $batch_size;
    if ($max > $context['sandbox']['max']) {
      $max = $context['sandbox']['max'];
    } // end if

    foreach ($csv_data as $current_csv) {
      unset($current_csv['nid']);
      // Cargar ID's
      foreach ($current_csv as $nid => $fields_container) {
        // Cargar columnas
        foreach ($fields_container as $fields) {
          $paragraph = Paragraph::create(['type' => 'ps_productos',]);
          // Cargar filas  
          foreach ($fields as $field) {
            $value = (isset($field['value']) && !empty($field['value'])) ? $field['value'] : "";
            $paragraph->set($field['field'], $value);
          } // end foreach $fields

          $paragraph->isNew();
          $paragraph->save();

          $current[$nid][] = array(
            'target_id' => $paragraph->id(),
            'target_revision_id' => $paragraph->getRevisionId(),
          );

          // Update progress
          $context['sandbox']['progress']++;

        } // end foreach $fields_container

        $node = Node::load($nid);
        $node->field_ps_productos = $current[$nid];
        $node->save();
      } // end foreach $current_csv
      
    } // end foreach $csv_data

    // Finalizacion del batch
    if ($context['sandbox']['progress'] != $context['sandbox']['max']) {
      $context['finished'] = $context['sandbox']['progress'] / $context['sandbox']['max'];
    } // end if
  }
}

/**
 * Callback al finalizar el proceso del batch
 * @param $success
 * @param $results
 * @param $operations
 */
function bm_import_completed_callback($success, $results, $operations)
{
  $message = t('There were some errors.');
  if ($success) {
    // Do something else if needed.
    $message = t('Success.');
  }
  drupal_set_message($message);
}
