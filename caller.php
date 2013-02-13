#!/usr/bin/env php
<?php
// command line stuff
if (php_sapi_name() != 'cli') 
{
        die('Must run from command line');
}
//error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);
ini_set('log_errors', 0);
ini_set('html_errors', 0);

try
{
    $pipe="/tmp/queueserver-input";
    $fh = fopen($pipe, 'w') or die("can't open file $pipe");
    fwrite($fh, "456");

    exit(0);
} // stop trying
catch (Exception $e)
{
    print "ERROR: an Exception was thrown \"{$e->getMessage()}\"\n";
    exit(1);
}
?>
