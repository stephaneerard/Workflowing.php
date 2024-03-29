<?php
namespace se\Promise\Test;

use se\Workflowing\Test\WorkflowingTestSuite;

class PhpunitRunner
{
	public function __construct($suite, $dir)
	{
		$runner = new \PHPUnit_TextUI_TestRunner();
		$suite = new $suite;
		$suite->addTestFiles($this->getTestFiles($dir));
		$runner->doRun($suite, array('verbose'=>true));
	}

	function getTestFiles($dir)
	{
		$files = array();
		$dir = new \DirectoryIterator($dir);
		foreach($dir as $file)
		{
			if(in_array($file->getFilename(), array('.', '..'))) continue;
			if($file->getType() == 'dir')
			{
				$files = array_merge($files, $this->getTestFiles($file->getPathname()));
			}
			elseif(strpos($file->getFilename(), 'Test.php'))
			{
				$files[] = $file->getPathname();
			}
		}
		return $files;
	}
}

$loader = require __DIR__ . '/bootstrap.php';
$loader->add('se\\Workflowing\Test', __DIR__);

new PhpunitRunner(new WorkflowingTestSuite(), __DIR__);
