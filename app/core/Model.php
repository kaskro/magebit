<?php

namespace app\core;

use app\lib\DB;

abstract class Model
{

    public $_db;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }
}
