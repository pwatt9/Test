<?php
namespace Hotels;

/**
 * Base object to hold functionality required by all classes.
 *
 * @author Paula Watt
 *
 */
class Object
{
    /**
     * Call the logger class to appropriately handle the error message.
     *
     * @param string $class
     * @param string $function
     * @param Exception|Exception $e
     */
    public function logError($class, $function, $e) {
        try {
            Logger\Logger::log($class, $function, $e->getMessage());
        } catch (\Exception $ex) {
            echo 'Error in logging system: '.$ex->getMessage();
        }
    }

    public function displayErrorPage() {
        //@TODO: Surely there is a better way to do this??
    }
}