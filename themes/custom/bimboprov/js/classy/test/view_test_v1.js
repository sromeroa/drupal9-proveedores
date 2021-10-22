Drupal.behaviors.autoSubmitExposedFilters = {

    attach: function (context, settings) {
  
      $('.views-exposed-form #edit-field-preguntas-frecuentes-categ-target-id.form-select').on('change', function() {
        $('#edit-submit-bimbo-preguntas-frecuentes').click();
      });
  
    }
  
  }