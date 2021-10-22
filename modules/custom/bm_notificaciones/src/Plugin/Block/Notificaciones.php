<?php

namespace Drupal\bm_notificaciones\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Url;

/**
 *
 * @Block(
 *   id = "notificaciones_block",
 *   admin_label = @Translation("Block Notificaciones - Bimbo Proveedores")
 * )
 */
class Notificaciones extends BlockBase implements ContainerFactoryPluginInterface {

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
      '#theme' => 'notificaciones_template',
      '#notificaciones' => $this->retrieve_content($this->enlaces_taxonomy()),
    ];

 
    return $renderable;
  }

   /**
   * @param int $parent
   *
   * @return array|int
   */
  public function enlaces_taxonomy($parent = 0) {


  
    $results = [];
    try {
      $query = \Drupal::entityQuery('taxonomy_term');
      $query->condition('vid', "menu_notificaciones");
      $query->condition('parent', $parent);
      $query->sort('weight', 'ASC');
      $results = $query->execute();
    } catch (\Exception $e) {
    } // end try - catch

    return $results;
  }


   /**
   * @param array $tids
   *
   * @return array
   */
  private function retrieve_content($tids = []) {
    global $base_url;
    $taxname_array	= [];
    if (count($tids)<=0) {
      return $taxname_array;
    } // end if

    foreach($tids as $key => $val) {
      $taxonomy_term = \Drupal\taxonomy\Entity\Term::load($val);

      $taxname_array[] =
        [
          "id" => $taxonomy_term->id(),
          "name" => (isset($taxonomy_term->name->value) && !empty($taxonomy_term->name->value)) ? $taxonomy_term->name->value : $taxonomy_term->name->value,
          "link_uri" => (isset($taxonomy_term->field_enlace_menu->getValue()[0]['uri'])) ? $taxonomy_term->field_enlace_menu->getValue()[0]['uri'] : "/",

        ];
    } // end foreach

    return $taxname_array;
  }

  
}
