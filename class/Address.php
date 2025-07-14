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
* Class: address
*
* @author Bertrand Boutillier <b.boutillier@gmail.com>
* @contrib Michaël Val
*
*/


class Address {

  private $_personId;
  private $_addressStreetNumber=null;
  private $_addressStreet=null;
  private $_addressCity=null;
  private $_addressPostalCode=null;
  private $_addressPhone=null;


  function __construct($id='0') {
    $this->_personId=$id;
  }

  public function getAddressStreetNumber() {
    return $this->_addressStreetNumber;
  }

  public function getAddressStreet() {
    return $this->_addressStreet;
  }

  public function getAddressCity() {
    return $this->_addressCity;
  }

  public function getAddressPostalCode() {
    return $this->_addressPostalCode;
  }

  public function getAddressPhone() {
    return $this->_addressPhone;
  }

  public function getRandomAddress() {
    $cities = yaml_parse_file('data/cities.yml');
    $city = array_rand($cities);
    $this->_addressPostalCode = $city;
    $this->_addressCity = $cities[$city]['name'];
    $this->_addressStreet = $cities[$city]['streets'][array_rand($cities[$city]['streets'])];
    $this->_addressStreetNumber = rand(STREETNUMBERMIN, STREETNUMBERMAX);
    $this->_addressPhone = $this->_getRandomPhone();
    return $this;
  }

  private function _getRandomPhone() {
    if(METHODFORPHONE == 'list') {
      $phone = yaml_parse_file('data/phone.yml');
      return $phone[array_rand($phone)];
    } else {
      $id=str_pad($this->_personId, 6, '0', STR_PAD_LEFT);
      $phone=array(
        '0'=>PHONEPREFIX,
        '1'=>rand(10,99),
        '2'=>substr($id, 4, 2),
        '3'=>($this->_personId < 10000)?(rand(10,99)):(substr($id, 0, 2)),
        '4'=>($this->_personId < 100)?(rand(10,99)):(substr($id, 2, 2)),
      );
      return implode(' ', $phone);
    }
  }

}
