<?php 
	class DB
	{
		private $db;
		/**
		 * Функция: __construct
		 * Входные параметры: 
		 * Краткое описание: Аунтификация БД
		 */
		public function __construct()
		{
			$dbinfo = require 'dbinfo.php';
			$this->db = new PDO('mysql:host=' . $dbinfo['host'] . ';dbname=' . $dbinfo['dbname'], $dbinfo['login'], $dbinfo['password']);
		}

		/**
		 * Функция: query
		 * Входные параметры: sql - ссылка на БД, params - входные параметры 
		 * Краткое описание: Проход по БД
		 */
		public function query($sql, $params = [])
		{
			// Подготовка запроса
			$stmt = $this->db->prepare($sql);
			
			// Обход массива с параметрами 
			// и подставляем значения
			if ( !empty($params) ) {
				foreach ($params as $key => $value) {
					$stmt->bindValue(":$key", $value);
				}
			}
			
			// Выполняя запрос
			$stmt->execute();
			// Возвращаем ответ
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		/**
		 * Функция: query_update
		 * Входные параметры: sql - ссылка на БД, params - входные параметры 
		 * Краткое описание: Операция обновления БД по запросу
		 */
		public function query_update($sql, $params = [])
		{
			// Подготовка запроса
			$stmt = $this->db->prepare($sql);
			
			// Обход массива с параметрами 
			// и подставляем значения
			if ( !empty($params) ) {
				foreach ($params as $key => $value) {
					$stmt->bindValue(":$key", $value);
				}
			}
			
			// Выполняя запрос
			return $stmt->execute();
		}
		/**
		 * Функция: registration
		 * Входные параметры: login - логин пользователя, pass - хэшированный пароль пользователя, date - текущая дата
		 * Краткое описание: Регистрация соискателя в системе 
		 */
		public function registration($login, $pass, $date)
		{
			$login_p = [ "login" => $login ];
			$data = $this->query("SELECT * FROM users WHERE login = :login", $login_p);
            
			if (!isset($data[0]["login"])) {
				$param = [
					"login" => $login,
					"pass" => $pass,
					"date" => $date
				];
				$result = $this->query_update("INSERT INTO users (id_user, login, pass, date_reg) VALUES (NULL, :login, :pass, :date)", $param);
			}
			else {
				$result = 2;
			}
            return $result;
		}
		/**
		 * Функция: check_login
		 * Входные параметры: login - логин пользователя
		 * Краткое описание: Проверка логина пользователя
		 */
		public function check_login($login)
		{
			$login_p = [ "login" => $login ];
			$data = $this->query("SELECT * FROM users WHERE login = :login", $login_p);
            if (isset($data[0]["login"])) {
				return $data[0];
			}
			else {
				return null;
			}
		}
		/**
		 * Функция: get_name
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Возвращает имя пользователя в анкете по id
		 */
		public function get_name($id)
		{
			$param = [ "id" => $id ];
			$data = $this->query("SELECT fam, name FROM anketa WHERE id_user = :id", $param);
            if (isset($data[0]["fam"]) && isset($data[0]["name"])) {
				return $data[0]["fam"]." ".$data[0]["name"];
			}
			else {
				$data = $this->query("SELECT login FROM users WHERE id_user = :id", $param);
				if (isset($data[0]["login"])) {
					return $data[0]["login"];
				}
				else {
					return null;
				}
			}
		}
		/**
		 * Функция: check_anketa
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Возвращает имя и фамилию пользователя в анкете по id
		 */
		public function check_anketa($id)
		{
			$param = [ "id" => $id ];
			$data = $this->query("SELECT fam, name FROM anketa WHERE id_user = :id", $param);
            if (isset($data[0]["fam"]) && isset($data[0]["name"])) {
				return true;
			}
			else {
				return false;
			}
		}
		/**
		 * Функция: get_anketa
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Получение номера и статус анкеты
		 */
		public function get_anketa($id)
		{
			$param = [ "id" => $id ];
			$data = $this->query("SELECT id_anketa, status FROM anketa WHERE id_user = :id", $param);
            if (isset($data[0]["id_anketa"]) && isset($data[0]["status"])) {
				return $data[0];
			}
			else {
				return null;
			}
		}
		/**
		 * Функция: get_anketa_info
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Получения всю информацию из анкеты о пользователе
		 */
		public function get_anketa_info($id)
		{
			$param = [ "id" => $id ];
			$data = $this->query("SELECT * FROM anketa WHERE id_user = :id", $param);
            if (isset($data[0])) {
				$data[0]["pol"] = $data[0]["pol"] == "0" ? "Женский" : "Мужской";
				return $data[0];
			}
			else {
				return null;
			}
		}
		/**
		 * Функция: get_name_post
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Получения название должности
		 */
		public function get_name_post($id)
		{
			$param = [ "id" => $id ];
			$data = $this->query("SELECT name_post FROM posts WHERE id_post = :id", $param);
            if (isset($data[0]["name_post"])) {
				return $data[0]["name_post"];
			}
			else {
				return null;
			}
		}
		/**
		 * Функция: get_active_vacans
		 * Входные параметры: 
		 * Краткое описание: Получения названия активных вакансий
		 */
		public function get_active_vacans()
		{
			$result = $this->query("SELECT id_post, name_post FROM posts WHERE active = 1");
            return $result;
		}
		/**
		 * Функция: create_anketa
		 * Входные параметры: params - параметры пользователя
		 * Краткое описание: создание новой анкеты по информации пользователя
		 */
		public function create_anketa($params)
		{
			$result = $this->query_update("INSERT INTO anketa VALUES (NULL,:id_user,:fam,:name,:otch,
			:date_birthday,:pol,:mesto_rojdenia,:grajdanstvo,:obrazovanie,:telephone,:posts,:resume,'На рассмотрении')", $params);
            return $result;
		}

	}
?>