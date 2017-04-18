<?php
namespace Hotels\Objects;

use Hotels;

/**
 * A Region of the United States
 *
 * @author Paula Watt
 *
 */
class Region extends Hotels\Object
{
    /**
     * Unique identifier.
     *
     * @var integer $id
     */
    protected $id;

    /**
     * Full name of the Region.
     *
     * @var string $name
     */
    protected $name;

    /**
     * Allows an Property to be populated during construction.
     *
     * @param integer $id
     * @param string $name
     * @return boolean
     */
    public function __construct($id = null, $name = null)
    {
        try {
            if ($id !== null) {
                $this->setId($id);
            }
            if ($name !== null) {
                $this->setName($name);
            }
            return true;
        } catch (\Exception $e) {
            $this->logError(__CLASS__, __FUNCTION__, $e);
            return false;
        }
    }


    /**
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
}