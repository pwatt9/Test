<?php
namespace Hotels\Controllers;

use Hotels;
use Hotels\Database\PropertyDB;
use Hotels\Objects\Property;
use Hotels\Objects\Region;
use Hotels\Database\RegionDB;

/**
 * Property Controller to sit between Model (Business Logic) and the Views (UI)
 *
 * @author Paula Watt
 *
 */
class PropertyController extends Hotels\Object
{
    /**
     * Fetch a single Property from the database, and return an object with
     *   the results.
     *
     * @param integer $id
     * @return Property|boolean
     */
    public function loadObj($id)
    {
        try {

            $dbPropertyObj = new PropertyDB;
            // If the fetch was successfull, populate the object.
            if ($propertyDb = $dbPropertyObj->dbFetch($id)) {
                $propertyObj = new Property($propertyDb['id'],
                                            $propertyDb['name'],
                                            $propertyDb['brand'],
                                            $propertyDb['phone'],
                                            $propertyDb['isFullService'],
                                            $propertyDb['url'],
                                            $propertyDb['regionId']);


                // Now get the Region that goes with it
                $dbRegionObj = new RegionDB();
                $regionDb = $dbRegionObj->dbFetch($propertyDb['regionId']);
                $propertyObj->setRegion(new Region($regionDb['id'], $regionDb['name']));
                return $propertyObj;
            }
            return false;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            return false;
        }
    }


    /**
     * Fetch all instances of properties from the database, then return an
     *   array of Objects
     *
     * @return \Hotels\Objects\Property[]|boolean
     */
    public function loadAllObj()
    {
        try {
            $dbPropertyObj= new PropertyDB;
            // If the fetch was successfull, populate the object.
            if ($propertiesDb = $dbPropertyObj->dbFetchAll()) {
                // If no records were found, or there was an error:
                if (!is_array($propertiesDb)) {
                    $propertiesDb = array();
                }
                $propertyObjArray = array();
                // Loop through the DB array, creating an Object Array
                foreach ($propertiesDb as $propertyDb) {
                    $propertyObj = new Property($propertyDb['id'],
                        $propertyDb['name'],
                        $propertyDb['brand'],
                        $propertyDb['phone'],
                        $propertyDb['isFullService'],
                        $propertyDb['url'],
                        $propertyDb['regionId']);

                    // Now get the Region that goes with it
                    $dbRegionObj = new RegionDB();
                    $regionDb = $dbRegionObj->dbFetch($propertyDb['regionId']);
                    $propertyObj->setRegion(new Region($regionDb['id'], $regionDb['name']));

                    // Assign the object to the array
                    $propertyObjArray[]= $propertyObj;
                }
                return $propertyObjArray;
            }
            return false;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            return false;
        }
    }

    /**
     * Insert a single property record
     *
     * @param array $data
     * @return boolean
     */
    public function addProperty($data) {
        try {
            $dbObj = new PropertyDB;

            // Assume $data has corrupted data.
            $validData = $this->validateProperty($data);

            if ($validData !== false && !empty($validData) && is_array($validData)) {
                return $dbObj->dbInsert($validData['name'], $validData['brand'],
                    $validData['phone'], $validData['isFullService'],
                    $validData['url'], $validData['regionId']);
            }
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            return false;
        }
    }


    /**
     * Update a single property record
     *
     * @param array $data
     * @return array|boolean
     */
    public function editProperty($data) {
        try {
            $dbObj = new PropertyDB;

            // Assume $data has corrupted data.
            $validData = $this->validateProperty($data);
            // Validate the id separately, since it's required here
            $validId = $this->validateId($data['id']);
            if ($validId !== false && !empty($validId)) {
                $validData['id'] = $validId['id'];
            }

            // Determine if the data is valid, and return.
            if ($validData !== false && !empty($validData) && is_array($validData)) {
                return $dbObj->dbUpdate($validData['id'], $validData['name'], $validData['brand'],
                        $validData['phone'], $validData['isFullService'],
                        $validData['url'], $validData['regionId']);
            }
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            return false;
        }
    }

    /**
     * Validate the Property data in an array from an unknown source.
     *
     * @param array $data
     * @throws \Exception
     * @return array|boolean
     */
    public function validateProperty($data) {
        try {
            $error = array();
            isset($data['name']) ? $name = strip_tags(trim($data['name'])): $error[] = 'name';
            isset($data['brand']) ? $brand = strip_tags(trim($data['brand'])): $error[] = 'brand';
            isset($data['phone']) ? $phone = strip_tags(trim($data['phone'])): $error[] = 'phone';
            isset($data['isFullService']) ? $isFullService = strip_tags(trim($data['isFullService'])): $error[] = 'isFullService';
            isset($data['url']) ? $url = strip_tags(trim($data['url'])): $error[] = 'url';
            isset($data['regionId']) ? $regionId = strip_tags(trim($data['regionId'])): $error[] = 'regionId';

            if (!empty($error)) {
                $errMsg = implode(', ', $error);
                throw new \Exception("Could not find required fields: $errMsg");
                return false;
            }
            $validateArray = array('name'=>$name, 'brand'=>$brand, 'phone'=>$phone,
                    'isFullService'=>$isFullService, 'url'=>$url, 'regionId'=>$regionId);
            return $validateArray;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            $this->displayErrorPage();
            return false;
        }
    }

    /**
     * Validates the id, from an unknown source
     *
     * @param string $dirtyId
     * @throws \Exception
     * @return boolean|array
     */
    public function validateId($dirtyId) {
        $error = array();
        isset($dirtyId) ? $id = strip_tags(trim($dirtyId)): $error[] = 'id';
        if (!empty($error)) {
            $errMsg = implode(', ', $error);
            throw new \Exception("Could not find required fields: $errMsg");
            return false;
        }
        $validateArray = array('id'=>$id);
        return $validateArray;
    }

    /**
     * Delete the record specified by $id
     *
     * @param string $id
     * @throws \Exception
     * @return boolean
     */
    public function deleteProperty($id) {
        try {
            $dbObj = new PropertyDB;
            // Validate the id separately, since it's required here
            $validId = $this->validateId($id);
            $validId = $validId['id'];
            if ($validId !== false && !empty($validId)) {
                return $dbObj->dbDelete($validId);
            }
            return false;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            $this->displayErrorPage();
            return false;
        }
    }

}