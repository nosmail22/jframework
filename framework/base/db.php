<?php

class db
{
	private $connect;

	public function __construct($params)
	{
		extract($params);
		if(!isset($dbhost,$dbname,$dbusername,$dbpasswd))
			throw new Exception("остутствуют необходимые параметры для подключения к бд");
		$db=new PDO("mysql:host={$dbhost};dbname={$dbname}",$dbusername,$dbpasswd);
		$this->connect=$db;
	}

	public function get_connect()
	{
		return $this->connect;
	}

}