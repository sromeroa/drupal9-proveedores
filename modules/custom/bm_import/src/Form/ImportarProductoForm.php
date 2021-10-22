<?php

/**
 * @file
 */

namespace Drupal\bm_import\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\csv_importer\ParserInterface;
use Drupal\csv_importer\Plugin\ImporterManager;
use PDO;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\bm_import\Plugin\Importer\CatalogsImporter;
use Drupal\bm_import\Plugin\Importer\ImporterInstanceProduct;
use Drupal\bm_import\Plugin\Importer\ParserImporterProduct;

class ImportarProductoForm extends FormBase
{

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The entity field manager service.
   *
   * @var \Drupal\Core\Entity\EntityFieldManagerInterface
   */
  protected $entityFieldManager;

  /**
   * The entity bundle info service.
   *
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface
   */
  protected $entityBundleInfo;

  /**
   * The parser service.
   *
   * @var \Drupal\csv_importer\Parser\ParserInterface
   */
  protected $parser;

  /**
   * The renderer service.
   *
   * @var \Drupal\Core\Render\RendererInterface
   */
  protected $renderer;

  /**
   * The importer plugin manager service.
   *
   * @var \Drupal\csv_importer\Plugin\ImporterManager
   */
  protected $importer;

  /**
   * 
   */
  protected $catalog_list = [];

  /**
   * ImporterForm class constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   * @param \Drupal\Core\Entity\EntityFieldManagerInterface $entity_field_manager
   *   The entity field manager service.
   * @param \Drupal\Core\Entity\EntityTypeBundleInfoInterface $entity_bundle_info
   *   The entity bundle info service.
   * @param \Drupal\csv_importer\Parser\ParserInterface $parser
   *   The parser service.
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer service.
   * @param \Drupal\csv_importer\Plugin\ImporterManager $importer
   *   The importer plugin manager service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, EntityFieldManagerInterface $entity_field_manager, EntityTypeBundleInfoInterface $entity_bundle_info, ParserInterface $parser, RendererInterface $renderer, ImporterManager $importer)
  {
    $this->entityTypeManager = $entity_type_manager;
    $this->entityFieldManager = $entity_field_manager;
    $this->entityBundleInfo = $entity_bundle_info;
    $this->parser = $parser;
    $this->renderer = $renderer;
    $this->importer = $importer;

    $catalogs_importer = new CatalogsImporter();

    $this->catalog_list = [
      'pais' => $catalogs_importer->sortPais(),
      'categoria' => $catalogs_importer->sortCategoria(),
      'subcategoria' => $catalogs_importer->sortSubcategoria(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('entity_field.manager'),
      $container->get('entity_type.bundle.info'),
      $container->get('csv_importer.parser'),
      $container->get('renderer'),
      $container->get('plugin.manager.importer')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'importar_producto_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

    $form['importer']['csv'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Seleccionar un archivo'),
      '#description' => $this->t('Selecciona un archivo en formato CSV separado por comas (,)'),
      '#required' => TRUE,
      '#autoupload' => TRUE,
      '#upload_validators' => ['file_validate_extensions' => ['csv']],
      '#weight' => 10,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Importar Productos de Proveedores'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * Entity type AJAX form handler.
   */
  public function getContentEntityTypesAjaxForm(array &$form, FormStateInterface $form_state)
  {
    return $form['importer'];
  }

  /**
   * Get entity type options.
   *
   * @return array
   *   Entity type options.
   */
  protected function getEntityTypeOptions()
  {
    $options = [];
    $plugin_definitions = $this->importer->getDefinitions();

    foreach ($plugin_definitions as $definition) {
      $entity_type = $definition['entity_type'];
      if ($this->entityTypeManager->hasDefinition($entity_type)) {
        $entity = $this->entityTypeManager->getDefinition($entity_type);
        $options[$entity_type] = $entity->getLabel();
      }
    }

    return $options;
  }

