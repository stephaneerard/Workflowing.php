<?php
namespace se\Workflowing\Job;

class Condition
{
	protected $closure;
	
	public function __construct(\Closure $closure)
	{
		$this->closure = $closure;
	}
	
	public function check(Job $job)
	{
		return call_user_func_array($this->closure, array($job));
	}
}