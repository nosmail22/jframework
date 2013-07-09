<?php

class base_controller
{
	protected $app_path;
	protected $controller_name;
	protected $action_name;

	public function __construct($app_path,$controller_name,$action_name)
	{
		$this->app_path=$app_path;
		$this->controller_name=$controller_name;
		$this->action_name=$action_name;
	}

	public function __call($name,$arguments)
	{
		$msg="отсутствует метод {$name} в классе {$this->controller}";
		throw new Exception($msg);
	}

	public function render($view,$params=array())
	{
		$view_file=$this->app_path.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.$this->controller_name.DIRECTORY_SEPARATOR.$view.'.php';
		if(!is_file($view_file))
			throw new Exception('отсутствует файл '.$view_file);	
		/*$content=@file_get_contents($view_file);
		if(false===$content)
			throw new Exception('ошибка чтения файла '.$view_file);*/
		extract($params);
		ob_start();
		require_once $view_file;
		$content=ob_get_contents();
		ob_end_clean(); 
		echo $content;
	}
	
}
