<?php

namespace Drupal\bm_perfilproveedor\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Url;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 *
 * @Block(
 *   id = "menuproveedor_block",
 *   admin_label = @Translation("Menu Proveedor - Bimbo Proveedores")
 * )
 */
class MenuPerfil extends BlockBase implements ContainerFactoryPluginInterface
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

    $renderable = [
      '#theme' => 'menuperfil_template',
      '#menu' => $this->menuLoadLinks('menu-proveedor'),
      '#user_img' => $this->userLoadImage(),
    ];

    return $renderable;
  }

  /**
   * Obtener la imagen del usuario
   * @param  $menu_name
   */
  public function userLoadImage() {
    $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());

    if (!$user->user_picture->isEmpty()) {
      $picture = file_create_url($user->user_picture->entity->getFileUri());
    }else{
      $picture = '';    
    }     

    return $picture;
  }

  /**
   * Cargar los enlaces del menu de proveedor
   * @see /admin/structure/menu/manage/menu-proveedor
   * 
   * @param  $menu_name
   */
  public function menuLoadLinks($menu_name)
  {
    $links = [];
    $storage = \Drupal::entityTypeManager()->getStorage('menu_link_content');
    $menu_links = $storage->loadByProperties(['menu_name' => $menu_name]);
    if (empty($menu_links)) return $links;
    foreach ($menu_links as $mlid => $menu_link) {
      $link = [];
      $link['type'] = 'menu_link';
      $link['mlid'] = $menu_link->id->value;
      $link['plid'] = $menu_link->parent->value ?? '0';
      $link['menu_name'] = $menu_link->menu_name->value;
      $link['link_title'] = $menu_link->title->value;
      $url = Url::fromUri($menu_link->link->uri)->toString();
      $link['uri'] = $url;
      $link['options'] = $menu_link->link->options;
      $link['weight'] = $menu_link->weight->value;
      $links[] = $link;
    }
    // Sort menu links by weight element
    usort($links, [SortArray::class, 'sortByWeightElement']);
    return $links;
  }
}
