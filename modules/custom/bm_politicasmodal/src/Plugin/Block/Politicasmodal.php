<?php

namespace Drupal\bm_politicasmodal\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Url;
use Drupal\user\Entity;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\Core\Form\FormInterface;

/**
 *
 * @Block(
 *   id = "politicasmodal_block",
 *   admin_label = @Translation("Block Pop-up Politicas  - Bimbo Proveedores")
 * )
 */
class Politicasmodal extends BlockBase
{

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $form = \Drupal::formBuilder()->getForm('Drupal\bm_politicasmodal\Form\PoliticasForm');
    return $form;
  }

}
