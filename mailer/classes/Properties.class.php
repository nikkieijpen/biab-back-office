<?php
	//-------------------------------------------------------------------------
	// Colorize Web Commons
	// Copyright 2009-2015 Colorize
	// Apache license (http://www.colorize.nl/code_license.txt)
	//-------------------------------------------------------------------------
	
	/**
	 * PHP port of Java's Properties class and the associated file format.
	 * Property files, with the .properties file extension, store key/value pairs
	 * in a very simple format. Every line contains one key/value pair, separated
	 * by an equals character. Optionally, multi-line values can be used by ending
	 * a line with the backslash character. All leading and trailing whitespace is
	 * removed from both keys and values.
	 */
	class Properties {
	
		private $propertyMap;
	
		/**
		 * Creates a new Properties instance which is initially empty.
		 */
		public function __construct() {
			$this->propertyMap = array();
		}
		
		/**
		 * Loads the .properties file located at the specified path. All key/value
		 * pairs in the file will be added to this object.
		 * @throws Exception if the file cannot be parsed.
		 */
		public function loadFromFile($file) {
			if (!file_exists($file)) {
				throw new Exception("File does not exist: $file");
			}
			
			$fileContents = file($file);
			$this->loadFromString($fileContents);
		}
		
		/**
		 * Loads a .properties file from a string. 
		 * @param contents Either a string that represents the contents of a
		 *        .properties file, or an array of lines (also representing a
		 *        .properties file).
		 * @throws Exception if the string cannot be parsed.
		 */
		public function loadFromString($contents) {
			$lines = $this->getLines($contents);
			$lastKey = "";
			$buffer = "";
			
			foreach ($lines as $line) {
				$line = trim($line);
				
				if ((strlen($line) == 0) || (strpos($line, '#') === 0)) {
					continue;					
				}
				
				$parts = explode('=', $line, 2);
				
				if (count($parts) == 2) {
					$lastKey = trim($parts[0]);
					$buffer .= $parts[1];
				} elseif (strlen($buffer) > 0) {
					$buffer .= $line;
				}
				
				if (substr($line, -1) != "\\") {
					$this->propertyMap[$lastKey] = $this->normalizeWhitespace($buffer);
					$buffer = "";
				} else {
					$buffer = substr($buffer, 0, strlen($buffer) - 1);
				}
			}
		}
		
		private function getLines($contents) {
			if (is_array($contents)) {
				return $contents;
			} else {
				return explode("\n", $contents);
			}
		}
		
		private function normalizeWhitespace($str) {
			$str = str_replace('\n', "\n", $str);
			$str = str_replace('\t', "\t", $str);
			return $str;
		}
		
		public function setProperty($key, $value) {
			$this->propertyMap[$key] = $value;
		}
		
		/**
		 * Returns the value of the property with the specified key. If the key
		 * does not exist this returns the default value.
		 */
		public function getProperty($key, $defaultValue = null) {
			if (array_key_exists($key, $this->propertyMap)) {
				return $this->propertyMap[$key];
			} else {
				return $defaultValue;
			}
		}
		
		public function hasProperty($key) {
			return array_key_exists($key, $this->propertyMap);
		}
		
		public function removeAll() {
			$this->propertyMap = array();
		}
	}
?>
