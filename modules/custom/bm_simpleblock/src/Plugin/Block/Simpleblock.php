<?php

namespace Drupal\bm_simpleblock\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Url;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 *
 * @Block(
 *   id = "simple_block",
 *   admin_label = @Translation("Simple block general - Bimbo Proveedores")
 * )
 */
class Simpleblock extends BlockBase implements ContainerFactoryPluginInterface {

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
  public function build() {

    $renderable = [
      '#theme' => 'basic_template',
      '#test' => "Info",
    ];

    return $renderable;
  }

}
