<?php

namespace Soict\Model\Resource;

class AbstractClass {

	protected static $_name = '';

	public static function getName() {
		global $wpdb;
		return $wpdb->prefix . static::$_name;
	}

}
