<?php

require_once '../inc/setup.inc.php';

//確保在連接客戶端時不會超時   
set_time_limit(0);

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
    $msg = "Welcome To Xmind Server!" . PHP_EOL;
    socket_write($msgsock, $msg, strlen($msg));
    

    echo "The Server is running……" . PHP_EOL;
    do {
        if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
            echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($msgsock)) . "\n";
            break 2;
        }
        if (!$buf = trim($buf)) {
            continue;
        }
        if ($buf == 'quit') {
            break;
        }
        if ($buf == 'shutdown') {
            socket_close($msgsock);
            break 2;
        }
        $talkback = "PHP: You said '$buf'.\n";
        socket_write($msgsock, $talkback, strlen($talkback));
        echo "$buf\n";
    } while (true);
    socket_close($msgsock);
} while (true);

socket_close($sock);
