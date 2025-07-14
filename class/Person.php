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
* Class: person
*
* @author Bertrand Boutillier <b.boutillier@gmail.com>
* @contrib Michaël Val
*
*/

class Person
{
  private $_id=null;
  private $_firstname=null;
  private $_birthname=null;
  private $_lastname=null;
  private $_birthdate=null;
  private $_age=null;
  private $_weight;
  private $_height;
  private $_gender=null;
  private $_motherId=null;
  private $_motherIsMarried;
  private $_motherAge=null;
  private $_motherPregnantAge=null;
  private $_fatherId=null;
  private $_noChildren=false;
  private $_childId=[];
  private $_siblingsId=[];
  private $_inRelationShip=null;
  private $_married=null;
  private $_partnerId=null;
  private $_job=null;
  private $_address=[];
  private $_mobilPhone=null;
  private $_personalEmail=null;

  public function setId($id) {
    $this->_id = $id;
  }

  public function getId() {
    return $this->_id;
  }

  public function setFirstname($firstname) {
    $this->_firstname=$firstname;
  }

  public function getFirstname() {
    return $this->_firstname;
  }

  public function setBirthname($birthname) {
    $this->_birthname=$birthname;
  }

  public function getBirthname() {
    return $this->_birthname;
  }

  public function setLastname($lastname) {
    $this->_lastname=$lastname;
  }

  public function getLastname() {
    return $this->_lastname;
  }

  public function setChildId($childId) {
    if(!in_array($childId, $this->_childId)) $this->_childId[]=$childId;
  }

  public function getChildId() {
    return $this->_childId;
  }

  public function setPartnerId($v, $ou='', $obj='') {
    return $this->_partnerId=$v;
  }

  public function getPartnerId() {
    return $this->_partnerId;
  }

  public function setBirthdate($date) {
    $this->_birthdate = $date;
  }

  public function getBirthdate() {
    return $this->_birthdate;
  }

  public function setAge($age) {
    $this->_age = $age;
  }

  public function getAge() {
    return $this->_age;
  }

  public function setMotherAge($age) {
    $this->_motherAge = $age;
  }

  public function getMotherAge() {
    return $this->_motherAge;
  }

  public function setMotherPregnantAge($v) {
    $this->_motherPregnantAge=$v;
  }

  public function getMotherPregnantAge() {
    return $this->_motherPregnantAge;
  }

  public function setGender($gender) {
    $this->_gender = $gender;
  }

  public function getGender() {
    return $this->_gender;
  }

  public function getWeight() {
    return $this->_weight;
  }

  public function getHeight() {
    return $this->_height;
  }

  public function setMotherId($motherId) {
    $this->_motherId = $motherId;
  }

  public function setMotherIsMarried($v) {
    return $this->_motherIsMarried = $v;
  }

  public function getMotherIsMarried() {
    return $this->_motherIsMarried;
  }


  public function getMotherId() {
    return $this->_motherId;
  }

  public function setFatherId($fatherId) {
    $this->_fatherId = $fatherId;
  }

  public function getFatherId() {
    return $this->_fatherId;
  }

  public function setIsInRelationShip($v) {
    return $this->_inRelationShip = $v;
  }

  public function getIsInRelationShip() {
    return $this->_inRelationShip;
  }

  public function setIsMarried($v) {
    return $this->_married = $v;
  }

  public function getIsMarried() {
    return $this->_married;
  }

  public function setAddress($type, $objAddress) {
    $this->_address[$type]=$objAddress;
  }

  public function getAddress($type) {
    return $this->_address[$type];
  }

  public function setSiblingsId($v) {
    if(!in_array($v, $this->_siblingsId) and $v!=$this->getId()) {
      return $this->_siblingsId[]=$v;
    }
  }

  public function getSiblingsId() {
    return $this->_siblingsId;
  }

  public function getJob() {
    return $this->_job;
  }

  public function getPersonalEmail() {
    return $this->_personalEmail;
  }

  public function getMobilPhone() {
    return $this->_mobilPhone;
  }

