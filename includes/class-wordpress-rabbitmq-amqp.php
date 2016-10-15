<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Sending and receiving messages from RabbitMQ
 *
 * @package    Wordpress_Rabbitmq
 * @subpackage Wordpress_Rabbitmq/admin
 * @author     Nathan Kleekamp <nkleekamp@gmail.com>
 */

class Wordpress_Rabbitmq_AMQP {

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
}
