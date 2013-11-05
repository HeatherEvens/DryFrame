<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Heather Evens
 * Date: 15/10/13
 * Time: 13:11
 * To change this template use File | Settings | File Templates.
 */

class DBAL extends PDO {

  public static function getInstance()
  {
    static $inst = null;
    if ($inst === null) {
      try {
        $inst = new DBAL();
      }
      catch (PDOException $e)
      {
        print_r($e);
      }
    }
    return $inst;
  }
  public function __construct()
  {
    parent::__construct('mysql:host='.Config::db_host.';dbname='.Config::db_database,Config::db_user,Config::db_password);
  }
}