  public function checkAndCompletePerson() {
    if(is_null($this->_gender)) $this->_gender = GENDERS[array_rand(GENDERS)];
    if(is_null($this->_birthdate)) $this->_getRandomBirthdate();
    if(is_null($this->_birthname)) $this->_birthname = $this->_getRandomName();
    if(is_null($this->_firstname)) $this->_firstname = $this->_getRandomFirstname();

    if(!isset($this->_address['personal'])) {
      $personalAddress = new Address($this->getId());
      $this->setAddress('personal', $personalAddress->getRandomAddress());
    }

    if(is_null($this->_inRelationShip)) $this->_inRelationShip = $this->_getRandomIsInRelationShip();

    if($this->_inRelationShip) {
        if(is_null($this->_married)) {
          $this->_married = $this->_getRandomIsMarried();
        }
        if($this->_married and $this->_gender == 'f' and is_null($this->_lastname)) {
          $this->_lastname = $this->_getRandomName();
        }
        if(is_null($this->getPartnerId()) and !is_null($this->_birthname)) {
          $this->setPartnerId($this->_addPartner(), 'checkAndCompletePerson');
        }
    }

    if(is_null($this->getMotherId())) {
      $this->_addMother();
    }
    if(is_null($this->getFatherId())) {
      $this->_addFather();
    }

    if(empty($this->getSiblingsId())) {
      $this->_addSiblings();
    }

    if($this->getAge() >= MINAGEPREGNANCY and empty($this->getChildId()) and $this->_noChildren != true) {
      if(!$this->_addChildren()) {
        $this->_noChildren=true;
      }
    }

    if($this->getAge() >= 20 ) {
      $this->_getRandomAdultHeightWeight();
    }

    if(is_null($this->_job)) {
      $this->_job = $this->_getRandomJob();
    }
    if(is_null($this->_mobilPhone) and $this->getAge() >= AGEFORPERSONALMOBILPHONE ) {
      $this->_mobilPhone = $this->_getRandomMobilPhone();
    }

    if($this->getAge() >= AGEFORPERSONALEMAIL ) {
      $this->_personalEmail = $this->_buildPersonalEmail();
    }

    $this->_writePersonData($this->_id, $this);
  }

  private function _addChildren() {

     if($GLOBALS['incrementalId']+1 > NUMBEROFPEOPLE) return false;

     $children = yaml_parse_file('data/childrenByFamily.yml');
     $numberOfChildren = $this->_getRandomWeightedElement($children);
     if($numberOfChildren === 0) return false;

     $agesPregnant = array_map(function($el) { return $el * 100; }, yaml_parse_file('data/probAgePregnant.yml'));
     $pregnantAt=[];
     for($i=1; $i<=$numberOfChildren; $i++) {
       $randAge = $this->_getRandomWeightedElement($agesPregnant);
       if($randAge < $this->getAge()) {
         $pregnantAt[$i]=$randAge;
         unset($agesPregnant[$randAge],$agesPregnant[($randAge+1)], $agesPregnant[($randAge-1)]);
       }
     }
     if(count($pregnantAt) === 0) return false;
     $usedFirstnames=[];
     foreach($pregnantAt as $pregA) {

       $child = new Person();
       $child->setGender($child->_getRandomGender());
       if(!in_array($child->getGender(), GENDERS)) continue;

       $child->setId($GLOBALS['incrementalId']+1);

       $min = strtotime(($this->getAge() - $pregA)." years 365 days ago");
       $max = strtotime(($this->getAge() - $pregA)." years ago");
       $rand_time = mt_rand($min, $max);
       $child->setBirthdate(date('Y-m-d', $rand_time));
       $child->setAge(self::getAgeFromBirthdate($child->getBirthdate()));
       if($child->getAge() < MINAGE or $child->getAge() > MAXAGE) continue;

       if($this->getGender() == 'f' and !empty($this->getLastname())) {
         $child->setBirthname($this->getLastname());
       } else {
         $child->setBirthname($this->getBirthname());
       }
       $child->setFirstname($child->_getRandomFirstname($usedFirstnames));
       $usedFirstnames[]=$child->getFirstname();

       $child->setMotherId($this->getId());
       $child->setMotherAge($this->getAge());
       $child->setMotherPregnantAge($pregA);
       if(is_numeric($this->getPartnerId())) {
         $child->setFatherId($this->getPartnerId());
       } else {
         $child->setFatherId(false);
       }

       if($child->getAge() >= AGEFORPERSONALADDRESS) {
         $childAddress = new Address($child->getId());
         $childAddress = $childAddress->getRandomAddress();
         $child->setAddress('personal', $childAddress);
         $child->setAddress('mother', $this->getAddress('personal'));
       } else {
         $child->setAddress('personal', $this->getAddress('personal'));
         $child->setAddress('mother', $this->getAddress('personal'));
       }

       $this->setChildId($child->getId());
       $child->addChildTo($child->getId(), $child->getFatherId());

       $child->_writePersonData($child->getId(), $child);

     }

     foreach($this->_childId as $v) {
       foreach($this->_childId as $v2) {
         if($v != $v2 and $v > 0 and $v2 > 0) $this->addToSiblings($v, $v2);
       }
     }
     return true;

  }


