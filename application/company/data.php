<?php
class data_company{

	private $id;
  private $name;
	private $status;

  private static $statuses = ['true', 'false'];

  public function get_id(){
    return $this->id;
  }

  public function get_name(){
    return $this->name;
  }

  public function get_status(){
    return $this->status;
  }

  public function set_id($id){
    if($id > 255 OR $id < 1)
      throw new DomainException('Идентификатор компании задан не верно.');
    $this->id = $id;
  }

  public function set_name($name){
    if(!preg_match('/^[А-Я][а-я]{0,19}$/', $name))
      throw new DomainException('Название компании задано не верно.');
    $this->name = $name;
  }

  public function set_status($status){
    if(!in_array($status, self::$statuses))
      throw new DomainException('Статус компании задан не верно.');
    $this->status = $status;
  }
}