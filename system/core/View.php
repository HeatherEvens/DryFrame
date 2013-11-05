<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Heather Evens
 * Date: 14/10/13
 * Time: 12:09
 * To change this template use File | Settings | File Templates.
 */

class View {
  private $templates = array();
  public function addTemplate($template)
  {
    if (strpos($template,'..') === false && file_exists(SYSTEM_PATH.'/view/'.$template.'.php'))
      $this->templates[$template] = array();
  }
  public function removeTemplate($template)
  {
    if (isset($this->templates[$template]))
      unset($this->templates[$template]);
  }
  public function assignVar($template,$varName,$var)
  {
    if (isset($this->templates[$template]))
    {
      $this->templates[$template][$varName] = $var;
    }
  }
  public function assignVars($template,$vars)
  {
    if (isset($this->templates[$template]))
    {
      foreach ($vars as $varName => $var)
      {
        $this->templates[$template][$varName] = $var;
      }
    }
  }
  public function displayTemplate()
  {
    foreach ($this->templates as $templateName => $template)
    {
      $this->_includeTemplate($templateName,$template);
    }
  }
  private function _includeTemplate($templateName,$template)
  {
    if (file_exists(SYSTEM_PATH.'/view/'.$templateName.'.php'))
    {
      foreach ($template as $varName => $var)
        ${$varName} = $var;
      ob_start();
      include SYSTEM_PATH.'/view/'.$templateName.'.php';
      ob_end_flush();
    }
  }
}