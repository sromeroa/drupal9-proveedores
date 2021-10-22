<?php

namespace Drupal\bm_actualdatos\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\bm_actualdatos\ActualEditar;
use Drupal\bm_actualdatos\ActualInfoUsuario;

/**
 * Implements form.
 */
class ActualdatosForm extends FormBase
{

  /**
   * @var int
   */
  private $uid = 0;

  /**
   * @var int
   */
  private $nid = 0;

  /**
   * Form constructor.
   *
   * @param $uid
   */
    function __construct() {
        $this->uid = \Drupal::currentUser()->id();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'actualdatos_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        
        $info_user = new ActualInfoUsuario($this->uid);
        $this->nid = $info_user->getUserNID();
        $field_values = $info_user->getContenidoUsuario($this->nid);
        
        $form['#prefix'] = '<div class="c-form-actualizacion-datos">';

           //// Datos Comerciales (dc)
           $form['dc_razon_social'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dc_razon_social'])) ? $field_values['dc_razon_social'] : "",
            '#attributes' => ['placeholder' => 'Razon Social', 'data-name' => t('Razon Social'), 'class' => ['withLabel block']],
            '#prefix' => '<div class="c-form-actualizacion-datos__field js-datos-focus" disabled=""><h4>Datos comerciales</h4><ul class="form-list full"><li class="c-form-actualizacion-datos__candado js-block-group"><a href="" title="Bloquear campos"><span class="icon candado"></span></a></li><li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dc_numero_proveedor'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dc_numero_proveedor'])) ? $field_values['dc_numero_proveedor'] : "",
            '#attributes' => ['placeholder' => t('Número proveedor'), 'data-name' => t('Número proveedor'), 'class' => ['withLabel onlyNumbers block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dc_nombre_comercial'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dc_nombre_comercial'])) ? $field_values['dc_nombre_comercial'] : "",
            '#attributes' => ['placeholder' => t('Nombre Comercial'), 'data-name' => t('Nombre Comercial'), 'class' => ['withLabel block']],
            '#prefix' => '<li ><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];
        $form['dc_rfc'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_rfc'])) ? $field_values['dc_rfc'] : "",
            '#attributes' => ['placeholder' => t('R.F.C.'),  'data-name' => t('R.F.C.'), 'class' => ['withLabel rfc block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dc_actividad_economica'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_actividad_economica'])) ? $field_values['dc_actividad_economica'] : "",
            '#attributes' => ['placeholder' => t('Actividad economica'), 'data-name' => t('Actividad economica'), 'class' => ['withLabel block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];
        $form['dc_regimen_fiscal'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_regimen_fiscal'])) ? $field_values['dc_regimen_fiscal'] : "",
            '#attributes' => ['placeholder' => t('Regimen Fiscal'), 'data-name' => t('Regimen Fiscal'), 'class' => ['withLabel block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dc_clasificacion_empresa'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_clasificacion_empresa'])) ? $field_values['dc_clasificacion_empresa'] : "",
            '#attributes' => ['placeholder' => t('Clasificaión tamaño de empresa'), 'data-name' => t('Clasificaión tamaño de empresa'), 'class' => ['withLabel block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];
        $form['dc_no_colaboradores'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_no_colaboradores'])) ? $field_values['dc_no_colaboradores'] : "",
            '#attributes' => ['placeholder' => t('Número de Colaboradores'), 'data-name' => t('Número de Colaboradores'), 'class' => ['withLabel block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];


        $form['dc_nivel_ventas'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_nivel_ventas'])) ? $field_values['dc_nivel_ventas'] : "",
            '#attributes' => ['placeholder' => t('Nivel de ventas(Millores de pesos)'), 'data-name' => t('Nivel de ventas(Millores de pesos)'), 'class' => ['withLabel block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

      


        $form['dc_numero_duns'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_numero_duns'])) ? $field_values['dc_numero_duns'] : "",
            '#attributes' => ['placeholder' => t('Número Duns'), 'data-name' => t('Número Duns'), 'class' => ['withLabel block']],
            '#prefix' => '<li ><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

      

        $form['dc_giro_comercial'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_giro_comercial'])) ? $field_values['dc_giro_comercial'] : "",
            '#attributes' => ['placeholder' => t('Giro Comercial de la Empresa'), 'data-name' => t('Giro Comercial de la Empresa'), 'class' => ['withLabel block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];
        $form['dc_especialidad'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_especialidad'])) ? $field_values['dc_especialidad'] : "",
            '#attributes' => ['placeholder' => t('Especialidad a la que Cooresponde'), 'data-name' => t('Especialidad a la que Cooresponde'), 'class' => ['withLabel block']],
            '#prefix' => '<li ><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];


        $form['dc_nombre_respresantante'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_nombre_respresantante'])) ? $field_values['dc_nombre_respresantante'] : "",
            '#attributes' => ['placeholder' => t('Nombre de su representante legal'), 'data-name' => t('Nombre de su representante legal'), 'class' => ['withLabel block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];
        $form['dc_genero_direccion'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_genero_direccion'])) ? $field_values['dc_genero_direccion'] : "",
            '#attributes' => ['placeholder' => t('Genero que preside la direccion general de la empresa'), 'data-name' => t('Genero que preside la direccion general de la empresa'), 'class' => ['withLabel block']],
            '#prefix' => '<li ><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];



        $form['dc_en_fideicomiso'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_en_fideicomiso'])) ? $field_values['dc_en_fideicomiso'] : "",
            '#attributes' => ['placeholder' => t('Esta incorporado al Fideicomiso de Grupo Bimbo - Nafinsa'), 'data-name' => t('Esta incorporado al Fideicomiso de Grupo Bimbo - Nafinsa'), 'class' => ['withLabel block']],
            '#prefix' => '<li ><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];



        $form['dc_con_certificaciones'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#maxlength' => 12,
            '#default_value' => (isset($field_values['dc_con_certificaciones'])) ? $field_values['dc_con_certificaciones'] : "",
            '#attributes' => ['placeholder' => t('Cuenta con Certificaciones con vigencia a 2 años de acuerdo a su giro comercial'), 'data-name' => t('Cuenta con Certificaciones con vigencia a 2 años de acuerdo a su giro comercial'), 'class' => ['withLabel block']],
            '#prefix' => '<li ><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];


   /*      $form['dc_termino_credito'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dc_termino_credito'])) ? $field_values['dc_termino_credito'] : "",
            '#attributes' => ['placeholder' => t('Término de Credito'), 'data-name' => t('R.F.C.'), 'class' => ['withLabel block']],
            '#prefix' => '<li class="doble mg-left"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ]; 

      

        $form['dc_pais'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dc_pais'])) ? $field_values['dc_pais'] : "",
            '#attributes' => ['placeholder' => t('País'), 'data-name' => t('R.F.C.'), 'class' => ['withLabel block']],
            '#prefix' => '<li class="doble mg-left"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dc_editar'] = [
            '#markup' => "",
            '#prefix' => '',
            '#suffix' => '<div class="c-form-actualizacion-datos__editar"><a class="js-desbloquear-fieldset" href="#!" title="Editar Datos Comerciales"><span class="icon editar"></span><p>Editar Datos Comerciales</p></a></div></div>',
        ];
*/

        //// Domicilio (dm)
        $form['dm_calle'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dm_calle'])) ? $field_values['dm_calle'] : "",
            '#attributes' => ['placeholder' => 'Calle', 'data-name' => t('Calle'), 'class' => ['withLabel block']],
            '#prefix' => '<div class="c-form-actualizacion-datos__field js-datos-focus" disabled=""><h4>Domicilio</h4><ul class="form-list full"><li class="c-form-actualizacion-datos__candado js-block-group"><a href="" title="Bloquear campos"><span class="icon candado"></span></a></li><li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dm_no_interior'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dm_no_interior'])) ? $field_values['dm_no_interior'] : "",
            '#attributes' => ['placeholder' => t('No. Interior'), 'data-name' => t('No. Interior'), 'class' => ['withLabel onlyNumbers block']],
            '#prefix' => '<li class="doble"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dm_no_exterior'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dm_no_exterior'])) ? $field_values['dm_no_exterior'] : "",
            '#attributes' => ['placeholder' => t('No. Exterior'), 'data-name' => t('No. Exterior'), 'class' => ['withLabel onlyNumbers block']],
            '#prefix' => '<li class="doble mg-left"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dm_colonia'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dm_colonia'])) ? $field_values['dm_colonia'] : "",
            '#attributes' => ['placeholder' => t('Colonia'), 'data-name' => t('Colonia'), 'class' => ['withLabel block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dm_cp'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dm_cp'])) ? $field_values['dm_cp'] : "",
            '#attributes' => ['placeholder' => t('Código postal'), 'data-name' => t('Código postal'), 'class' => ['withLabel block']],
            '#prefix' => '<li class="doble"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dm_estado'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dm_estado'])) ? $field_values['dm_estado'] : "",
            '#attributes' => ['placeholder' => t('Estado'), 'data-name' => t('Estado'), 'class' => ['withLabel block']],
            '#prefix' => '<li class="doble mg-left"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dm_ciudad'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dm_ciudad'])) ? $field_values['dm_ciudad'] : "",
            '#attributes' => ['placeholder' => t('Ciudad'), 'data-name' => t('Ciudad'), 'class' => ['withLabel block']],
            '#prefix' => '<li class="doble"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dm_municipio'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dm_municipio'])) ? $field_values['dm_municipio'] : "",
            '#attributes' => ['placeholder' => t('Municipio'), 'data-name' => t('Municipio'), 'class' => ['withLabel block']],
            '#prefix' => '<li class="doble mg-left"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['archivo_pdf'] = [
            '#type' => 'managed_file',
            '#title' => t(''),
            '#upload_location' => 'private://certfiles',
            '#required' => FALSE,
            '#upload_validators' => [
                'file_validate_extensions' => ['pdf'],
            ],            
            '#attributes' => ['placeholder' => t('Municipio'), 'data-name' => t('Municipio'), 'class' => ['js-data-file file block']],
            '#prefix' => '<li class="c-form-actualizacion-datos__customFileInput js-detect-error"><label class="c-form-actualizacion-datos__customFileInput-label js-add-file-class block">',
            '#suffix' => '<span class="c-form-actualizacion-datos__customFileInput-span">Anexar comprobante de domicilio</span></label><span class="group-label-format">Formato .PDF</span><span class="group-label">Selecciona un archivo PDF</span></li>',
        ];
        
        $form['dm_editar'] = [
            '#markup' => "",
            '#prefix' => '',
            '#suffix' => '<div class="c-form-actualizacion-datos__editar"><a class="js-desbloquear-fieldset" href="#!" title="Editar Domicilio"><span class="icon editar"></span><p>Editar Datos Comerciales</p></a></div></div>',
        ];        

        //// Datos generales de contacto (dgc)
        $form['dgc_lada'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dgc_lada'])) ? $field_values['dgc_lada'] : "",
            '#attributes' => ['placeholder' => 'Lada', 'data-name' => t('Lada'), 'class' => ['withLabel onlyNumbers block']],
            '#prefix' => '<div class="c-form-actualizacion-datos__field js-datos-focus" disabled=""><h4>Datos generales de contacto</h4><ul class="form-list full"><li class="c-form-actualizacion-datos__candado js-block-group"><a href="" title="Bloquear campos"><span class="icon candado"></span></a></li><li class="doble"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dgc_telefono'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dgc_telefono'])) ? $field_values['dgc_telefono'] : "",
            '#attributes' => ['placeholder' => t('Telefono'), 'data-name' => t('Telefono'), 'class' => ['withLabel onlyNumbers tel block']],
            '#prefix' => '<li class="doble mg-left"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dgc_codigo_fax'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dgc_codigo_fax'])) ? $field_values['dgc_codigo_fax'] : "",
            '#attributes' => ['placeholder' => t('Código Fax'), 'data-name' => t('Código Fax'), 'class' => ['withLabel onlyNumbers block']],
            '#prefix' => '<li class="doble"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dgc_fax'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['dgc_fax'])) ? $field_values['dgc_fax'] : "",
            '#attributes' => ['placeholder' => t('Fax'), 'data-name' => t('Fax'), 'class' => ['withLabel onlyNumbers block']],
            '#prefix' => '<li class="doble mg-left"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dgc_editar'] = [
            '#markup' => "",
            '#prefix' => '',
            '#suffix' => '<div class="c-form-actualizacion-datos__editar"><a class="js-desbloquear-fieldset" href="#!" title="Editar Generales"><span class="icon editar"></span><p>Editar Datos Comerciales</p></a></div></div>',
        ];        

        // Contacto (ct)
        $form['ct_nombre'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['ct_nombre'])) ? $field_values['ct_nombre'] : "",
            '#attributes' => ['placeholder' => 'Nombre (s)', 'data-name' => t('Nombre (s)'), 'class' => ['withLabel name block']],
            '#prefix' => '<div class="c-form-actualizacion-datos__field js-datos-focus" disabled=""><h4>Datos generales de contacto</h4><ul class="form-list full"><li class="c-form-actualizacion-datos__candado js-block-group"><a href="" title="Bloquear campos"><span class="icon candado"></span></a></li><li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['ct_paterno'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['ct_paterno'])) ? $field_values['ct_paterno'] : "",
            '#attributes' => ['placeholder' => t('Apellido paterno'), 'data-name' => t('Apellido paterno'), 'class' => ['withLabel name block']],
            '#prefix' => '<li class="doble"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['ct_materno'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['ct_materno'])) ? $field_values['ct_materno'] : "",
            '#attributes' => ['placeholder' => t('Apellido materno'), 'data-name' => t('Apellido materno'), 'class' => ['withLabel name block']],
            '#prefix' => '<li class="doble mg-left"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['ct_profesion'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['ct_profesion'])) ? $field_values['ct_profesion'] : "",
            '#attributes' => ['placeholder' => t('Profesion'), 'data-name' => t('Profesion'), 'class' => ['withLabel name block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['ct_email'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['ct_email'])) ? $field_values['ct_email'] : "",
            '#attributes' => ['placeholder' => t('Email'), 'data-name' => t('Email'), 'class' => ['withLabel email block']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['ct_lada'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['ct_lada'])) ? $field_values['ct_lada'] : "",
            '#attributes' => ['placeholder' => t('Lada'), 'data-name' => t('Lada'), 'class' => ['withLabel onlyNumbers block']],
            '#prefix' => '<li class="doble"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['ct_telefono'] = [
            '#type' => 'textfield',
            '#title' => t(''),
            '#required' => TRUE,
            '#default_value' => (isset($field_values['ct_telefono'])) ? $field_values['ct_telefono'] : "",
            '#attributes' => ['placeholder' => t('Telefono'), 'data-name' => t('Telefono'), 'class' => ['withLabel onlyNumbers tel block']],
            '#prefix' => '<li class="doble mg-left"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['ct_editar'] = [
            '#markup' => "",
            '#prefix' => '',
            '#suffix' => '<div class="c-form-actualizacion-datos__editar"><a class="js-desbloquear-fieldset" href="#!" title="Editar Contacto"><span class="icon editar"></span><p>Editar Datos Comerciales</p></a></div></div>',
        ];        

        // Informacion valida (debe ir vacio para generar la evaluacion de la informacion)
        $form['informacion_valida'] = [
            '#type' => 'hidden',
            '#title' => t(''),
            '#default_value' => '',
        ];

        // Acciones
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#attributes' =>  ['class' => ['btn btn-primario btn-mediano btn-icono-derecha']],            
        );

        $form['#suffix'] = '</div>';

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $field_values = $form_state->getValues();
        unset($field_values['submit']);
        unset($field_values['form_build_id']);
        unset($field_values['form_token']);
        unset($field_values['form_id']);
        unset($field_values['op']);        
        
        $editar_user = new ActualEditar($this->nid, $this->uid, $field_values);
        $editar_user->EditarProveedor();
        
        if ($editar_user->Response()) {
            $url = Url::fromRoute('<front>');
            $form_state->setRedirectUrl($url);    
        } // end if

        return;
    }
}
