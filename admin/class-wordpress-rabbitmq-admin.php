<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wordpress_Rabbitmq
 * @subpackage Wordpress_Rabbitmq/admin
 * @author     Nathan Kleekamp <nkleekamp@gmail.com>
 */

class Wordpress_Rabbitmq_Admin {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name   The ID of this plugin.
   */

  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */

  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name   The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */

  public function __construct( $plugin_name, $version ) {
    $this->plugin_name = $plugin_name;
    $this->version = $version;
  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.0.0
   */

  public function enqueue_styles() {
    wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wordpress-rabbitmq-admin.css', array(), $this->version, 'all' );
  }

  /**
   * Register the JavaScript for the admin area.
   *
   * @since    1.0.0
   */

  public function enqueue_scripts() {
    wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wordpress-rabbitmq-admin.js', array( 'jquery' ), $this->version, false );
  }


  /**
   * Add settings page under the Settings menu
   *
   * @since     1.0.0
   */

  public function added_options_page() {
    add_management_page( __( 'Wordpress RabbitMQ' ), __( 'Wordpress RabbitMQ' ), 'activate_plugins', $this->plugin_name , array( $this, 'display_options_partial' ) );
  }


  public function added_settings_section() {
    add_settings_section( __( 'wordpress_rabbitmq_server_settings' ), __( 'RabbitMQ Server Settings' ), function() {
      echo "<p>Enter the RabbitMQ Server Settings.</p>";
    }, $this->plugin_name );

    add_settings_section( __( 'wordpress_rabbitmq_server_ssl_settings' ), __( 'SSL Settings' ), function() {}, $this->plugin_name );
  }


  /**
   * Create and register the fields on the plugin settings page
   *
   * @since   1.0.0
   */

  public function added_settings_fields() {
    add_settings_field( __( 'rabbitmq_server_host' ), __( 'Host' ), array( $this, 'rabbitmq_server_host' ), $this->plugin_name, 'wordpress_rabbitmq_server_settings', array( 'label_for' => 'rabbitmq_server_host' ) );
    add_settings_field( __( 'rabbitmq_server_port' ), __( 'Port' ), array( $this, 'rabbitmq_server_port' ), $this->plugin_name, 'wordpress_rabbitmq_server_settings', array( 'label_for' => 'rabbitmq_server_port' ) );
    add_settings_field( __( 'rabbitmq_server_username' ), __( 'Username' ), array( $this, 'rabbitmq_server_username' ), $this->plugin_name, 'wordpress_rabbitmq_server_settings', array( 'label_for' => 'rabbitmq_server_username' ) );
    add_settings_field( __( 'rabbitmq_server_password' ), __( 'Password' ), array( $this, 'rabbitmq_server_password' ), $this->plugin_name, 'wordpress_rabbitmq_server_settings', array( 'label_for' => 'rabbitmq_server_password' ) );
    add_settings_field( __( 'rabbitmq_server_connectionTimeout' ), __( 'Connection Timeout' ), array( $this, 'rabbitmq_server_connectionTimeout' ), $this->plugin_name, 'wordpress_rabbitmq_server_settings', array( 'label_for' => 'rabbitmq_server_connectionTimeout' ) );
    add_settings_field( __( 'rabbitmq_server_authType' ), __( 'Authentication Type' ), array( $this, 'rabbitmq_server_authType' ), $this->plugin_name, 'wordpress_rabbitmq_server_settings', array( 'label_for' => 'rabbitmq_server_authType' ) );
    add_settings_field( __( 'rabbitmq_server_vhost' ), __( 'Virtual Host' ), array( $this, 'rabbitmq_server_vhost' ), $this->plugin_name, 'wordpress_rabbitmq_server_settings', array( 'label_for' => 'rabbitmq_server_vhost' ) );
    add_settings_field( __( 'rabbitmq_server_ssl' ), __( 'SSL' ), array( $this, 'rabbitmq_server_ssl' ), $this->plugin_name, 'wordpress_rabbitmq_server_settings', array( 'label_for' => 'rabbitmq_server_ssl' ) );
    add_settings_field( __( 'rabbitmq_server_ssl_key_file' ), __( 'Key File' ), array( $this, 'rabbitmq_server_ssl_key_file' ), $this->plugin_name, 'wordpress_rabbitmq_server_ssl_settings', array( 'label_for' => 'rabbitmq_server_ssl_key_file' ) );
    add_settings_field( __( 'rabbitmq_server_ssl_cert' ), __( 'SSL Certificate File' ), array( $this, 'rabbitmq_server_ssl_cert' ), $this->plugin_name, 'wordpress_rabbitmq_server_ssl_settings', array( 'label_for' => 'rabbitmq_server_ssl_cert' ) );
    add_settings_field( __( 'rabbitmq_server_ssl_saFile' ), __( 'Certificate Authority File' ), array( $this, 'rabbitmq_server_ssl_saFile' ), $this->plugin_name, 'wordpress_rabbitmq_server_ssl_settings', array( 'label_for' => 'rabbitmq_server_ssl_saFile' ) );
    add_settings_field( __( 'rabbitmq_server_ssl_verify_peer' ), __( 'Verify Peer Connection' ), array( $this, 'rabbitmq_server_ssl_verify_peer' ), $this->plugin_name, 'wordpress_rabbitmq_server_ssl_settings', array( 'label_for' => 'rabbitmq_server_ssl_verify_peer' ) );

    // To Do: Sanitzation callbacks
    register_setting( $this->plugin_name, 'rabbitmq_server_host', 'sanitize_text_field' );
    register_setting( $this->plugin_name, 'rabbitmq_server_port', array( $this, 'int_validator' ) );
    register_setting( $this->plugin_name, 'rabbitmq_server_username', 'sanitize_text_field' );
    register_setting( $this->plugin_name, 'rabbitmq_server_password' );
    register_setting( $this->plugin_name, 'rabbitmq_server_connectionTimeout', array( $this, 'int_validator' ) );
    register_setting( $this->plugin_name, 'rabbitmq_server_authType', 'sanitize_text_field' );
    register_setting( $this->plugin_name, 'rabbitmq_server_vhost', 'sanitize_text_field' );
    register_setting( $this->plugin_name, 'rabbitmq_server_ssl' );
    register_setting( $this->plugin_name, 'rabbitmq_server_ssl_key_file' );
    register_setting( $this->plugin_name, 'rabbitmq_server_ssl_cert' );
    register_setting( $this->plugin_name, 'rabbitmq_server_ssl_saFile' );
    register_setting( $this->plugin_name, 'rabbitmq_server_ssl_verify_peer' );
  }


  /**
   * The html markup for the RabbitMQ server host field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_host() {
    $host = get_option( 'rabbitmq_server_host' );
    $html = '<fieldset>';
      $html .= '<input type="text" ';
        $html .= 'name="rabbitmq_server_host" ';
        $html .= 'id="rabbitmq_server_host" ';
        $html .= 'placeholder="amqp://"';
        $html .= 'class="wordpress-rabbitmq-textfield" ';
        $html .= 'value="' . $host .'">';
    $html .= '</fieldset>';
    echo $html;
  }


  /**
   * The html markup for the RabbitMQ server port field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_port() {
    $port = get_option( 'rabbitmq_server_port' );
    $html = '<fieldset>';
      $html .= '<input type="number" ';
        $html .= 'name="rabbitmq_server_port" ';
        $html .= 'id="rabbitmq_server_port" ';
        $html .= 'class="wordpress-rabbitmq-textfield" ';

        if ( $port ) {
          $html .= 'value="' . $port .'">';
        } else {
          $html .= 'value="5672">';
        }

    $html .= '</fieldset>';
    echo $html;
  }


  /**
   * The html markup for the RabbitMQ server username field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_username() {
    $username = get_option( 'rabbitmq_server_username' );
    $html = '<fieldset>';
      $html .= '<input type="text" ';
        $html .= 'name="rabbitmq_server_username" ';
        $html .= 'id="rabbitmq_server_username" ';
        $html .= 'placeholder="rabbitmq"';
        $html .= 'class="wordpress-rabbitmq-textfield" ';
        $html .= 'value="' . $username .'">';
    $html .= '</fieldset>';
    echo $html;
  }


  /**
   * The html markup for the RabbitMQ server password field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_password() {
    $password = get_option( 'rabbitmq_server_password' );
    $html = '<fieldset>';
      $html .= '<input type="password" ';
        $html .= 'name="rabbitmq_server_password" ';
        $html .= 'id="rabbitmq_server_password" ';
        $html .= 'class="wordpress-rabbitmq-textfield" ';
        $html .= 'value="' . $password .'">';
    $html .= '</fieldset>';
    echo $html;
  }


  /**
   * The html markup for the RabbitMQ server connection timeout field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_connectionTimeout() {
    $timeout = get_option( 'rabbitmq_server_connectionTimeout' );
    $html = '<fieldset>';
      $html .= '<input type="number" ';
        $html .= 'name="rabbitmq_server_connectionTimeout" ';
        $html .= 'id="rabbitmq_server_connectionTimeout" ';
        $html .= 'class="wordpress-rabbitmq-textfield" ';

        if ( $timeout ) {
          $html .= 'value="' . $timeout .'">';
        } else {
          $html .= 'value="10000">';
        }
    $html .= '</fieldset>';
    echo $html;
  }


  /**
   * The html markup for the RabbitMQ server authentication type field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_authType() {
    $auth = get_option( 'rabbitmq_server_authType' );
    $html = '<fieldset>';
      $html .= '<input type="text" ';
        $html .= 'name="rabbitmq_server_authType" ';
        $html .= 'id="rabbitmq_server_authType" ';
        $html .= 'placeholder="AMQPLAIN"';
        $html .= 'class="wordpress-rabbitmq-textfield" ';

        if ( $auth ) {
          $html .= 'value="' . $auth .'">';
        } else {
          $html .= 'value="AMQPLAIN">';
        }
    $html .= '</fieldset>';
    echo $html;
  }


  /**
   * The html markup for the RabbitMQ server virtual host field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_vhost() {
    $vhost = get_option( 'rabbitmq_server_vhost' );
    $html = '<fieldset>';
      $html .= '<input type="text" ';
        $html .= 'name="rabbitmq_server_vhost" ';
        $html .= 'id="rabbitmq_server_vhost" ';
        $html .= 'placeholder="/"';
        $html .= 'class="wordpress-rabbitmq-textfield" ';
        $html .= 'value="' . $vhost .'">';
    $html .= '</fieldset>';
    echo $html;
  }


  /**
   * The html markup for the RabbitMQ server ssl boolean field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_ssl() {
    $ssl = get_option( 'rabbitmq_server_ssl' );

    var_dump($ssl);

    $html = '<fieldset class="wordpress-rabbitmq-radio-fieldset" id="rabbitmq_server_ssl">';
      $html .= '<input type="radio" ';
        $html .= 'name="rabbitmq_server_ssl" ';
        $html .= 'id="rabbitmq_server_ssl_true" ';

        if ( $ssl === 'true' ) {
          $html .= 'checked="checked"';
        }

        $html .= 'autocomplete="off"';
        $html .= 'value="true">';
      $html .= '<label for="rabbitmq_server_ssl_true">' . __( 'True' ) . '</label>';
      $html .= '<input type="radio" ';
        $html .= 'name="rabbitmq_server_ssl" ';
        $html .= 'id="rabbitmq_server_ssl_false" ';

        if ( $ssl === 'false' ) {
          $html .= 'checked="checked"';
        }

        $html .= 'autocomplete="off"';
        $html .= 'value="false">';
      $html .= '<label for="rabbitmq_server_ssl_false">' . __( 'False' ) . '</label>';
    $html .= '</fieldset>';

    echo $html;
  }


  /**
   * The html markup for the RabbitMQ ssl key file field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_ssl_key_file () {
    $key_file = get_option( 'rabbitmq_server_ssl_key_file' );
    $html = '<fieldset>';
      $html .= '<input type="text" ';
        $html .= 'name="rabbitmq_server_ssl_key_file" ';
        $html .= 'id="rabbitmq_server_ssl_key_file" ';
        $html .= 'placeholder="/path/to/file"';
        $html .= 'autocomplete="off"';
        $html .= 'class="wordpress-rabbitmq-textfield" ';
        $html .= 'value="' . $key_file .'">';
    $html .= '</fieldset>';
    echo $html;
  }


  /**
   * The html markup for the RabbitMQ ssl cert field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_ssl_cert () {
    $cert = get_option( 'rabbitmq_server_ssl_cert' );
    $html = '<fieldset>';
      $html .= '<input type="text" ';
        $html .= 'name="rabbitmq_server_ssl_cert" ';
        $html .= 'id="rabbitmq_server_ssl_cert" ';
        $html .= 'placeholder="/path/to/file"';
        $html .= 'autocomplete="off"';
        $html .= 'class="wordpress-rabbitmq-textfield" ';
        $html .= 'value="' . $cert .'">';
    $html .= '</fieldset>';
    echo $html;
  }


  /**
   * The html markup for the RabbitMQ certificate authority field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_ssl_saFile () {
    $saFile = get_option( 'rabbitmq_server_ssl_saFile' );
    $html = '<fieldset>';
      $html .= '<input type="text" ';
        $html .= 'name="rabbitmq_server_ssl_saFile" ';
        $html .= 'id="rabbitmq_server_ssl_saFile" ';
        $html .= 'placeholder="/path/to/file"';
        $html .= 'autocomplete="off"';
        $html .= 'class="wordpress-rabbitmq-textfield" ';
        $html .= 'value="' . $saFile .'">';
    $html .= '</fieldset>';
    echo $html;
  }


  /**
   * The html markup for the RabbitMQ ssl verify peer field
   *
   * @since   1.0.0
   */

  public function rabbitmq_server_ssl_verify_peer() {
    $verify_peer = get_option( 'rabbitmq_server_ssl_verify_peer' );

    $html = '<fieldset class="wordpress-rabbitmq-radio-fieldset">';
      $html .= '<input type="radio" ';
        $html .= 'name="rabbitmq_server_ssl_verify_peer" ';
        $html .= 'id="rabbitmq_server_ssl_verify_peer_true" ';

        if ( $verify_peer === 'true' ) {
          $html .= 'checked="checked"';
        }

        $html .= 'autocomplete="off"';
        $html .= 'value="true">';
      $html .= '<label for="rabbitmq_server_ssl_verify_peer_true">' . __( 'True' ) . '</label>';
      $html .= '<input type="radio" ';
        $html .= 'name="rabbitmq_server_ssl_verify_peer" ';
        $html .= 'id="rabbitmq_server_ssl_verify_peer_false" ';

        if ( $verify_peer === 'false' ) {
          $html .= 'checked="checked"';
        }

        $html .= 'autocomplete="off"';
        $html .= 'value="false">';
      $html .= '<label for="rabbitmq_server_ssl_verify_peer_false">' . __( 'False') . '</label>';
    $html .= '</fieldset>';

    echo $html;
  }


  public function int_validator( $input ) {
    return intval( $input );
  }


  /**
   * The admin area view for the plugin settings page
   *
   * @since   1.0.0
   */

 public function display_options_partial() {
   require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/wordpress-rabbitmq-admin-display.php';
 }
}
