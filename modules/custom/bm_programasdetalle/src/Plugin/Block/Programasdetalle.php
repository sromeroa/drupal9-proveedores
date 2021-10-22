<?php

namespace Drupal\bm_programasdetalle\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Url;


/**
 *
 * @Block(
 *   id = "programasdetalle_block",
 *   admin_label = @Translation("Block Detalle de Programa  - Bimbo Proveedores")
 * )
 */
class Programasdetalle extends BlockBase implements ContainerFactoryPluginInterface
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

    $nid = 0;
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      // You can get nid and anything else you need from the node object.
      $nid = $node->id();
    } // end if

    $renderable = [
      '#theme' => 'programasdetalle_template',
      '#programas' => $this->get_programas($nid),
    ];


    return $renderable;
  }

  private function get_programas($nid = 0)
  {
    $response = [];
    if (empty($nid)) {
      return $response;
    } // end if

    global $base_url;
    $response = $this->_programas_info($nid);

    return $response;
  }
  /**
   * @param int $parent
   *
   * @return array|int
   */
  private function _programas_info($nid = 0)
  {
    $content = [];
    $results = [];

    $imagenes = [];

    try {
      $query = \Drupal::database()->select('node', 'n')
        ->fields('n', ['nid'])
        ->fields('tit', ['field_titulo_value'])
        ->fields('subt', ['field_subtitulo_value'])
        ->fields('block', ['field_elementos_descripciones_target_id'])
        ->fields('img', ['field_image_target_id']);
      $query->leftJoin('node__field_fecha_publicacion', 'fech', 'fech.entity_id = n.nid');
      $query->leftJoin('node__field_titulo', 'tit', 'tit.entity_id = n.nid');
      $query->leftJoin('node__field_subtitulo', 'subt', 'subt.entity_id = n.nid');
      $query->leftJoin('node__field_image', 'img', 'img.entity_id = n.nid');
      $query->leftJoin('node__field_elementos_descripciones', 'block', 'block.entity_id = n.nid');
      $query->condition('n.type', 'programas');
      $query->condition('block.entity_id', $nid);
      $content = $query->execute()
        ->fetchAll();
      foreach ($content as $result) {
        $reference = $this->_programas_reference_info($result->field_elementos_descripciones_target_id, $nid);
        if ($reference) array_push($results, $reference[0]);
      }
      $concat = [];
      if (count($results)) {
        $temp = [];
        $templ = [];
        foreach ($results as $val) {
          $listas = $this->listas_paragraph($val->id);
          $imagenes = $this->images_path_paragraph($val->id);
          $archivos = $this->archivos_path_paragraph($nid);
          $temp["id"] = $val->id;
          $temp["field_titulo_value"] = $val->gen_field_titulo_value;
          $temp["field_subtitulo_value"] = $val->field_subtitulo_value;
          $temp["field_imagen"] = $this->image_path($val->field_image_target_id);
          $temp["field_imagen_target_id"] = $imagenes;
          $temp["field_archivos"] = $archivos;
          $temp["field_listas"] = $listas;
          $temp["field_descripcion_value"] = $val->field_descripcion_value;
          array_push($concat, $temp);
        }
      }
      return $concat;
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
  function _programas_reference_info($entity_id = 0, $nid = 0)
  {
    $results = [];
    $imagenes = [];
    if (empty($entity_id)) {
      return $results;
    } // end if

    try {
      $query = \Drupal::database()->select('paragraphs_item', 'dat')
        ->fields('tit', ['field_titulo_value'])
        ->fields('gen', ['field_titulo_value'])
        ->fields('sub', ['field_subtitulo_value'])
        ->fields('imgg', ['field_image_target_id'])
        ->fields('img', ['field_imagen_target_id'])
        ->fields('des', ['field_descripcion_value'])
        ->fields('arc', ['field_archivo_de_descarga_target_id'])
        ->fields('dat', ['id']);
      $query->leftJoin('node__field_titulo', 'gen', 'gen.entity_id =' . $nid);
      $query->leftJoin('node__field_subtitulo', 'sub', 'sub.entity_id =' . $nid);
      $query->leftJoin('node__field_image', 'imgg', 'imgg.entity_id =' . $nid);
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
  private function images_path_paragraph($idParagraph = 0)
  {
    $results = [];
    try {
      $query = \Drupal::database()->select('paragraph__field_imagen', 'dat')
        ->fields('dat', ['field_imagen_target_id']);

      $query->condition('dat.entity_id', (int)$idParagraph);
      $content = $query->execute()
        ->fetchAll();
      if (count($content)) {
        foreach ($content as $val) {
          if (isset($val->field_imagen_target_id) && !empty($val->field_imagen_target_id)) {
            $results[] = $this->image_path($val->field_imagen_target_id);
          }
        } // end foreach
      } // end if
      return $results;
    } catch (\Exception $e) {
      print_r($e->getMessage());
    } // end try - catch
  }




  /**
   * @param string $fid
   *
   * @return string|void
   */
  private function listas_paragraph($idParagraph = 0)
  {
    $results = [];
    try {
      $query = \Drupal::database()->select('paragraph__field_lista', 'dat')
        ->fields('dat', ['field_lista_value']);
      $query->condition('dat.entity_id', (int)$idParagraph);
      $content = $query->execute()
        ->fetchAll();
      if (count($content)) {
        foreach ($content as $val) {
          if (isset($val->field_lista_value) && !empty($val->field_lista_value)) {
            $results[] = $val->field_lista_value;
          }
        } // end foreach
      } // end if
      return $results;
    } catch (\Exception $e) {
      print_r($e->getMessage());
    } // end try - catch
  }


  /**
   * @param string $fid
   *
   * @return string|void
   */
  private function archivos_path_paragraph($nid = 0)
  {
    $results = [];
    $ids = [];
    try {
      $query = \Drupal::database()->select('node__field_archivo_de_descarga', 'dat')
        ->fields('dat', ['field_archivo_de_descarga_target_id']);
      $query->condition('dat.entity_id', (int)$nid);
      $content = $query->execute()
        ->fetchAll();

      if (count($content)) {
        foreach ($content as $val) {
          if (isset($val->field_archivo_de_descarga_target_id) && !empty($val->field_archivo_de_descarga_target_id)) {
            $ids[] = $val->field_archivo_de_descarga_target_id;
          }
        } // end foreach
      } // end if

      $content = [];
      if (count($ids) > 0) {
        $query = \Drupal::database()->select('paragraphs_item', 'dat')
          ->fields('tit', ['field_titulo_documento_value'])
          ->fields('arc', ['field_archivo_de_descarga_target_id'])
          ->fields('dat', ['id']);
        $query->leftJoin('paragraph__field_titulo_documento', 'tit', 'tit.entity_id = dat.id');
        $query->leftJoin('paragraph__field_archivo_de_descarga', 'arc', 'arc.entity_id = dat.id');

        $query->condition('dat.id', $ids, 'IN');

        $content = $query->execute()
          ->fetchAll();
      } // end if

      if (count($content)) {
        foreach ($content as $val) {
          $temp = [];
          if (isset($val->field_archivo_de_descarga_target_id) && !empty($val->field_archivo_de_descarga_target_id)) {
            $temp["name"] = $val->field_titulo_documento_value;
            $temp["id"] = $val->id;
            $temp["path"] = $this->image_path($val->field_archivo_de_descarga_target_id);
          }
          array_push($results, $temp);
        } // end foreach
      } // end if
      return $results;
    } catch (\Exception $e) {
      print_r($e->getMessage());
    } // end try - catch

  }


  /**
   * @param string $fid
   *
   * @return string|void
   */
  private function image_path($fid = "")
  {
    $file_url = "";
    if (empty($fid)) {
      return $file_url;
    } // end ir
    $file = \Drupal\file\Entity\File::load($fid);
    $file_url = $file->createFileUrl();
    return $file_url;
  }
}
