<?php
namespace Hotels\Controllers;

use Hotels;
use Hotels\Database\RegionDB;
use Hotels\Objects\Region;

/**
 * Region Controller to sit between Model (Business Logic) and the Views (UI)
 *
 * @author Paula Watt
 *
 */
 class RegionController extends Hotels\Object
{
    /**
     * Fetch an Property from the database, and populate the current object with
     *   the results.
     *
     * @param integer $id
     * @return \Hotels\Objects\Region|boolean
     */
    public function loadObj($id)
    {
        try {
            $dbObj = new RegionDB;
            // If the fetch was successfull, populate the object.
            if ($regionDb = $dbObj->dbFetch($id)) {
                $regionObj = new Region($regionDb['id'],
                                        $regionDb['name']);
                return $regionObj;
            }
            return false;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            return false;
        }
    }

    /**
     * Fetch all instances of regions from the database, then return an
     *   array of Objects
     *
     * @return \Hotels\Objects\Region[]|boolean
     */
    public function loadAllObj()
    {
        try {
            $dbObj = new RegionDB;
            // If the fetch was successfull continue to populate objects
            if ($regionsDb = $dbObj->dbFetchAll()) {
                // If no records were found, or there was an error:
                if (!is_array($regionsDb)) {
                    $regionsDb = array();
                }
                $regionObjArray = array();
                // Loop through the DB array, creating an Object Array
                foreach ($regionsDb as $regionDb) {
                    $regionObj = new Region($regionDb['id'],
                                            $regionDb['name']);
                    $regionObjArray[]= $regionObj;
                }
                return $regionObjArray;
            }
            return false;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            return false;
        }
    }
}