  /**
   * Get entity type bundle options.
   *
   * @param string $entity_type
   *   Entity type.
   *
   * @return array
   *   Entity type bundle options.
   */
  protected function getEntityTypeBundleOptions(string $entity_type)
  {
    $options = [];
    $entity = $this->entityTypeManager->getDefinition($entity_type);

    if ($entity && $type = $entity->getBundleEntityType()) {
      $types = $this->entityTypeManager->getStorage($type)->loadMultiple();

      if ($types && is_array($types)) {
        foreach ($types as $type) {
          $options[$type->id()] = $type->label();
        }
      }
    }

    return $options;
  }

  /**
   * Get entity importer plugin options.
   *
   * @param string $entity_type
   *   Entity type.
   *
   * @return array
   *   Entity importer plugin options.
   */
  protected function getEntityTypeImporterOptions(string $entity_type)
  {
    $plugin_definitions = $this->importer->getDefinitions();
    $entity_type_importers = array_keys(array_combine(array_keys($plugin_definitions), array_column($plugin_definitions, 'entity_type')), $entity_type);

    if ($entity_type_importers && is_array($entity_type_importers)) {
      $plugin_definitions = array_intersect_key($plugin_definitions, array_flip($entity_type_importers));

      foreach ($plugin_definitions as $plugin_id => $plugin_defintion) {
        $options[$plugin_id] = $plugin_defintion['label'];
      }
    }

    return $options;
  }

  /**
   * Get entity type fields.
   *
   * @param string $entity_type
   *   Entity type.
   * @param string|null $entity_type_bundle
   *   Entity type bundle.
   *
   * @return array
   *   Entity type fields.
   */
  protected function getEntityTypeFields(string $entity_type, string $entity_type_bundle = NULL)
  {
    $fields = [];

    if (!$entity_type_bundle) {
      $entity_type_bundle = key($this->entityBundleInfo->getBundleInfo($entity_type));
    }

    $entity_fields = $this->entityFieldManager->getFieldDefinitions($entity_type, $entity_type_bundle);
    foreach ($entity_fields as $entity_field) {
      $fields['fields'][] = $entity_field->getName();

      if ($entity_field->isRequired()) {
        $fields['required'][] = $entity_field->getName();
      }
    }

    return $fields;
  }

  /**
   * Get entity missing fields.
   *
   * @param string $entity_type
   *   Entity type.
   * @param array $required
   *   Entity required fields.
   * @param array $csv
   *   Parsed CSV.
   *
   * @return array
   *   Missing fields.
   */
  protected function getEntityTypeMissingFields(string $entity_type, array $required, array $csv)
  {
    $entity_definition = $this->entityTypeManager->getDefinition($entity_type);

    if ($entity_definition->hasKey('bundle')) {
      unset($required[array_search($entity_definition->getKey('bundle'), $required)]);
    }

    $csv_fields = [];

    if (!empty($csv)) {
      foreach ($csv[0] as $csv_row) {
        $csv_row = explode('|', $csv_row);
        $csv_fields[] = $csv_row[0];
      }
    }

    $csv_fields = array_values(array_unique($csv_fields));

    return array_diff($required, $csv_fields);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {

    $csv = current($form_state->getValue('csv'));
    $csv_parse = $this->parser->getCsvById($csv, ',');
    
    // Reemplazar los valores de CSV por las columas correspondientes al producto
    $parser_importer = new ParserImporterProduct();
    $parser_importer->setCSV($csv_parse);
    $current_csv = $parser_importer->getUpdatedCSV();

    $batch = [
      'title' => t('Executing a batch...'),
      'operations' => [
        [
          'bm_import_producto',
          [
           (int)(count($csv_parse) - 1),
           $current_csv
          ],
        ],
      ],
      'finished' => 'bm_import_completed_callback',
      'file' => drupal_get_path('module', 'bm_import') . '/bm_import.producto.inc',
    ];
    batch_set($batch);

  }
}
