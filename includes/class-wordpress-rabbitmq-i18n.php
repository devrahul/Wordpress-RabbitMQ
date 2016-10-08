<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/NathanKleekamp/Wordpress-RabbitMQ
 * @since      1.0.0
 *
 * @package    Wordpress_Rabbitmq
 * @subpackage Wordpress_Rabbitmq/includes
 */




/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wordpress_Rabbitmq
 * @subpackage Wordpress_Rabbitmq/includes
 * @author     Nathan Kleekamp <nkleekamp@gmail.com>
 */

class Wordpress_Rabbitmq_i18n {

  /**
   * Load the plugin text domain for translation.
   *
   * @since    1.0.0
   */

  public function load_plugin_textdomain() {
    load_plugin_textdomain( 'wordpress-rabbitmq', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' );
  }
}
