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
* Class: export
*
* @author Bertrand Boutillier <b.boutillier@gmail.com>
* @contrib Michaël Val
*
*/

class Export {

  public static function getArrayFromObj($obj) {
      $add = $obj->getAddress('personal');
      return [
          'id' => (int)$obj->getId(),
          'firstname' => (string)$obj->getFirstname(),
          'birthname' => (string)$obj->getBirthname(),
          'lastname' => (string)$obj->getLastname(),
          'birthdate' => (string)$obj->getBirthdate(),
          'age' => (int)$obj->getAgeFromBirthdate($obj->getBirthdate()),
          'weight' => (int)$obj->getWeight(),
          'height' => (int)$obj->getHeight(),
          'gender' => (string)$obj->getGender(),
          'motherId' => (int)$obj->getMotherId(),
          'fatherId' => (int)$obj->getFatherId(),
          'childrenId' => (array)$obj->getChildId(),
          'siblingsId' => (array)$obj->getSiblingsId(),
          'relationShipId' => (int)$obj->getPartnerId(),
          'married' => (bool)$obj->getIsMarried(),
          'job' => (string)$obj->getJob(),
          'addressStreetNumber' => (int)$add->getAddressStreetNumber(),
          'addressStreet' => (string)$add->getAddressStreet(),
          'addressCity' => (string)$add->getAddressCity(),
          'addressPostalCode' => (string)$add->getAddressPostalCode(),
          'mobilPhone' => (string)$obj->getMobilPhone(),
          'phone' => (string)$add->getAddressPhone(),
          'email' => (string)$obj->getPersonalEMail()
      ];
  }

  public static function exportYaml() {
    foreach(glob("population/*.obj") as $file) {
      $obj = file_get_contents($file);
      $obj = unserialize($obj);
      $array=self::getArrayFromObj($obj);
      $yaml = Spyc::YAMLDump($array, false, false, true);
      $filedest='population/'.$obj->getId().'.yml';
      file_put_contents($filedest, $yaml);
      unlink($file);
    }
  }

  public static function exportCSV() {
    $fp = fopen('export.csv', 'w');
    $i=0;
    foreach(glob("population/*.obj") as $file) {
      $obj = file_get_contents($file);
      $obj = unserialize($obj);
      $array=self::getArrayFromObj($obj);
      $array['childrenId']=(string)implode(',', $array['childrenId']);
      $array['siblingsId']=(string)implode(',', $array['siblingsId']);

      if($i==0) {
        fputcsv($fp, array_keys($array), ';');
        $i++;
      }

      fputcsv($fp, $array, ';');

      unlink($file);
    }
    fclose($fp);
  }

  public static function exportYamlBrut() {
      foreach (glob("population/*.obj") as $file) {
          $obj = file_get_contents($file);
          $obj = unserialize($obj);
          $dataArray = (array)$obj;
          $yaml = yaml_emit($dataArray);

          $filedest = 'population/' . $obj->getId() . '.yml';
          file_put_contents($filedest, $yaml);
          unlink($file);
      }
  }

}
