<?php

namespace CodeGen\Php;

use CodeGen\AbstractObject;
use CodeGen\Functionality\Typeable;
use CodeGen\Functionality\Staticable;
use CodeGen\Functionality\Defaultable;
use CodeGen\Generator;

class Parameter extends AbstractObject
{
	use Typeable, Staticable, Defaultable;
	
	public function __toString() {
		
		$str = '';
		$type = $this->getType();
		
		if ($type && Generator::isPrintableType($type)) {
			if ($this->isTypeArray()) {
				$str .= 'array ';
			} else {
				$str .= $this->getCanvas()->escapeClassname($type) . ' ';
			}
		}
		
		$str .= '$' . $this->getName();
		
		if ($this->hasDefault()) {
			$str .= ' = ' . $this->getDefault();
		}
		
		return $str;
	}
	
}
