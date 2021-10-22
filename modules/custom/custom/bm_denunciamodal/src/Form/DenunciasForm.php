<?php

namespace Drupal\bm_politicasmodal\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use \Drupal\user\Entity\User;
use Drupal\Core\Url;
use Drupal\paragraphs\Entity\Paragraph;

/**
 * Implements form.
 */
class PoliticasForm extends FormBase
{
    /**
     * {@inheritdoc}
     */
    public function getFormId()
    {
        return 'politicas_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $current_user = \Drupal::currentUser()->id();
        $politicas = $this->get_politicas_popup($current_user);

        if (count($politicas) <= 0) {
            return $form;
        } // end if

        $form['#prefix'] = '<div class="c-modal"><div class="c-modal__container">';

        $form['titulo'] =
            [
                '#markup' => $politicas['titulo'],
                '#prefix' => '<div class="c-modal__titulo"><h3>',
                '#suffix' => '</h3></div>',
            ];
        $form['descripcion'] = [
            '#markup' => $politicas['descripcion'],
            '#prefix' => '<div class="c-modal__texto"><span class="c-modal__blur"></span><div class="c-modal__texto-contenido">',
            '#suffix' => '</div></div>',
        ];

        $form['politica'] = array(
            '#type' => 'hidden',
            '#required' => TRUE,
            '#value' => $politicas['nid'],
        );

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Acepto Políticas'),
            '#prefix' => '<div class="c-modal__boton">',
            '#suffix' => '</div>',
        );

        $form['actions']['submit']['#attributes']['class'] = array('btn btn-primario btn-grande js-modal');

        $form['#suffix'] = '</div></div>';

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {

        $id_politica = $form_state->getValue('politica');
        $this->_agregar_politica_fe((int)$id_politica);

        $url = Url::fromRoute('<front>');
        $form_state->setRedirectUrl($url);
        return;
    }

    /**
     * Obtener las politicas de los usuarios
     */
    private function get_politicas_popup($uid = 0)
    {

        $informacionUsuario = $this->_politicas_fe_info($uid);

        if (!$informacionUsuario) {

            //usuario sin aceptar nada
            $politicasDisponibles = $this->_politicas_disponibles_fe_info($uid);
            $info = $this->_get_info_politica($politicasDisponibles[0]->nid);

            if ($info) return $info;
        } else {

            //usuario con politicas y sin metodo Get 
            $politicasDisponibles = $this->_politicas_disponibles_fe_info($uid);
            $politicasAceptadas = $this->_politicas_fe_info($uid);

            $ids = [];
            foreach ($politicasAceptadas as $politicaAcept)
                $ids[$politicaAcept->field_politica_target_id] = $politicaAcept->field_fecha_aceptacion_value;

            /////FOREACH QUE VALIDA  POLITICAS  CUANDO NO HAN SIDO ACEPTADAS
            foreach ($politicasDisponibles as $politica) {
                if (!array_key_exists($politica->nid, $ids)) {
                    $info = $this->_get_info_politica($politica->nid);
                    if ($info) {
                        return $info;
                    }
                }
            }

            /////FOREACH QUE VALIDA LA VIGENCIA DE LAS POLITICAS
            foreach ($politicasDisponibles as $politica) {
                if (array_key_exists($politica->nid, $ids)) {
                    foreach ($ids as $id => $fecha) {
                        if ($id == $politica->nid) {
                            if (strtotime($politica->field_fecha_actualizacion_value) > strtotime($fecha)) {
                                $info = $this->_get_info_politica($politica->nid);
                                if ($info)  return $info;
                            }
                        }
                    }
                }
            }
            return [];  // si todo aceptado
        }
    }

    /**
     * @param int $parent
     *
     * @return array|int
     */
    private function _get_info_politica($politicaId = 0)
    {
        $result = $this->get_politica($politicaId);
        $response =
            [
                "titulo" => (isset($result[0]->field_titulo_value) && !empty($result[0]->field_titulo_value)) ? $result[0]->field_titulo_value : "",
                "descripcion" => (isset($result[0]->field_descripcion_value) && !empty($result[0]->field_descripcion_value)) ? $result[0]->field_descripcion_value : "",
                "nid" => (isset($result[0]->nid) && !empty($result[0]->nid)) ? $result[0]->nid : "",
            ];
        return $response;
    }

