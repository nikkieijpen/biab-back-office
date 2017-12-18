<?php
	//-------------------------------------------------------------------------
	// Colorize Web Commons
	// Copyright 2009-2015 Colorize
	// Apache license (http://www.colorize.nl/code_license.txt)
	//-------------------------------------------------------------------------

	/**
	 * PHP implementation of the Java class ResourceBundle. A property bundle
	 * can be used to localize a website's texts. Although it can be used to store
	 * the actual contents of the website, its intended use is for texts that are
	 * static, such as the labels for "OK" and "cancel" buttons. By moving all these
	 * texts to one please it becomes far easier to localize the website.
	 *
	 * Property bundles are loaded from plain text files with key/value pairs. The
	 * name of the file determines the locale for which it is intended (for example
	 * bundle_nl.properties for Dutch). If no file is available for the requested
	 * locale, the default bundle will be used (which in the example is 
	 * bundle.properties). This fallback file can optionally be changed.
	 */
	class PropertyBundle {
	
		private $name;
		private $language;
		private $path;
		
		private $properties;
		private $fallback;
		
		/**
		 * Creates a new property bundle for the specified language.
		 * @param name Name of the .properties file.
		 * @param language 2-letter language code (e.g. "nl", "en", etc.)
		 * @param path Optional path from where to load .properties files.
		 * @throws Exception if the .properties file could not be loaded.
		 */
		public function __construct($name, $language, $path = "") {
			$this->name = $name;
			$this->language = $language;
			$this->path = $path;
			
			$this->load();
			$this->setFallbackLanguage(NULL);
		}
		
		/**
		 * Loads all texts in this property bundle into an associative array.
		 * @throws Exception if the file does not exist.
		 */
		protected function load() {
			$file = $this->searchFile();	
			if (!file_exists($file)) {
				throw new Exception("File does not exist: $file");
			}
			
			$this->properties = new Properties();
			$this->properties->loadFromFile($file);
		}
	
		/**
		 * Returns the path to the .properties that should be loaded.
		 */
		private function searchFile() {
			$file = $this->path.$this->name.".properties";
		
			if (!is_null($this->language)) {
				$file = $this->path.$this->name."_".$this->language.".properties";
				if (!file_exists($file)) {
					$file = $this->path.$this->name.".properties";
				}
			}
			
			return $file;
		}
		
		public function setFallbackLanguage($fallbackLanguage) {
			if (!is_null($fallbackLanguage)) {
				$this->fallback = new PropertyBundle($this->name, $fallbackLanguage, $this->path);
			} else {
				$this->fallback = null;
			}
		}
		
		public function getFallbackLanguage() {
			return $this->fallback->getLanguage();
		}
		
		/**
		 * Returns the text from this property bundle with the specified key. If
		 * no such key exists in the bundle, the key itself is returned. 
		 * Optionally, a number of parameters can be embedded in the string. Any
		 * parameters set will replace the values "{0}", "{1}" etc.
		 */
		public function getString($key, $params = "") {
			if ($this->hasKey($key)) {
				$text = $this->properties->getProperty($key);
			} elseif (!is_null($this->fallback)) {
				$text = $this->fallback->getString($key, $params);
			} else {
				return $key;
			}
			
			// Vararg emulation
			$paramsArray = func_get_args();
			array_shift($paramsArray);
			return $this->messageFormat($text, $paramsArray);
		}
		
		/**
		 * PHP implementation of the MessageFormat notation, where parameters are
		 * represented by "{0}, "{1}", etc.
		 * @param paramsArray An array with all parameter values.
		 */
		protected function messageFormat($text, $paramsArray) {
			for ($i = 0; $i < count($paramsArray); $i++) {
				if (strlen($paramsArray[$i]) > 0) {
					$text = str_replace('{'.$i.'}', $paramsArray[$i], $text);
				}
			}	
			return $text;
		}
		
		protected function hasKey($key) {
			return $this->properties->hasProperty($key);
		}
	}
?>
