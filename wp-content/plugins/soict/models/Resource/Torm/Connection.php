<?php

namespace Torm;

require_once dirname(__FILE__) . '/NotOrm/NotORM.php';
require_once dirname(__FILE__) . '/NotOrm/NotORM/Structure.php';

class Connection {

	//need to modified for your new framework
	public function getConnection($primary = 'id', $cached = false){
		return $this->getConnector($primary, $cached);
	}

	public function getConnector($primary = 'id', $cached = false){
		$pdo = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';', DB_USER, DB_PASSWORD);
		$structure = new \NotORM_Structure_Convention(
			$primary //get first column name to be primary key
		);
		if($cached){
			return new \NotORM($pdo, $structure, new NotORM_Cache_Session);
		}
		return new \NotORM($pdo, $structure);
	}

	public function getDbName(){
		return DB_NAME;
	}

	public function getDbHost(){
		return DB_HOST;
	}
}
