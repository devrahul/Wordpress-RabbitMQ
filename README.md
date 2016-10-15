# Wordpress RabbitMQ

A plugin for emitting messages for create, update, and delete events in
Wordpress.

## Settings

### `wp-config.php`

To connect to a RabbitMQ server with a password, you'll need to to
define it in your `wp-config.php`:

```php
define('WP_RABBITMQ_PASSWORD', 'password');
```

To connect to a RabbitMQ server via SSL, you'll also have to add these constants to your
`wp-config.php`:

```php
define('WP_RABBITMQ_KEY_FILE', '/path/to/file/.pem');
define('WP_RABBITMQ_CERT_FILE', '/path/to/file/.pem');
define('WP_RABBITMQ_SA_FILE', '/path/to/file/.pem');
```

### Plugin settings page

For more information about these settings, take a look at the [RabbitMQ
URI Specification](https://www.rabbitmq.com/uri-spec.html) and the
documentation for the PHP implementation of the AMQP protocol,
[php-amqplib](https://github.com/php-amqplib/php-amqplib).

`Host`: The host to which the underlying TCP connection is made.

`Port`: The port number to which the underlying TCP connection is made.

`Username`: The username of the user connecting to the RabbitMQ server.

`Connection Timeout`: The period afterwhich a connection should close if
it can't connect.

`Authentication Type`: See RabbitMQ's
[Authentication](https://www.rabbitmq.com/authentication.html)
documentation.

`Virtual Host`: The vhost component is used as the basis for the
virtual-host field of the connection.open AMQP 0-9-1 method.

`Verify Peer`: If the client does send us a certificate, we must be able to
establish a chain of trust to it. See RabbitMQ's [TLS
Support](https://www.rabbitmq.com/ssl.html) documentation.
