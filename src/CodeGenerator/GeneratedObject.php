<?php

namespace CodeGenerator;

class GeneratedObject {
	
	public $namespace;
	
	public $uses = array();
	
	public function setNamespace( $ns ) {
		$this->namespace = $ns;
		return $this;
	}
	
	public function addUse( $class ) {
		$this->uses[] = $class;
		return $this;
	}
	
}
