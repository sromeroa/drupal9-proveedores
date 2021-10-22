<?php

namespace Drupal\bm_actualdatos\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Url;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 *
 * @Block(
 *   id = "actualdatos_block",
 *   admin_label = @Translation("Bloque Actualización de Datos - Bimbo Proveedores")
 * )
 */
class Actualdatosblock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $form = \Drupal::formBuilder()->getForm('Drupal\bm_actualdatos\Form\ActualdatosForm');
    return $form;
  }

}