  private function _addSiblings() {
     if($GLOBALS['incrementalId']+1 > NUMBEROFPEOPLE) return;

     $children = yaml_parse_file('data/childrenByFamily.yml');
     unset($children[0]);
     $numberOfChildren = $this->_getRandomWeightedElement($children);
     if($numberOfChildren === 1) return;

     $agesPregnant = array_map(function($el) { return $el * 100; }, yaml_parse_file('data/probAgePregnant.yml'));

     if(isset($agesPregnant[$this->_motherPregnantAge])) {
       unset($agesPregnant[$this->_motherPregnantAge],$agesPregnant[($this->_motherPregnantAge+1)], $agesPregnant[($this->_motherPregnantAge-1)]);
     }
     foreach($agesPregnant as $k=>$v) {
       if($k >= $this->_motherAge) unset($agesPregnant[$k]);
     }
     $pregnantAt=[];
     for($i=1; $i<=$numberOfChildren; $i++) {
       if(!empty($agesPregnant)) {
         $pregnantAt[$i]=$this->_getRandomWeightedElement($agesPregnant);
         unset($agesPregnant[$pregnantAt[$i]],$agesPregnant[($pregnantAt[$i]+1)], $agesPregnant[($pregnantAt[$i]-1)]);
       }
     }
     $usedFirstnames=[];
     foreach($pregnantAt as $pregA) {

       $child = new Person();

       $child->setGender($child->_getRandomGender());
       if(!in_array($child->getGender(), GENDERS)) continue;

       $min = strtotime(($this->getMotherAge() - $pregA)." years 365 days ago");
       $max = strtotime(($this->getMotherAge() - $pregA)." years ago");
       $rand_time = mt_rand($min, $max);
       $child->setBirthdate(date('Y-m-d', $rand_time));
       $child->setAge(self::getAgeFromBirthdate($child->getBirthdate()));
       if($child->getAge() < MINAGE or $child->getAge() > MAXAGE) continue;

       $child->setId($GLOBALS['incrementalId']+1);
       $child->setBirthname($this->getBirthname());
       $child->setFirstname($child->_getRandomFirstname($usedFirstnames));
       $usedFirstnames[]=$child->getFirstname();

       $child->setMotherId($this->getMotherId());
       $child->setMotherPregnantAge($pregA);
       $child->setFatherId($this->getFatherId());

       if($child->getAge() >= AGEFORPERSONALADDRESS) {
         $childAddress = new Address($child->getId());
         $childAddress = $childAddress->getRandomAddress();
         $child->setAddress('personal', $childAddress);
         $child->setAddress('mother', $this->getAddress('mother'));
       } else {
         $child->setAddress('personal', $this->getAddress('mother'));
         $child->setAddress('mother', $this->getAddress('mother'));
       }

       $child->addChildTo($child->getId(), $this->getMotherId());
       $child->addChildTo($child->getId(), $this->getFatherId());

       if(!in_array($child->getId(), $this->getSiblingsId())) $this->setSiblingsId($child->getId());

       $child->_writePersonData($child->getId(), $child);

     }

     foreach(array_merge($this->getSiblingsId(), (array)$this->_id) as $v) {
       foreach(array_merge($this->getSiblingsId(), (array)$this->_id) as $v2) {
         if($v != $v2 and $v > 0 and $v2 > 0) $this->addToSiblings($v, $v2);
       }
     }

  }

