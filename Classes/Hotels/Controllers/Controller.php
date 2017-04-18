<?php
namespace Hotels\Controllers;

use Hotels\Objects\Property;

/**
 * Controller to sit between the Model (Business Logic) and the Views (UI)
 *
 * @author Paula Watt
 *
 */
class Controller
{
    /**
     * Plates templating library variable
     *
     * @var \League\Plates\Engine $templates
     */
    private $templates;

    /**
     *
     * @param \League\Plates\Engine $templates
     */
    public function __construct(\League\Plates\Engine $templates)
    {
        $this->templates = $templates;
    }

    /**
     * Renders home page, and implements specified action
     *
     * @param string $action
     * @param array|string $data
     * @return string
     */
    public function getIndex($action = '', $data = '')
    {
        // Create and assign data to template object
        $template = $this->templates->make('home');

        // Create a Property controller, to deal will the Property interface
        $propertyCtrl = new PropertyController();
        if ($action == 'Add') {
            $propertyArray = $propertyCtrl->addProperty($data);
        } elseif ($action == 'Edit') {
            $propertyArray = $propertyCtrl->editProperty($data);
        } elseif ($action == 'delete') {
            // Determine whether $data is a number or an array, and treat accordingly
            if (is_numeric($data)) {
                $id = $data;
            } elseif (is_array($data)) {
                $id = $data['id'];
            }
            $propertyCtrl->deleteProperty($id);
        }

        // Get all the Properties and preprare to show them on the screen
        $propertyArray = $propertyCtrl->loadAllObj();
        $template->data(['propertyArray' => $propertyArray]);

        return $template->render();
    }

    /**
     *
     * @param string $action ('add', 'edit')
     * @param string $id (only for use with 'edit')
     * @return boolean|string
     */
    public function getProperty($action = 'add', $id = null)
    {
        if (empty($action)) {
            $action = 'add';
        }
        $action = strtolower($action);

        // Create and assign data to template object
        $template = $this->templates->make('propertyEdit');

        // Create a new Property object, and load it (if editing)
        $propertyObj = new Property();
        if ($action == 'edit') {
            $propertyCtrl = new PropertyController();
            $propertyObj = $propertyCtrl->loadObj($id);
            if ($propertyObj === false) {
                return false;
            }
        }
        // Get all the Regions for the drop drown
        $regionCtrl = new RegionController();
        $regionObjArray = $regionCtrl->loadAllObj();
        if ($regionObjArray == false) {
            return false;
        }

        // Make $action appropriate case for display on button
        $action = ucfirst($action);

        $template->data(['regionObjArray' => $regionObjArray,
                'propertyObj' => $propertyObj,
                'action' => $action]);

        return $template->render();
    }

    /**
     * Renders the error page.
     *
     * @return string
     */
    public function getErrorPage()
    {
        // Create and assign data to template object
        $template = $this->templates->make('error');

        return $template->render();
    }
}