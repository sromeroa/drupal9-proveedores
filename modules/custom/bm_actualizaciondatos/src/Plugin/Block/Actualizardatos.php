<?php

namespace Drupal\bm_actualizardatos\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\bm_actualizardatos\ActualEditar;
use Drupal\bm_actualizardatos\ActualInfoUsuario;
use Drupal\Core\Cache\Cache;

use \Drupal\Core\Url;

/**
 *
 * @Block(
 *   id = "actualizardatos_block",
 *   admin_label = @Translation("Block actualzar datos - Bimbo Proveedores")
 * )
 */
class actualizardatos extends BlockBase implements ContainerFactoryPluginInterface {

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
    $actualizardatos= $this->getUserData();

      $uid_f = \Drupal::currentUser()->id();
      $info_user = new ActualInfoUsuario($uid_f);
      $nid_f=$this->getUserNID();
      $field_values = $info_user->getContenidoUsuario($nid_f);

      
      $campos_post=$field_values;
     if($_SERVER['REQUEST_METHOD']==="POST"){
      $campos_post=$_POST;
     
   
       
    }
    $editar_user = new ActualEditar($nid_f, $uid_f, $campos_post);
      $editar_user->EditarProveedor();
   
  
    $nid = 0;
    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      // You can get nid and anything else you need from the node object.
      $nid = $node->id();
    } // end if
   
    
    $renderable = [
      '#theme' => 'actualizardatos_template',
      '#actualizardatos' => $field_values,
      '#catalogos' => $this->getcatalogos(),
    ];
  
    return $renderable;
  }


 



  private function getUserData() {
  
    $response = [];
    $current_user = \Drupal::currentUser()->id();
    $user = user_load($current_user);
    $userName = $user->get('name')->value;
    global $base_url;
    $content = $this->_userdata_info($current_user,$userName);


   
    return $content;
    if (count($content)) {
      foreach($content as $val) {

        $nid = (isset($val->nid) && !empty($val->nid)) ? $val->nid : "";
        $options = ['absolute' => TRUE];
        $url_object = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => $nid], $options);

        $response[] =
          [
            "fecha" => (isset($val->field_fecha_publicacion_value) && !empty($val->field_fecha_publicacion_value)) ? $val->field_fecha_publicacion_value : "",
            "titulo" => (isset($val->field_titulo_value) && !empty($val->field_titulo_value)) ? $val->field_titulo_value : "",
            "subtitulo" => (isset($val->field_subtitulo_value) && !empty($val->field_subtitulo_value)) ? $val->field_subtitulo_value : "",
            "imagen" => (isset($val->field_image_target_id) && !empty($val->field_image_target_id)) ? $this->image_path($val->field_image_target_id) : "",
            "noticiaId" => $url_object,
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
  private function _userdata_info($user=0,$userName=null) {
    $fields =$this->enlaces_taxonomy();
 
 
    $fields_campos =$this->enlaces_taxonomy();
    $campos=$fields["CAMPOS"];
    $catalogos=$fields["CATALOGOS"];
    sort($campos);
    sort($catalogos);
    $results = [];

    try {
      $query = \Drupal::database()->select('node__field_proveedor', 'fhi')
      ->fields('fhi', ['entity_id']);
    $query->condition('fhi.field_proveedor_target_id', $user);
    $query->orderBy('fhi.delta', 'ASC');
    $entity = $query->execute()
    //  ->fetchAll();
      ->fetchField();
     $resultado_de_campos=[];
      foreach ($campos as $key => $value) {
        $result=$this->campos($value,$entity,"campo");
        $resultado_de_campos[$value]=$result;
      }
     $resultado_de_catalogos=[];
     foreach ($catalogos as $key => $value) {
       $result=$this->campos($value,$entity, "catalogo");
       if(count($result)>0)$resultado_de_campos[$value]=$result;
       else $resultado_de_campos[$value]="";
     }
    } catch (\Exception $e) {
      print_r($e->getMessage());
    } // end try - catch
    return $resultado_de_campos;
  }

  public function campos($campo=null, $entity=0,$tipo=null){
  if($tipo=="campo") {
      try {
        $query = \Drupal::database()->select('node__'.$campo, 'fhi')
        ->fields('fhi', [$campo.'_value']);
        $query->condition('fhi.entity_id', $entity);
        $query->orderBy('fhi.entity_id', 'ASC');
        $content = $query->execute()
        //  ->fetchAll();
        ->fetchField();
        //code...
      } catch (\Exception $e) {
        print_r($e->getMessage());
      } // end try - catch
      return $content;
    }
  if($tipo=="catalogo") {
      $result=[];
      try {
        $query = \Drupal::database()->select('node__'.$campo, 'fhi')
        ->fields('fhi', [$campo.'_target_id']);
        $query->condition('fhi.entity_id', $entity);
        $query->orderBy('fhi.entity_id', 'ASC');
        $content = $query->execute()
        ->fetchAll();
      } catch (\Exception $e) {
        print_r($e->getMessage());
      } // end try - catch
      if (count($content)) {
        foreach($content as $val) {
          foreach ($val as $va) 
            array_push($result,$va);
        } // end foreach
      } // end if
      return $result;
  }
}

   /**
   * @param int $parent
   *
   * @return array|int
   */
  public function getCatalogos($parent = 0) {
    $results = [];
    $catalogo_nombre=[];

    try {
        $query = \Drupal::database()->select('taxonomy_term__field_catalogo', 'cat')
          ->fields('cat', ['entity_id'])
          ->fields('ext', ['description__value'])
          ->fields('cat', ['field_catalogo_value']);
        $query->leftJoin('taxonomy_term_field_data', 'ext', 'ext.tid = cat.entity_id');
        $query->condition('cat.bundle', 'equivalencias_campos_importador');
        $query->condition('ext.vid', 'equivalencias_campos_importador');
        $content = $query->execute()
          ->fetchAll();
        $catalogos=[];
        if (count($content)) {
            foreach($content as $val) {
                if (isset($val->entity_id) && !empty($val->entity_id)) {
                    array_push($catalogos,$val->entity_id);
                }
            } // end foreach
        } // end if

      
    
        foreach ($content as $key => $value) {
        
          $query = \Drupal::database()->select('taxonomy_term_field_data', 'ttf')
          ->fields('ttf', ['tid'])
          ->fields('ttf', ['name']);
        $query->condition('ttf.vid', $value->field_catalogo_value);
        
      //  $query->condition('ttf.tid', $catalogos, 'NOT IN');
        $content = $query->execute()
          ->fetchAll();

          
        $catalogo_nombre[$value->description__value]=$content;
         
        }

      
     
    } catch (\Exception $e) {
    } // end try - catch
    return $catalogo_nombre;
  }
   /**
   * @param int $parent
   *
   * @return array|int
   */
  public function enlaces_taxonomy() {
    $results = [];
    $results_CAT = [];
    try {
        $query = \Drupal::database()->select('taxonomy_term__field_catalogo', 'cat')
          ->fields('cat', ['entity_id']);
        $query->condition('cat.bundle', 'equivalencias_campos_importador');
        $content = $query->execute()
          ->fetchAll();

        $catalogos=[];
        if (count($content)) {
            foreach($content as $val) {
                if (isset($val->entity_id) && !empty($val->entity_id)) {
                    array_push($catalogos,$val->entity_id);
                }
            } // end foreach
        } // end if
        $query = \Drupal::database()->select('taxonomy_term_field_data', 'ttf')
          ->fields('ttf', ['tid'])
          ->fields('ttf', ['description__value']);
        $query->condition('ttf.vid', 'equivalencias_campos_importador');
        $query->condition('ttf.tid', $catalogos, 'NOT IN');
        $content = $query->execute()
          ->fetchAll();

          $query_CAT = \Drupal::database()->select('taxonomy_term_field_data', 'ttf')
          ->fields('ttf', ['tid'])
          ->fields('ttf', ['description__value']);
        $query_CAT->condition('ttf.vid', 'equivalencias_campos_importador');
        $query_CAT->condition('ttf.tid', $catalogos, 'IN');
        $content_CAT = $query_CAT->execute()
          ->fetchAll();


         
        if (count($content_CAT)) {
          foreach($content_CAT as $val) {
            if (isset($val->description__value) && !empty($val->description__value)) {
              array_push($results_CAT,$val->description__value);
            }
          } // end foreach
        } // end if
        if (count($content)) {
          foreach($content as $val) {
            if (isset($val->description__value) && !empty($val->description__value)) {
              array_push($results,$val->description__value);
            }
          } // end foreach
        } // end if
    } catch (\Exception $e) {
    } // end try - catch

   
   
    return ["CAMPOS"=>$results,"CATALOGOS"=>$results_CAT];
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
  
  public function getUserNID() {

    $nid = 0;
    $uid_f = \Drupal::currentUser()->id();
    try {
      $query = \Drupal::entityQuery('node')
      ->condition('type', 'user_revision')
      ->condition('field_proveedor', $uid_f);
      $results = $query->execute();

      $array_values = array_values($results);
      $nid = (isset($array_values[0])) ? $array_values[0] : $nid;

    } catch (\Exception $e) {
    } // try - catch

    return $nid;
  }
  public function getCacheTags() {
    $nid_f=$this->getUserNID();
   // return Cache::mergeTags(parent::getCacheTags(), array('node:'.$nid_f));
     return Cache::mergeTags(parent::getCacheTags(), array('node_list'));

  }

}
