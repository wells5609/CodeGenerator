<?php

namespace CodeGen;

interface ObjectInterface 
{
		
	/**
	 * @return \CodeGen\Canvas
	 */
	public function getCanvas();
	
	/**
	 * @return string
	 */
	public function getName();
	
	/**
	 * @return string
	 */
	public function __toString();
	
}
