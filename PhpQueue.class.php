<?php
/*
 * Based on the example here: http://squirrelshaterobots.com/programming/php/building-a-queue-server-in-php-part-4-run-as-a-background-daemon-a-k-a-forking/comment-page-1/#comment-8089
 *
*/
class PhpQueue{
    /**
     * pipe_file: FIFO file used for queuing
     */
    private $pipe_file;
    /**
     * syslog_on : bool for syslog on or off
     */
    private $syslog_on;

    /**
     * __construct 
     * 
     * @param mixed $_pipe_file : FIFO file
     * @param mixed $_use_syslog : if you intend to use syslog or not
     * @param mixed $_fork_debug : if you want to debug the object defaults to false
     * @return void
     */
    public function __construct($_pipe_file,$_use_syslog,$_syslog_app_name,$_syslog_facility){
        $this->pipe_file=$_pipe_file;
        $this->syslog_on=$_use_syslog;
        if($this->syslog_on){
            $this->setupSyslog($_syslog_app_name,$_syslog_facility);
            syslog(LOG_INFO, "Queue Reader Started");
        }
    }

    /**
     * setupSyslog : setup syslog for logging
     * 
     * @param mixed $_syslog_app_name 
     * @param mixed $_syslog_facility 
     * @return void
     */
    public function setupSyslog($_syslog_app_name,$_syslog_facility) {
        $this->syslog_on=true;
        openlog($_syslog_app_name, LOG_PID, $_syslog_facility);
        syslog(LOG_INFO, "Syslog Setup complete");
    }


    /**
     * setupPipeFile : setup the file pipe (removing the old one)
     * 
     * @param mixed $_pipe_file 
     * @return php file handler
     */
    public function setupPipeFile($_pipe_file){
        if(file_exists($_pipe_file)){
            if(!unlink($_pipe_file)) {
                die('unable to remove stale file');
            }   
        }   

        umask(0);
        if(!posix_mkfifo($_pipe_file,0666)){
            die('unable to create named pipe');
        }   

        $pipe = fopen($_pipe_file,'r+');
        if(!$pipe){
            die('unable to open the named pipe');
        }
        stream_set_blocking($pipe,false);
        return $pipe;
    }
    /**
     * readQueue 
     * 
     * @param mixed $_fork_debug 
     * @param mixed $_callback_object 
     * @param mixed $_callback_function 
     * @return void
     */
    public function readQueue($_fork_debug,$_callback_object,$_callback_function) {
        // set this constant to false if we ever need to debug
        // the application in a terminal.
        define('QUEUESERVER_FORK',$_fork_debug);

        if($this->syslog_on){
            syslog(LOG_INFO, "readQueue called: _callback_object:$_callback_object _callback_function:$_callback_function");
        }
        //$queue = array();

        $pipe = fopen($this->pipe_file,'r+');
        if(!$pipe) die('unable to open the named pipe');
        stream_set_blocking($pipe,false);

        // process the queue
        while(1) {
            while($input = trim(fgets($pipe))) {
                stream_set_blocking($pipe,false);
                $queue[] = $input;
            }

            $job = current($queue);
            $jobkey = key($queue);
            if($job) {
                if($this->syslog_on){
                    syslog(LOG_INFO, "Calling: $_callback_object->$_callback_function with job: $job");
                }
                else {
                    print "processing job $job\n";
                }

                $cb_obj = new $_callback_object;
                call_user_func_array(array($cb_obj, $_callback_function), array($job));
                unset($cb_obj);
                //process($job);
                
                next($queue);
                unset($job,$queue[$jobkey]);        
            } else {
                if($this->syslog_on){
                    syslog(LOG_INFO, "no jobs to do - waiting");
                }
                else{
                    print "no jobs to do - waiting\n";
                }
                stream_set_blocking($pipe,true);
            }
            
            if(QUEUESERVER_FORK) ob_clean();
        }//end while running
    } // end readQueue

} // Queue
?>
