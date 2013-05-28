<?php
class model_meter{

	/**
	* Создает новую услугу
	* @return data_service
	*/
	public static function add_service(data_company $company, data_meter $meter, data_service $service){
	    self::verify_id($meter);
	    model_company::verify_id($company);
	    model_service::verify_id($service);
	    $meters = self::get_meters($company, $meter);
	    if(count($meters) !== 1)
	        throw new e_model('Cчетчик с таким идентификатором не существует.');
	    $meter = $meters[0];
	    self::is_data_meter($meter);
	    $service = model_service::get_services($company, $service);
	    if(count($service) !== 1)
	        throw new e_model('Услуги с таким идентификатором не существует.');
	    $service = $service[0];
	    model_service::is_data_service($service);
	    if(count(self::get_services($company, $meter, $service)) > 0)
	    	throw new e_model('Такая служба уже добавлена в счетчик.');
	    $sql = new sql();
	    $sql->query("INSERT INTO `meter2service` (`company_id`, `meter_id`,
	    			`service_id`) VALUES(:company_id, :meter_id, :service_id)");
	    $sql->bind(':company_id', $company->id, PDO::PARAM_INT);
	    $sql->bind(':service_id', $service->id, PDO::PARAM_INT);
	    $sql->bind(':meter_id', $meter->id, PDO::PARAM_INT);
	    $sql->execute('Проблема при добавлении услуги в счетчик.');
	    $sql->close();
	}

