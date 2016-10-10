<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wordpress_Rabbitmq
 * @subpackage Wordpress_Rabbitmq/admin/partials
 */

$options = get_option('wordpress_rabbitmq_options');

?>

<div class="wrap">
  <h2>
    <?php echo esc_html( get_admin_page_title() ); ?>
  </h2>

  <?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] == 'success' ) : ?>
    <div class="notice notice-success">
      <p><?php _e( 'Settings successfully updated!', 'wordpress-rabbitmq' ); ?></p>
    </div>
  <?php endif; ?>

  <form action="?save-settings=true" method="post" id="wordpress-rabbitmq-settings" class="wordpress-rabbitmq-form">
    <fieldset class="wordpress-rabbitmq-fieldset">
      <h3>RabbitMQ Server Settings</h3>
      <label for="wordpress_rabbitmq_options[host]"><?php echo __( 'Host' ) ?>:
        <input type="text" name="wordpress_rabbitmq_options[host]" id="wordpress_rabbitmq_options[host]" autocomplete="off" placeholder="amqp://" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['host'] ) ? esc_attr( $options['host'] ) : "" ?>">
      </label>
      <label for="wordpress_rabbitmq_options[port]"><?php echo __( 'Port' ) ?>:
        <input type="number" name="wordpress_rabbitmq_options[port]" id="wordpress_rabbitmq_options[port]" autocomplete="off" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['port'] ) ? esc_attr( $options['port'] ) : 5672 ?>">
      </label>
      <label for="wordpress_rabbitmq_options[username]"><?php echo __( 'Username' ) ?>:
        <input type="text" name="wordpress_rabbitmq_options[username]" id="wordpress_rabbitmq_options[username]" autocomplete="off" placeholder="rabbitmq" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['username'] ) ? esc_attr( $options['username'] ) : "" ?>">
      </label>
      <label for="wordpress_rabbitmq_options[password]"><?php echo __( 'Password' ) ?>:
        <input type="password" name="wordpress_rabbitmq_options[password]" id="wordpress_rabbitmq_options[password]" autocomplete="off" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['password'] ) ? esc_attr( $options['password'] ) : "" ?>">
      </label>
      <label for="wordpress_rabbitmq_options[connection_timeout]"><?php echo __( 'Connection Timeout' ) ?>:
        <input type="number" name="wordpress_rabbitmq_options[connection_timeout]" id="wordpress_rabbitmq_options[connection_timeout]" autocomplete="off" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['connection_timeout'] ) ? esc_attr( $options['connection_timeout'] ) : 10000 ?>">
      </label>
      <label for="wordpress_rabbitmq_options[auth_type]"><?php echo __( 'Authentication Type' ) ?>:
        <input type="text" name="wordpress_rabbitmq_options[auth_type]" id="wordpress_rabbitmq_options[auth_type]" autocomplete="off" placeholder="AMQPLAIN" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['auth_type'] ) ? esc_attr( $options['auth_type'] ) : "" ?>">
      </label>
      <label for="wordpress_rabbitmq_options[vhost]"><?php echo __( 'Virtual Host' ) ?>
        <input type="text" name="wordpress_rabbitmq_options[vhost]" id="wordpress_rabbitmq_options[vhost]" autocomplete="off" placeholder="/" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['vhost'] ) ? esc_attr( $options['vhost'] ) : "" ?>">
      </label>
      <fieldset class="wordpress-rabbitmq-radio-fieldset" id="rabbitmq_server_ssl">
        <label for="wordpress_rabbitmq_options[ssl]"><?php echo __( 'SSL' ) ?>
          <div class="radio-wrapper">
            <label for="rabbitmq_server_ssl_true" class="inline"><?php echo __( 'True' ) ?>
            <input type="radio" name="wordpress_rabbitmq_options[ssl]" id="rabbitmq_server_ssl_true" autocomplete="off" value="true" <?php echo isset( $options['ssl'] ) && $options['ssl'] === 'true' ? esc_attr ('checked=checked' ) : "" ?> >
            </label>
            <label for="rabbitmq_server_ssl_false" class="inline"><?php echo __( 'False' ) ?>
              <input type="radio" name="wordpress_rabbitmq_options[ssl]" id="rabbitmq_server_ssl_false" autocomplete="off" value="false" <?php echo isset( $options['ssl'] ) && $options['ssl'] === 'false' ? esc_attr( 'checked=checked' ) : "" ?> >
            </label>
          </div>
          <div id="wordpress-rabbitmq-ssl-settings">
            <h4>SSL Settings</h4>
            <label for="wordpress_rabbitmq_options[key_file]"><?php echo __( 'Key File' ) ?>:
              <input type="text" name="wordpress_rabbitmq_options[key_file]" id="wordpress_rabbitmq_options[key_file]" autocomplete="off" placeholder="/path/to/file" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['key_file'] ) ? esc_attr( $options['key_file'] ) : "" ?>">
            </label>
            <label for="wordpress_rabbitmq_options[ssl_cert]"><?php echo __( 'SSL Certificate' ) ?>:
              <input type="text" name="wordpress_rabbitmq_options[ssl_cert]" id="wordpress_rabbitmq_options[ssl_cert]" autocomplete="off" placeholder="/path/to/file" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['ssl_cert'] ) ? esc_attr( $options['ssl_cert'] ) : "" ?>">
            </label>
            <label for="wordpress_rabbitmq_options[sa_file]"><?php echo __( 'Certificate Authority' ) ?>:
              <input type="text" name="wordpress_rabbitmq_options[sa_file]" id="wordpress_rabbitmq_options[sa_file]" autocomplete="off" placeholder="/path/to/file" class="wordpress-rabbitmq-textfield" value="<?php echo isset( $options['sa_file'] ) ? esc_attr( $options['sa_file'] ) : "" ?>">
            </label>
            <label for="wordpress_rabbitmq_options[verify_peer]"><?php echo __( 'Reject Unauthorized' ) ?>
              <div class="radio-wrapper">
                <label for="rabbitmq_server_verify_peer_true" class="inline"><?php echo __( 'True' ) ?>
                <input type="radio" name="wordpress_rabbitmq_options[verify_peer]" id="rabbitmq_server_verify_peer_true" autocomplete="off" value="true" <?php echo isset( $options['verify_peer'] ) && $options['verify_peer'] === 'true' ? esc_attr ('checked=checked' ) : "" ?> >
                </label>
                <label for="rabbitmq_server_verify_peer_false" class="inline"><?php echo __( 'False' ) ?>
                  <input type="radio" name="wordpress_rabbitmq_options[verify_peer]" id="rabbitmq_server_verify_peer_false" autocomplete="off" value="false" <?php echo isset( $options['verify_peer'] ) && $options['verify_peer'] === 'false' ? esc_attr( 'checked=checked' ) : "" ?> >
                </label>
              </div>
            </label>
          </div>
        </label>
      </fieldset>
    </fieldset>
    <?php wp_nonce_field( 'wordpress_rabbitmq_nonce', 'wordpress_rabbitmq_nonce' ); ?>
    <input type="button" name="reset" id="reset" class="button button-secondary" value="Reset Fields">
    <?php submit_button(); ?>
  </form>
</div>
