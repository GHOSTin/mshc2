<?php namespace domain;

use DomainException;
use Doctrine\Common\Collections\ArrayCollection;

/**
* @Entity(repositoryClass="\domain\repositories\query")
* @Table(name="queries")
*/
class query{

	/**
  * @Id
  * @Column(name="id", type="integer")
  * @GeneratedValue
  */
	private $id;

	/**
  * @Column(name="status", type="string")
  */
	private $status;

	/**
  * @Column(name="initiator", type="string")
  */
	private $initiator;

	/**
  * @Column(name="payment_status", type="string")
  */
	private $payment_status;

	/**
  * @Column(name="warning_type", type="string")
  */
	private $warning_status;

	/**
  * @ManyToOne(targetEntity="\domain\department")
  */
	private $department;

	/**
  * @ManyToOne(targetEntity="\domain\house")
  */
	private $house;

	/**
  * @ManyToOne(targetEntity="\domain\workgroup")
  * @JoinColumn(name="query_worktype_id", referencedColumnName="id")
  */
	private $work_type;

	/**
  * @Column(name="opentime", type="string")
  */
	private $time_open;

	/**
  * @Column(name="worktime", type="string")
  */
	private $time_work;

	/**
  * @Column(name="closetime", type="string")
  */
	private $time_close;

	/**
  * @Column(type="string")
  */
	private $contact_fio;

	/**
  * @Column(type="string")
  */
	private $contact_telephone;

	/**
  * @Column(type="string")
  */
	private $contact_cellphone;

	/**
  * @Column(name="description", type="string")
  */
	private $description;

	/**
  * @Column(name="reason", type="string")
  */
	private $close_reason;

	/**
  * @Column(name="querynumber", type="string")
  */
	private $number;

	/**
   * @ManyToMany(targetEntity="\domain\number")
   * @JoinTable(name="query2number",
   * joinColumns={@JoinColumn(name="query_id", referencedColumnName="id")},
   * inverseJoinColumns={@JoinColumn(name="number_id", referencedColumnName="id")})
   */
	private $numbers;

	/**
   * @ManyToMany(targetEntity="\domain\query2work")
   * @JoinTable(name="query2work",
   * joinColumns={@JoinColumn(name="query_id", referencedColumnName="id")},
   * inverseJoinColumns={@JoinColumn(name="query_id", referencedColumnName="query_id")})
   */
	private $works;

	/**
   * @ManyToMany(targetEntity="\domain\query2user")
   * @JoinTable(name="query2user",
   * joinColumns={@JoinColumn(name="query_id", referencedColumnName="id")},
   * inverseJoinColumns={@JoinColumn(name="query_id", referencedColumnName="query_id")})
   */
	private $users;

	/**
  * @OneToMany(targetEntity="\domain\query2comment", mappedBy="query")
  */
	private $comments;

	public static $initiator_list = ['number', 'house'];
	public static $payment_status_list = ['paid', 'unpaid', 'recalculation'];
	public static $status_list = ['open', 'close', 'working', 'reopen'];
	public static $warning_status_list = ['hight', 'normal', 'planned'];

  public function __construct(){
    $this->numbers = new ArrayCollection();
    $this->comments = new ArrayCollection();
  }

	public function add_number(\domain\number $number){
    if($this->numbers->contains($number))
      throw new DomainException('Лицевой счет уже добавлен в заявку.');
		$this->numbers->add($number);
	}

	public function add_comment(\domain\query2comment $comment){
		if($this->comments->contains($comment))
			throw new DomainException('Комментарий уже существует.');
		$this->comments->add($comment);
	}

	public function add_user(\domain\query2user $user){
		$this->users->add($user);
	}

	public function add_work(\domain\query2work $work){
		if($this->works->contains($work))
			throw new DomainException("Работа уже добавлен в заявку.");
		$this->works->add($work);
	}

	public function remove_work(\domain\work $w){
		if(!empty($this->works))
			foreach($this->works as $work)
				if($work->get_id() === $w->get_id()){
					$this->works->removeElement($work);
					return $work;
				}
	}

	public function add_work_type(\domain\workgroup $wt){
		$this->work_type = $wt;
	}

	public function get_work_type(){
		return $this->work_type;
	}

	public function get_numbers(){
		return $this->numbers;
	}

	public function get_close_reason(){
		return $this->close_reason;
	}

	public function get_comments(){
		return $this->comments;
	}

	public function get_creator(){
		$creators = [];
		if(!empty($this->users))
			foreach($this->users as $user)
				if($user->get_class() === 'creator')
					$creators[] = $user;
		return $creators[0];
	}

