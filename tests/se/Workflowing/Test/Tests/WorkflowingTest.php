<?php

namespace se\Workflowing\Test\Tests;

use se\Workflowing\Workflow;

class WorkflowingTestCase extends \PHPUnit_Framework_TestCase
{
	public function testNew()
	{
		$new = $this->getNewWorkflow();
		$this->assertInstanceOf('se\Workflowing\Workflow\Workflow', $new);
	}

	

	/**********************
	 *
	* 			HELPERS
	*
	*********************/

	/**
	 * @param string $class
	 * @return Workflow
	 */
	public function getNewWorkflow($class = null)
	{
		$class = $class ?: 'se\Workflowing\Workflow\Workflow';
		return new $class();
	}
}