<?php

namespace se\Workflowing\Test\Tests;

use se\Workflowing\Workflow\Workflow;
use Symfony\Component\EventDispatcher\EventDispatcher;
use se\Promise\Promise;

class WorkflowingTestCase extends \PHPUnit_Framework_TestCase
{
	public function testNewEventDispatcher()
	{
		$dispatcher = new EventDispatcher();
		$this->assertInstanceOf('Symfony\Component\EventDispatcher\EventDispatcher', $dispatcher);
	}
	
	public function testNewPromise()
	{
		$promise = new Promise(function(){});
		$this->assertInstanceOf('se\Promise\Promise', $promise);
	}
}