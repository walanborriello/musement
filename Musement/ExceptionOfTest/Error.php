<?php
/**
 * Created by PhpStorm.
 * User: franco
 * Date: 18/02/2021
 * Time: 17:28
 */

namespace ExceptionOfTest;

class Error{

    public function __construct($message) {
        @set_exception_handler(array($this, 'exception_handler'));
        throw new \Exception('DOH!!! ' . $message);
    }

    public function exception_handler($exception) {
        print "Exception Caught: ". $exception->getMessage() ."\n";
    }
}


