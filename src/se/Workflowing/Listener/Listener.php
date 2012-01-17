<?php
namespace se\Workflowing\Listener;

interface Listener
{
	public function listen(Type $type);
}