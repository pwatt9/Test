<?php
namespace Hotels\Logger;

/**
 * Basic logging class.
 *
 * At the moment, the implementation is a simple echo because it's in design
 *   and development mode. When in production, this information would go to a
 *   log file.
 *
 * @author Paula Watt
 *
 */
class Logger
{
    /**
     * Print the error message to the screen (dev mode)
     *
     * @param string $class
     * @param string $function
     * @param string $error_msg
     */
    public static function log($class, $function, $error_msg)
    {
        echo "<br>Class($class) Function($function) Error: $error_msg <br>";
    }

}