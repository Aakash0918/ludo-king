<?php


namespace App\Controllers;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Libraries\Room;

class Server extends BaseController
{

    public function index()
    {
        if (!is_cli()) {
            die("Not a valid method");
        }

        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Room()
                )
            ),
            8080
        );

        $server->run();
    }
}
