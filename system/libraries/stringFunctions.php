<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Heather Evens
 * Date: 14/10/13
 * Time: 14:05
 * To change this template use File | Settings | File Templates.
 */

function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
{

  $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

  if ($capitalizeFirstCharacter === false)
    $str = lcfirst($str);

  return $str;
}
