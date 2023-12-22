<?php

require_once 'utils/Database.php';

abstract class BaseModel {
    protected Database $db;

    public function __construct() {
        include "config/database.php";
        $this->db = new Database($dbconfig);
    }
}