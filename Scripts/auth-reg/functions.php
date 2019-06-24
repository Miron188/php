<?
/**
  * functions.php
  * Файл с пользовательскими функциями
  */
  
// Подключаем файл с параметрами подключения к СУБД
require_once('database.php');

// Проверка имени пользователя
function checkLogin($str) {
	// Инициализируем переменную с возможным сообщением об ошибке
	$error = '';
	
	// Если отсутствует строка с логином, возвращаем сообщение об ошибке
	if(!$str) {
		$error = 'Вы не ввели имя пользователя';
		return $error;
	}
	
	/**
	  * Проверяем имя пользователя с помощью регулярных выражений
	  * Логин должен быть не короче 4, не длинне 16 символов
	  * В нем должны быть символы латинского алфавита, цифры, 
	  * в нем могут быть символы '_', '-', '.'
	  */
	$pattern = '/^[-_.a-z\d]{4,16}$/i';	
	$result = preg_match($pattern, $str);
	
	// Если проверка не прошла, возвращаем сообщение об ошибке
	if(!$result) {
		$error = 'Недопустимые символы в имени пользователя или имя пользователя слишком короткое (длинное)';
		return $error;
	}
	
	// Если же всё нормально, вернем значение true
	return true;
}

// Проверка пароля пользователя
function checkPassword($str) {
	// Инициализируем переменную с возможным сообщением об ошибке
	$error = '';
	
	// Если отсутствует строка с логином, возвращаем сообщение об ошибке
	if(!$str) {
		$error = 'Вы не ввели пароль';
		return $error;
	}
	
	/**
	  * Проверяем пароль пользователя с помощью регулярных выражений
	  * Пароль должен быть не короче 6, не длинне 16 символов
	  * В нем должны быть символы латинского алфавита, цифры, 
	  * в нем могут быть символы '_', '!', '(', ')'
	  */
	$pattern = '/^[_!)(.a-z\d]{6,16}$/i';	
	$result = preg_match($pattern, $str);
	
	// Если проверка не прошла, возвращаем сообщение об ошибке
	if(!$result) {
		$error = 'Недопустимые символы в пароле пользователя или пароль слишком короткий (длинный)';
		return $error;
	}
	
	// Если же всё нормально, вернем значение true
	return true;
}

// Функция регистрации пользователя
function registration($login, $password) {
	// Инициализируем переменную с возможным сообщением об ошибке
	$error = '';
	
	// Если отсутствует строка с логином, возвращаем сообщение об ошибке
	if(!$login) {
		$error = 'Не указан логин';
		return $error;
	} 
	elseif(!$password) {
		$error = 'Не указан пароль';
		return $error;
	}
	
	// Проверяем не зарегистрирован ли уже пользователь
	// Подключаемся к СУБД
	connect();
	
	// Пишем строку запроса
	$sql = "SELECT `id` FROM `users` WHERE `login`='" . $login . "'";
	// Делаем запрос к базе
	$query = mysql_query($sql) or die("<p>Невозможно выполнить запрос: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");
	// Смотрим на количество пользователей с таким логином, если есть хоть один,
	// возвращаем сообщение об ошибке
	if(mysql_num_rows($query) > 0) {
		$error = 'Пользователь с указанным логином уже зарегистрирован';
		return $error;
	}
	
	// Если такого пользователя нет, регистрируем его
	// Пишем строку запроса
	$sql = "INSERT INTO `users` 
			(`id`,`login`,`password`) VALUES 
			(NULL, '" . $login . "','" . $password . "')";
	// Делаем запрос к базе
	$query = mysql_query($sql) or die("<p>Невозможно добавить пользователя: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");
	
	// Не забываем отключиться от СУБД
	mysql_close();
	
	// Возвращаем значение true, сообщающее об успешной регистрации пользователя
	return true;
}

/**
  * Функция авторизации пользователя.
  * Авторизация пользователей у нас будет осуществляться
  * с помощью сессий PHP.
  */
function authorization($login, $password) {
	// Инициализируем переменную с возможным сообщением об ошибке
	$error = '';
	
	// Если отсутствует строка с логином, возвращаем сообщение об ошибке
	if(!$login) {
		$error = 'Не указан логин';
		return $error;
	} 
	elseif(!$password) {
		$error = 'Не указан пароль';
		return $error;
	}
	
	// Проверяем не зарегистрирован ли уже пользователь
	// Подключаемся к СУБД
	connect();
	
	// Нам нужно проверить, есть ли такой пользователь среди зарегистрированных
	// Составляем строку запроса
	$sql = "SELECT `id` FROM `users` WHERE `login`='".$login."' AND `password`='".$password."'";
	// Выполняем запрос
	$query = mysql_query($sql) or die("<p>Невозможно выполнить запрос: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");
	
	// Если пользователя с такими данными нет, возвращаем сообщение об ошибке
	if(mysql_num_rows($query) == 0)	{
		$error = 'Пользователь с указанными данными не зарегистрирован';
		return $error;
	}

	$sql = "SELECT `rights` FROM `users` WHERE `login`='".$login."' AND `password`='".$password."'";
	// Выполняем запрос для полуения прав
	$query = mysql_query($sql) or die("<p>Невозможно выполнить запрос: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");	
	// Если пользователя с такими данными нет, возвращаем сообщение об ошибке

	if(mysql_num_rows($query) == 0) {
		$error = 'Неверно';
		return $error;
	}
	
	
	// Если пользователь существует, запускаем сессию
	session_start();
	// И записываем в неё логин и пароль пользователя
	// Для этого мы используем суперглобальный массив $_SESSION
	$_SESSION['login'] = $login;
	$_SESSION['password'] = $password;
	$_SESSION['rights'] = mysql_result($query, 0);
	
	
	// Не забываем закрывать соединение с базой данных
	mysql_close();
	
	
	// Возвращаем true для сообщения об успешной авторизации пользователя
	return true;
}

function checkAuth($login, $password) {
	// Если нет логина или пароля, возвращаем false
	if(!$login || !$password)	return false;
	
	// Проверяем зарегистрирован ли такой пользователь
	// Подключаемся к СУБД
	connect();
	
	// Составляем строку запроса
	$sql = "SELECT `id` FROM `users` WHERE `login`='".$login."' AND `password`='".$password."'";
	// Выполняем запрос
	$query = mysql_query($sql) or die("<p>Невозможно выполнить запрос: " . mysql_error() . ". Ошибка произошла в строке " . __LINE__ . "</p>");
	
	// Если пользователя с такими данными нет, возвращаем false;
	if(mysql_num_rows($query) == 0)	{
		return false;
	}
	
	// Не забываем закрывать соединение с базой данных
	mysql_close();
	
	// Иначе возвращаем true
	return true;
}

?>