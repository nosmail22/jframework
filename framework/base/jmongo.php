<?php

class jmongo
{
	protected $collection;

	protected function __construct($collection)
	{
		//проверки на нулл монго
		$db=jf::app()->mongo;
		//var_dump($db);
		if(is_null($db))
			throw new Exception('mongo: null, проверьте конфигурационный файл');
		$this->collection=$db->$collection;
	}

}