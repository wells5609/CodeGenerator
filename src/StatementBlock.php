<?php

namespace CodeGen;

class StatementBlock
{
	public $canvas;
	public $scope;
	protected $expressions = [];
	
	public function __construct(Canvas $canvas) {
		$this->canvas = $canvas;
	}
	
	public function getCanvas() {
		return $this->canvas;
	}
	
	public function addExpression(ExpressionInterface $expr) {
		$this->expressions[] = $expr;
		return $this;
	}
	
	public function __toString() {
		$str = '';
		foreach($this->expressions as $expr) {
			$str .= $expr;
		}
		return $str;
	}
	
}
