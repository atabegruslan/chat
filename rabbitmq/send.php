<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

$connection = new AMQPConnection(
    'localhost',    #host - host name where the RabbitMQ server is runing
    5672,           #port - port number of the service, 5672 is the default
    'guest',        #user - username to connect to server
    'guest'         #password
);

/** @var $channel AMQPChannel */
$channel = $connection->channel();

$channel->queue_declare(
    'key',    #queue name - Queue names may be up to 255 bytes of UTF-8 characters
    false,          #passive - can use this to check whether an exchange exists without modifying the server state
    false,          #durable - make sure that RabbitMQ will never lose our queue if a crash occurs - the queue will survive a broker restart
    false,          #exclusive - used by only one connection and the queue will be deleted when that connection closes
    false           #autodelete - queue is deleted when last consumer unsubscribes
);

$msg = new AMQPMessage($message, array('delivery_mode' => 2));

$channel->basic_publish(
    $msg,           #message 
    '',             #exchange
    'key'     #routing key
);

$channel->close();
$connection->close();