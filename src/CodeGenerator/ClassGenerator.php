<?php

namespace CodeGenerator;

class ClassGenerator extends Generator {
	
	public static function factory($classname = null) {
		return new GeneratedClass($classname);
	}
	
	public function create($classname = null) {
		return self::factory($classname);
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
	
	public function generate(GeneratedObject $object) {
		
		if (! empty($object->template)) {
			return $this->generateFromTemplate($object);
		}
		
		$str = $this->phpStart();
		
		$str .= $this->generateNamespace($object);
		
		$str .= $this->generateUses($object);
		
		$str .= $this->generateClass($object);
		
		$str .= ' {'. n();
		
		if (! empty($object->properties)) {
			$str .= $this->generateProperties($object);
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
		
		if (isset($object->write_file)) {
			
			// name if one is not set
			$filename = $object->class . '-'. time() .'.php';
			
			return $this->writeToFile($object, $str, $filename);
		}
		
		return $str;
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
	
	protected function generateProperties(GeneratedClass $object) {
		$str = '';
		
		foreach($object->properties as $access => $props) {
			foreach($props as $property => $vartype) {
				$str .= nt() .'/**';
				$str .= nt() .' * @var ' . $vartype;
				$str .= nt() .' */';
				$str .= nt() .$access . ' $' . $property . ';' . n();
			}
		}
		
		return $str;
	}
	
	protected function generateMethods( array $methods ) {
		
		$str = '';
		
		foreach($methods as $access => $_methods) {
			
			foreach($_methods as $method => $args) {
				
				$str .= $this->generateFunction($method, $args, $access);
			}
		}
		
		return $str;
	}

	protected function generateInterfaceMethods(GeneratedClass $object) {
		
		$imethods = array();
		$str = '';
		
		foreach($object->interfaces as $interface) {
				
			if (InterfaceMethods::isKnown($interface)) {
				// interface methods are public
				$str .= $this->generateMethods(array(
					'public' => InterfaceMethods::getMethods($interface)
				));
			}
		}
		
		return $str;
	}
		
}
