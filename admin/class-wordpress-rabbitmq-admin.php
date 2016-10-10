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


  /**
   * Custom form processing for the plugin's admin page.
   *
   * @see https://git.io/vP0dA
   *
   * @since 1.0.0
   */

  public function process_form() {
    if ( ! isset( $_GET['save-settings'] ) || $_GET['save-settings'] !== 'true' ) {
      return;
    }

    if ( ! current_user_can( 'activate_plugins' ) ) {
      return;
    }

    if ( ! isset( $_POST['wordpress_rabbitmq_nonce'] ) || ! wp_verify_nonce( $_POST['wordpress_rabbitmq_nonce'], 'wordpress_rabbitmq_nonce' ) ) {
      wp_die( 'Permission denied', 'wordpress-rabbitmq' );
    }

    $updated = isset( $_POST['wordpress_rabbitmq_options'] ) ? $_POST['wordpress_rabbitmq_options'] : array();
    $sanitized = array();

    if ( ! $updated ) {
      return;
    }

    if ( isset( $updated['host'] ) ) {
      $sanitized['host'] = sanitize_text_field( $updated['host'] );
    }

    if ( isset( $updated['port'] ) ) {
      $sanitized['port'] = intval( $updated['port'] );
    }

    if ( isset( $updated['username'] ) ) {
      $sanitized['username'] = sanitize_text_field( $updated['username'] );
    }

    if ( isset( $updated['connection_timeout'] ) ) {
      $sanitized['connection_timeout'] = intval( $updated['connection_timeout'] );
    }

    if ( isset( $updated['auth_type'] ) ) {
      $sanitized['auth_type'] = sanitize_text_field( $updated['auth_type'] );
    }

    if ( isset( $updated['vhost'] ) ) {
      $sanitized['vhost'] = sanitize_text_field( $updated['vhost'] );
    }

    if ( isset( $updated['ssl'] ) ) {
      $sanitized['ssl'] = $this->validate_bool( $updated['ssl'] );
    }

    if ( isset( $updated['verify_peer'] ) ) {
      $sanitized['verify_peer'] = $this->validate_bool( $updated['verify_peer'] );
    }

    update_option( 'wordpress_rabbitmq_options', $sanitized );

    wp_redirect( add_query_arg( array( 'page' => 'wordpress-rabbitmq', 'settings-updated' => 'success' ), admin_url( 'admin.php' ) ) );
  }


  /**
   * Validate the radio button only returns true or false
   *
   * @param   string    $input    The data from the radio button field
   *
   * Since 1.0.0
   */

  public function validate_bool( $input ) {
    if ( $input === "true" || $input === "false" ) {
      return $input;
    }

    return;
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