	public function get_managers(){
		$managers = [];
		if(!empty($this->users))
			foreach($this->users as $user)
				if($user->get_class() === 'manager')
					$managers[] = $user;
		return $managers;
	}

	public function get_observers(){
		$performers = [];
		if(!empty($this->users))
			foreach($this->users as $user)
				if($user->get_class() === 'observer')
					$performers[] = $user;
		return $performers;
	}

	public function get_performers(){
		$observers = [];
		if(!empty($this->users))
			foreach($this->users as $user)
				if($user->get_class() === 'performer')
					$observers[] = $user;
		return $observers;
	}

	public function get_users(){
		return $this->users;
	}

	public function get_works(){
		return $this->works;
	}

	public function get_contact_cellphone(){
		return $this->contact_cellphone;
	}

	public function get_contact_fio(){
		return $this->contact_fio;
	}

	public function get_contact_telephone(){
		return $this->contact_telephone;
	}

	public function get_description(){
		return $this->description;
	}

	public function get_id(){
		return $this->id;
	}

	public function get_payment_status(){
		return $this->payment_status;
	}

	public function get_status(){
		return $this->status;
	}

	public function get_initiator(){
		return $this->initiator;
	}

	public function get_department(){
		return $this->department;
	}

	public function get_house(){
		return $this->house;
	}

	public function get_number(){
		return $this->number;
	}

	public function get_time_open(){
		return $this->time_open;
	}

	public function get_time_close(){
		return $this->time_close;
	}

	public function get_time_work(){
		return $this->time_work;
	}

	public function get_warning_status(){
		return $this->warning_status;
	}

	public function set_id($id){
		if($id > 4294967295 OR $id < 1)
      throw new DomainException('Идентификатор заявки задан не верно.');
		$this->id = $id;
	}

	public function set_number($number){
		if(!preg_match('/^[0-9]{1,6}$/', $number))
        throw new DomainException('Номер заявки задан не верно.');
		$this->number = (int) $number;
	}

	public function set_time_open($time){
		if($time < 1)
      throw new DomainException('Время открытия заявки задано не верно.');
		$this->time_open = $time;
	}

	public function set_close_reason($reason){
		if(!preg_match('|^[А-Яа-яёЁ0-9№"!?()/:;.,\*\-+= ]{0,65535}$|u', $reason))
      throw new DomainException('Описание заявки заданы не верно.');
		$this->close_reason = (string) $reason;
	}

	public function set_department(department $department){
		$this->department = $department;
	}

	public function set_initiator($initiator){
		if(!in_array($initiator, self::$initiator_list, true))
      throw new DomainException('Инициатор заявки задан не верно.');
		$this->initiator = $initiator;
	}

	public function set_house(\domain\house $house){
		$this->house = $house;
	}

	public function set_contact_cellphone($cellphone){
		$this->contact_cellphone = $cellphone;
	}

	public function set_contact_fio($fio){
		$this->contact_fio = $fio;
	}

	public function set_contact_telephone($telephone){
		$this->contact_telephone = $telephone;
	}

	public function set_description($description){
		if(!preg_match('|^[А-Яа-яёЁ0-9№"!?()/:;.,\*\-+= ]{0,65535}$|u', $description))
      throw new DomainException('Описание заявки заданы не верно.');
		$this->description = $description;
	}

	public function set_payment_status($status){
		if(!in_array($status, self::$payment_status_list, true))
      throw new DomainException('Статус оплаты заявки задан не верно.');
		$this->payment_status = (string) $status;
	}

	public function set_status($status){
		if(!in_array($status, self::$status_list, true))
      throw new DomainException('Статус заявки задан не верно.');
		$this->status = $status;
	}

	public function set_time_close($time){
		if(!in_array($this->status, ['open', 'working'], true)){
			if( $time < $this->time_open)
				throw new DomainException('Время закрытия заявки не может быть меньше времени открытия.');
			if($time < $this->time_work)
				throw new DomainException('Время закрытия заявки не может быть меньше времени передачи в работу.');
		}
		$this->time_close = $time;
	}

	public function set_time_work($time){
		if($this->time_open > $time)
			throw new DomainException('Время закрытия заявки не может быть меньше времени открытия.');
		$this->time_work = $time;
	}

	public function set_warning_status($status){
		if(!in_array($status, self::$warning_status_list, true))
      throw new DomainException('Статус ворнинга заявки задан не верно.');
		$this->warning_status = (string) $status;
	}
}