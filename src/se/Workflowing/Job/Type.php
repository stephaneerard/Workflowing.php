<?php
namespace se\Workflowing\Job;

class Type
{
	protected $name;
	
	public function __construct($name = null)
	{
		$this->name = $name;
	}
	
	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	
	public function getName()
	{
		return $this->name;
	}
}