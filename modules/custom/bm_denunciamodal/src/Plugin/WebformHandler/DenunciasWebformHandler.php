<?php

namespace Drupal\bm_denunciamodal\Plugin\WebformHandler;

use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Create a new node entity from a webform submission.
 *
 * @WebformHandler(
 *   id = "denuncias",
 *   label = @Translation("Salvar resultado de denuncias"),
 *   category = @Translation("Entity Creation"),
 *   description = @Translation("Creates a new node from Webform Submissions."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_REQUIRED,
 * )
 */
class DenunciasWebformHandler extends WebformHandlerBase
{

  /**
   * {@inheritdoc}
   */

  public function postSave(WebformSubmissionInterface $webform_submission, $update = TRUE)
  {
    //$values = $webform_submission->getData();
    $webform = $webform_submission->getWebform();
    $webform_id = $webform->id();

    $uid = \Drupal::currentUser()->id();
    $user = \Drupal\user\Entity\User::load($uid);

    $user->get('field_denuncias')->appendItem([
      'plugin_id' => 'webform_block',
      'settings' => [
        'id' => 'webform_block',
        'label' => 'Webform',
        'provider' => 'webform',
        'label_display' => 'visible',
        'webform_id' => $webform_id,
        'default_data' => '',
        'redirect' => 0,
      ]
    ]);

    $user->save();

  }
}
