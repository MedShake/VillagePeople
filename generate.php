<?php
/*
* This file is part of MedShake's Village People.
*
* Copyright (c) 2019
* Bertrand Boutillier <b.boutillier@gmail.com>
* http://www.medshake.net
*
* MedShake's Village People is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* any later version.
*
* MedShake's Village People is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
*
* You should have received a copy of the GNU Affero General Public License
* along with MedShake's Village People. If not, see <http://www.gnu.org/licenses/>.
*/

/**
* Generate population 
*
* @author Bertrand Boutillier <b.boutillier@gmail.com>
* @contrib Michaël Val
*
*/

ini_set('display_errors', 1);
setlocale(LC_ALL, "fr_FR.UTF-8");

spl_autoload_register(function ($class) {
    if (is_file('class/' . $class . '.php')) {
        include 'class/' . $class . '.php';
    }
});

foreach (yaml_parse_file('definePop.yml') as $k => $v) {
    define(mb_strtoupper($k), $v);
}

array_map('unlink', glob("population/*.obj"));
array_map('unlink', glob("population/*.yml"));

$GLOBALS['incrementalId']=STARTID;
echo "start";
for ($i = STARTID ; $i<= NUMBEROFPEOPLE ; $i++ ) {
  unset($person);
  if($i%100 == 0) {
    echo "-->$i";
  }
  if(is_file('population/'.$i.'.obj')) {
    $person = unserialize(file_get_contents('population/'.$i.'.obj'));
  } else {
    $person = new Person();
    $person->setId($i);
  }
  $person->checkAndCompletePerson();
}


Export::exportCSV();
echo "-->done\n";

?>
