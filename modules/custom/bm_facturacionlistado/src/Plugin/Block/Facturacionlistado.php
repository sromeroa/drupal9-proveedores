<?php

namespace Drupal\bm_facturacionlistado\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Url;

/**
 *
 * @Block(
 *   id = "facturacionlistado_block",
 *   admin_label = @Translation("Block Listado de Facturacion  - Bimbo Proveedores")
 * )
 */
class Facturacionlistado extends BlockBase implements ContainerFactoryPluginInterface {

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
      '#theme' => 'facturacionlistado_template',
      '#facturacion' => $this->get_facturacion($nid),
    ];
    return $renderable;
  }

  private function get_facturacion($nid = 0) {
    $response = [];
    if (empty($nid)) {
      return $response;
    } // end if

    global $base_url;
    $content = $this->_facturacion_info($nid);
    if (count($content)) {
      foreach($content as $val) {
        $response[] =
          [
            "titulogeneral" => (isset($val->gen_field_titulo_value) && !empty($val->gen_field_titulo_value)) ? $val->gen_field_titulo_value : "",
            "titulo" => (isset($val->field_titulo_value) && !empty($val->field_titulo_value)) ? $val->field_titulo_value : "",
            "descripcion" => (isset($val->field_descripcion_value) && !empty($val->field_descripcion_value)) ? $val->field_descripcion_value : "",
            "imagen" => (isset($val->field_imagen_target_id) && !empty($val->field_imagen_target_id)) ? $this->image_path($val->field_imagen_target_id) : "",
            "archivodescarga" => (isset($val->field_archivo_de_descarga_target_id) && !empty($val->field_archivo_de_descarga_target_id)) ? $this->image_path($val->field_archivo_de_descarga_target_id) : "",
            "facturacionId" => (isset($val->id) && !empty($val->id)) ? $val->id : "",

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
  private function _facturacion_info($nid = 0) {
    $content = [];
    try {
        $query = \Drupal::database()->select('node', 'n')
          ->fields('n', ['nid'])
          ->fields('tit', ['field_titulo_value'])
          ->fields('subt', ['field_subtitulo_value'])
          ->fields('block', ['field_sub_programas_target_id'])
          ->fields('img', ['field_image_target_id']);
          
        $query->leftJoin('node__field_fecha_publicacion', 'fech', 'fech.entity_id = n.nid');
        $query->leftJoin('node__field_titulo', 'tit', 'tit.entity_id = n.nid');
        $query->leftJoin('node__field_subtitulo', 'subt', 'subt.entity_id = n.nid');
        $query->leftJoin('node__field_image', 'img', 'img.entity_id = n.nid');
        $query->leftJoin('node__field_sub_programas', 'block', 'block.entity_id = n.nid');
        $query->condition('n.type','facturacion');
        $query->condition('block.entity_id',$nid);
        $content = $query->execute()
          ->fetchAll();
          $results = [];
          foreach ($content as $result) {
          $reference =$this->_facturacion_reference_info($result->field_sub_programas_target_id, $nid);
            if ($reference) array_push($results,$reference[0]);
          }
        return $results;
    } catch (\Exception $e) {
      print_r($e->getMessage());
    } // end try - catch
    return $results;
  }
/**
 * @param int $entity_id
 *
 * @return array
 */
function _facturacion_reference_info($entity_id = 0, $nid=0) {
  $results = [];

  if (empty($entity_id)) {
    return $results;
  } // end if

  try {
    $query = \Drupal::database()->select('paragraphs_item', 'dat')
      ->fields('tit', ['field_titulo_value'])
      ->fields('gen', ['field_titulo_value'])
      ->fields('img', ['field_imagen_target_id'])
      ->fields('des', ['field_descripcion_value'])
      ->fields('arc', ['field_archivo_de_descarga_target_id'])
      ->fields('dat', ['id']);
      $query->leftJoin('node__field_titulo', 'gen', 'gen.entity_id ='.$nid);
      $query->leftJoin('paragraph__field_descripcion', 'des', 'des.entity_id = dat.id');
      $query->leftJoin('paragraph__field_titulo', 'tit', 'tit.entity_id = dat.id');
      $query->leftJoin('paragraph__field_imagen', 'img', 'img.entity_id = dat.id');
      $query->leftJoin('paragraph__field_archivo_de_descarga', 'arc', 'arc.entity_id = dat.id');
      $query->condition('dat.id', (int)$entity_id);
      $content = $query->execute()
      ->fetchAll();

      return $content;
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