    /**
     * @param int $parent
     *
     * @return array|int
     */
    private function _agregar_politica_fe($politicaId = 0)
    {
        $uid = \Drupal::currentUser()->id();
        $politicas = $this->_politicas_fe_info($uid);
        try {
            $ids = [];
            foreach ($politicas as $politica) {
                $ids[$politica->field_politica_target_id]["field_fecha_aceptacion_value"] = $politica->field_fecha_aceptacion_value;
                $ids[$politica->field_politica_target_id]["field_politicas_target_id"] = $politica->field_politicas_target_id;
                $ids[$politica->field_politica_target_id]["field_politica_target_id"] = $politica->field_politica_target_id;
            }
            $user = user_load($uid);

            if (array_key_exists($politicaId, $ids)) {

                foreach ($ids as $valores) {
                    if ($valores["field_politica_target_id"] == $politicaId) {
                        $paragraph = Paragraph::load($valores["field_politicas_target_id"]);
                        $paragraph->field_politica = [$politicaId];
                        $paragraph->field_fecha_aceptacion = [date("Y-m-d\TH:i:s")];
                        $paragraph->set('field_politica', $paragraph->toArray()["field_politica"]);
                        $violations = $paragraph->validate();
                        $paragraph->save();
                        return 0;
                    }
                }
            }
            if (!array_key_exists($politicaId, $ids)) {
                $user = user_load($uid);

                //  $politicas=$this->_politicas_fe_info($uid);
                $paragraph = Paragraph::create(['type' => 'actualizacion_politicas',]);
                $paragraph->field_politica = [$politicaId];
                $paragraph->field_fecha_aceptacion = date("Y-m-d\TH:i:s");
                $paragraph->parent_id[] = ['value' => 1];
                $paragraph->parent_type[] = ['value' => "user"];
                $paragraph->parent_field_name[] = ['value' => "field_politicas"];
                $paragraph->save();
                $user = user_load($uid);
                $user->field_politicas[] = [
                    'target_id' => $paragraph->id(),
                    'target_revision_id' => $paragraph->getRevisionId()
                ];
                $user->set('field_politicas', $user->toArray()["field_politicas"]);
                $violations = $user->validate();
                if (count($violations) === 0)
                    $user->save();
                return;
            }
        } catch (\Exception $e) {
            //($e->getMessage());
        } //
    }


    /**
     * @param int $parent
     *
     * @return array|int
     */
    private function get_politica($politicaId = 0)
    {
        $results = [];
        try {
            $query = \Drupal::database()->select('node_field_revision', 'pol')
                ->fields('pol', ['nid'])
                ->fields('tit', ['field_titulo_value'])
                ->fields('desc', ['field_descripcion_value']);
            $query->leftJoin('node__field_descripcion', 'desc', 'desc.entity_id = pol.nid');
            $query->leftJoin('node__field_titulo', 'tit', 'tit.entity_id = pol.nid');
            $query->condition('pol.nid', (int)$politicaId);
            $results = $query->execute()
                ->fetchAll();
        } catch (\Exception $e) {
            //($e->getMessage());
        } // end try - catch
        return $results;
    }

    /**
     * @param int $parent
     *
     * @return array|int
     */
    private function _politicas_fe_info($nid = 0)
    {
        $results = [];
        $user = user_load($nid);
        $entity_type = 'paragraph';
        try {
            $query = \Drupal::database()->select('user__field_politicas', 'usrp')
                ->fields('fech', ['field_fecha_aceptacion_value'])
                ->fields('idp', ['field_politica_target_id'])
                ->fields('usrp', ['field_politicas_target_id'])
                ->fields('usrp', ['delta']);
            $query->leftJoin('paragraph__field_fecha_aceptacion', 'fech', 'fech.entity_id = usrp.field_politicas_target_id');
            $query->leftJoin('paragraph__field_politica', 'idp', 'idp.entity_id = usrp.field_politicas_target_id');
            $query->condition('usrp.entity_id', (int)$nid);
            $query->orderBy('usrp.delta', 'ASC');
            $results = $query->execute()
                ->fetchAll();
            return $results;
        } catch (\Exception $e) {
            //($e->getMessage());
        } // end try - catch
    }

    /**
     * @param int $parent
     *
     * @return array|int
     */
    private function _politicas_disponibles_fe_info($nid = 0)
    {
        $results = [];
        try {
            $query = \Drupal::database()->select('node_field_data', 'politicas')
                ->fields('politicas', ['nid'])
                ->fields('fech', ['field_fecha_actualizacion_value'])
                ->fields('ord', ['field_orden_value']);
            $query->leftJoin('node__field_fecha_actualizacion', 'fech', 'fech.entity_id = politicas.nid');
            $query->leftJoin('node__field_orden', 'ord', 'ord.entity_id = politicas.nid');
            $query->leftJoin('node__field_descripcion', 'desc', 'desc.entity_id = politicas.nid');
            $query->condition('type', "politicas_pop_up");
            $query->condition('status', 1);
            $query->orderBy('ord.field_orden_value', 'ASC');
            $content = $query->execute()
                ->fetchAll();
            return $content;
        } catch (\Exception $e) {
            //($e->getMessage());
        } // end try - catch

        return $results;
    }
}
