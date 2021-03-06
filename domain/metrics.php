<?php namespace domain;

/**
* @Entity(repositoryClass="\domain\repositories\metrics")
* @Table(name="metrics")
*/
class metrics {

  /**
  * @Id
  * @Column(name="id", type="string")
  */
  private $id;

  /**
  * @Column(name="address", type="string")
  */
  private $address;

  /**
  * @Column(name="metrics", type="string")
  */
  private $metrics;
  /**
   * @Column(name="date", type="bigint")
   * @var
   */
  private $time;
  /**
   * @Column(name="status", type="string")
   * @var
   */
  private $status;

  /**
   * @return mixed
   */
  public function get_status()
  {
    return $this->status;
  }

  /**
   * @param mixed $status
   */
  public function set_status($status)
  {
    $this->status = $status;
  }
  /**
   * @return mixed
   */
  public function get_time()
  {
    return $this->time;
  }

  /**
   * @param mixed $time
   */
  public function set_time($time)
  {
    $this->time = $time;
  }
  /**
   * @param mixed $address
   */
  public function set_address($address)
  {
    $this->address = $address;
  }

  /**
   * @return mixed
   */
  public function get_address()
  {
    return $this->address;
  }

  /**
   * @param mixed $id
   */
  public function set_id($id)
  {
    $this->id = $id;
  }

  /**
   * @return mixed
   */
  public function get_id()
  {
    return $this->id;
  }

  /**
   * @param mixed $metrics
   */
  public function set_metrics($metrics)
  {
    $this->metrics = $metrics;
  }

  /**
   * @return mixed
   */
  public function get_metrics()
  {
    return $this->metrics;
  }
}