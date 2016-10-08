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
   * @var      string    $wordpress_rabbitmq    The ID of this plugin.
   */

  private $wordpress_rabbitmq;

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
   * @param      string    $wordpress_rabbitmq       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */

  public function __construct( $wordpress_rabbitmq, $version ) {
    $this->wordpress_rabbitmq = $wordpress_rabbitmq;
    $this->version = $version;
  }

  /**
   * Register the stylesheets for the admin area.
   *
   * @since    1.0.0
   */

  public function enqueue_styles() {
    wp_enqueue_style( $this->wordpress_rabbitmq, plugin_dir_url( __FILE__ ) . 'css/wordpress-rabbitmq-admin.css', array(), $this->version, 'all' );
  }

  /**
   * Register the JavaScript for the admin area.
   *
   * @since    1.0.0
   */

  public function enqueue_scripts() {
    wp_enqueue_script( $this->wordpress_rabbitmq, plugin_dir_url( __FILE__ ) . 'js/wordpress-rabbitmq-admin.js', array( 'jquery' ), $this->version, false );
  }

  public function on_post_publish() {}
}
