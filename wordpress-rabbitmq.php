<?php

/**
 * @link              https://github.com/NathanKleekamp/Wordpress-RabbitMQ
 * @since             1.0.0
 * @package           Wordpress_Rabbitmq
 *
 * @wordpress-plugin
 * Plugin Name:       Wordpress-RabbitMQ
 * Plugin URI:        https://github.com/NathanKleekamp/Wordpress-RabbitMQ
 * Description:       A plugin for emitting messages for create, update, and delete events in Wordpress.
 * Version:           1.0.0
 * Author:            Nathan Kleekamp <nkleekamp@gmail.com>
 * Author URI:        https://github.com/NathanKleekamp
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wordpress-rabbitmq
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}


function activate_wordpress_rabbitmq() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-rabbitmq-activator.php';
  Wordpress_Rabbitmq_Activator::activate();
}


function deactivate_wordpress_rabbitmq() {
  require_once plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-rabbitmq-deactivator.php';
  Wordpress_Rabbitmq_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wordpress_rabbitmq' );
register_deactivation_hook( __FILE__, 'deactivate_wordpress_rabbitmq' );


require plugin_dir_path( __FILE__ ) . 'includes/class-wordpress-rabbitmq.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_wordpress_rabbitmq() {
  $plugin = new Wordpress_Rabbitmq();
  $plugin->run();
}

run_wordpress_rabbitmq();
