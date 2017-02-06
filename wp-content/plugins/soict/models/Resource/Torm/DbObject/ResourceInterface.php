<?php

namespace Torm\DbObject;

interface ResourceInterface {

    public function setConnection($conn);

    public function getConnection();

    public function getCollection();

}
