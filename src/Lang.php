<?php

namespace CodeGen;

abstract class Lang
{
	const OPER_ASSIGN = '=';
	const OPER_ADD = '+';
	const OPER_SUB = '-';
	const OPER_MULT = '*';
	const OPER_DIV = '/';
	const OPER_CONCAT = '.';
	const OPER_BITWISE_CONCAT = '|';
	
	const CMP_EQUAL = '==';
	const CMP_IDENTICAL = '===';
	const CMP_NOT_EQUAL = '!=';
	const CMP_NOT_IDENTICAL = '!==';
	const CMP_GT = '>';
	const CMP_LT = '<';
	const CMP_GTE = '>=';
	const CMP_LTE = '<=';
	
	public static function isOperator($oper) {
		return in_array($oper, array(
			self::OPER_ASSIGN,
			self::OPER_ADD,
			self::OPER_SUB,
			self::OPER_MULT,
			self::OPER_DIV,
			self::OPER_CONCAT
		), true);
	}
	
	public static function isComparator($cmp) {
		return in_array($cmp, array(
			self::CMP_EQUAL,
			self::CMP_IDENTICAL,
			self::CMP_NOT_EQUAL,
			self::CMP_NOT_IDENTICAL,
			self::CMP_GT,
			self::CMP_LT,
			self::CMP_GTE,
			self::CMP_LTE
		), true);
	}
}
