<?php

namespace CodeGen\Functionality;

use CodeGen\Docs;

trait Documentable
{
	protected $docs;
	
	public function setDocs(Docs $doc) {
		$this->docs = $doc;
		return $this;
	}
	
	public function hasDocs() {
		return $this->docs;
	}
	
	public function getDocs() {
		return $this->docs;
	}	
}
