<?php

namespace CodeGen;

class Generator 
{
	
	protected static $nonPrintableTypes = array(
		'string', 
		'bool', 
		'boolean', 
		'object', 
		'resource', 
		'integer', 
		'int', 
		'mixed', 
		'scalar'
	);
	
	/**
	 * Returns true if parameter type is printable in a type-hinting context
	 * @return boolean
	 */
	public static function isPrintableType($phptype) {
		if (false !== strpos($phptype, '|')) {
			return false;
		}
		return ! in_array(strtolower($phptype), static::$nonPrintableTypes, true);	
	}
	
	/**
	 * Parses parameters to determine type and name
	 */
	public static function parseParams(array $params) {
		
		$parameters = array();
		
		foreach($params as $i => $param) {
				
			$type = null;
			
			if (false !== $cpos = strpos($param, ':')) {
				$type = substr($param, 0, $cpos);
				$param = substr($param, $cpos+1);
			}
			
			$parameters[$i] = array(
				'name' => $param,
				'type' => $type,
			);
		}
		
		return $parameters;
	}
	
	/**
	 * Returns a starting PHP tag and blank line.
	 * @return string
	 */
	public static function startPhpFile(){
		return "<?php \n\n";
	}
	
	/**
	 * Generates a "namespace" statement
	 * @return string
	 */
	public static function generateNamespace(Entity $obj) {
		
		if ($namespace = $obj->getNamespace()) {
			return "namespace {$namespace}; \n\n";
		}
		
		return '';
	}
	
	/**
	 * Generates a block of "use" statements
	 * @return string
	 */
	public static function generateUses(Entity $object) {
		
		$str = '';
		$uses = $object->getUses();
		
		if (! empty($uses)) {
			
			foreach($uses as $class => $as) {
				
				$str .= "use {$class}";
				
				if ($as !== $class) {
					$str .= " as {$as}";
				}
				
				$str .= ";\n";
			}
			
			$str .= "\n";
		}
		
		return $str;
	}
	
	/**
	 * Generates a function (or class method), including docblock.
	 * 
	 * @param string $name Name of function.
	 * @return string
	 */
	public static function generateFunction($name, array $params = null, $visibility = '') {
		
		if (! empty($params)) {
			$params = static::parseParams($params);
		}
		
		$str = static::generateDocBlock($params);
				
		$str .= (empty($visibility) ? '' : $visibility.' ') . 'function '. $name . '(';
		
		if (! empty($params)){
			
			foreach($params as $param) {
				if (! empty($param['type']) && static::isPrintableType($param['type'])) {
					$str .= $param['type'] . ' ';
				}
				$str .= '$' . $param['name'] . ', ';
			}

			$str = rtrim($str, ' ,');
		}
		
		$str .= ') {'. "\n\t" .'}'. "\n";
		
		return $str;
	}
	
	/**
	 * Generates a docblock of params, optional return value, and optional extra lines.
	 */
	public static function generateDocBlock(array $params = array(), $return = null, array $extra_lines = null) {
		return (string) new DocBlock($params, $return, $extra_lines);
	}
	
	/**
	 * Writes the generated code to a file.
	 */
	public static function writeToFile(Entity $object, $code, $filename) {
		return false !== file_put_contents($filename, $code);
	}
	
}

