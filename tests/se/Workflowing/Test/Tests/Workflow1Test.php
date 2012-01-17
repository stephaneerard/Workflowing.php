<?php

namespace se\Workflowing\Test\Tests;

use se\Workflowing\Actor\Actor;

use se\Workflowing\Job\Condition as JobCondition;
use se\Workflowing\Job\Type as JobType;
use se\Workflowing\Job\Job;
use se\Workflowing\Workflow\Workflow;
use Symfony\Component\EventDispatcher\EventDispatcher;
use se\Promise\Promise;

class Workflow1TestCase extends \PHPUnit_Framework_TestCase
{
	public function testWorkflow1()
	{
		$eventDispatcher = new EventDispatcher();
		
		$jobType = new JobType('prepare_new_year_2013');
		
		$jobConditions = new \ArrayObject(array());
		
		$job = new Job();
		
		$job
		->setType($jobType)
		->getConditions()->append(new JobCondition(function(){
			return  strtotime(date('Y-m-d')) < strtotime('2013-12-31');
		}));
		
		$actor1 = new Actor($eventDispatcher);
		$actor1->connect($jobType, function(\se\Workflowing\Job\Event $jobEvent){
			$jobEvent->getPromise()->then(/** normal closure **/function() use($jobEvent){
				echo '$actor1 is in da place', PHP_EOL;
			}, /** failure closure **/function() use($jobEvent){
				echo '$actor1 has failing', PHP_EOL;
			});
		});
		
		$actor2 = new Actor($eventDispatcher);
		$actor2->connect($jobType, function(\se\Workflowing\Job\Event $jobEvent){
			$jobEvent->getPromise()->then(/** normal closure **/function() use($jobEvent){
				echo '$actor2 is in da place', PHP_EOL;
				throw new \Exception();
			}, /** failure closure **/function() use($jobEvent){
				echo '$actor2 has failed', PHP_EOL;
			});
		});
		
		$actor3 = new Actor($eventDispatcher);
		$actor3->connect($jobType, function(\se\Workflowing\Job\Event $jobEvent){
			$jobEvent->getPromise()->then(/** normal closure **/function() use($jobEvent){
				echo '$actor3 is in da place', PHP_EOL;
			}, /** failure closure **/function() use($jobEvent){
			
			});
		});
		
		$actor4 = new Actor($eventDispatcher);
		$actor4->connect($jobType, function(\se\Workflowing\Job\Event $jobEvent){
			$jobEvent->getPromise()->then(/** normal closure **/function() use($jobEvent){
				echo '$actor4 is in da place', PHP_EOL;
			}, /** failure closure **/function() use($jobEvent){
			
			});
		});
		
		$mainActor = new Actor($eventDispatcher);
		$mainActor->connect($jobType, function(\se\Workflowing\Job\Event $jobEvent){
			$jobEvent->getPromise()->then(/** normal closure **/function() use($jobEvent){
				echo '$mainActor is in da place', PHP_EOL;
			}, /** failure closure **/function() use($jobEvent){
			
			});
		});
		$mainActor->ask($job);
	}
}