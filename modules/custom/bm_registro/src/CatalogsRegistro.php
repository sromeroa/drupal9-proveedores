<?php

namespace Drupal\bm_registro;

use Drupal\bm_actualdatos\ActualCatalogos;

/**
 * Class BlockImporter.
 */
class CatalogsRegistro extends ActualCatalogos
{
  private $title = "";

  private $catalog = [];

  public function setFirstValue($title = "") {
    $this->title = $title;
    return $this;
  }

  public function processCatalog() {

    if (!empty($this->title)) {
      unset($this->catalog[0]);
      array_unshift($this->catalog, $this->title);
    } // end if

    return $this->catalog;
  }

  public function getCatalog() {
    $this->processCatalog();
    return $this->catalog;
  }

  public function loadPais()
  {

    $this->catalog = [];
    $paises = $this->getPais();
    foreach ($paises as $pais) {
      $this->catalog[$pais['tid']] = $pais['name'];
    } // end foreach

    return $this;
  }

  public function loadCategoria()
  {

    $this->catalog = [];
    $categorias = $this->getCategoria();
    foreach ($categorias as $categoria) {
      $this->catalog[$categoria['tid']] = $categoria['name'];
    } // end foreach

    return $this;
  }

  public function loadSubcategoria()
  {
    $this->catalog = [];
    $subcategorias = $this->getSubCategoria();
    foreach ($subcategorias as $subcategoria) {
      $this->catalog[$subcategoria['tid']] = $subcategoria['name'];
    } // end foreach

    return $this;
  }

}
