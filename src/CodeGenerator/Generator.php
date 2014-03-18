<?php

namespace CodeGenerator;

class Generator {
	
	protected $template;
	
	protected function phpStart(){
		return '<?php'. blankLine();
	}
	
	protected function generateNamespace(GeneratedObject $obj) {
		
		if (isset($obj->namespace)) {
			return "namespace $obj->namespace;". blankLine();
		}
		
		return '';
	}
	
	protected function generateUses(GeneratedObject $obj) {
		
		$str = '';
		
		if (! empty($obj->uses)) {
			foreach($obj->uses as $class) {
				$str .= "use $class;\n";
			}
			$str .= n();
		}
		
		return $str;
	}
	
	public static function generateFromTemplate( $template ) {
		
		$contents = file_get_contents($template);
		
		//...
	}
	
}

function n(){
	return "\n";
}

function t(){
	return "\t";
}

function nt(){
	return "\n\t";
}

function blankLine(){
	return "\n\n";
}
