<?php

namespace CodeGen\Lang;

class Expression implements ExpressionInterface
{
	public $scope;
	protected $left;
	protected $right;
	protected $mid;
	
	public function __construct(Scope $scope) {
		$this->scope = $scope;
	}
	
	public function getScope() {
		return $this->scope;
	}
	
	public function setLeft($leftValue) {
		$this->left = trim($leftValue);
		return $this;
	}
	
	public function setRight($rightValue) {
		$this->right = trim($rightValue);
		return $this;
	}
	
	public function setMid($midValue) {
		$this->mid = trim($midValue);
		return $this;
	}
	
	public function __toString() {
		return $this->stringBefore().trim($this->left.' '.$this->mid.' '.$this->right).$this->stringAfter();		
	}
	
	protected function stringBefore() {
		return '';
	}
	
	protected function stringAfter() {
		return '';
	}
}
