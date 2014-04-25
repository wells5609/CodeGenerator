<?php

namespace CodeGenerator;

class InterfaceMethods {
	
	protected static $interfaces = array(
		'ArrayAccess' => array(
			'offsetSet' => array('index', 'newval'),
			'offsetGet' => array('index'),
			'offsetUnset' => array('index'),
			'offsetExists' => array('index'), 
		),
		'Countable' => array(
			'count' => array()
		),
		'Iterator' => array(
			'current' => array(),
			'key' => array(),
			'next' => array(),
			'rewind' => array(),
			'valid' => array(),
		),
		'IteratorAggregate' => array(
			'getIterator' => array(),
		),
		'Serializable' => array(
			'serialize' => array(),
			'unserialize' => array('string:serialized'),
		),
		'JsonSerializable' => array(
			'jsonSerialize' => array(),
		),
		'SplObserver' => array(
			'update' => array('SplSubject:subject'),
		),
		'SplSubject' => array(
			'notify' => array(),
			'attach' => array('SplObserver:observer'),
			'detatch' => array('SplObserver:observer'),
		),
	);
	
	public static function isKnown($interface) {
		return isset(self::$interfaces[$interface]);
	}
	
	public static function getMethods($interface) {
		return self::$interfaces[$interface];
	}
	
}
