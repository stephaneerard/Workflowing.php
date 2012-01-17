<?php
namespace se\Workflowing\Actor;

use se\Workflowing\Scheduler\Scheduler;

use se\Workflowing\Job\Event as JobEvent;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use se\Workflowing\Job\Type as JobType;
use se\Workflowing\Job\Job;


class Actor
{
	/**
	 * @var Symfony\Component\EventDispatcher\EventDispatcher
	 */
	protected $dispatcher;

	protected $jobTypes;

	public function __construct(EventDispatcher $dispatcher)
	{
		$this->dispatcher = $dispatcher;
		$this->jobTypes = array();
	}

	public function connect(JobType $jobType, \Closure $closure = null)
	{
		if(!isset($this->jobTypes[$jobType->getName()]))
		{
			$this->jobTypes[$jobType->getName()] = $jobType;
			$this->dispatcher->addListener($jobType->getName(), $closure ? function(Event $jobEvent) use ($closure){
				$closure($jobEvent);
			} : array($this, 'listen'));
		}
		return $this;
	}

	public function listen(JobEvent $event)
	{
		echo sprintf('listening to jobevent of type "%s"', $event->getName()), PHP_EOL;
	}

	public function ask(Job $job)
	{
		$jobEvent = new JobEvent($job, $this);
		$scheduler = new Scheduler($jobEvent, $this->dispatcher);
		return $scheduler->schedule()->complete();
	}

	public function setDispatcher(EventDispatcher $dispatcher)
	{
		$this->dispatcher = $dispatcher;
		return $this;
	}
}