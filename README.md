phpqueue
===
A Php Queuing system using FIFO files

Based on:
===
This is based on the work done here: http://squirrelshaterobots.com/programming/php/building-a-queue-server-in-php-part-4-run-as-a-background-daemon-a-k-a-forking/

[https://github.com/bobmajdakjr|bobmajdakjr| on Github

Files:
===
* PhpQueue.class.php: PHP Class file 
*  order_queue.php: example of how to build a message queue listener for "orders"
* order_queue: example INIT script to start stop the "order_queue"daemon

Usage:
====

Why
==
Why would you want to use this? If you have lots of existing PHP infrastructure and you need some non-blocking message queing-like functionality.

Authors
--------------------------------

 * Orginal Author: Bob Majdak Jr <bob@catch404.net> (@bobmajdakjr)
* Modified By: John Hirbour <john@hirbour.org> (@jhirbour)

License
--------------------------------

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


