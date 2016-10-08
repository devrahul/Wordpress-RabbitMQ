<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/NathanKleekamp/Wordpress-RabbitMQ
 * @since      1.0.0
 *
 * @package    Wordpress_Rabbitmq
 * @subpackage Wordpress_Rabbitmq/public
 */




/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wordpress_Rabbitmq
 * @subpackage Wordpress_Rabbitmq/public
 * @author     Nathan Kleekamp <nkleekamp@gmail.com>
 */

class Wordpress_Rabbitmq_Public {

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
   * @param      string    $wordpress_rabbitmq       The name of the plugin.
   * @param      string    $version    The version of this plugin.
   */

  public function __construct( $wordpress_rabbitmq, $version ) {
    $this->wordpress_rabbitmq = $wordpress_rabbitmq;
    $this->version = $version;
  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */

  public function enqueue_styles() {
    wp_enqueue_style( $this->wordpress_rabbitmq, plugin_dir_url( __FILE__ ) . 'css/wordpress-rabbitmq-public.css', array(), $this->version, 'all' );
  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */

  public function enqueue_scripts() {
    wp_enqueue_script( $this->wordpress_rabbitmq, plugin_dir_url( __FILE__ ) . 'js/wordpress-rabbitmq-public.js', array( 'jquery' ), $this->version, false );
  }
}
