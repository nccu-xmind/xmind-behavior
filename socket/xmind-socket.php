<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//確保在連接客戶端時不會超時   
set_time_limit(0);

//設定 IP 和 連接埠號   
$address = '127.0.0.1';
$port = 5566;
//創建一個 SOCKET
if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) < 0) {
    echo "socket_create() failed: " . socket_strerror($sock) . PHP_EOL;
} else {
    echo "socket_create() successed!" . PHP_EOL;
}


//绑定到 socket 連接埠   
if (($ret = socket_bind($sock, $address, $port)) < 0) {
    echo "socket_bind() failed: " . socket_strerror($ret) . PHP_EOL;
} else {
    echo "socket_bind() successed!" . PHP_EOL;
}

//開始監聽   
if (($ret = socket_listen($sock, 4)) < 0) {
    echo "socket_listen() failed:" . socket_strerror($ret) . PHP_EOL;
} else {
    echo "socket_listen() successed!" . PHP_EOL;
}

do {
    // Accept any connections coming in on this socket
    if (($msgsock = socket_accept($sock)) < 0) {
        echo "socket_accept() failed: reason: " . socket_strerror($msgsock) . PHP_EOL;
        echo "The Server is Stop……" . PHP_EOL;
        break;
    } else {
        echo "Socket connected." . PHP_EOL;
    }

    //發到客戶端   
    $msg = "<font color=red>Welcome To Server!</font><br>";
    socket_write($msgsock, $msg, strlen($msg));
    socket_close($msgsock);

    echo "The Server is running……" . PHP_EOL;
} while (true);

socket_close($sock);
