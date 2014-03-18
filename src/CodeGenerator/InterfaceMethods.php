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
		'Serializable' => array(
			'serialize' => array(),
			'unserialize' => array('serialized'),
		),
	);
	
	public static function isKnown($interface) {
		return isset(self::$interfaces[$interface]);
	}
	
	public static function getMethods($interface) {
		return self::$interfaces[$interface];
	}
	
}
