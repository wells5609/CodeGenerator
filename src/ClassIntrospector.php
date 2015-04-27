<?php

namespace CodeGen;

use ReflectionClass;
use ReflectionMethod;
use CodeGen\Php\ClassDefinition;
use CodeGen\Php\Method;
use CodeGen\Php\Parameter;

class ClassIntrospector
{
	
	/**
	 * @var \CodeGen\Canvas
	 */
	protected $canvas;
	
	/**
	 * @var \ReflectionClass
	 */
	protected $ref;
	
	public static function addMethodsToClass(ClassDefinition $object, $classname) {
		
		$introspector = new static($object->getCanvas(), $classname);
		
		foreach($introspector->getMethods() as $method) {
			$object->addMethod($method);
		}
		
		return $object;
	}
	
	public function __construct(Canvas $canvas, $class) {
		$this->canvas = $canvas;
		$this->ref = new ReflectionClass($class);
	}
	
	public function getMethods() {
		
		$methods = array();
		
		foreach($this->ref->getMethods() as $method) {
			
			if (! $method->isAbstract()) {
				continue;
			}
			
			$gen = new Method($this->canvas, $method->name);
			
			$gen->setVisibility($this->resolveMethodVisibility($method));
			
			if ($method->isStatic()) {
				$gen->setStatic();
			}
			
			$this->addMethodParams($gen, $method);
			
			if ($docStr = $method->getDocComment()) {
				$gen->setDocs(new Docs($docStr));
			}
			
			$methods[$method->name] = $gen;
		}
		
		return $methods;
	}
	
	protected function addMethodParams(Method $gen, ReflectionMethod $method) {
		
		foreach($method->getParameters() as $param) {
			
			$parameter = new Parameter($this->canvas, $param->name);
			
			if ($param->isArray()) {
				$parameter->setType('array');
			} else if ($class = $param->getClass()) {
				$parameter->setType($class->name);
			}
			
			if ($param->isOptional()) {
				if ($param->isDefaultValueAvailable()) {
					$parameter->setDefault($param->getDefaultValue());
				} else {
					$parameter->setDefault('null');
				}
			}
			
			$gen->addParam($parameter);
		}
		
		return $gen;
	}
	
	protected function resolveMethodVisibility(ReflectionMethod $method) {
		if ($method->isPublic()) {
			return 'public';
		} else if ($method->isProtected()) {
			return 'protected';
		} else if ($method->isPrivate()) {
			return 'private';
		}
	}
	
}
