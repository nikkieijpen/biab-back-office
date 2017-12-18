<?php
	//-------------------------------------------------------------------------
	// Colorize Web Commons
	// Copyright 2015 Colorize
	// Apache license (http://www.colorize.nl/code_license.txt)
	//-------------------------------------------------------------------------

	/**
	 * Provides access to a MongoDB database. Methods are available for creating
	 * a connection to the database and for working with Mongo Query Language queries. This class
	 * can also be extended with website-specific methods, moving all database
	 * interaction to one place.
	 */
	abstract class AbstractMongoDatabase {

		private $connection;
		private $database;

		/**
		 * Creates a connection to the specified database. The connection will
		 * stay open until the HTTP requests ends or close() is called.
		 * @param 	server String The database server's host name or address.
		 * @param 	dbname String Name of the database to select.
		 * @param 	username String Username of the database account.
		 * @param 	password String Password of the database account.
		 */
		public function __construct($server, $dbname, $username, $password) {
            $this->connection = new MongoClient("mongodb://".$server);
            $this->database = $this->connection->$dbname;
			//$this->connection->authenticate($username, $password);
		}

		/**
		 * Closes the database connection.
		 */
		public function close() {
			$this->connection->close();
		}

		/**
		 * Selects documents from requested collection based on supplied criterea
		 * @param 	collection String The name of the collection.
		 * @param 	options Array criteria that have to be applied to the selection
		 * 			of documents. All options are optional
		 *			- select Array fields to select
		 *			- conditions Array conditions that apply (equivalent of SQL WHERE)
		 *			- sort Array (field => order (ASC or DESC))
		 *			- start Integer number of document that has to be the first of the selection
		 *			- limit Integer number of documents to select
		 */
		public function select($collection, $options = array()) {
			if(isset($options["select"]) === false && isset($options["conditions"]) === false) {
				$selection = $this->database->$collection->find();
			} elseif(isset($options["select"]) === true && isset($options["conditions"]) === true) {
				$selection = $this->database->$collection->find($options["conditions"], $options["select"]);
			} elseif(isset($options["select"]) === true && isset($options["conditions"]) === false) {
				$selection = $this->database->$collection->find(array(), $options["select"]);
			} elseif(isset($options["select"]) === false && isset($options["conditions"]) === true) {
				$selection = $this->database->$collection->find($options["conditions"]);
			}

			if(isset($options["sort"]) === true) {
				$selection->sort(MongoDatabaseUtils::getSort($options["sort"]));
			}

			if(isset($options["start"]) === true) {
				$selection->skip($options["start"]);
			}

			if(isset($options["limit"]) === true) {
				$selection->limit($options["limit"]);
			}

			return $selection;
		}

		/**
		 * Selects all documents from requested collection based on supplied criterea
		 * @param 	collection String The name of the collection.
		 * @param 	sort Array The order in which the selected documents have to
		 *			be sorted.
		 */
		public function selectAll($collection, $sort = array("_id" => "ASC")) {
			$sort = MongoDatabaseUtils::getSort($sort);

			return $this->select(
				$collection,
				$sort
			);
		}

		/**
		 * Selects the document complient to the suppied document ID
		 * @param 	collection String The name of the collection.
		 * @param 	id String The unique ID of the document
		 */
		public function selectById($collection, $id) {
			return $this->select(
				$collection,
				array(
					"conditions" => array("_id" => new MongoId($id))
				)
			);
		}

		/**
		 * Inserts a document in a collection
		 * @param 	collection String The name of the collection.
		 * @param 	document Array The document that has to be added to the
		 *			collection
		 */
		public function insert($collection, $document) {
			$this->database->$collection->insert($document);
			return $document["_id"];
		}

		/**
		 * Updates documents complient to the suppied criterea
		 * @param 	collection String The name of the collection.
		 * @param   where Array properties of documents that have to be affected
		 *			by the changes
		 * @param 	changes Array The changes that have to be applied to the
		 *			particular documents
		 */
		public function update($collection, $where = array(), $changes = array(), $method = '$set') {
			$this->database->$collection->update($where, array($method => $changes));
		}

		/**
		 * Updates the document complient to the suppied document ID
		 * @param 	collection String The name of the collection.
		 * @param 	id String The unique ID of the document
		 * @param 	changes Array The changes that have to be applied to the
		 *			particular documents
		 */
		public function updateById($collection, $id, $changes = array()) {
			$this->update($collection, array("_id" => new MongoId($id)), $changes, '$set');
		}

		/**
		 * Adds a new item to a (sub)array
		 * @param 	collection String The name of the collection.
		 * @param 	id String The unique ID of the document
		 * @param 	field String Name of the array
		 * @param
		 */
		public function updateByIdAddToArray($collection, $id, $field, $newItem) {
			$this->update($collection, array("_id" => new MongoId($id)), array($field => $newItem), '$push');
		}

		/**
		 * Deletes documents complient to the suppied criterea
		 * @param 	collection String The name of the collection.
		 * @param   where Array properties of documents that have to be deleted
		 * @param   justOne Boolean whether only one record should be removed or not
		 */
		public function delete($collection, $where = array(), $justOne = false) {
			$this->database->$collection->remove($where, array("justOne" => $justOne));
		}

		/**
		 * Deletes the document complient to the suppied document ID
		 * @param 	collection String The name of the collection.
		 * @param 	id String The unique ID of the document
		 */
		public function deleteById($collection, $id) {
			$this->delete($collection, array("_id" => new MongoId($id)), true);
		}

		public function count($collection, $options = array()) {
			return $this->select(
				$collection,
				$options
			)->count();
		}

		public function countCursor($cursor) {
			return $cursor->count();
		}
	}

	class MongoDatabaseUtils {
		const SORT_ASC = 1;
		const SORT_DESC = -1;

		/**
		 * Converts (My)SQL sorting to MongoDB sorting
		 * @param 	order String ASC or DESC.
		 */
		public static function getSort($sort) {
			$mongo_sort = array();

			foreach ($sort as $field => $order) {

				switch($order) {
					case "ASC": $order = self::SORT_ASC; break;
					case "DESC": $order = self::SORT_DESC; break;
					default: $order = self::SORT_ASC;
				}

				$mongo_sort[$field] = $order;
			}

			return $mongo_sort;
		}

		/**
		 * Converts (My)SQL LIKE statement value to MongoDB value
		 * @param 	like String.
		 */
		public static function getMongoLike($like) {
			$mongoLike = (substr($like, 0 , 1) == "%" ? $like : "^");
			$mongoLike = (substr($like, -1, 1) == "%" ? $mongoLike : $mongoLike.'$');

			return new MongoRegex("/$mongoLike/i");
		}

		public static function cursorToArray($cursor) {
			return iterator_to_array($cursor, false);
		}
	}
?>
