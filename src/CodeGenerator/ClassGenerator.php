<?php

namespace CodeGenerator;

class ClassGenerator extends Generator {
	
	public static function factory($classname = null) {
		return new GeneratedClass($classname);
	}
	
	public function create($classname = null) {
		return self::factory($classname);
	}
	
	public function generate(GeneratedClass $object) {
		
		if (! empty($object->template)) {
			return static::generateFromTemplate($object);
		}
		
		$str = $this->phpStart();
		
		$str .= $this->generateNamespace($object);
		
		$str .= $this->generateUses($object);
		
		$str .= $this->generateClass($object);
		
		$str .= ' {'. n();
		
		if (! empty($object->properties)) {
			foreach($object->properties as $access => $props) {
				foreach($props as $property => $vartype) {
					$str .= nt() .'/**';
					$str .= nt() .' * @var ' . $vartype;
					$str .= nt() .' */';
					$str .= nt() .$access . ' $' . $property . ';' . n();
				}
			}
		}
		
		if (! empty($object->predefined_methods)) {
			foreach($object->predefined_methods as $class) {
				$o = new $class;
				$str .= nt() . $o->__toString() . n();
			}
		}
		
		$str .= $this->generateMethods($object->methods);
		
		if (! empty($object->interfaces)) {
			$str .= $this->generateInterfaceMethods($object);
		}
		
		$str .= n() ."}". n();
		
		return $str;
	}
	
	public static function generateFromArray( array $arr ) {
		
		if (! isset($arr['class'])) {
			trigger_error("Must set class to generate from array.");
		}
		
		$gen = new GeneratedClass($arr['class']);
		
		if (isset($arr['namespace'])) {
			$gen->namespace = $arr['namespace'];
		}
		
		if (isset($arr['parent'])) {
			$gen->parent = $arr['parent'];
		}
		
		$data = array(
			'use' => 'addUse',
			'interfaces' => 'addInterface',
			'properties' => 'addProperty',
			'methods' => 'addMethod'
		);
		
		foreach($data as $item => $method) {
			if (! empty($arr[$item])) {
				array_walk($arr[$item], function ($val) use ($method, &$gen) {
					$gen->{$method}($val);
				});
			}
		}
		
		$generator = new self();
				
		return $generator->generate($gen);
	}
	
	protected function generateClass(GeneratedClass $object) {
		$str = '';
		
		$str .= "class $object->class ";
		
		$fixIfUses = function ($classname) use ($object) {
			if (! empty($object->uses) && in_array($classname, $object->uses, true)) {
				$parts = explode('\\', $classname);
				$classname = array_pop($parts);
			} elseif (isset($object->namespace) && 0 === strpos($classname, $object->namespace)){
				$classname = substr($classname, strlen($object->namespace)+1);
			} else {
				$classname = '\\' . $classname;
			}
			return $classname;
		};
		
		if (isset($object->parent)) {
			
			$parentClass = $fixIfUses($object->parent);
			
			$str .= 'extends '. $parentClass .' ';
		}
		
		if (! empty($object->interfaces)) {
			
			$str .= "implements ";
			
			foreach($object->interfaces as $interface) {
				
				$intClass = $fixIfUses($interface);
				
				$str .= $intClass .', ';
			}
			
			$str = trim($str, ', ');
		}
		
		return $str;
	}
	
	protected function generateMethods( array $methods ) {
		
		$str = '';
		
		foreach($methods as $access => $_methods) {
			
			foreach($_methods as $method => $args) {
				
				$str .= nt() .'/**';
				
				if (! empty($args)) {
					foreach($args as $arg) {
						$str .= nt(). " * @param $$arg ";
					}
				}
				
				$str .= nt() . ' * @return ';
				
				$str .= nt() .' */' . nt();
				
				$str .= $access. ' function '. $method . '(';
				
				if (! empty($args)){
					$str .='$'.implode(', $', $args);
				}
				
				$str .= ') {'. nt() .'}'. n();
			}
		}
		
		return $str;
	}

	protected function generateInterfaceMethods(GeneratedClass $object) {
		
		$imethods = array();
		$str = '';
		
		foreach($object->interfaces as $interface) {
			if (InterfaceMethods::isKnown($interface)) {
				$str .= $this->generateMethods(array('public' => InterfaceMethods::getMethods($interface)));
			}
		}
		
		return $str;
	}
		
}
