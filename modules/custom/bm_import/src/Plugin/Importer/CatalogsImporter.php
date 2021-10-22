<?php

namespace Drupal\bm_import\Plugin\Importer;

use Drupal\bm_actualdatos\ActualCatalogos;

/**
 * Class BlockImporter.
 */
class CatalogsImporter extends ActualCatalogos
{

  public function sortPais()
  {

    $contenido = [];

    $paises = $this->getPais();
    foreach ($paises as $pais) {
      $contenido[$pais['name']] = $pais['tid'];
    } // end foreach

    return $contenido;
  }

  public function sortCategoria()
  {

    $contenido = [];

    $categorias = $this->getCategoria();
    foreach ($categorias as $categoria) {
      $contenido[$categoria['name']] = $categoria['tid'];
    } // end foreach

    return $contenido;
  }

  public function sortSubcategoria()
  {

    $contenido = [];

    $subcategorias = $this->getSubCategoria();
    foreach ($subcategorias as $subcategoria) {
      $contenido[$subcategoria['name']] = $subcategoria['tid'];
    } // end foreach

    return $contenido;
  }

}
