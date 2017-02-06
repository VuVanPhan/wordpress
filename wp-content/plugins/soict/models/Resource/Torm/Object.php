<?php

namespace Torm;

require_once 'ObjectAbstract.php';

class Object extends ObjectAbstract {

    const TABLE_NAME = '';

    public function getTableName(){
        return static::TABLE_NAME;
    }

}
