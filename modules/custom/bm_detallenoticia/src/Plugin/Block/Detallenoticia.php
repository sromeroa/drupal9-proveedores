<?php

namespace Drupal\bm_detallenoticia\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\Cache;
use \Drupal\Core\Url;

/**
 *
 * @Block(
 *   id = "detallenoticia_block",
 *   admin_label = @Translation("Block detallenoticia - Bimbo Proveedores")
 * )
 */
class Detallenoticia extends BlockBase implements ContainerFactoryPluginInterface {

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
      '#theme' => 'detallenoticia_template',
      '#detallenoticia' =>  $this->get_detalleNoticia($nid),
      '#breadcrumbs' =>  $this->get_breadcrumb($nid),
    ];
   
    return $renderable;
  }
  private function get_detalleNoticia($nid = 0) {
    $response = [];
    if (empty($nid)) {
      return $response;
    } // end if
    $content = $this->_detalle_info($nid);
    if (count($content)) {
      foreach($content as $val) {
        $response[] =
          [
            "titulo" => (isset($val->field_titulo_value) && !empty($val->field_titulo_value)) ? $val->field_titulo_value : "",
            "fecha" => (isset($val->field_fecha_publicacion_value) && !empty($val->field_fecha_publicacion_value)) ? $val->field_fecha_publicacion_value : "",
            "descripcion" => (isset($val->field_descripcion_value) && !empty($val->field_descripcion_value)) ? $val->field_descripcion_value : "",
            "imagen" => (isset($val->field_imagen_de_portada_target_id) && !empty($val->field_imagen_de_portada_target_id)) ? $this->image_path($val->field_imagen_de_portada_target_id) : "",
          ];
      } // end foreach
    } // end if
    return $response;
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
   /**
   * @param int $parent
   *
   * @return array|int
   */
  private function _detalle_info($nid = 0) {
    $results = [];
   
    try {
        $query = \Drupal::database()->select('node', 'n')
          ->fields('n', ['nid'])
          ->fields('img', ['field_imagen_de_portada_target_id'])
          ->fields('fch', ['field_fecha_publicacion_value'])
          ->fields('desc', ['field_descripcion_value'])
          ->fields('tit', ['field_titulo_value']);

        $query->leftJoin('node__field_imagen_de_portada', 'img', 'img.entity_id = n.nid');
        $query->leftJoin('node__field_fecha_publicacion', 'fch', 'fch.entity_id = n.nid');
        $query->leftJoin('node__field_descripcion', 'desc', 'desc.entity_id = n.nid');
        $query->leftJoin('node__field_titulo', 'tit', 'tit.entity_id = n.nid');

        $query->condition('n.nid', $nid);
        $results = $query->execute()
          ->fetchAll();

    } catch (\Exception $e) {
      print_r($e->getMessage());
    } // end try - catch

   
    return $results;
  }
    /**
   * @param string $fid
   *
   * @return string|void
   */
  private function image_path($fid = "") {
    $file_url = "";
    if (empty($fid)) {
      return $file_url;
    } // end ir
    $file = \Drupal\file\Entity\File::load($fid);
    $file_url = $file->createFileUrl();

    return $file_url;
  }

  public function getCacheTags() {
    if ($node = \Drupal::routeMatch()->getParameter('node')) {
      return Cache::mergeTags(parent::getCacheTags(), array('node:' . $node->id()));
    } else {
      return parent::getCacheTags();
    }
  }
  
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), array('route'));
  }

}
