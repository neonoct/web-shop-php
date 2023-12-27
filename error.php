<?php
#i didnt clear the log file, so it has some old errors that are not accuring anymore
//toplevel error handling
function handleError($errno, $errstr, $errfile, $errline) {
    #add date to error message
    $errorMsg = date("Y-m-d H:i:s - ");
    $errorMsg .= "Error [$errno]: $errstr in $errfile on line $errline" . PHP_EOL;
    error_log($errorMsg, 3, "error.log");
}
set_error_handler("handleError");

function handleException($exception) {
    $exceptionMsg = date("Y-m-d H:i:s - ");
    $exceptionMsg .= "Exception: " . $exception->getMessage() . PHP_EOL;
    error_log($exceptionMsg, 3, "error.log");
}
set_exception_handler("handleException");


?>