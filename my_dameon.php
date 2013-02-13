#!/usr/bin/env php
<?php
// has to be run from the command line
if (php_sapi_name() != 'cli') 
{
        die('Must run from command line');
}
//error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
ini_set('log_errors', 0);
ini_set('html_errors', 0);

/**
 * myTestClass: an example class that you've created. It must have a __to_string method and at least 1 method that takes an ID that you want to process
 */
class myTestClass{
    public function __toString() {
        return __CLASS__;
    }

    /**
     * doit : simple method that does something needful
     * 
     * @param mixed $id 
     * @return void
     */
    public function doit($id) {
        // here is where you'd do something...
        // we just log and sleep pretending we did something
        syslog(LOG_INFO, "This is myTestClass.doit running for id:$id");
        sleep(1); //. make it look like we did work.
        return;
    }
}

require_once('PhpQueue.class.php');
try
{
    // FIFO file that will be used to send messages
    $pipe_file="/tmp/queueserver-input";

    // create a new queue instance giving the pipefile, true (that we want syslog), syslog_app_name (optional), syslog facility (optional)
    $Queue = new PhpQueue($pipe_file,true,"Netsuite Order batcher",LOG_LOCAL6);

    // set this to false if you want to run the daemon on the CLI for debugging
    define('QUEUESERVER_FORK',true);

    // fork into a background process
    if(QUEUESERVER_FORK) {
        $pid = pcntl_fork();
        if($pid === -1) die('error: unable to fork.');
        else if($pid) exit(0);
        
        posix_setsid();
        sleep(1);
        
        ob_start();
    }

    // setup a pipe file to use
    $Queue->setupPipeFile($pipe_file);

    // do the queue needful
    $Queue->readQueue(false,"myTestClass","doit");

    // close syslog
    closelog();
    exit(0);
} // stop trying
catch (Exception $e)
{
    print "ERROR: an Exception was thrown \"{$e->getMessage()}\"\n";
    exit(1);
}
?>
