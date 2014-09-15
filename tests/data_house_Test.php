<?php

class data_house_Test extends PHPUnit_Framework_TestCase{

  public function setUp(){
    $this->house = new data_house();
  }

  public function test_set_id_1(){
    $this->house->set_id(125);
    $this->assertEquals(125, $this->house->get_id());
  }

  public function test_set_id_2(){
    $this->setExpectedException('DomainException');
    $this->house->set_id(0);
  }

  public function test_set_id_3(){
    $this->setExpectedException('DomainException');
    $this->house->set_id(65536);
  }

  public function test_set_id_4(){
    $this->setExpectedException('DomainException');
    $this->house->set_id(-125);
  }

  public function test_set_number_1(){
    $this->house->set_number('1А');
    $this->assertEquals('1А', $this->house->get_number());
    $this->house->set_number('1/А');
    $this->assertEquals('1/А', $this->house->get_number());
    $this->house->set_number('1/1');
    $this->assertEquals('1/1', $this->house->get_number());
  }

  public function test_set_number_2(){
    $this->setExpectedException('DomainException');
    $this->house->set_number('Первый');
  }

  public function test_set_status_1(){
    $this->house->set_status('true');
    $this->assertEquals('true', $this->house->get_status());
    $this->house->set_status('false');
    $this->assertEquals('false', $this->house->get_status());
  }

  public function test_set_status_2(){
    $this->setExpectedException('DomainException');
    $this->house->set_status('truefalse');
  }

  public function test_set_city(){
    $city = new data_city();
    $this->house->set_city($city);
    $this->assertSame($city, $this->house->get_city());
  }

  public function test_set_department(){
    $department = new data_department();
    $this->house->set_department($department);
    $this->assertSame($department, $this->house->get_department());
  }

  public function test_set_street(){
    $street = new data_street();
    $this->house->set_street($street);
    $this->assertSame($street, $this->house->get_street());
  }

  public function test_add_number_1(){
    $number = new data_number();
    $this->house->add_number($number);
    $numbers = $this->house->get_numbers();
    $this->assertCount(1, $numbers);
    $this->assertSame($number, $numbers[0]);
  }

  public function test_add_number_2(){
    $this->setExpectedException('DomainException');
    $number = new data_number();
    $this->house->add_number($number);
    $this->house->add_number($number);
  }

  public function test_add_flat_1(){
    $flat = new data_flat();
    $this->house->add_flat($flat);
    $flats = $this->house->get_flats();
    $this->assertCount(1, $flats);
    $this->assertSame($flat, $flats[0]);
  }

  public function test_add_flat_2(){
    $this->setExpectedException('DomainException');
    $flat = new data_flat();
    $this->house->add_flat($flat);
    $this->house->add_flat($flat);
  }
}