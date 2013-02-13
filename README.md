phpqueue
===
A Php non-blocking PHP Queuing system that uses FIFO files

Based on:
===
This is based on the work/tutorial I read here: 

http://squirrelshaterobots.com/programming/php/building-a-queue-server-in-php-part-4-run-as-a-background-daemon-a-k-a-forking/

The author of the tutorial can be found here: https://github.com/bobmajdakjr|bobmajdakjr| on Github

Files:
===
* PhpQueue.class.php: PHP Class file 
* my_dameon.php: example of how to build a listener daemon
* caller.php: an example of how you'd write to the queue from php
* caller.sh: an example of how you'd write to the queue from shell/bash

* my_dameon: example INIT script to start stop the "order_queue"daemon

Usage:
====
Use this code to create a Daemon that will listen for input and call a defined method in an object for each entry it receives. The daemon will accept the input in a non-blocking/asynchronous fashion meaning that the caller code doesn't have to wait for the process to finish. 

Typical usage would be sending data to a slow webservice. Your calling code writes an ID to the queue and moves on. The daemon handles actually doing the work but doesn't make the caller wait.

Setup:
====
You'll need to place PhpQueue.class.php somewhere in your php include path.. or load it using an autoloader. (composer support is on my TODO list) . 

Make a copy of my_dameon.php to start yourself off. Inside this file you'll find a example action class. This class actually does the work (IE calls a webservice ... or does something that will take a while). The class should have a __toString method that we use for logging. It also needs at least 1 method that takes in a single ID. These would be IDs that a caller sends to the queue.

There is a unix init script (my_dameon) (tested on Centos tested) that will start/stop the queue server. You'll need to change the name/pathes listed at the stop of the my_dameon file. 

Once you have a daemon setup and listening to a file: queueserver-input. Your calling code can just do this:
```
echo "123" > /tmp/queueserver-input
```
OR from php
```
$pipe="/tmp/queueserver-input";
$fh = fopen($pipe, 'w') or die("can't open file $pipe");
fwrite($fh, "456");

```


Why
==
Why would you want to use this? If you have lots of existing PHP infrastructure and you need some non-blocking message queing-like functionality.

TODO
==
* PSR0
* Composer

Authors
==
* Orginal Tutorial Author: Bob Majdak Jr <bob@catch404.net> (@bobmajdakjr)
* Modified By: John Hirbour <john@hirbour.org> (@jhirbour)

License
==
This project and all its files are licensed under the New BSD License. Here it is...

Copyright (c) 2013 All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions
are met:

* Redistributions of source code must retain the above copyright
notice, this list of conditions and the following disclaimer.

* Redistributions in binary form must reproduce the above copyright
notice, this list of conditions and the following disclaimer in the
documentation and/or other materials provided with the
distribution.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
"AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.



