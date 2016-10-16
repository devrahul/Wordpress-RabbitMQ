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
   * The AMQPStreamConnection object.
   *
   * @since   1.0.0
   * @access  private
   * @var     object      $connection   The AMQPStreamConnection object
   *
   */

  private $connection;

  /**
   * The queue for sending the messages.
   *
   * @since   1.0.0
   * @access  private
   * @var     array       $queue        The RabbitMQ queue
   */

  private $queue;

  /**
   * The options from the admin settings page
   *
   * @since   1.0.0
   * @access  private
   * @var     array       $options      The settings array
   */

  private $options;

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

    $this->options = get_option( 'wordpress_rabbitmq_options' );
    $this->connection = $this->get_connection();
    $this->queue = array(
      "name" => "hello",
      "passive" => false,
      "durable" => false,
      "exclusive" => false,
      "auto_delete" => false
    );
  }

  private function get_connection() {
    return new AMQPStreamConnection( $this->options['host'], $this->options['port'], $this->options['username'], WP_RABBITMQ_PASSWORD );
  }

  private function send_message( $msg ) {
    $channel = $this->connection->channel();
    $channel->queue_declare( $this->queue['name'], $this->queue['passive'], $this->queue['durable'], $this->queue['exclusive'], $this->queue['auto_delete'] );
    $channel->basic_publish( $msg, '', $this->queue['name'] );
    $channel->close();
    $this->connection->close();
  }

  private function post_message( $http_verb, $post_id ) {
    $json = json_encode( array(
      'http_verb' => $http_verb,
      'url' => get_site_url(),
      'post_id' => $post_id
    ), JSON_UNESCAPED_SLASHES );
    $msg = new AMQPMessage( $json );
    $this->send_message( $msg );
  }

  private function term_message( $http_verb, $term_id, $tt_id, $taxonomy ) {
    $tax_label = get_taxonomy_labels( get_taxonomy( $taxonomy ) );
    $json = json_encode( array(
      'http_verb' => $http_verb,
      'url' => get_site_url(),
      'term_id' => $term_id,
      'term_taxonomy_id' => $tt_id,
      'taxonomy' => $taxonomy
    ), JSON_UNESCAPED_SLASHES );
    $msg = new AMQPMessage( $json );
    $this->send_message( $msg );
  }

  public function get_term( $term_id, $tt_id, $taxonomy ) {
    $this->term_message( 'GET', $term_id, $tt_id, $taxonomy );
  }

  public function delete_term( $term_id, $tt_id, $taxonomy ) {
    $this->term_message( 'DELETE', $term_id, $tt_id, $taxonomy );
  }

  public function get_post( $post_id ) {
    $this->post_message( 'GET', $post_id );
  }

  public function delete_post( $post_id ) {
    $this->post_message( 'DELETE', $post_id );
  }

  // We only want to emit an event message if the post is publically available
  public function status_change( $new_status, $old_status, $post ) {
    $password_required = post_password_required( $post );

    switch ( TRUE ) {

      // If post that wasn't previously published is published with a password, don't do anything
      case ( $new_status === 'publish' && $old_status !== 'publish' && $password_required ):
        break;

      // If an already published post is put behind a password
      case ( $new_status === 'publish' && $old_status === 'publish' && $password_required ):
        $this->post_message( 'DELETE', $post->ID );
        break;

      // If an already published post behind a password is given a new status and still requires a password, don't do anything
      case ( $new_status !== 'publish' && $old_status === 'publish' && $password_required ):
        break;

      case ( $new_status === 'publish' && $old_status !== 'publish' ):
        $this->post_message( 'GET', $post->ID );
        break;

      case ( $old_status === 'publish' && $new_status !== 'publish' ):
        $this->post_message( 'DELETE', $post->ID );
        break;
    }
  }
}
