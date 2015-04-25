CodeGenerator
=============

Generate PHP code using PHP.

##Example

```php
// create a class generator
$generator = new \CodeGenerator\ClassGenerator();

// set the classname
$gen = $generator->create('MyController');

$gen->setNamespace('App\Resources');

$gen->setParent('App\Resources\Controller');

// Add 'use' statements
$gen->addUse('Countable')
	->addUse('ArrayAccess')
	->addUse('Serializable');

// Add interfaces - will append methods
$gen->addInterface('ArrayAccess')
	->addInterface('Countable')
	->addInterface('Serializable');

$gen->addProperty('instance', 'string', 'protected static');

$gen->addPredefinedMethod('CodeGenerator\Method\StaticInstance');

$gen->addMethod('getSomething', array('var'));
$gen->addMethod('setSomething', array('var', 'value'));
```

Using the above, a call to `$generator->generate($gen)` will produce the following output:

```php
<?php

namespace App\Resources;

use Countable;
use ArrayAccess;
use Serializable;

class MyController extends Controller implements ArrayAccess, Countable, Serializable {

	/**
	 * @var string
	 */
	protected static $instance;

	/** 
	 * Returns singleton instance.
	 * @return $this
	 */
	public static function instance() {
		if (! isset(self::$instance))
			self::$instance = new self();
		return self::$instance;
	}

	/**
	 * @param $var 
	 * @return 
	 */
	public function getSomething($var) {
	}

	/**
	 * @param $var 
	 * @param $value 
	 * @return 
	 */
	public function setSomething($var, $value) {
	}

	/**
	 * @param $index 
	 * @param $newval 
	 * @return 
	 */
	public function offsetSet($index, $newval) {
	}

	/**
	 * @param $index 
	 * @return 
	 */
	public function offsetGet($index) {
	}

	/**
	 * @param $index 
	 * @return 
	 */
	public function offsetUnset($index) {
	}

	/**
	 * @param $index 
	 * @return 
	 */
	public function offsetExists($index) {
	}

	/**
	 * @return 
	 */
	public function count() {
	}

	/**
	 * @return 
	 */
	public function serialize() {
	}

	/**
	 * @param $serialized 
	 * @return 
	 */
	public function unserialize($serialized) {
	}

}
```
