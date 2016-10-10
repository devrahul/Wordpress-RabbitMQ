(function( $ ) {
  'use strict';

  function convertToArray(nodeList) {
    return Array.prototype.slice.call(nodeList);
  }

  function getCheckedRadioButtons(target) {
    return target.querySelector('input[type="radio"]:checked');
  }

  function show(target) {
    var classList = target.classList;

    if (classList.contains('hidden') === true) {
      classList.remove('hidden');
      return;
    }
  }

  function hide(target) {
    var classList = target.classList;

    if (classList.contains('hidden') === false) {
      classList.add('hidden');
      return;
    }
  }

  function resetRadio(button) {
    if (button.value === "false") {
      button.checked = true;
      return;
    }

    button.checked = false;
  }

  // @todo: Better reset that restores default values
  function reset(fields) {
    fields.forEach(function(field) {
      if (field.type !== 'radio') {
        field.value = "";
        return;
      }

      resetRadio(field);
    });
  }


  $(document).ready(function() {
    var form = document.getElementById('wordpress-rabbitmq-settings');

    if (form === null || form === undefined) {
      return;
    }

    var ssl = form.querySelector('#rabbitmq_server_ssl');
    var sslTrue = form.querySelector('#rabbitmq_server_ssl_true');
    var sslFalse = form.querySelector('#rabbitmq_server_ssl_false');
    var sslSettings = form.querySelector('#wordpress-rabbitmq-ssl-settings');
    var resetButton = form.querySelector('#reset');
    var submitButton = form.querySelector('#submit');


    // Show / Hide SSL Settings section
    ssl.addEventListener("click", function(e) {
      var checkedRadioButton = getCheckedRadioButtons(form);
      var fields = convertToArray(sslSettings.querySelectorAll('input'));

      if (checkedRadioButton === sslTrue) {
        show(sslSettings);
        return;
      }

      hide(sslSettings);
    });


    // Hide SSL Settings section and reset all field values
    resetButton.addEventListener("click", function(e) {
      var fields = [];

      // Explicitly get the fields and convert the node lists to arrays
      var textFields = convertToArray(form.querySelectorAll('input[type="text"]'));
      var numberFields = convertToArray(form.querySelectorAll('input[type="number"]'));
      var radioButtons = convertToArray(form.querySelectorAll('input[type="radio"]'));
      var passwordFields = convertToArray(form.querySelectorAll('input[type="password"]'));

      // Flatten the fields array
      fields = fields.concat(textFields, numberFields, radioButtons, passwordFields);

      hide(sslSettings)
      reset(fields);
    });


    // Reset SSL Settings fields if false is checked
    submitButton.addEventListener("click", function(e) {
      var checkedRadioButton = getCheckedRadioButtons(form);
      var fields = convertToArray(sslSettings.querySelectorAll('input'));

      if (checkedRadioButton === sslFalse) {
        reset(fields);
        return;
      }
    });


    // Set initial show/hide state for ssl settings fieldset
    if (sslTrue.checked === false) {
      hide(sslSettings);
    }
  });

})( jQuery );
