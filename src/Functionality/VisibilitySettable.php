<?php

namespace CodeGen\Functionality;

// Possibly the stupidest name for a class ever.
trait VisibilitySettable
{
	protected $visibility = 'public';
	
	public function setVisibility($visibility) {
		
		if (! in_array($visibility, array('public', 'protected', 'private'), true)) {
			throw new \InvalidArgumentException("Visibility must be 'public', 'protected', or 'private'");
		}
		
		$this->visibility = $visibility;
		
		return $this;
	}
	
	public function getVisibility() {
		return $this->visibility;
	}
}
