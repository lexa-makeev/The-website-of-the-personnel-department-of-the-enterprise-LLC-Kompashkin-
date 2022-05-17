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
				return null;
			}
		}

		
		/**
		 * Функция: get_info_from_anketa
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Возвращает информацио о пользователе в анкете по id
		 */
		public function get_info_from_anketa($id)
		{
            $param = [ "id" => $id ];
            $result_array = [];
            $result = $this->query("SELECT * FROM anketa WHERE id_anketa = :id LIMIT 1", $param);
            if ($result) {
				$result[0]["pol"] = $result[0]["pol"] == "0" ? "Женский" : "Мужской";
                return $result[0];
            }
            else {
                return null;
            }
		}

		/**
		 * Функция: get_info_change_anketa
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Возвращает информацио о пользователе в анкете по id
		 */
		public function get_info_change_anketa($id)
		{
            $param = [ "id" => $id ];
            $result_array = [];
            $result = $this->query("SELECT * FROM anketa WHERE id_anketa = :id LIMIT 1", $param);
            if ($result) {
                return $result[0];
            }
            else {
                return null;
            }
		}

		/**
		 * Функция: get_info_sotr
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Возвращает информацио о пользователе по id
		 */
		public function get_info_sotr($id)
		{
            $param = [ "id" => $id ];
			$result = $this->query("SELECT lich_delo.id_lichdelo, anketa.fam, anketa.name, anketa.otch, anketa.date_birthday,
				anketa.pol, anketa.mesto_rojdenia, anketa.grajdanstvo, anketa.obrazovanie, anketa.telephone,
				anketa.resume, posts.name_post, posts.cash FROM anketa 
				JOIN posts ON anketa.id_post = posts.id_post
				JOIN sotr ON sotr.id_anketa = anketa.id_anketa 
				JOIN lich_delo ON lich_delo.id_sotr = sotr.id_sotr
				WHERE sotr.id_sotr = :id", $param);
            if ($result[0]) {
				$result[0]["pol"] = $result[0]["pol"] == 1 ? "Мужской" : "Женский";
				return $result[0];
			}
			return null;
		}

		/**
		 * Функция: sort_all_sotr
		 * Входные параметры: pole - поля: фамилии, имени, отчеству, дате рождения, должности, зарплате, sort - сортировка: по возрастанию, по убыванию
		 * Краткое описание: Сортирует по фамилии, имени, отчеству, дате рождения, должности, зарплате
		 */
		public function sort_all_sotr($pole, $sort)
		{
			$params = [ 
				"pole" => $pole,
				"sort" => $sort
			];
			$result = $this->query("SELECT sotr.id_sotr, anketa.fam, anketa.name, anketa.otch, anketa.date_birthday,
			 posts.name_post, posts.cash FROM sotr JOIN posts ON sotr.id_post = posts.id_post 
			 JOIN anketa ON sotr.id_anketa = anketa.id_anketa ORDER BY :pole :sort", $params);
			if ($result) {
				return $result;
			}
            return null;
		}

		/**
		 * Функция: get_all_sotr
		 * Входные параметры: 
		 * Краткое описание: Возвращает информацио о сотрудниках
		 */
		public function get_all_sotr()
		{
			$result = $this->query("SELECT sotr.id_sotr, anketa.fam, anketa.name, anketa.otch, anketa.date_birthday,
			 posts.name_post, posts.cash FROM sotr JOIN posts ON sotr.id_post = posts.id_post 
			 JOIN anketa ON sotr.id_anketa = anketa.id_anketa");
			if ($result) {
				return $result;
			}
            return null;
		}

		/**
		 * Функция: get_id_new_ankets
		 * Входные параметры: 
		 * Краткое описание: Возвращает id новой анкеты
		 */
		public function get_id_new_ankets()
		{
            $result_array = [];
			$result = $this->query("SELECT id_anketa FROM anketa WHERE status = 'На рассмотрении'");
            foreach ($result as $key => $value) {
                array_push($result_array, $value["id_anketa"]);
            }
            return $result_array;
		}

		/**
		 * Функция: get_all_ankets
		 * Входные параметры: 
		 * Краткое описание: Возвращает все анкеты
		 */
		public function get_all_ankets()
		{
			$result = $this->query("SELECT id_anketa, status FROM anketa");
			if ($result) {
				return $result;
			}
            return null;
		}

		/**
		 * Функция: get_active_vacans
		 * Входные параметры: 
		 * Краткое описание: Возвращает открытые вакансии
		 */
		public function get_active_vacans()
		{
			$result = $this->query("SELECT id_post, name_post FROM posts WHERE active = 1");
            return $result;
		}

		/**
		 * Функция: get_all_vacans
		 * Входные параметры: 
		 * Краткое описание: Возвращает информацио о всех вакансиях
		 */
		public function get_all_vacans()
		{
			$result = $this->query("SELECT id_post, name_post, active FROM posts");
			if ($result) {
				return $result;
			}
			return null;
		}

		/**
		 * Функция: get_name_vacans
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Возвращает названия вакансий
		 */
		public function get_name_vacans($id)
		{
            $param = [ "id" => $id ];
			$result = $this->query("SELECT name_post FROM posts WHERE id_post = :id LIMIT 1", $param);
            if ($result[0]["name_post"]) {
                return $result[0]["name_post"];
            }
            else {
                return null;
            }
		}

		/**
		 * Функция: get_name_post
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Возвращает название должности
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
		 * Функция: change_active
		 * Входные параметры: id - номер пользователя, active - активная должность
		 * Краткое описание: Обновляет поле active
		 */
		public function change_active($id, $active)
		{
			$active = $active == 1 ? 0 : 1;
			$param = [ 
				"id" => $id, 
				"active" =>$active 
			];
			$result = $this->query_update("UPDATE posts SET active=:active WHERE id_post = :id;", $param);
			return $result;
		}

		/**
		 * Функция: change_anketa
		 * Входные параметры: params - информация заполненная в анкете
		 * Краткое описание: обновлет информацию в анкете
		 */
		public function change_anketa($params = [])
		{
			$result = $this->query_update("UPDATE anketa SET fam = :fam,name=:name,
            otch = :otch,date_birthday = :date_birthday,pol = :pol,
            grajdanstvo = :grajdanstvo,obrazovanie = :obrazovanie,telephone = :telephone,
            id_post = :id_post,resume = :resume WHERE id_anketa= :id_anketa", $params);
            return $result;
		}

		/**
		 * Функция: cancel_anketa
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Отклоняет анкету по id
		 */
		public function cancel_anketa($id)
		{
			$params = [ "id" => $id ];
			$result = $this->query_update("UPDATE anketa SET status = 'Отклонена' WHERE id_anketa = :id", $params);
            return $result;
		}

		/**
		 * Функция: odobr_anketa
		 * Входные параметры: id - номер пользователя
		 * Краткое описание: Одобряет анкету по id
		 */
		public function odobr_anketa($id)
		{
			$params = [ "id" => $id ];
			$result = $this->query_update("UPDATE anketa SET status = 'Одобрена' WHERE id_anketa = :id", $params);
            return $result;
		}

		/**
		 * Функция: check_login
		 * Входные параметры: login - логин пользователя
		 * Краткое описание: Проверяет логин пользователя на корректность
		 */
		public function check_login($login)
		{
			$param = [ "login" => $login ];
			$result = $this->query("SELECT users.id_user, users.pass FROM users JOIN posts ON posts.id_post = users.id_post 
			WHERE login = :login AND posts.id_post = 2", $param);
			return $result[0]; 
		}
	}

?>