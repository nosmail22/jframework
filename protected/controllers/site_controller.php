<?php

class site_controller extends base_controller
{
	public function before_action()
	{
		$this->layout='test';
	}

	public function action_index()
	{

		$msg='Hello world!';
		$this->render('index',array('msg'=>$msg));
	}

}
