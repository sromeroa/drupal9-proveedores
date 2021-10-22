<?php

namespace Drupal\bm_registro\Form;

use Drupal\bm_actualdatos\ActualCrearRevision;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\bm_actualdatos\ActualCrearUsuario;
use Drupal\Core\Url;
use Drupal\Core\Routing;
use Drupal\bm_registro\CatalogsRegistro;
use Drupal\bm_registro\EmailRegistro;


/**
 * Implements form.
 */
class RegistroForm extends FormBase
{

    /**
     * 
     */
    protected $catalog_list = [];

    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'bloque_registro_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['#prefix'] = '<div class="c-form__container"><div class="c-form__content-form">';

        // Contacto (ct) / Datos Personales
        $form['ct_nombre'] = [
            '#type' => 'textfield',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#maxlength' => 40,
            '#default_value' => "",
            '#attributes' => ['placeholder' => $this->t('Nombre (s)'), 'class' => ['required withLabel name']],
            '#prefix' => '<div class="c-form__fieldset"><ul class="form-list full"><li><h3 class="c-form__registro-titulo">Datos personales</h3></li><li><span class="currentInput">',
            '#suffix' => '<div class="currentInput-label">Razón Social</div></span></li>',
        ];

        $form['ct_paterno'] = [
            '#type' => 'textfield',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#maxlength' => 40,
            '#default_value' => "",
            '#attributes' => ['placeholder' => $this->t('Apellido paterno'), 'class' => ['required withLabel name']],
            '#prefix' => '<li class="doble"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['ct_materno'] = [
            '#type' => 'textfield',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#maxlength' => 40,
            '#default_value' => "",
            '#attributes' => ['placeholder' => $this->t('Apellido materno'), 'class' => ['required withLabel name']],
            '#prefix' => '<li class="doble mg-left"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];
        
        $form['ct_email'] = [
            '#type' => 'textfield',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#maxlength' => 40,
            '#default_value' => "",
            '#attributes' => ['placeholder' => $this->t('Email'), 'class' => ['required withLabel email']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['ct_telefono'] = [
            '#type' => 'textfield',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#maxlength' => 15,
            '#default_value' => "",
            '#attributes' => ['placeholder' => $this->t('Teléfono Fijo'), 'class' => ['required withLabel onlyNumbers tel']],
            '#prefix' => '<li class="doble"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['ct_celular'] = [
            '#type' => 'textfield',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#maxlength' => 15,
            '#default_value' => "",
            '#attributes' => ['placeholder' => $this->t('Teléfono celular'), 'class' => ['required withLabel onlyNumbers tel']],
            '#prefix' => '<li class="doble mg-left"><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        // $form['usr_password'] = [
        //     '#type' => 'password',
        //     '#title' => $this->t(''),
        //     '#required' => TRUE,
        //     '#maxlength' => 20,
        //     '#default_value' => "",
        //     '#attributes' => ['placeholder' => $this->t('Contraseña'), 'class' => ['required withLabel contrasenia contrasena password']],
        //     '#prefix' => '<li><div class="icon-contrasena js-contrasena"><span class="currentInput listo">',
        //     '#suffix' => '<div class="currentInput-label">Contraseña</div></span><span class="icon ver js-mostrar-pass"></span></div><label class="c-form__registro-pass">Debes utilizar como mínimo 8 caracteres, incluyendo un número, mayúsculas y minúsculas.</label></li>',
        // ];

        // $form['usr_password_confirmacion'] = [
        //     '#type' => 'password',
        //     '#title' => $this->t(''),
        //     '#required' => TRUE,
        //     '#maxlength' => 20,
        //     '#default_value' => "",
        //     '#attributes' => ['placeholder' => $this->t('Confirmar contraseña'), 'class' => ['required withLabel contrasena password']],
        //     '#prefix' => '<li><div class="icon-contrasena js-contrasena"><span class="currentInput listo">',
        //     '#suffix' => '<div class="currentInput-label">Confirmar contraseña</div></span><span class="icon ver js-mostrar-pass"></span></div></li>',
        //];

        $form['ct_editar'] = [
            '#markup' => "",
            '#prefix' => '',
            '#suffix' => '</ul></div>',
        ];

        //// Datos Comerciales (dc)        
        $form['dc_razon_social'] = [
            '#type' => 'textfield',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#maxlength' => 60,
            '#default_value' => "",
            '#attributes' => ['placeholder' => 'Razon Social', 'class' => ['required withLabel']],
            '#prefix' => '<div class="c-form__fieldset"><ul class="form-list full"><li><h3 class="c-form__registro-titulo">Datos comerciales</h3></li><li><span class="currentInput">',
            '#suffix' => '<div class="currentInput-label">Razón Social</div></span></li>',
        ];

        $form['dc_numero_proveedor'] = [
            '#type' => 'textfield',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#maxlength' => 60,
            '#default_value' => "",
            '#attributes' => ['placeholder' => $this->t('Número DUNS'), 'class' => ['required withLabel rfc']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dc_actividad_economica'] = [
            '#type' => 'radios',
            '#title' => $this->t(''),
            '#options' => ['Persona física' => $this->t('Persona física'), 'Persona Moral' => $this->t('Persona Moral'),],
            '#attributes' => ['class' => ['required rfc']],
            '#prefix' => '<li class="c-form__checkbox group-input required"><div class="c-form__registro-label">Actividad económica:</div><div class="c-form__checkbox-inline">',
            '#suffix' => '</div><span class="group-label">Selecciona una opción</span></li>',
        ];

        $form['dc_marca'] = [
            '#type' => 'textfield',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#maxlength' => 60,
            '#default_value' => "",
            '#attributes' => ['placeholder' => $this->t('Marca'), 'class' => ['required withLabel']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        $form['dc_monto_facturacion'] = [
            '#type' => 'textfield',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#maxlength' => 20,
            '#default_value' => "",
            '#attributes' => ['placeholder' => $this->t('Monto de facturación anual'), 'class' => ['required withLabel onlyNumbers']],
            '#prefix' => '<li><span class="currentInput">',
            '#suffix' => '</span></li>',
        ];

        // Importar Catalogos
        $catalogs = new CatalogsRegistro();

        $catalogs->loadPais()
            ->setFirstValue("País en el que desea tener relaciones comerciales");
        $form['dc_relacion_comercial'] = [
            '#type' => 'select',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#default_value' => 0,
            '#options' => $catalogs->getCatalog(),
            '#attributes' => ['class' => ['required']],
            '#prefix' => '<li>',
            '#suffix' => '</li>',
        ];

        $catalogs->setFirstValue("País en los que produce y/o distribuye");
        $form['dc_distribucion'] = [
            '#type' => 'select',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#default_value' => 0,
            '#options' => $catalogs->getCatalog(),
            '#attributes' => ['class' => ['required']],
            '#prefix' => '<li>',
            '#suffix' => '</li>',
        ];
        
        $catalogs->loadCategoria()->setFirstValue("Categoría");
        $form['dc_categoria'] = [
            '#type' => 'select',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#default_value' => 0,
            '#options' => $catalogs->getCatalog(),
            '#attributes' => ['class' => ['required']],
            '#prefix' => '<li>',
            '#suffix' => '</li>',
        ];
        
        $catalogs->loadSubcategoria()->setFirstValue("Sub Categoría");
        $form['dc_subcategoria'] = [
            '#type' => 'select',
            '#title' => $this->t(''),
            '#required' => TRUE,
            '#default_value' => 0,
            '#options' => $catalogs->getCatalog(),
            '#attributes' => ['class' => ['required']],
            '#prefix' => '<li>',
            '#suffix' => '</li>',
        ];

        $form['dc_editar'] = [
            '#markup' => "",
            '#prefix' => '',
            '#suffix' => '</ul></div>',
        ];

        //// Productos que Suministra (ps)        
        $form['ps_productos'] = [
            '#type' => 'multivalue',
            '#title' => $this->t(''),
            '#prefix' => '<fieldset class="c-form__fieldset js-template-producto"><div class="form-list full c-form__productos" id="c-producto__dinamico-1">',
            '#suffix' => '</div></div>',
            'ps_nombre_producto' => [
                '#type' => 'textfield',
                '#title' => $this->t('Name'),
                '#attributes' => ['placeholder' => $this->t('Nombre del producto'), 'class' => ['required withLabel']],
                '#prefix' => '<h3 class="c-form__registro-titulo">Productos que suministra</h3><span class="currentInput">',
                '#suffix' => '<div class="currentInput-label">Nombre del producto</div></span>',
            ],
            'ps_descripcion' => [
                '#type' => 'textarea',
                '#title' => $this->t('E-mail'),
                '#maxlength' => 350,
                '#attributes' => ['placeholder' => $this->t('Descripción'), 'class' => ['js-textarea withLabel required']],
                '#prefix' => '<span class="currentInput listo">',
                '#suffix' => '<div class="currentInput-label">Descripción</div></span><div class="c-form__registro-conta u-text-right"><spanclass="c-form__current js-incremento">0</span><span class="c-form__max">/350</span></div>',
            ],
            'ps_produce' => [
                '#type' => 'radios',
                '#title' => $this->t('Produce'),
                '#options' => ['Si' => $this->t('Si'), 'No' => $this->t('No'),],
                '#prefix' => '<div class="c-form__checkbox group-input required"><div class="c-form__registro-label">Produce:</div><div class="c-form__checkbox-inline c-form__checkbox-margin">',
                '#suffix' => '</div><span class="group-label">Selecciona una opción</span></div>',
                '#attributes' => ['class' => ['required rfc']],
            ],
            'ps_comercializa' => [
                '#type' => 'radios',
                '#title' => $this->t('Comercializa'),
                '#options' => ['Si' => $this->t('Si'), 'No' => $this->t('No'),],
                '#prefix' => '<div class="c-form__checkbox group-input required"><div class="c-form__registro-label">Comercializa:</div><div class="c-form__checkbox-inline c-form__checkbox-margin">',
                '#suffix' => '</div><span class="group-label">Selecciona una opción</span></div>',
                '#attributes' => ['class' => ['required rfc']],
            ],
        ];

        // Acciones
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#attributes' => ['class' => ['btn btn-primario btn-mediano btn-icono-derecha']],
        );

        $form['#attached']['library'][] = 'bimboprov/libs-registro';

        $form['#suffix'] = '</div></div>';

        return $form;
    }

     /**
    * {@inheritdoc}
    */
    /*
    public function validateForm(array &$form, FormStateInterface $form_state) {

        // Validar nombre
        if (!$form_state->getValue('ct_nombre') || empty($form_state->getValue('ct_nombre'))) {
            $form_state->setErrorByName('firstname', $this->t('Campo Nombre requerido.'));
        }

        // Validar apellido paterno
        if (!$form_state->getValue('ct_paterno') || empty($form_state->getValue('lastname'))) {
            $form_state->setErrorByName('lastname', $this->t('Campo Apellido paterno requerido.'));
        }
        
        // Validar apellido materno
        if (!$form_state->getValue('ct_materno') || empty($form_state->getValue('ct_materno'))) {
            $form_state->setErrorByName('ct_materno', $this->t('Campo Apellido materno requerido.'));
        }
        
        // Validar email
        if (!$form_state->getValue('ct_email') || !filter_var($form_state->getValue('ct_email'), FILTER_VALIDATE_EMAIL)) {
            $form_state->setErrorByName('ct_email', $this->t('Agregue un email valido.'));
        }        
        
        // Validar telefono
        if (!$form_state->getValue('ct_telefono') || empty($form_state->getValue('ct_telefono'))) {
            $form_state->setErrorByName('ct_materno', $this->t('Campo Telefono requerido.'));
        }

        // Validar telefono celular
        if (!$form_state->getValue('ct_celular') || empty($form_state->getValue('ct_celular'))) {
            $form_state->setErrorByName('ct_celular', $this->t('Campo Telefono Celular requerido.'));
        }
        
        // Validar password
        if (!$form_state->getValue('usr_password') || empty($form_state->getValue('usr_password'))) {
            $form_state->setErrorByName('usr_password', $this->t('Campo Password requerido.'));
        }

        // Validar confirmacion password
        if (!$form_state->getValue('usr_password_confirmacion') || empty($form_state->getValue('usr_password_confirmacion'))) {
            $form_state->setErrorByName('usr_password_confirmacion', $this->t('Campo Confirmación de Password requerido.'));
        }        

        // Validar numero de proveedor
        if (!$form_state->getValue('dc_numero_proveedor') || empty($form_state->getValue('dc_numero_proveedor'))) {
            $form_state->setErrorByName('dc_numero_proveedor', $this->t('Campo número proveedor requerido.'));
        }        
        
        // Validar actividad economica
        if (!$form_state->getValue('dc_actividad_economica') || empty($form_state->getValue('dc_actividad_economica'))) {
            $form_state->setErrorByName('dc_actividad_economica', $this->t('Campo actividad economica requerido.'));
        }                
        
        // Validar marca
        if (!$form_state->getValue('dc_marca') || empty($form_state->getValue('dc_marca'))) {
            $form_state->setErrorByName('dc_marca', $this->t('Campo marca requerido.'));
        }                
        
        // Validar monto facturacion
        if (!$form_state->getValue('dc_monto_facturacion') || empty($form_state->getValue('dc_monto_facturacion'))) {
            $form_state->setErrorByName('dc_monto_facturacion', $this->t('Campo monto factualzacion requerido.'));
        }        

        // Validar relacion comercial
        if (!$form_state->getValue('dc_relacion_comercial') || empty($form_state->getValue('dc_relacion_comercial'))) {
            $form_state->setErrorByName('dc_relacion_comercial', $this->t('Campo relación comercial requerido.'));
        }        

        // Validar distribucion
        if (!$form_state->getValue('dc_distribucion') || empty($form_state->getValue('dc_distribucion'))) {
            $form_state->setErrorByName('dc_distribucion', $this->t('Campo distribución requerido.'));
        }        
        
        // Validar categoria
        if (!$form_state->getValue('dc_categoria') || empty($form_state->getValue('dc_categoria'))) {
            $form_state->setErrorByName('dc_categoria', $this->t('Campo categoría requerido.'));
        }        
        
        // Validar sub-categoria
        if (!$form_state->getValue('dc_subcategoria') || empty($form_state->getValue('dc_subcategoria'))) {
            $form_state->setErrorByName('dc_subcategoria', $this->t('Campo sub-categoría requerido.'));
        }        

    }
    */

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

        // Crear Usuario
        $crear_user = new ActualCrearUsuario();
        $crear_user->setFields($field_values);
        $usuario_id = $crear_user->crearUsuario();

        // Crear Revision
        if (!empty($usuario_id)) {
            // Crear nodo
            $crear_revision = new ActualCrearRevision();
            $crear_revision->setCampos($field_values);
            $crear_revision->setIDUsuario($usuario_id);
            $crear_revision->crearRevision();

            // Enviar Emails
            if (!empty($field_values['dc_categoria'])) {
                $enviar_emails = new EmailRegistro();
                $enviar_emails->setCategories($field_values['dc_categoria']);
                $enviar_emails->processSendEmails();
            } // end if

            $path = '/datos-enviados';
            $url = Url::fromUserInput($path);
            $form_state->setRedirectUrl($url);

            return;
        } // end if


        $path = '/registro';
        $url = Url::fromUserInput($path);
        $form_state->setRedirectUrl($url);

        return;
    }
}
