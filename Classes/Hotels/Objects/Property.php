<?php
namespace Hotels\Objects;

use Hotels;
use Hotels\Objects\Region;


/**
 * A Property generally refers to a Hotel of some kind.
 *
 * Property is tightly coupled with Region, since a Region may have one
 *   or more Properties
 *
 * @author Paula Watt
 *
 */
class Property extends Hotels\Object
{
    /**
     * Unique identifier.
     *
     * @var integer $id
     */
    protected $id;

    /**
     * Full name of the Property.
     *
     * @var string $name
     */
    protected $name;

    /**
     * Brand name for the Property.
     *
     * @var string $brand
     */
    protected $brand;

    /**
     * Phone number
     *
     * @var string $phone
     */
    protected $phone;

    /**
     * Phone number (formatted US Style: xxx-xxx-xxxx)
     *
     * @var string $phoneFormatted
     */
    protected $phoneFormatted;

    /**
     * Is this a full Service Property?
     *
     * 1 indicates Full Service
     * 0 indicates Selected Service
     *
     * @var integer $isFullService
     */
    protected $isFullService;

    /**
     * Is this a full Service Property?
     *
     * 1 indicates Full-Service
     * 0 indicates Selected Service
     *
     * @var string $isFullServiceName
     */
    protected $isFullServiceName;

    /**
     * URL for Property
     *
     * @var string $url
     */
    protected $url;

    /**
     * Connection to Region by id
     *
     * @var integer $regionId
     */
    protected $regionId;


    /**
     * Region Object for this property
     *
     * @var Region $region
     */
    protected $region;

    /**
     * Allows an Property to be populated during construction.
     *
     * @param integer $id
     * @param string $name
     * @param string $brand
     * @param string $phone
     * @param integer $isFullService
     * @param string $url
     * @param integer $regionId
     * @return boolean
     */
    public function __construct($id = null, $name = null,  $brand = null,
            $phone = null, $isFullService = null, $url = null, $regionId = null)
    {
        try {
            if ($id !== null) {
                $this->setId($id);
            }
            if ($name !== null) {
                $this->setName($name);
            }
            if ($brand !== null) {
                $this->setBrand($brand);
            }
            if ($phone !== null) {
                $this->setPhone($phone);
            }
            if ($isFullService !== null) {
                $this->setIsFullService($isFullService);
            }
            if ($url !== null) {
                $this->setUrl($url);
            }
            if ($regionId !== null) {
                $this->setRegionId($regionId);
            }

            return true;
        } catch (\Exception $t) {
            $this->logError(__CLASS__, __FUNCTION__, $t);
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

    /**
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     *
     * @param string $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     *
     * @param string $phone
     */
    public function setPhone($phone)
    {
        // Strip any possible formatting already in place
        $this->phone= preg_replace("/[^0-9]/","", $phone);

        // Add dashes for US formatting
        $this->phoneFormatted = substr($this->phone, 0, 3)."-".substr($this->phone, 3, 3)."-".substr($this->phone,6);

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getPhoneFormatted()
    {
        return $this->phoneFormatted;
    }

    /**
     *
     * @param string $phoneFormatted
     */
    public function setPhoneFormatted($phoneFormatted)
    {
        $this->setPhone($phoneFormatted);

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getIsFullService()
    {
        return $this->isFullService;
    }

    /**
     *
     * @param string $isFullService
     */
    public function setIsFullService($isFullService)
    {
        $this->isFullServiceName = '';

        if (is_numeric($isFullService)) {
            $this->isFullService = $isFullService;

            if ($isFullService == 0) {
                $this->isFullServiceName = 'Select Service';
            } elseif ($isFullService == 1) {
                $this->isFullServiceName = 'Full-Service';
            }
        }
        // @TODO: What if it's not numeric or valid?
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getIsFullServiceName()
    {
        return $this->isFullServiceName;
    }


    /**
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     *
     * @return integer
     */
    public function getRegionId()
    {
        return $this->regionId;
    }

    /**
     *
     * @param integer $regionId
     */
    public function setRegionId($regionId)
    {
        $this->regionId = $regionId;
        return $this;
    }

    /**
     *
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     *
     * @param Region|integer $region
     */
    public function setRegion($region = null)
    {
        // Did we get an Object, or an array?
        if (is_a($region, 'Hotels\Objects\Region')) {
            $this->region = $region;
        } else if (is_numeric($region)) {
            $this->region = new Region($region);
        } else if (!empty($this->getRegionId())) {
            $this->region = new Region($this->getRegionId());
        }
        return $this;
    }

}