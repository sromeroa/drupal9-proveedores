<?php

namespace Drupal\bm_programascatalogo\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Url;

/**
 *
 * @Block(
 *   id = "programascatalogo_block",
 *   admin_label = @Translation("Block Programas catalogo principal- Bimbo Proveedores")
 * )
 */
class Programascatalogo extends BlockBase implements ContainerFactoryPluginInterface {

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
      '#theme' => 'programascatalogo_template',
      '#programas' => $this->get_programas($nid),
    ];
    return $renderable;
  }

  private function get_programas($nid = 0) {
    $response = [];
    if (empty($nid)) {
      return $response;
    } // end if

    global $base_url;
    $content = $this->_programas_info($nid);
    if (count($content)) {
      foreach($content as $val) {

        $nid = (isset($val->nid) && !empty($val->nid)) ? $val->nid : "";
        $options = ['absolute' => TRUE];
        $url_object = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => $nid], $options);

        $response[] =
          [
            "titulo" => (isset($val->field_titulo_value) && !empty($val->field_titulo_value)) ? $val->field_titulo_value : "",
            "subtitulo" => (isset($val->field_subtitulo_value) && !empty($val->field_subtitulo_value)) ? $val->field_subtitulo_value : "",
            "imagen" => (isset($val->field_image_target_id) && !empty($val->field_image_target_id)) ? $this->image_path($val->field_image_target_id) : "",
            "programaId" => $url_object,
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
  private function _programas_info($nid = 0) {
    $results = [];
    try {
        $query = \Drupal::database()->select('node', 'n')
          ->fields('n', ['nid'])
          ->fields('tit', ['field_titulo_value'])
          ->fields('subt', ['field_subtitulo_value'])
          ->fields('img', ['field_image_target_id']);
        $query->leftJoin('node__field_fecha_publicacion', 'fech', 'fech.entity_id = n.nid');
        $query->leftJoin('node__field_titulo', 'tit', 'tit.entity_id = n.nid');
        $query->leftJoin('node__field_subtitulo', 'subt', 'subt.entity_id = n.nid');
        $query->leftJoin('node__field_image', 'img', 'img.entity_id = n.nid');
        
        $query->condition('n.type','programas');
        $query->orderBy('fech.field_fecha_publicacion_value', 'DESC');

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
}