  private function _addMother() {
     if($GLOBALS['incrementalId']+1 > NUMBEROFPEOPLE) return;

     $mother = new Person();

     $agesPregnant = array_map(function($el) { return $el * 100; }, yaml_parse_file('data/probAgePregnant.yml'));
     $this->setMotherPregnantAge($this->_getRandomWeightedElement($agesPregnant));
     $min = strtotime(($this->_age + $this->_motherPregnantAge)." years 365 days ago");
     $max = strtotime(($this->_age + $this->_motherPregnantAge)." years ago");
     $rand_time = mt_rand($min, $max);
     $mother->setBirthdate(date('Y-m-d', $rand_time));

     $mother->setAge(self::getAgeFromBirthdate($mother->getBirthdate()));
     $this->setMotherAge($mother->getAge());

     $mother->setIsMarried($this->_getRandomIsMarried());
     $this->setMotherIsMarried($mother->getIsMarried());

     if($this->_age >= AGEFORPERSONALADDRESS) {
       $motherAddress = new Address($GLOBALS['incrementalId']+1);
       $motherAddress = $motherAddress->getRandomAddress();
       $mother->setAddress('personal', $motherAddress);
       $this->setAddress('mother', $motherAddress);
     } else {
       $mother->setAddress('personal', $this->getAddress('personal'));
       $this->setAddress('mother', $this->getAddress('personal'));
     }

     if($mother->getAge() <= MAXAGE and in_array('f', GENDERS) ) {

       $this->setMotherId($GLOBALS['incrementalId']+1);
       $mother->setId($this->getMotherId());
       $mother->setChildId($this->getId());
       $mother->setGender('f');
       $mother->setIsInRelationShip(true);
       if($mother->getIsMarried()) {
         $mother->setLastname($this->_birthname);
       }
       $mother->setBirthname($mother->_getRandomName());
       $mother->setFirstname($mother->_getRandomFirstname());

       $mother->_writePersonData($mother->getId(), $mother);

     }
  }

  private function _addFather() {
    if($GLOBALS['incrementalId']+1 > NUMBEROFPEOPLE) return;

    if(!is_null($this->getMotherAge())) {

      $father = new Person();
      $father->setAge($this->getMotherAge() + rand(-5,5));
      $father->setIsInRelationShip(true);
      $father->setIsMarried($this->getMotherIsMarried());

      $min = strtotime($father->getAge()." years 365 days ago");
      $max = strtotime($father->getAge()." years ago");
      $rand_time = mt_rand($min, $max);
      $father->setBirthdate(date('Y-m-d', $rand_time));

      if($father->getAge() < MAXAGE and in_array('m', GENDERS) ) {
        $father->setId($GLOBALS['incrementalId']+1);
        $this->setFatherId($father->getId());

        $father->setAddress('personal', $this->getAddress('mother'));

        $father->setChildId($this->getId());
        if($this->getMotherId()) {
          $father->setPartnerId($this->getMotherId(), '_addFather', $this);
          $father->addPartnerReciprocity($father->getId(), $this->getMotherId());
        }
        $father->setBirthname($this->getBirthname());
        $father->setGender('m');
        $father->setFirstname($father->_getRandomFirstname());
        $father->_writePersonData($father->getId(), $father);
      }
    }
  }

  private function _addPartner() {
    if($GLOBALS['incrementalId']+1 > NUMBEROFPEOPLE) return false;

    $partner = new Person();

    if($this->getGender()=='f') {
      $partner->setGender('m');
    } else {
      $partner->setGender('f');
    }
    if(!in_array($partner->getGender(), GENDERS)) return false;

    $partner->setId($GLOBALS['incrementalId']+1);
    if($partner->getGender()=='m') {
      if($this->getIsMarried()) {
        $partner->setBirthname($this->getLastname());
      } else {
        $partner->setBirthname($partner->_getRandomName());
      }
    } else {
      if($this->getIsMarried()) $partner->setLastname($this->getBirthname());
      $partner->setBirthname($partner->_getRandomName());
    }
    $min = strtotime(($this->getAge()+5)." years ago");
    $max = strtotime(($this->getAge()-5)." years ago");
    $rand_time = mt_rand($min, $max);
    $partner->setBirthdate(date('Y-m-d', $rand_time));
    $partner->getAgeFromBirthdate($partner->getBirthdate());
    if($partner->getAge() < MINAGE or $partner->getAge() > MAXAGE) return false;

    $partner->setFirstname($partner->_getRandomFirstname());
    $partner->setIsInRelationShip(true);
    $partner->setPartnerId($this->getId(), '_addPartener');
    $partner->setIsMarried($this->getIsMarried());
    $partner->setAddress('personal', $this->getAddress('personal'));
    $partner->_writePersonData($partner->getId(), $partner);

    return $partner->getId();
  }

