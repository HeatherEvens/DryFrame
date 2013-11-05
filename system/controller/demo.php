<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Heather Evens
 * Date: 16/10/13
 * Time: 09:34
 * To change this template use File | Settings | File Templates.
 */

class Demo extends Controller {
  public function index()
  {
    $this->view->addTemplate('demo');
  }
}