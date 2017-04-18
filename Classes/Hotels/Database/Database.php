<?php
namespace Hotels\Database;

use Hotels;

/**
 * Database connector base class.
 *
 * @author Paula Watt
 *
 */
class Database extends Hotels\Object {

/**
 * An implementation of a persistent database connection.
 *
 * @var \PDO $pdo
 */
    protected static $pdo;
/**
 * Return a database connection.
 *
 * If the persistent connection isn't available, connect again.  This alllows
 *  for the possibility of non-persistent connections as well, since it is dynamic.
 *
 * @return \PDO
 */
    public static function get_db_conn()
    {
        try {
            // Include the configuration file with the database credentials
            require Hotels\BASE_DIR .'\config.php';

            if (empty(self::$pdo)) {
                $dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset";
                $options = [
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_EMULATE_PREPARES   => false,
                ];
                self::$pdo = new \PDO($dsn, $db_user, $db_pass, $options);
            }
            return self::$pdo;
        } catch (\PDOException $pdoEx) {
            echo 'Could not connect to Database Error: '.$pdoEx->getMessage();
            die();
        } catch (\Exception $e) {
            echo 'Could not connect to Database Error: '.$e->getMessage();
            die();
        }
    }

/**
  * Clears the persistent database connection.
  *
  * Used primarily in error or exception situations where a hanging database
  *   session could cause unexpected behavior.
  *
  */
    public static function close_db_conn()
    {
        self::$pdo = null;
    }
}