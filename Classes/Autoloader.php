<?php
/*
 * Simple PHP Namespace Friendly Autoloader Class
 *
 * inspired by Thomas Hunter II
 *
 */
class Autoloader {
	/**
	 * Converts a class name (with namespace) into a directory php file.
	 *
	 * @param string $className
	 * @return boolean
	 */
	static public function loader($className)
	{
		/**
		 * File name for the class in question.
		 *
		 * @var string $filename
		 */
		$filename = "Classes/" . str_replace('\\', '/', $className) . ".php";
		
		if (file_exists($filename)) {
			include($filename);
			if (class_exists($className)) {
				return true;
			}
		}
		return false;
	}
}
spl_autoload_register('Autoloader::loader');