  public function addPartnerReciprocity($from, $to) {
    if(is_file('population/'.$to.'.obj')) {
      $obj = unserialize(file_get_contents('population/'.$to.'.obj'));
      $obj->setPartnerId($from, 'addPartnerReciprocity');
      $obj->_writePersonData($to, $obj);
    }
  }

  public function addChildTo($child, $to) {
    if(is_file('population/'.$to.'.obj')) {
      $partner = unserialize(file_get_contents('population/'.$to.'.obj'));
      if(!in_array($child, $partner->_childId)) {
            $partner->_childId[]=$child;
      }
      $partner->_writePersonData($to, $partner);
    }
  }

  public function addToSiblings($child, $to) {
    if($child == $to) return;
    if(is_file('population/'.$to.'.obj')) {
      $siblings = unserialize(file_get_contents('population/'.$to.'.obj'));
      if(!in_array($child, $siblings->_siblingsId)) {
            $siblings->_siblingsId[]=$child;
      }
      $siblings->_writePersonData($to, $siblings);
    }
  }

  private function _buildPersonalEmail() {
    $email = str_replace(" ", '-', $this->getFirstname()).'.'.str_replace([" ", "'"], '-', $this->getBirthname()).'@mail.com';
    $email = self::stripAccents(strtolower($email));
    return $email;
  }

  private function _writePersonData($id, $obj) {
    if(!is_numeric($id)) throw new Exception('id non num');

    if(!is_file('population/'.$id.'.obj')) {
      $GLOBALS['incrementalId']++;
      $action = "NEW:\t";
    } else {
      $action = "UP: \t";
    }

    file_put_contents('population/'.$id.'.obj', serialize($obj));
  }

  private function _getRandomName() {
    $names = yaml_parse_file('data/name.yml');
    return $this->_getRandomWeightedElement($names);
  }

  private function _getRandomFirstname($used=[]) {
    $datetime = new DateTime($this->_birthdate);
    $y = $datetime->format('Y');
    $decade = floor($y/10) * 10;
    $firstnames = yaml_parse_file('data/firstname-'.$this->_gender.'.yml')[$decade];
    $firstname = $this->_getRandomWeightedElement($firstnames);
    while(in_array($firstname, $used)) {
      $firstname = $this->_getRandomWeightedElement($firstnames);
    }
    return mb_convert_case($firstname, MB_CASE_TITLE);
  }

  private function _getRandomGender() {
    $genders=['f','m'];
    return $genders[array_rand($genders)];
  }

  private function _getRandomBirthdate() {
    $data = yaml_parse_file('data/numberOfPeoplePerAge.yml');
    foreach($data as $k=>$v) {
      if($k < NEWPERSONMINAGE or $k > NEWPERSONMAXAGE) unset($data[$k]);
    }
    $this->setAge($this->_getRandomWeightedElement($data));

    $min = strtotime(($this->getAge())." years 365 days ago");
    $max = strtotime($this->getAge()." years ago");
    $rand_time = mt_rand($min, $max);
    $this->setBirthdate(date('Y-m-d', $rand_time));
  }

  private function _getRandomIsInRelationShip() {
    $data = yaml_parse_file('data/peopleInRelationship.yml');
    $decade = floor($this->getAge() / 10 ) * 10;
    if(!isset($data[$decade])) {
      $percents = 100;
    } else {
      $percents = $data[$decade];
    }
    return (bool)$this->_getRandomWeightedElement([0=>(100-$percents), 1=>$percents]);
  }

