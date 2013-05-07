<?php
class model_auth{
	/**
	* Возвращает пользователя для сессии data_cureent_user
	*/
	public static function auth_user(){
		$sql = new sql();
		$sql->query("SELECT `id`, `company_id`, `status`, `username` as `login`,
					`firstname`, `lastname`, `midlename` as `middlename`,
					`password`, `telephone`, `cellphone`
					FROM `users` WHERE `username` = :login AND `password` = :hash");
		$sql->bind(':login', htmlspecialchars($_POST['login']), PDO::PARAM_STR);
		$sql->bind(':hash', model_user::get_password_hash($_POST['password']) , PDO::PARAM_STR);
		$sql->execute('Проблемы при авторизации.');
		if($sql->count() !== 1){
			$sql->close();
			throw new e_model('Проблемы при авторизации.');
		}
		$users = $sql->map(new data_current_user(), 'Проблема при авторизации.');
		$sql->close();
		return $users[0];
	}
}