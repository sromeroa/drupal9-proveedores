<?php

namespace Drupal\bm_breadcrumbs\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Url;

/**
 *
 * @Block(
 *   id = "breadcrumbs_block",
 *   admin_label = @Translation("Block breadcrumbs - Bimbo Proveedores")
 * )
 */
class Breadcrumbs extends BlockBase implements ContainerFactoryPluginInterface {

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


    $nid = 0;
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      // You can get nid and anything else you need from the node object.
      $nid = $node->id();
    } // end if

    $renderable = [
      '#theme' => 'breadcrumbs_template',
      '#breadcrumbs' =>  $this->get_breadcrumb($nid),
    ];

   
    return $renderable;
  }




  private function get_breadcrumb($nid = 0) {
    $response = [];
    if (empty($nid)) {
      return $response;
    } // end if

    $content = $this->_breadcrumb_info($nid);
    if (count($content)) {
      foreach($content as $val) {
        $response[] =
          [
            "title" => (isset($val->field_breadcrumb_title) && !empty($val->field_breadcrumb_title)) ? $val->field_breadcrumb_title : "",
            "url" => (isset($val->field_breadcrumb_uri) && !empty($val->field_breadcrumb_uri)) ? Url::fromUri($val->field_breadcrumb_uri)->toString() : "/",
          ];
      } // end foreach
    } // end if


   
    return $response;
  }

  /**
   * @param int $parent
   *
   * @return array|int
   */
  private function _breadcrumb_info($nid = 0) {
    $results = [];
    try {
      $query = \Drupal::database()->select('node__field_breadcrumb', 'fbr')
        ->fields('fbr', ['field_breadcrumb_uri', 'field_breadcrumb_title']);
      $query->condition('fbr.entity_id', (int)$nid);
      $query->orderBy('fbr.delta', 'ASC');
      $results = $query->execute()
        ->fetchAll();

    } catch (\Exception $e) {
      print_r($e->getMessage());
    } // end try - catch

    return $results;
  }

  
}
