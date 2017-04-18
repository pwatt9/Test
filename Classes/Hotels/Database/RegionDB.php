<?php
namespace Hotels\Database;

/**
 * Database support for the region class
 *
 * @author Paula Watt
 *
 */
class RegionDB extends Database
{
    /**
     * Reads from the database and returns an array of a single database element.
     *
     * @param integer $id
     * @return array|boolean
     */
    public function dbFetch($id)
    {
        try {
            $dbo = Database::get_db_conn();

            $stmt = $dbo->prepare('SELECT id, name '.
                    'FROM region WHERE id = :id');
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                if ($row) {
                    return $row;
                }
            }
            return false;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            Database::close_db_conn();
            return false;
        }
    }

    /**
     * Reads from the database and returns an array of all database elements.
     *
     * @return array|boolean
     */
    public function dbFetchAll()
    {
        try {
            $dbo = Database::get_db_conn();

            $stmt = $dbo->prepare('SELECT id, name '.
                    'FROM region');
            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                if ($rows) {
                    return $rows;
                }
            }
            return false;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            Database::close_db_conn();
            return false;
        }
    }

    /**
     * Inserts new record into the database.
     *
     * @param string $name
     * @param string $brand
     * @param string $phone
     * @param integer $isFullService
     * @param string $url
     * @return integer|boolean
     */
    public function dbInsert($name)
    {
        try {
            $dbo = Database::get_db_conn();

            $stmt = $dbo->prepare('INSERT INTO region (name)'
                    .' VALUES (:name)');
            $stmt->bindParam(':name', $name);
            if ($stmt->execute()) {
                $id = $dbo->lastInsertId();
                return $id;
            }
            return false;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            Database::close_db_conn();
            return false;
        }
    }

    /**
     * Delete specific record from the database, by id
     *
     * @param integer $id
     * @return boolean
     */
    public function dbDelete($id)
    {
        try {
            $dbo = Database::get_db_conn();

            $stmt = $dbo->prepare('DELETE FROM region WHERE id = :id');
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            if ($stmt->execute()) {
                $affected_rows = $stmt->rowCount();
                if ($affected_rows == 1) {
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            Logger\Logger::Log(__CLASS__, __FUNCTION__, $e->getMessage());
            Database::close_db_conn();
            return false;
        }
    }

    /**
     * Update the database record identified by the $id parameter
     *
     * @param integer $id
     * @param string $name
     * @return boolean
     */
    public function dbUpdate($id, $name)
    {
        try {
            $dbo = Database::get_db_conn();

            $stmt = $dbo->prepare('UPDATE region SET name = :name'
            		. ' WHERE id = :id');
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
            $stmt->bindParam(':name', $name);
            if ($stmt->execute()) {
                $affected_rows = $stmt->rowCount();
                if ($affected_rows == 1) {
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            Database::close_db_conn();
            return false;
        }
    }
}