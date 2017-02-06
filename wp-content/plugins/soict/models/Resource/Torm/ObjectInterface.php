<?php

namespace Torm;

interface ObjectInterface {

	//get objects of an model
	//return object array interator
	public function getCollection();

	//delete to database of this object
	//return id primary key of object if success or false
	public function delete();


	//update $data array to internal data
	public function update($data = array());

	//load object data to model by id
	public function load($id);

}
