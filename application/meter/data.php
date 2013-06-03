<?php
/*
* Связь с таблицей `meters`.
*/
final class data_meter extends data_object{
    
    public $capacity;
    // public $checktime;
    public $company_id;
    public $id;
    public $name;
    public $rates;
    public $serial;
    public $service;
    public $period;
    public $periods;
    public $date_release;
    public $date_install;
    public $date_checking;
    public $place;

    public function __construct(){
        if(empty($this->service))
            $this->service = [];
        else
            $this->service = explode(',', $this->service);

        $this->periods = (empty($this->periods))? []: explode(';', $this->periods);
    }   
}