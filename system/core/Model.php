<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Heather Evens
 * Date: 14/10/13
 * Time: 13:36
 * To change this template use File | Settings | File Templates.
 */

abstract class Model {
  /** @var DBAL $dbConnection */
  protected $dbConnection;
  protected $dry;
  public function __construct()
  {
    $this->dry = DryFrame::getInstance();
    $this->dbConnection = DBAL::getInstance();
  }
}