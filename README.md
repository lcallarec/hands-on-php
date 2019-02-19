# Hands-on PHP

## Distributed chat

This exercise is designed to be completed by several teams at the same time. Teams can be of any size.

You will implement a simple command line distributed chat : one terminal window for displaying messages in a unique channel, and one terminal window to write your message.

### Technical base

According to the composer file, your project will depend on :

- [ReactPHP](https://reactphp.org/) / [ReactPHP/Socket](https://reactphp.org/socket/) and [ReactPHP/Datagram](https://reactphp.org/datagram/), a non-blocking I/O library
- [The Symfony/Console](https://symfony.com/doc/current/components/console.html) component for writing command line applications

### Setup

Install project dependencies

```bash
php composer.phar install
```

If you're using VSCode :

* Install PHP IntelliSense extension
* Disable PHP › Suggest: Basic in your settings


### Rules

#### 1. Create a command line application server which listen on an UDP socket and output datagrams messages it receives.

 <details>
  <summary>Create an UDP server</summary>
  <p>
  [examples](https://github.com/reactphp/datagram/tree/v1.4.0/examples)
  </p>
</details>
 <details>
  <summary>Which IP address and port should my server listen to?</summary>
  <p>
  You have to listen to the broadcast IP adress of the network interface that connects you with the other teams. Choose en port number that isn't used be any known services.
  </p>
</details>
<details>
  <summary>How can I output messages to the console ?</summary>
  <p>
  [doc](https://symfony.com/doc/current/console.html#console-output)
  </p>
</details>
 <details>
  <summary>At this point, how can I test if my server is working without having to write a dedicated client?</summary>
  <p>
  On macOs, install `netcat` and `socat`: `brew install netcat && brew install socat`.
  
  Send to UDP :
  ```bash
 socat - UDP-DATAGRAM:$IP:$PORT[,broadcast]
  ```

Listen to UDP :

```bash
nc -kluvw 1 $IP $PORT
```
  </p>
</details>

#### 2. Create a command line application client which sends user inputs to a given (hardcoded, doesn't matters) IP. Use the `UdpSocketFactory` class to create the socket client.

<details>
  <summary>Why should I use this factory : ReactPHP/Datagram already exposes such factory ?</summary>
  <p>
  That's because the `ReactPHP datagram socket factory` doesn't allow to set a stream factory context when creating the socket. When your create a socket, for security reasons, you have to tell explicitly that you want to send messages on a broadcast IP.   
  </p>
</details>

<details>
  <summary>Create an UDP client</summary>
  <p>
  [examples](https://github.com/reactphp/datagram/tree/v1.4.0/examples)
  </p>
</details>

<details>
  <summary>How can I read stdin to catch user input  ?</summary>
  <p>
  [doc](https://symfony.com/doc/current/components/console/helpers/questionhelper.html)
  </p>
</details>

<details>
  <summary>How can I ask many times for a user input ?</summary>
  <p>Remember that, somewhere in your client, there'll be an event loop in action.
  [loop interface](https://reactphp.org/event-loop/#loopinterface)</p>
</details>

#### 3. Both your server and client command line application must take as options both IP and port they handle. Both options are required.

 <details>
  <summary>Options command documentation</summary>
  <p>
  [doc](https://symfony.com/doc/current/console/input.html#using-command-options)
  </p>
</details>

#### 4. Your client application should accept a _mandatory_ argument to tell your username.

 <details>
  <summary>Argument command documentation</summary>
  <p>
  [doc](https://symfony.com/doc/current/console/input.html#using-command-arguments)
  </p>
</details>

#### 5. When your server application receives a message, it should display the username before the actual message, as in :

```
[rick] Hello !
```

Teams must agree on the way to send this username information. Tips : don't use protocol buffers :)

 <details>
  <summary>Argument command documentation</summary>
  <p>
  [doc](https://symfony.com/doc/current/console/coloring.html)
  </p>
</details>

#### 6. On the server output, your own messages are displayed in a flashy color

#### 7. When your server application receive a message, it should display the username and the current timestamp before the actual message, as in :

```
[02/06/2019 18:34:43 rick] Hello !
```

#### 8. Take care : your server may receive messages from undesired clients, so handle that kind of messages carefully.

#### 9. While the server application continue to display messages reveived from UDP datagrams, it can display messages from a TCP socket. The client application is now able to send such TCP packets to the server. You don't have to add any options or arguments to the command line applications to implement this rule.
