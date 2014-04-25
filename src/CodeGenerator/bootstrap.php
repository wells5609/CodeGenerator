<?php
/**
 * @package CodeGenerator
 */

function CodeGenerator_autoload($class) {
	if (0 === strpos($class, 'CodeGenerator')) {
		include __DIR__.'/'. str_replace(array('CodeGenerator\\', '\\'), array('', '/'), $class).'.php';
	}
}

spl_autoload_register('CodeGenerator_autoload');