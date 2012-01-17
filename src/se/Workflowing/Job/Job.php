<?php
namespace se\Workflowing\Job;

class Job
{
	/**
	 * @var ArrayObject
	 */
	protected $conditions;
	
	public function __construct()
	{
		$this->conditions = new \ArrayObject();
	}
	
	/**
	 * @param Type $type
	 * @return Job
	 */
	public function setType(Type $type)
	{
		$this->type = $type;
		return $this;	
	}
	
	/**
	 * @return Type
	 */
	public function getType()
	{
		return $this->type;
	}
	
	/**
	 * @return array
	 */
	public function getConditions()
	{
		return $this->conditions;
	}
}