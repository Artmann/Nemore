<?php

namespace Nemore;

use \Nemore\FileNotFoundException;

class DAL {
	protected $store;
	protected $storePath;
	protected $persistedAt;

	/**
	* Initialize a new store
	* @param string $storePath
	*/
	public function __construct($storePath = null) {
		if($storePath) {
			$this->storePath = $storePath;
			$this->loadStoreFromFile();
			$this->persistedAt = time();
		} else {
			$this->store = "";
		}
  }

	/**
	* Select data from the store
	* @param string $pattern
	* @return array
	*/
  public function select($pattern) {
		$matches = [];
		preg_match_all($pattern, $this->store, $matches);
		return $matches;
	}

	/**
	* @param mixed $data The data to be inserted
	* @param bool $forcePersistance Force save to disk if store path is present
  */
  public function insert($data, $forcePersistance = false) {
		if(is_array($data)) {
			$this->store .= implode("", $data);
		} else {
			$this->store .= $data;
		}

		if($this->storePath !== null) {
			if($forcePersistance || (time() - $this->persistedAt) > 60) {
				if($this->saveToFile()) {
					$this->persistedAt = time();
				}
			}
		}
	}

	protected function loadStoreFromFile() {
		if(! file_exists($this->storePath) ) {
			throw new FileNotFoundException("Could not open store:".$this->storePath);
		}
		$this->store = file_get_contents($this->storePath);
	}

	protected function saveToFile() {
		return file_put_contents($this->storePath, $this->store) !== false;
	}
}
