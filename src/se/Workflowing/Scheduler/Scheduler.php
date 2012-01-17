<?php
namespace se\Workflowing\Scheduler;

use Symfony\Component\EventDispatcher\EventDispatcher;

use se\Workflowing\Job\Event;

class Scheduler
{
	/**
	 * 
	 * @var se\Workflowing\Job\Event
	 */
	protected $jobEvent;
	
	/**
	 * 
	 * @var Symfony\Component\EventDispatcher\EventDispatcher
	 */
	protected $dispatcher;
	
	public function __construct(Event $jobEvent, EventDispatcher $dispatcher)
	{
		$this->dispatcher = $dispatcher;
		$this->jobEvent = $jobEvent;
	}
	
	public function schedule()
	{
		$this->jobEvent->scheduling();
		$this->dispatcher->dispatch($this->jobEvent->getName(), $this->jobEvent);
		$this->jobEvent->waitingCompletion();
		return $this;
	}
	
	public function complete()
	{
		$this->jobEvent->inCompletion();
		$this->jobEvent->run();
		$this->jobEvent->completed();
		return $this;
	}
}