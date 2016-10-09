(function( $ ) {
  'use strict';

  $(document).ready(function() {
    var form = document.getElementById('wordpress-rabbitmq-settings');

    if (!form) {
      return;
    }

    var ssl = form.querySelector('#rabbitmq_server_ssl');
    var sslTrue = form.querySelector('#rabbitmq_server_ssl_true');
    var sslFalse = form.querySelector('#rabbitmq_server_ssl_false');
    var sslSettings = form.querySelector('#wordpress-rabbitmq-ssl-settings');

    function getChecked() {
      return form.querySelector('input[type="radio"]:checked');
    }

    function show() {
      var classList = sslSettings.classList;

      if (classList.contains('hidden') === true) {
        classList.remove('hidden');
        return;
      }
    }

    function hide() {
      var classList = sslSettings.classList;

      if (classList.contains('hidden') === false) {
        classList.add('hidden');
        return;
      }
    }

    function resetFields(fields) {
      fields = Array.prototype.slice.call(fields);

      fields.forEach(function(field) {
        if (field.type !== 'radio') {
          field.value = "";
          return;
        }

        field.value = false;
      });
    }

    ssl.addEventListener("click", function(e) {
      if (e.error) {
        console.error(e.error);
      }

      var checked = getChecked();

      if (checked === sslTrue) {
        show();
        return;
      }

      if (checked === sslFalse) {
        //var fields = sslSettings.querySelectorAll('input');

        hide();
        //resetFields(fields);
      }
    });

    if (sslTrue.checked === true) {
      show();
    }
  });

})( jQuery );
