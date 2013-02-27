<?php
set_time_limit(0);
# подключаем фреймворк
$dir = dirname(__FILE__);
define('ROOT' , substr($dir, 0, (strlen($dir) - strlen('/test'))));
require_once(ROOT."/framework/framework.php");
/*
* Создает таблицы
*/
function create_tables(){
	$stm = db::get_handler()->exec(file_get_contents(ROOT."/specifications/database_structure.sql"));
}
/*
* Создает фейковых юзеров
*/
function create_users(){
	$sql = "INSERT INTO `users` (
				`id`, `company_id`,`status`, `username`, `firstname`, `lastname`,
				`midlename`, `password`, `telephone`, `cellphone`
			) VALUES (
				1, 1, true, 'NekrasovEV', 'Евгений', 'Некрасов', 'Валерьевич', 
				'".get_password_hash('{htyfntym')."', 647957, '+7 922 294 47 42'
			);";
	$stm = db::get_handler()->prepare($sql);
	$stm->execute();
}
/*
* Стираем все таблицы в базе данных
*/
function drop_tables(){
	$stm = db::get_handler()->query('SHOW TABLES');
	$stm->setFetchMode(PDO::FETCH_NUM);
	$table_string = '';
	while($table = $stm->fetch())
		$table_string .= $table[0].', ';
	if(!empty($table_string))
		$stm = db::get_handler()->exec('DROP TABLES '.substr($table_string, 0, -2));
}
function get_password_hash($passwd){
	return md5(md5(htmlspecialchars($passwd)).application_configuration::authSalt);
}
/*
* Запуск
*/
try{
	model_environment::create_batabase_connection();
	drop_tables();
	create_tables();
	create_users();
}catch(exception $e){
	die($e->getMessage());
}