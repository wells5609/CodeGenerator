<?php

namespace CodeGen\Functionality;

trait Defaultable
{
	protected $default;
	
	public function setDefault($value) {
		if (null === $value) {
			$value = 'null';
		} else if (true === $value) {
			$value = 'true';
		} else if (false === $value) {
			$value = 'false';
		}
		$this->default = $value;
		return $this;
	}
	
	public function hasDefault() {
		return isset($this->default);
	}
	
	public function getDefault() {
		if (! isset($this->default)) {
			return null;
		}
		if (! is_string($this->default) || in_array(strtolower($this->default), ['null', 'true', 'false'], true)) {
			return $this->default;
		}
		return '"'.$this->default.'"';
	}
}
