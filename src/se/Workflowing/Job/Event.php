<?php
namespace se\Workflowing\Job;

use se\Promise\Promise;

use Symfony\Component\EventDispatcher\Event as SfEvent;

use se\Workflowing\Actor\Actor;

class Event extends SfEvent
{
	const __STATE__WAITING_SCHEDULING	= 1;
	const __STATE__SCHEDULING			= 2;
	const __STATE__WAITING_COMPLETION	= 3;
	const __STATE__IN_COMPLETION		= 4;
	const __STATE__COMPLETED			= 5;

	protected $job;
	protected $actor;
	protected $state;
	protected $actors;
	protected $promise;

	public function __construct(Job $job, Actor $actor)
	{
		$this->job = $job;
		$this->actor = $actor;
		$this->waitingScheduling();
		$this->takingPart = array();
		$this->ordered = array();
		
		$event = $this;
		$this->promise = new Promise(function() use ($event){
			/** @var EventDispatcher **/
			$event->getDispatcher()->dispatch('job.starting', $event);
		});
	}
	
	/**
	 * 
	 * @êeturn se\Promise\Promise
	 */
	public function getPromise()
	{
		return $this->promise;
	}
	
	public function run()
	{
		$promise = $this->promise;
		$promise();
	}
	
	public function getResult()
	{
		return $this->promise->result();
	}
	
	/**
	 * 
	 * @param Actor $actor
	 * @return se\Workflowing\Job\Event
	 */
	public function addActor(Actor $actor)
	{
		$this->actors[] = $actor;
		return $this;
	}
	
	/**
	 *
	 * @return Job
	 */
	public function getJob()
	{
		return $this->job;
	}

	/**
	 *
	 * @return Actor
	 */
	public function getAskingActor()
	{
		return $this->actor;
	}
	
	public function getName()
	{
		return $this->job->getType()->getName();
	}


	/**************************************************
	 *
	* 					STATES
	*
	*************************************************/

	public function waitingScheduling()
	{
		$this->state = self::__STATE__WAITING_SCHEDULING;
		return $this;
	}

	public function isWaitingScheduling()
	{
		return $this->state === self::__STATE__WAITING_SCHEDULING;
	}

	public function scheduling()
	{
		$this->state = self::__STATE__SCHEDULING;
		return $this;
	}

	public function isScheduling()
	{
		return $this->state === self::__STATE__SCHEDULING;
	}

	public function waitingCompletion()
	{
		$this->state = self::__STATE__WAITING_COMPLETION;
		return $this;
	}

	public function isWaitingCompletion()
	{
		return $this->state === self::__STATE__WAITING_COMPLETION;
	}

	public function inCompletion()
	{
		$this->state = self::__STATE__IN_COMPLETION;
		return $this;
	}

	public function isInCompletion()
	{
		return $this->state === self::__STATE__IN_COMPLETION;
	}

	public function completed()
	{
		$this->state = self::__STATE__COMPLETED;
		return $this;
	}

	public function isCompleted()
	{
		return $this->state === self::__STATE__COMPLETED;
	}

	public function getState()
	{
		return $this->state;
	}
}