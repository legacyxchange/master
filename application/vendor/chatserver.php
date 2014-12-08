<?php


//require dirname(dirname(dirname(__DIR__))) . '/vendor/vendor/autoload.php';

require 'vendor/autoload.php';



require dirname(__DIR__) . '/third_party/bms/libraries/chatsocket.php';



use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use chatsocket\Chat;

// load objects
//$loop = React\EventLoop\Factory::create();

//$socket = new React\Socket\Server($loop);
//$socket->listen(8080, '0.0.0.0'); // Binding to 0.0.0.0 means remotes can connect

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new Chat()
            )
        ),
        8080
    );



    $server->run();