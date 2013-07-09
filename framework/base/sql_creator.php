<?php

class sql_creator
{
	public $action;
	public $table;

	public $select;
	public $where;
	public $order;
	public $limit;

	public $columns;
	public $values;

	public function __construct($action,$table)
	{
		$this->action=mb_strtoupper($action);
		$this->table=$table;
	}

	public function create()
	{
		$sql='';
		switch($this->action)
		{
			case 'INSERT':
				//
				$sql.=$this->action.' INTO '.$this->table;
				if(!is_null($this->columns))
				{
					$sql.=" ({$this->columns})";
				}
				$sql.=" VALUES ({$this->values})";
				break;
						case 'SELECT':
				$sql.=$this->action.' ';
				if(!is_null($this->select))
					$sql.=$this->select;
				else
					$sql.='*';
				$sql.=' FROM ';
				$sql.=$this->table;
				if(!is_null($this->where))
				{
					$sql.=" WHERE {$this->where}";
				}
				if(!is_null($this->order))
				{
					$sql.=" ORDER BY {$this->order}";
				}
				if(!is_null($this->limit))
				{
					$sql.=" LIMIT {$this->limit}";
				}
				break;			case 'SELECT':
				$sql.=$this->action.' ';
				if(!is_null($this->select))
					$sql.=$this->select;
				else
					$sql.='*';
				$sql.=' FROM ';
				$sql.=$this->table;
				if(!is_null($this->where))
				{
					$sql.=" WHERE {$this->where}";
				}
				if(!is_null($this->order))
				{
					$sql.=" ORDER BY {$this->order}";
				}
				if(!is_null($this->limit))
				{
					$sql.=" LIMIT {$this->limit}";
				}
				break;
			case 'UPDATE':
				$sql.="UPDATE {$this->table} SET {$this->values}";
				if(!is_null($this->where))
				{
					$sql.=" WHERE {$this->where}";
				}
				if(!is_null($this->order))
				{
					$sql.=" ORDER BY {$this->order}";
				}
				if(!is_null($this->limit))
				{
					$sql.=" LIMIT {$this->limit}";
				}
				break;
			case 'DELETE':
				$sql.="DELETE FROM {$this->table} WHERE {$this->where}";
				if(!is_null($this->order))
				{
					$sql.=" ORDER BY {$this->order}";
				}
				if(!is_null($this->limit))
				{
					$sql.=" LIMIT {$this->limit}";
				}
				break;
		}
		$sql.=';';
		return $sql;
	}

}