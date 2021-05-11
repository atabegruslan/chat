<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;

$connection = new AMQPConnection(
    'localhost',    #host 
    5672,           #port
    'guest',        #user
    'guest'         #password
);

$channel = $connection->channel();

$channel->queue_declare(
    'key',    #queue name, the same as the sender
    false,          #passive
    false,          #durable
    false,          #exclusive
    false           #autodelete
);

echo ' * Waiting for messages. To exit press CTRL+C', "\n";

function callback($msg)
{
    echo " * Message received: " . $msg->body . "\n";
}

$channel->basic_qos(null, 1, null);

$channel->basic_consume(
    'key',                    #queue 
    '',                             #consumer tag - Identifier for the consumer, valid within the current channel. just string
    false,                          #no local - TRUE: the server will not send messages to the connection that published them
    true,                           #no ack - send a proper acknowledgment from the worker, once we're done with a task
    false,                          #exclusive - queues may only be accessed by the current connection
    false,                          #no wait - TRUE: the server will not respond to the method. The client should not wait for a reply method
    'callback'    #callback - method that will receive the message
);
    
while (count($channel->callbacks)) 
{
    $channel->wait();
}

$channel->close();
$connection->close();