<?php

class jf
{
	private static $instance;

	private $config_file;
	private $config;

	public $db;

	private function __construct($config_file)
	{
		session_start();

		//подключаем конфиг
		if(is_null($config_file))
			throw new Exception('не задан config_file');
		if(!is_file($config_file))
			throw new Exception('отсутствует файл '.$config_file);
		$this->config_file=$config_file;
		$this->config=require_once $config_file;

		//автоподгрузка классов
		spl_autoload_register(function ($class)
		{
			$class_file=dirname(__FILE__).DIRECTORY_SEPARATOR.'base'.DIRECTORY_SEPARATOR.$class.'.php';
			if(!is_file($class_file))
				throw new Exception('отсутствует файл '.$class_file);
			require_once $class_file;
			if(!class_exists($class,false))
				throw new Exception("отсутствует класс {$class} в файле {$class_file}");
		});

		//коннект к базе если он прописан в конфиге
		if(isset($this->config['db']))
		{
			$params=$this->config['db'];
			$db=new db($params);
			$this->db=$db->get_connect();
		}
	}

	private function __clone(){}
	private function __wakeup(){}

	public static function app($config_file=null)
	{
		if(is_null(self::$instance))
		{
			self::$instance=new self($config_file);
		}
		return self::$instance;
	}

	//запускает mvc
	public function run()
	{
		$route_key='r';
		$expl=explode(DIRECTORY_SEPARATOR,$this->config_file);
		$cf=array_pop($expl);
		unset($cf);
		$cd=array_pop($expl);
		unset($cd);
		$app_path=implode(DIRECTORY_SEPARATOR,$expl);
		$default_controller='site';
		if(isset($this->config['default_controller']))
			$default_controller=$this->config['default_controller'];
		$default_path=$default_controller.'/index';
		$path=$default_path;
		if(isset($_GET[$route_key]))
		{
			if(''==$_GET[$route_key])
				throw new Exception('Неверное значение для '.$route_key);
			$path=$_GET[$route_key];
		}
		$expl=explode('/',$path);
		$controller_name=$expl[0];
		$action_name='';
		if(isset($expl[1]))
			$action_name=$expl[1];
		$action_name=(''===$action_name)?'index':$action_name;
		$action_name=isset($action_name)?$action_name:'index';
		$controller=$controller_name.'_controller';
		$action='action_'.$action_name;
		$controller_file=$app_path.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR.$controller.'.php';
		if(!is_file($controller_file))
			throw new Exception('отсутствует файл '.$controller_file);
		require_once $controller_file;
		if(!class_exists($controller,false))
			throw new Exception("в файле {$controller_file} отсутствует класс {$controller}");
		$c=new $controller($app_path,$controller_name,$action_name);
		$c->$action();
	}

}
