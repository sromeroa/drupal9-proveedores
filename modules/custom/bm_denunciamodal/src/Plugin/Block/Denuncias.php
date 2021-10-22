<?php

namespace Drupal\bm_denunciamodal\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Url;
use Drupal\webform\Entity\Webform;

/**
 *
 * @Block(
 *   id = "denunciamodal_block",
 *   admin_label = @Translation("Block Denuncias modal - Bimbo Proveedores")
 * )
 */
class Denuncias extends BlockBase implements ContainerFactoryPluginInterface
{

  /**
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
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
    \Drupal::service('page_cache_kill_switch')->trigger();
    
    // Validar si el bloque de denuncia actual no ha sido registrada
    $container = \Drupal::service('bm_denunciamodal.bloquesvisibles');

    $renderable = [
      '#theme' => 'denuncia_template',
      '#bloque' => $container->bloques(),      
      '#titulo' => $container->titulo(),
      '#descripcion' => $container->descripcion(),
    ];

    return $renderable;
  }
}
