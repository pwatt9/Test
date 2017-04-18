<?php
namespace Hotels\Database;

/**
 * Database support for the Property class
 *
 * @author Paula Watt
 *
 */
class PropertyDB extends Database
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

            $stmt = $dbo->prepare('SELECT id, name, brand, isFullService, phone, url, regionId '.
                    'FROM property WHERE id = :id');
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

            $stmt = $dbo->prepare('SELECT id, name, brand, isFullService, phone, url, regionId '.
                    'FROM property');
            if ($stmt->execute()) {
                $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
                if ($rows) {
                    return $rows;
                } else {
                    return array();
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
     * @param integer $regionId
     * @return integer|boolean
     */
    public function dbInsert($name, $brand, $phone, $isFullService, $url, $regionId)
    {
        try {
            $dbo = Database::get_db_conn();

            $errors = array();
            if ($this->validate($name, $brand, $phone, $isFullService, $url, $regionId, $errors) == false) {
                $errMsg = implode(', ', $errors);
                throw new \Exception('Invalid fields: '.$errMsg);
                die();
            }

            $stmt = $dbo->prepare('INSERT INTO property (name, brand, phone, isFullService, url, regionId)'
                    .' VALUES (:name, :brand, :phone, :isFullService, :url, :regionId)');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':brand', $brand);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':isFullService', $isFullService, \PDO::PARAM_INT);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':regionId', $regionId, \PDO::PARAM_INT);
            if ($stmt->execute()) {
                $id = $dbo->lastInsertId();
                return $id;
            }
            return false;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            Database::close_db_conn();
            $this->displayErrorPage();
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

            $stmt = $dbo->prepare('DELETE FROM property WHERE id = :id');
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
     * @param string $brand
     * @param string $phone
     * @param integer $isFullService
     * @param string $url
     * @param integer $regionId
     * @return array|boolean
     */
    public function dbUpdate($id, $name, $brand, $phone, $isFullService, $url, $regionId)
    {
        try {
            $dbo = Database::get_db_conn();

            $errors = array();
            if ($this->validate($name, $brand, $phone, $isFullService, $url, $regionId, $errors, $id) == false) {
                $errMsg = implode(', ', $errors);
                throw new \Exception('Invalid fields: '.$errMsg);
                die();
            }

            $stmt = $dbo->prepare('UPDATE property SET name = :name,'
                    .' brand = :brand, phone = :phone, isFullService = :isFullService,'
            		.' url = :url, regionId = :regionId '
            		. ' WHERE id = :id');
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':brand', $brand);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':isFullService', $isFullService, \PDO::PARAM_INT);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':regionId', $regionId, \PDO::PARAM_INT);
            $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
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

    /**
     * Validate for non-null, data types and length
     *
     * @param string $name
     * @param string $brand
     * @param string $phone
     * @param integer $isFullService
     * @param string $url
     * @param integer $regionId
     * @param array $errors (by reference)
     * @param integer $id (optional)
     * @return boolean
     */
    private function validate($name, $brand, $phone, $isFullService, $url, $regionId, &$errors, $id=null) {
        try {
            $errors = '';

            if (empty($name) || strlen($name) > 50) {
                $errors[] = 'name';
            }

            if (empty($brand) || strlen($brand) > 25) {
                $errors[] = 'brand';
            }

            if (empty($phone) || strlen($phone) > 25) {
                $errors[] = 'phone';
            }

            if (!is_numeric($isFullService)) {
                $errors[] = 'isFullService';
            }

            if (empty($url) || strlen($url) > 255) {
                $errors[] = 'url';
            }

            if (empty($regionId) || !is_numeric($regionId)) {
                $errors[] = 'regionId';
            }
            if ($id !== null && (empty($id) || !is_numeric($id))) {
                $errors[] = 'id';
            }

            if (empty($errors) == false) {
                return false;
            }
            return true;

        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            return false;
        }

    }
}