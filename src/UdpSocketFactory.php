<?php

namespace Chat;

use Exception;
use React;
use React\EventLoop\LoopInterface;
use React\Datagram\Socket;
use React\EventLoop\Factory;

class UdpSocketFactory extends React\Datagram\Factory
{
  public function createClient($address)
  {
      $loop = $this->loop;

      return $this->resolveAddress($address)->then(function ($address) use ($loop) {
          $socket = stream_socket_client($address, $errno, $errstr, 30, STREAM_CLIENT_CONNECT, stream_context_create(
            ['socket' => ['so_broadcast' => true]]
          ));

          if (!$socket) {
              throw new Exception('Unable to create client socket: ' . $errstr, $errno);
          }

          return new Socket($loop, $socket);
      });
  }
}