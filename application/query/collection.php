<?php
class collection_query{

  private $company;
  private $queries = [];
  private $id = [];
  private $pointer = 0;
  private $numbers = [];
  private $q2n = [];

  public function __construct(data_company $company, array $queries){
    $this->company = $company;
    $this->company->verify('id');
    $this->queries = $queries;
    if(!empty($this->queries))
      foreach($this->queries as $query)
        $this->id[] = $query->get_id();
  }

  public function count(){
    return count($this->id);
  }

  public function get_queries(){
    foreach($this->queries as $query){
      if(!($query instanceof data_query))
        return null;
      if(!empty($this->q2n[$query->get_id()]))
        foreach($this->q2n[$query->get_id()] as $number)
          $query->add_number($this->numbers[$number]);
      yield $query;
    }
  }

  public function create_number(array $row){
    $number = new data_number();
    $number->set_id($row['number_id']);
    $number->set_number($row['number']);
    $number->set_fio($row['fio']);
    $flat = new data_flat();
    $flat->set_number($row['flat_number']);
    $number->set_flat($flat);
    return $number;
  }

  public function init_numbers(){
    if(!empty($this->id)){
      $ids = implode(', ', $this->id);
      $sql = new sql();
      $sql->query("SELECT DISTINCT `query2number`.* , `numbers`.`number`,
          `numbers`.`fio`, `flats`.`flatnumber` as `flat_number`
          FROM `query2number`, `numbers`, `flats`
          WHERE `query2number`.`company_id` = :company_id
          AND `numbers`.`company_id` = :company_id
          AND `query2number`.`query_id` IN(".$ids.")
          AND `query2number`.`number_id` = `numbers`.`id`
          AND `numbers`.`flat_id` = `flats`.`id`");
      $sql->bind(':company_id', $this->company->get_id(), PDO::PARAM_INT);
      $sql->execute('Проблемы при выборе лицевых счетов.');
      $stmt = $sql->get_stm();
      while($row = $stmt->fetch()){
        $number = $this->create_number($row);
        $this->numbers[$number->get_id()] = $number;
        $this->q2n[$row['query_id']][] = $number->get_id();
      }
    }
  }
}