  private function _getRandomIsMarried() {
    $data = yaml_parse_file('data/marriedCouples.yml');
    $decade = floor($this->getAge() / 10 ) * 10;
    if(!isset($data[$decade])) {
      $percents = 100;
    } else {
      $percents = $data[$decade];
    }
    return (bool)$this->_getRandomWeightedElement([0=>(100-$percents), 1=>$percents]);
  }

  private function _getRandomJob() {
    if ($this->_age < AGEFORJOB) return '';

    $jobs = yaml_parse_file('data/jobs-' . $this->_gender . '.yml');

    // Check if $jobs is an array
    if (!is_array($jobs)) {
        // Handle the error, e.g., log it or return a default value
        return ''; // or throw an exception
    }

    return $jobs[array_rand($jobs)];
}


  private function _getRandomMobilPhone() {
    if(METHODFORMOBILPHONE == 'list') {
      if($this->_age < AGEFORPERSONALMOBILPHONE) return '';
      $mobilPhone = yaml_parse_file('data/mobilPhone.yml');
      return $mobilPhone[array_rand($mobilPhone)];
    } else {
      $id=str_pad($this->getId(),6,'0',STR_PAD_LEFT);
      $phone=array(
        '0'=>MOBILPHONEPREFIX,
        '1'=>rand(10,99),
        '2'=>($this->getId() < 10000)?(rand(10,99)):(substr($id, 0, 2)),
        '3'=>($this->getId() < 100)?(rand(10,99)):(substr($id, 2, 2)),
        '4'=>substr($id, 4, 2),
      );
      return implode(' ', $phone);
    }
  }



  private function _getRandomAdultHeightWeight() {
    $data = yaml_parse_file('data/height-weight-'.$this->getGender().'.yml');
    $randomHeight = array_rand($data);
    $this->_height = $randomHeight + rand(0,4);
    $this->_weight = $data[$randomHeight] + rand(-10,10);
  }

/**
 * Thanks to Brad for this function ! <https://stackoverflow.com/a/11872928>
 *
 * getRandomWeightedElement()
 * Utility function for getting random values with weighting.
 * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
 * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
 * The return value is the array key, A, B, or C in this case.  Note that the values assigned
 * do not have to be percentages.  The values are simply relative to each other.  If one value
 * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
 * chance of being selected.  Also note that weights should be integers.
 *
 * @param array $weightedValues
 */
  private function _getRandomWeightedElement(array $weightedValues) {
    $rand = mt_rand(1, (int) array_sum($weightedValues));
    foreach ($weightedValues as $key => $value) {
      $rand -= $value;
      if ($rand <= 0) {
        return $key;
      }
    }
  }

  public static function getAgeFromBirthdate($birthdate) {
    $from = new DateTime($birthdate);
    $to   = new DateTime('today');
    return $from->diff($to)->y;
  }


  public static function stripAccents($texte) {
  	$texte = str_replace(
  		array(
  			'à', 'â', 'ä', 'á', 'ã', 'å',
  			'î', 'ï', 'ì', 'í',
  			'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
  			'ù', 'û', 'ü', 'ú',
  			'é', 'è', 'ê', 'ë',
  			'ç', 'ÿ', 'ñ',
  			'À', 'Â', 'Ä', 'Á', 'Ã', 'Å',
  			'Î', 'Ï', 'Ì', 'Í',
  			'Ô', 'Ö', 'Ò', 'Ó', 'Õ', 'Ø',
  			'Ù', 'Û', 'Ü', 'Ú',
  			'É', 'È', 'Ê', 'Ë',
  			'Ç', 'Ÿ', 'Ñ',
  			'œ', 'Œ'
  		),
  		array(
  			'a', 'a', 'a', 'a', 'a', 'a',
  			'i', 'i', 'i', 'i',
  			'o', 'o', 'o', 'o', 'o', 'o',
  			'u', 'u', 'u', 'u',
  			'e', 'e', 'e', 'e',
  			'c', 'y', 'n',
  			'A', 'A', 'A', 'A', 'A', 'A',
  			'I', 'I', 'I', 'I',
  			'O', 'O', 'O', 'O', 'O', 'O',
  			'U', 'U', 'U', 'U',
  			'E', 'E', 'E', 'E',
  			'C', 'Y', 'N',
  			'oe', 'OE'
  		), $texte);
  	return $texte;
  }

}
