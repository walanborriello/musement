<?php
/**
 * Created by PhpStorm.
 * User: franco
 * Date: 18/02/2021
 * Time: 17:28
 */

namespace ExceptionOfTest;

/**
 * Class Error
 * @package ExceptionOfTest
 */
class Error{

    /**
     * Error constructor.
     * @param $message
     * @throws \Exception
     */
    public function __construct($message) {
        @set_exception_handler(array($this, 'exception_handler'));
        throw new \Exception('DOH!!! ' . $message);
    }

    /**
     * Exception handler
     * @param $exception
     */
    public function exception_handler($exception) {
        print "Exception Caught: ". $exception->getMessage() ."\n";
    }
}


