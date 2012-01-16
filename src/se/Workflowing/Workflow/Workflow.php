<?php
namespace se\Workflowing\Workflow;

class Workflow extends AbstractWorkflow
{

	
	/**
	 * @var WorkerListenerInterface
	 */
	protected $workerListener;
	
	/**
	 * @var OrdonnancerListenerInterface
	 */
	protected $ordonnancerListener;
	
	
	/**
	 * @var unknown_type
	 */
	protected $eventDispatcher;

	public function ordonnate()
	{
		
	}
	
	public function orchestrate()
	{
		$this->workerListener->listen();
		$this->ordonnancerListener->listen();
	}
	
	public function setWorkerListener(WorkerListenerInterface $workerListener)
	{
		$this->workerListener = $workerListener;
	}
	
	public function getWorkerListener()
	{
		return $this->workerListener;
	}
	
	public function setOrdonnancerListener(OrdonnancerListenerInterface $ordonnancerListener)
	{
		$this->ordonnancerListener = $ordonnancerListener;
	}
	
	public function getOrdonnancerListener()
	{
		return $this->ordonnancerListener;
	}
}