<?php
class model_auth{
	/**
	* При удачной авторизации в сессию добавляются данные о пользователе(класс data_user).
	*/
	public static function get_login(){
		$sql = "SELECT `id`, `company_id`, `status`, `username` as `login`,
				`firstname`, `lastname`, `midlename` as `middlename`,
				`password`, `telephone`, `cellphone`
				FROM `users` WHERE `username` = :login AND `password` = :hash";
		$stm = db::get_handler()->prepare($sql);
		$stm->bindValue(':login', htmlspecialchars($_POST['login']), PDO::PARAM_STR);
		$stm->bindValue(':hash', model_user::get_password_hash($_POST['password']) , PDO::PARAM_STR);
		if($stm->execute() == false)
			throw new e_model('Проблемы при авторизации.');
		if($stm->rowCount() !== 1){
			$stm->closeCursor();
			return false;
		}
		$stm->setFetchMode(PDO::FETCH_CLASS, 'data_user');
		$_SESSION['user'] = $stm->fetch();
		$stm->closeCursor();
		self::set_cockies();
		return true;
	}
	/**
	* Настройка кук
	*/
	private static function set_cockies(){
		setcookie("chat_host", application_configuration::chat_host, 0);
		setcookie("chat_port", application_configuration::chat_port, 0);
	}
}