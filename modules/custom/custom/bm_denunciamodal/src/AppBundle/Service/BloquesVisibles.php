<?php

namespace Drupal\bm_denunciamodal\AppBundle\Service;

use Drupal\Core\Session\AccountInterface;
use Drupal\webform\Entity\Webform;

class BloquesVisibles
{
    private $current_user;
    private $uid = 0;
    private $title = "";
    private $description = "";

    public function __construct(AccountInterface $currentUser)
    {
        $this->current_user = $currentUser;
        $this->uid = $this->current_user->id();
    }

    /**
     * Bloque a mostrar
     */
    public function bloques()
    {
        $bloque = "";
        // Bloques de denuncias registrados
        $denuncias_usuario = $this->DenunciasUsuarioRegistradas();

        // Bloques totales (webform) de Popup menos los registrados en las denuncias de usuario
        $bloques_ids = $this->BloquesExistentes($denuncias_usuario);        
        if (count($bloques_ids)) {
            foreach ($bloques_ids as $plugin_id) {
                $entitymanager = \Drupal::entityTypeManager()->getStorage('webform')->load($plugin_id);
                $bloque = $entitymanager->getSubmissionForm();
            } // end foreach
        } // end if

        return $bloque;
    }

    /**
     * Titulo
     */
    public function titulo() {
        return $this->title;
    }

    /**
     * Description
     */
    public function descripcion() {
        return $this->description;
    }

    /**
     * Denuncias Registradas
     */
    private function DenunciasUsuarioRegistradas()
    {
        $results = [];
        try {
            $query = \Drupal::database()->select('user__field_denuncias', 'den')
                ->fields('den', ['field_denuncias_settings']);

            $query->condition('den.entity_id', (int)$this->uid);
            $query->condition('den.field_denuncias_plugin_id', 'webform_block');
            $query->condition('den.field_denuncias_settings', '%denuncias%', 'LIKE');

            $results = $query->execute()
                ->fetchAll();
        } catch (\Exception $e) {
        } // end try - catch  

        return $results;
    }

    /**
     * Bloques (denuncias) existentes
     */
    private function BloquesExistentes($denuncias_usuario = [])
    {
        $results = [];
        try {
            $query = \Drupal::database()->select('node__field_bloques', 'blc')
                ->fields('blc', ['field_bloques_settings'])
                ->fields('nfd', ['title'])
                ->fields('dc', ['field_descripcion_value']);

            $query->condition('blc.bundle', 'formularios_popup');

            $query->leftJoin('node_field_data', 'nfd', 'nfd.nid = blc.entity_id');
            $query->leftJoin('node__field_descripcion', 'dc', 'dc.entity_id = blc.entity_id');

            // Descartar bloques agregados al usuario actual
            if (count($denuncias_usuario) > 0) {
                foreach ($denuncias_usuario as $result) {
                    $unserialize = unserialize($result->field_denuncias_settings);
                    if (isset($unserialize['webform_id']) && !empty($unserialize['webform_id'])) {
                        $query->condition('blc.field_bloques_settings', '%' . $unserialize['webform_id'] . '%', 'NOT LIKE');
                    } // end if
                } // end foreach    
            } // end if

            $query->range(0, 1);
            $bloques = $query->execute()
                ->fetchAll();

            // Obtener solo el bloque id (webform_id) 
            foreach ($bloques as $bloque) {
                $unserialize_bloque = unserialize($bloque->field_bloques_settings);
                if (isset($unserialize_bloque['webform_id']) && !empty($unserialize_bloque['webform_id'])) {
                    $results[] = $unserialize_bloque['webform_id'];
                } // end if
                $this->title = (isset($bloque->title) && !empty($bloque->title)) ? $bloque->title : "";
                $this->description = (isset($bloque->field_descripcion_value) && !empty($bloque->field_descripcion_value)) ? $bloque->field_descripcion_value : "";
            } // end foreach


        } catch (\Exception $e) {
        } // end try - catch

        return $results;
    }
}
