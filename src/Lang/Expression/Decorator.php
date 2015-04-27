<?php

namespace CodeGen\Lang\Expression;

use CodeGen\Lang\ExpressionInterface;
use CodeGen\Lang\Expression;
use CodeGen\Lang\Scope;

class Decorator implements ExpressionInterface
{
	protected $expression;
	
	public function __construct($expr) {
		if ($expr instanceof ExpressionInterface) {
			$this->expression = $expr;
		} else if ($expr instanceof Scope) {
			$this->expression = new Expression($expr);
		} else {
			throw new \InvalidArgumentException("Expecting Scope or Expression");
		}
	}
	
	public function getScope() {
		return $this->expression->getScope();
	}
	
	public function setLeft($leftValue) {
		$this->expression->setLeft($leftValue);
		return $this;
	}
	
	public function setRight($rightValue) {
		$this->expression->setRight($rightValue);
		return $this;
	}
	
	public function setMid($midValue) {
		$this->expression->setMid($midValue);
		return $this;
	}
	
	public function __toString() {
		return $this->stringBefore().$this->expression.$this->stringAfter();		
	}
	
	public function __get($var) {
		if ('scope' === $var) {
			return $this->expression->getScope();
		}
	}
	
	protected function stringBefore() {
		return '';
	}
	
	protected function stringAfter() {
		return '';
	}
}
