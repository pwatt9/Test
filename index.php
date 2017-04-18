<?php
namespace Hotels;

use Hotels\Controllers;

/**
 * The application is be a simplified Hotel tracking system.
 *
 */

include '/vendor/autoload.php';

/**
 * Constant used to locate the base directory (for config.php file).
 *
 * @var string BASE_DIR
 */
CONST BASE_DIR = __DIR__;

require_once("Classes/Autoloader.php");

// Create new Plates engine
$templates = new \League\Plates\Engine(BASE_DIR.'/views');

// Get a new instance of the controller to use for this file
$controller = new Controllers\Controller($templates);

// Clean input and determine next page to open
$page = '';
if (isset($_POST['page'])) {
    $page = strip_tags(trim($_POST['page']));
}

// Clean action to determine next action
$action = '';
if (isset($_POST['action'])) {
    $action = strip_tags(trim($_POST['action']));
}

// If the Cancel button has been pressed, all actions are Cancelled
if (isset($_POST['cancel'])) {
    $action = 'cancel';
}

// Default to the home page
if (empty($page) || $page == 'home' || $action == 'home') {
    echo $controller->getIndex($action, $_POST);
} else {
    // Add button
    if ($page == 'propertyAdd') {
        echo $controller->getProperty('add');
    }
    // Edit button
    if ($page == 'propertyEdit') {
        $id = '';
        if (isset($_POST['id'])) {
            $id = strip_tags(trim($_POST['id']));
        }
        echo $controller->getProperty('edit', $id);
    }
    // Delete button
    if ($page == 'delete') {
        $id = '';
        if (isset($_POST['id'])) {
            $id= strip_tags(trim($_POST['id']));
        }
        echo $controller->getIndex('delete', $id);
    }
    // Error page
    if ($page == 'error') {
        echo $controller->getErrorPage();
    }
}