<?php

namespace CodeGenerator;

class GeneratedObject {
	
	public $namespace;
	
	public $uses = array();
	
	public $write_file;
	
	public function setNamespace( $ns ) {
		$this->namespace = $ns;
		return $this;
	}
	
	public function addUse( $class ) {
		$this->uses[] = $class;
		return $this;
	}
	
	public function writeTo($path) {
		
		$path = ltrim(str_replace('\\', '/', $path), '/');
	
		if (! is_writable($path)) {
			trigger_error("Given path is not writable at $path.");
			return null;
		}
		
		if (is_dir($path)) {
			$this->write_file = $path . '<NEWNAME>';
		} else {
			$this->write_file = $path;
		}
		
		return $this;
	}
	
}
