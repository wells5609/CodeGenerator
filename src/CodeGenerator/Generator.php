<?php

namespace CodeGenerator;

abstract class Generator {
	
	protected $template;
	
	/**
	 * Subclasses implement this function to generate the object.
	 */
	abstract public function generate(GeneratedObject $object);
	
	/**
	 * Returns true if parameter type is printable in a type-hinting context.
	 * 
	 * @return boolean
	 */
	public function isPrintableType($phptype) {
		$disallow = array('string', 'bool', 'boolean', 'object', 'resource', 'integer', 'int');
		return ! in_array(strtolower($phptype), $disallow, true);	
	}
	
	/**
	 * Parses parameters to determine type and name.
	 */
	public function parseParams(array $params) {
		
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
	 */
	public function phpStart(){
		return '<?php'. blankLine();
	}
	
	/** ========================
			Generation
	========================= */
	
	/**
	 * Generates a "namespace" statement.
	 */
	protected function generateNamespace(GeneratedObject $obj) {
		
		if (isset($obj->namespace)) {
			return "namespace $obj->namespace;". blankLine();
		}
		
		return '';
	}
	
	/**
	 * Generates a block of "use" statements.
	 */
	protected function generateUses(GeneratedObject $obj) {
		
		$str = '';
		
		if (! empty($obj->uses)) {
			foreach($obj->uses as $class) {
				$str .= "use $class;\n";
			}
			$str .= n();
		}
		
		return $str;
	}
	
	/**
	 * Generates a docblock of params, optional return value, and optional extra lines.
	 */
	protected function generateDocBlock(array $params = array(), $return = null, array $extra_lines = null) {
		
		$str = '';
		
		$str .= nt() .'/**';
		
		if (! empty($params)) {
			foreach($params as $arg) {
				
				$str .= nt()." * @param ";
				
				if (! empty($arg['type'])) {
					$str .= $arg['type'].' ';
				}
				
				$str .= '$'.$arg['name'];
			}
		}
		
		$str .= nt() . ' * @return ' . (isset($return) ? $return : '') . nt();
		
		if (isset($extra_lines)) {
			foreach($extra_lines as $line) {
				$str .= ' * ' . $line . nt();
			}
		}
		
		$str .= ' */' . nt();
		
		return $str;
	}
	
	/**
	 * Generates a function (or class method), including docblock.
	 * 
	 * @param string $name Name of function.
	 * @return string
	 */
	protected function generateFunction($name, array $params = null, $scope = '') {
		
		if (! empty($params)) {
			$params = $this->parseParams($params);
		}
		
		$str = $this->generateDocBlock($params);
				
		$str .= (empty($scope) ? '' : $scope.' ') . 'function '. $name . '(';
		
		if (! empty($params)){
				
			foreach($params as $param) {
				if (! empty($param['type']) && static::isPrintableType($param['type'])) {
					$str .= $param['type'] . ' '; // type-hinting
				}
				$str .= '$'.$param['name'].', ';
			}

			$str = rtrim($str, ' ,');
		}
		
		$str .= ') {'. nt() .'}'. n();
		
		return $str;
	}
	
	/**
	 * Writes the generated code to a file.
	 */
	protected function writeToFile(GeneratedObject $object, $code, $new_filename = '') {
		
		if (empty($new_filename)) {
			$new_filename = str_replace('generated', '', strtolower(get_class($object))) . '-'. time();
		}
		
		$file = str_replace('<NEWNAME>', $new_filename, $object->write_file);
		$bytes = file_put_contents($file, $code);
		
		return false !== $bytes;
	}
	
	/**
	 * Not implemented
	 * @todo
	 */
	protected function generateFromTemplate(GeneratedObject $object) {
		
		$contents = file_get_contents($object->template);
		//...
	}
	
}

// new line
function n(){
	return "\n";
}

// tab
function t(){
	return "\t";
}

// new line + tab
function nt(){
	return "\n\t";
}

// double new line
function blankLine(){
	return "\n\n";
}
