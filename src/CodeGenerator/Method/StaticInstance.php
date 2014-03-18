<?php

namespace CodeGenerator\Method;

class StaticInstance extends AbstractPredefined {
	
	public $name = 'instance';
	
	public $scope = 'public static';
	
	public $description = 'Returns singleton instance.';
	
	public $returns = '$this';
	
	public function getBody(){
		$s = 'if (! isset(self::$instance))';
		$s .= "\n\t\t\t". 'self::$instance = new self();';
		$s .= "\n\t\t" . 'return self::$instance;';
		return $s;
	}
	
}