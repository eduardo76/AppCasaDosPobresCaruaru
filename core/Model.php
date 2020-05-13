<?php
namespace core;

use \core\Database;

class Model {

    protected static $pdo;

    public function __construct() {
        self::pdo();
    }

    public static function pdo(){
        self::$pdo = Database::getInstance();
        return self::$pdo;
    }

}
