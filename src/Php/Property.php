<?php

namespace CodeGen\Php;

use CodeGen\AbstractObject;
use CodeGen\Functionality\Typeable;
use CodeGen\Functionality\VisibilitySettable;
use CodeGen\Functionality\Staticable;
use CodeGen\Functionality\Defaultable;
use CodeGen\Docs;

class Property extends AbstractObject
{
	use Typeable, VisibilitySettable, Staticable, Defaultable;
	
	public function __toString() {
		
		if (! isset($this->docs)) {
			$this->setDocs(Docs::forProperty($this));
		}
		
		$str = '';
		$str .= $this->getDocs()->render();
		
		$str .= "\t" . $this->getVisibility() . ' ' . ($this->isStatic() ? 'static ' : '');
		
		$str .= '$' . $this->getName();
		
		if ($this->hasDefault()) {
			$str .= ' = ' . $this->getDefault();
		}
		
		$str .= ';' . "\n";
		
		return $str;
	}
}
