<?php

namespace CodeGen;

interface ExpressionInterface
{
	
	public function getScope();
	
	public function setLeft($leftValue);
	
	public function setRight($rightValue);
	
	public function setMid($midValue);
	
	public function __toString();
}