	/**
	* Возвращает список счетчиков
	* @return array из data_service
	*/
	public static function get_meters(data_company $company, data_meter $meter){
	    model_company::verify_id($company);
	    $sql = new sql();
	    $sql->query("SELECT `id`, `company_id`, `name`, `capacity`, `rates`
	    	FROM `meters` WHERE `company_id` = :company_id");
	    $sql->bind(':company_id', $company->id, PDO::PARAM_INT);
	    if(!empty($meter->id)){
	        self::verify_id($meter);
	        $sql->query(" AND `id` = :id");
	        $sql->bind(':id', $meter->id, PDO::PARAM_INT);
	    }
	    if(!empty($meter->name)){
	        self::verify_name($meter);
	        $sql->query(" AND `name` = :name");
	        $sql->bind(':name', $meter->name, PDO::PARAM_STR);
	    }
	    if(!empty($meter->capacity)){
	        self::verify_capacity($meter);
	        $sql->query(" AND `capacity` = :capacity");
	        $sql->bind(':capacity', $meter->capacity, PDO::PARAM_INT);
	    }
	    if(!empty($meter->rates)){
	        self::verify_rates($meter);
	        $sql->query(" AND `rates` = :rates");
	        $sql->bind(':rates', $meter->rates, PDO::PARAM_INT);
	    }
	    $sql->query(' ORDER BY `name`');
	    return $sql->map(new data_meter(), 'Проблема при выборке счетчиков.');
	}

	/**
	* Возвращает список услуг
	* @return array из data_service
	*/
	public static function get_services(data_company $company, data_meter $meter, data_service $service){
	    model_company::verify_id($company);
	    self::verify_id($meter);
	    $sql = new sql();
	    $sql->query("SELECT `services`.`id`, `services`.`name`
	    	FROM `services`, `meter2service`
	    	WHERE `services`.`company_id` = :company_id
	    	AND `meter2service`.`company_id` = :company_id
	    	AND `meter2service`.`service_id` = `services`.`id`
	    	AND `meter2service`.`meter_id` = :meter_id");
	    $sql->bind(':company_id', $company->id, PDO::PARAM_INT);
	    $sql->bind(':meter_id', $meter->id, PDO::PARAM_INT);
	    if(!empty($service->id)){
	    	model_service::verify_id($service);
	    	$sql->query(" AND `meter2service`.`service_id` = :service_id");
	    	$sql->bind(':service_id', $service->id, PDO::PARAM_INT);
	    }
	    $sql->query(' ORDER BY `name`');
	    return $sql->map(new data_service(), 'Проблема при выборке услуг.');
	}

	/**
	* Создает новый счетчик
	* @return data_meter
	*/
	public static function create_meter(data_company $company, data_meter $meter){
	    self::verify_name($meter);
	    self::verify_capacity($meter);
	    self::verify_rates($meter);
	    model_company::verify_id($company);
	    if(count(self::get_meters($company, $meter)) > 0)
	    	throw new e_model('Такой счетчик уже существует.');
	    $meter->id = self::get_insert_id($company);
	    $meter->company_id = $company->id;
	    self::verify_id($meter);
	    self::verify_company_id($meter);
	    self::verify_name($meter);
	    self::verify_rates($meter);
	    self::verify_capacity($meter);
	    $sql = new sql();
	    $sql->query("INSERT INTO `meters` (`id`, `company_id`, `name`, `rates`, `capacity`)
	                VALUES (:id, :company_id, :name, :rates, :capacity)");
	    $sql->bind(':id', $meter->id, PDO::PARAM_INT);
	    $sql->bind(':company_id', $meter->company_id, PDO::PARAM_INT);
	    $sql->bind(':name', $meter->name, PDO::PARAM_STR);
	    $sql->bind(':rates', $meter->rates, PDO::PARAM_INT);
	    $sql->bind(':capacity', $meter->capacity, PDO::PARAM_INT);
	    $sql->execute('Проблемы при создании счетчика.');
	    $sql->close();
	    return $meter;
	}

	/**
	* Возвращает следующий для вставки идентификатор счетчика.
	* @return int
	*/
	private static function get_insert_id(data_company $company){
	    model_company::verify_id($company);
	    $sql = new sql();
	    $sql->query("SELECT MAX(`id`) as `max_id` FROM `meters`
	                WHERE `company_id` = :company_id");
	    $sql->bind(':company_id', $company->id, PDO::PARAM_INT);
	    $sql->execute('Проблема при опредении следующего meter_id.');
	    if($sql->count() !== 1)
	        throw new e_model('Проблема при опредении следующего meter_id.');
	    $id = (int) $sql->row()['max_id'] + 1;
	    $sql->close();
	    return $id;
	}

	/**
	* Исключает услугу
	* @return data_service
	*/
	public static function remove_service(data_company $company, data_meter $meter, data_service $service){
	    self::verify_id($meter);
	    model_company::verify_id($company);
	    model_service::verify_id($service);
	    $meters = self::get_meters($company, $meter);
	    if(count($meters) !== 1)
	        throw new e_model('Cчетчик с таким идентификатором не существует.');
	    $meter = $meters[0];
	    self::is_data_meter($meter);
	    $service = model_service::get_services($company, $service);
	    if(count($service) !== 1)
	        throw new e_model('Услуги с таким идентификатором не существует.');
	    $service = $service[0];
	    model_service::is_data_service($service);
	    if(count(self::get_services($company, $meter, $service)) !== 1)
	    	throw new e_model('Служба не привязана к счетчику.');
	    $sql = new sql();
	    $sql->query("DELETE FROM `meter2service` WHERE `company_id` = :company_id
	    			AND `meter_id` = :meter_id AND `service_id` = :service_id");
	    $sql->bind(':company_id', $company->id, PDO::PARAM_INT);
	    $sql->bind(':service_id', $service->id, PDO::PARAM_INT);
	    $sql->bind(':meter_id', $meter->id, PDO::PARAM_INT);
	    $sql->execute('Проблема при исключении услуги из счетчика.');
	    $sql->close();
	}

	/**
	* Создает новую услугу
	* @return data_service
	*/
	public static function rename_meter(data_company $company, data_meter $meter){
	    self::verify_id($meter);
	    self::verify_name($meter);
	    $meter_params = new data_meter();
	    $meter_params->name = $meter->name;
	    if(count(self::get_meters($company, $meter_params)) > 0)
	        throw new e_model('Счетчик с таким именем уже существует.');
	    $meter_params = new data_meter();
	    $meter_params->id = $meter->id;
	    $meters = self::get_meters($company, $meter_params);
	    if(count($meters) !== 1)
	        throw new e_model('Cчетчик с таким идентификатором не существует.');
	    $new_meter = $meters[0];
	    self::is_data_meter($new_meter);
	    $new_meter->name = $meter->name;
	    $sql = new sql();
	    $sql->query("UPDATE `meters` SET `name` = :name
	                WHERE `company_id` = :company_id AND `id` = :id");
	    $sql->bind(':id', $new_meter->id, PDO::PARAM_INT);
	    $sql->bind(':company_id', $new_meter->company_id, PDO::PARAM_INT);
	    $sql->bind(':name', $new_meter->name, PDO::PARAM_STR);
	    $sql->execute('Проблема при переименовании счетчика.');
	    $sql->close();
	    return $new_meter;
	}

	/**
	* Изменяет разрядность счетчика.
	* @return object data_meter
	*/
	public static function update_capacity(data_company $company, data_meter $meter){
	    self::verify_id($meter);
	    self::verify_capacity($meter);
	    $meter_params = new data_meter();
	    $meter_params->id = $meter->id;
	    $meters = self::get_meters($company, $meter_params);
	    if(count($meters) !== 1)
	        throw new e_model('Cчетчик с таким идентификатором не существует.');
	    $new_meter = $meters[0];
	    self::is_data_meter($new_meter);
	    $new_meter->capacity = $meter->capacity;
	    $sql = new sql();
	    $sql->query("UPDATE `meters` SET `capacity` = :capacity
	                WHERE `company_id` = :company_id AND `id` = :id");
	    $sql->bind(':id', $new_meter->id, PDO::PARAM_INT);
	    $sql->bind(':company_id', $new_meter->company_id, PDO::PARAM_INT);
	    $sql->bind(':capacity', $new_meter->capacity, PDO::PARAM_INT);
	    $sql->execute('Проблема при изменении разрядности счетчика.');
	    $sql->close();
	    return $new_meter;
	}

	/**
	* Изменяет тарифность счетчика.
	* @return object data_meter
	*/
	public static function update_rates(data_company $company, data_meter $meter){
	    self::verify_id($meter);
	    self::verify_rates($meter);
	    $meter_params = new data_meter();
	    $meter_params->id = $meter->id;
	    $meters = self::get_meters($company, $meter_params);
	    if(count($meters) !== 1)
	        throw new e_model('Cчетчик с таким идентификатором не существует.');
	    $new_meter = $meters[0];
	    self::is_data_meter($new_meter);
	    $new_meter->rates = $meter->rates;
	    $sql = new sql();
	    $sql->query("UPDATE `meters` SET `rates` = :rates
	                WHERE `company_id` = :company_id AND `id` = :id");
	    $sql->bind(':id', $new_meter->id, PDO::PARAM_INT);
	    $sql->bind(':company_id', $new_meter->company_id, PDO::PARAM_INT);
	    $sql->bind(':rates', $new_meter->rates, PDO::PARAM_INT);
	    $sql->execute('Проблема при изменении тарифности счетчика.');
	    $sql->close();
	    return $new_meter;
	}

	/**
	* Верификация идентификатора счетчика.
	*/
	public static function verify_company_id(data_meter $meter){
		if($meter->company_id < 1)
			throw new e_model('Идентификатор компании задан не верно.');
	}

	/**
	* Верификация времени поверки счетчика.
	*/
	public static function verify_chektime(data_meter $meter){
		if($meter->chektime < 0)
			throw new e_model('Время поверки счетчика задано не верно.');
	}

	/**
	* Верификация идентификатора счетчика.
	*/
	public static function verify_id(data_meter $meter){
		if($meter->id < 1)
			throw new e_model('Идентификатор счетчика задан не верно.');
	}

	/**
	* Верификация названия счетчика.
	*/
	public static function verify_name(data_meter $meter){
		if(!preg_match('/^[а-яА-Яa-zA-Z0-9 -]+$/u', $meter->name))
			throw new e_model('Название счетчика задано не верно.');
	}

	/**
	* Верификация разрядности счетчика.
	*/
	public static function verify_capacity(data_meter $meter){
		if($meter->capacity < 1 OR $meter->capacity > 9)
			throw new e_model('Разрядность задана не верно.');
	}

	/**
	* Верификация тарифности счетчика.
	*/
	public static function verify_rates(data_meter $meter){
		if($meter->rates < 1 OR $meter->rates > 3)
			throw new e_model('Тарифность задана не верно.');
	}

	/**
	* Верификация заводского номера счетчика.
	*/
	public static function verify_serial(data_meter $meter){
		if(!preg_match('/^[а-яА-Я0-9]+$/u', $meter->serial))
			throw new e_model('Заводской номер счетчика задано не верно.');
	}

	/**
	* Проверка принадлежности объекта к классу data_meter.
	*/
	public static function is_data_meter($meter){
		if(!($meter instanceof data_meter))
			throw new e_model('Возвращеный объект не является счетчиком.');
	}
}