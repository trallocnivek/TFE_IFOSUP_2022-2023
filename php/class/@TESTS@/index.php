<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PHP CLASS HTML CSS</title>
	<style>
		*{
			font-family: Arial, sans-serif;
			font-size: 24px;
			tab-size: 4;
			background: black;
			color: red;
		}
		table, tr, th, td{
			all: initial;
		}
		.pointer{cursor: pointer;}
		h1{color: lime;}
	</style>
</head>
<body>
<?php
	/*include_once "HTML.class.php";
	function code(string $code, $get, $method, $data = null, $print = true){
		if($print) echo htmlspecialchars(strtoupper($code)::$get($method, $data)) . PHP_EOL;
		else echo strtoupper($code)::$get($method, $data) . PHP_EOL;
	}
	function code2(string $code, $method, $data, $print = true){
		if($print) echo htmlspecialchars(strtoupper($code)::$method($data)) . PHP_EOL;
		else echo strtoupper($code)::$method($data) . PHP_EOL;
	}*/
	function indent($x){
		$result = '';
		for($i = 0; $i < $x; $i++) $result .= " \t";
		return $result;
	}
	function dump_string($x){
		return (is_string($x) ? '\'' : '') . $x . (is_string($x) ? '\'' : '');
	}
	function dump_type($x){
		return '<font color=#888a85>=&gt;</font> <small>' . gettype($x) . '</small>';
	}
	function dump_size($type, $size){
		return '<i>(' . $type . '=' . $size . ')</i>';
	}
	function dump_line($indent, $k, $v, $type, $size){
		return indent(++$indent) . dump_string($k) . ' ' . dump_type($k) . ' ' . dump_string($v) . ' ' . dump_size($type, $size);
	}
	function dump_array_size($indent, $array){
		return indent($indent) . '<b>' . gettype($array) . '</b> <i>(size=' . count($array) . ')</i>' . PHP_EOL;
	}
	function dump_array($indent, $array, $k){
		return indent($indent) . dump_string($k) . ' <font color=#888a85>=&gt;</font> ' . PHP_EOL;
	}
	function dump_object_size($indent, $object, $type = 'unknow', $extends = ''){
		return indent($indent) . '<b>' . gettype($object) . '</b>( <i>' . get_class($object) . '</i> )[ <i>' . $type . '</i> ]' 
				. (!empty($extends) ? ' : string ' . dump_string($extends) . ' ' . dump_size('length', strlen($extends)) : '') 
				. ($type == 'extends' && empty($extends) ? PHP_EOL . indent($indent + 1) . ' <i>empty</i>' : '') . PHP_EOL
		;
	}
	function dump_object_line($indent, $k, $v){
		return indent($indent) . dump_string($k) . ' ' . dump_type($v) . ' ' . dump_string($v) . ' ' . dump_size('length', strlen($v));
	}
	function dump_size_type($x, $indent = 1){
		switch(strtolower(gettype($x))){
			case 'array': return dump_array_size($indent, $x);
			case 'object': return dump_object_size($indent, $x);
			default: return dump_size('length', strlen($x));
		}
	}
	function dump_object_property($indent, $static, $visibility, $property, $value){
		return indent($indent) . (!empty($static) ? '<b>static</b> ' : '') . '<i>' . $visibility . '</i> ' . dump_string($property) . ' ' . dump_type($value) . ' ' . dump_string($value) . ' ' . dump_size_type($value, $indent);
	}
	function dump_build($indent, $data, $new = false, $object = false){
		$result = '';
		if(is_array($data)){
			if((bool) $new) $result .= dump_array_size($indent, $data);
			else $indent--;
			foreach($data as $k => $v){
				if(is_array($v)){
					$result .= dump_array(++$indent, $data, $k) . dump_array_size(++$indent, $v) . dump_build($indent + 1, $v);
					if(empty($v)){
						$result .= indent(++$indent) . '<i>empty</i>' . PHP_EOL;
						$indent--;
					}
					$indent -= 2;
				}
				else if(is_object($v)){
					$result .= dump_array(++$indent, $data, $k) . dump_object_size(++$indent, $v);
					$result .= dump_build($indent + 1, $v);
					$indent -= 2;
				}
				else if(is_string($v) || is_numeric($v)) $result .= dump_line($indent, $k, $v, 'length', strlen($v)) . PHP_EOL;
			}
		}else if(is_object($data)){
			$class = get_class($data);
			$reflex = new ReflectionClass($class);
			$list['interfaces'] = $reflex->getInterfaceNames();
			$list['extends'] = $reflex->getParentClass()->getName();
			$list['traits'] = $reflex->getTraitNames();
			$list['constants'] = $reflex->getConstants();
			$list['properties'] = $reflex->getProperties();
			// $list['methods'] = $reflex->getMethods();

			$result .= dump_object_size($indent, $data, 'interfaces');
			if(!empty($list['interfaces'])) foreach($list['interfaces'] as $k => $v) $result .= dump_object_line($indent + 1, $k, $v) . PHP_EOL;
			else $result .= indent($indent) . '<i>empty</i>' . PHP_EOL;
			$result .= dump_object_size($indent, $data, 'extends', $list['extends']);
			$result .= dump_object_size($indent, $data, 'traits');
			if(!empty($list['traits'])) foreach($list['traits'] as $k => $v) $result .= dump_object_line($indent + 1, $k, $v) . PHP_EOL;
			else $result .= indent($indent + 1) . '<i>empty</i>' . PHP_EOL;
			$result .= dump_object_size($indent, $data, 'constants');
			if(!empty($list['constants'])) foreach($list['constants'] as $k => $v) $result .= dump_object_line($indent + 1, $k, $v) . PHP_EOL;
			else $result .= indent($indent + 1) . '<i>empty</i>' . PHP_EOL;
			$result .= dump_object_size($indent, $data, 'properties');
			if(!empty($list['properties'])){
				foreach($list['properties'] as $k => $v){
					$obj = new ReflectionProperty($class, $v->getName());
					$static = $obj->isStatic();
					$visibility = $obj->isPrivate() ? 'private' : ($obj->isProtected() ? 'protected' : 'public');
					$property = $obj->getName();	
					$test = $reflex->getProperty($property);
					$test->setAccessible(true);
					$value = $test->getValue($data);
					$result .= dump_object_property($indent + 1, $static, $visibility, $property, $value) . PHP_EOL;
				}
			}
			else $result .= indent($indent + 1) . '<i>empty</i>' . PHP_EOL;

			$result .= '';

			// var_dump($list['constants']);
		}
		return $result;
	}
	function dump(){
		$args = func_get_args();
		foreach($args as $val){
			if(!is_array($val) && !is_object($val)){
				$type = '<small>' . gettype($val) . '</small>';
				$elem = '<font color=#cc0000>\'' . $val . '\'</font>';
				$length = '<i>(length=' . strlen($val) . ')</i>';
				$string = $type . ' ' . $elem . ' ' . $length;
			} else $string = '';
			echo '<pre class=xdebug-var-dump dir=ltr style="tab-size: 2;">';
			echo '<small>' . realpath(__FILE__) . ':' . debug_backtrace()[0]['line'] . ':</small>' . $string . PHP_EOL;
			if(is_array($val) || is_object($val)) echo dump_build(0, $val, true);
			echo '</pre>' . PHP_EOL;
		}
	}
	$array = [
		'test' => ['bug', 'chat'],
		'index' => 'valeur',
		0 => 'truc',
		1 => ['baise', 'new' => ['hugh']],
		'array'
	];
	$array0 = [
    	"foo" => "bar",
    	42 => 24,
    	"multi" => [
         	"dimensional" => [
             	"array" => "foo"
         	]
    	]
	];
	interface I{

	}
	interface B{

	}
	trait machin{
		public function bizare(){}
	}
	abstract class Retest{
		public function test(){return 'test';}
	}
	class Test extends Retest implements I, B{
		public $a = null;
		private $b = 'test';
		protected $c = 5;
		public $d = 'fuck';
		static public $e = '';
		public $f;
		public $g = '';
		use machin;
		public function __construct(){
			return parent::test();
		}
		public function test(){}
		private function retest(){}
		protected function reretest(){}
	}
	$object = new Test;
	echo '<h1>TEST ZONE :</h1>';
	// dump($array, $array0, $object, 'test_VD');
	// dump('$array');
	dump($array, $object);
	echo '<h1>VAR_DUMP ZONE :</h1>';
	var_dump($object);
	// var_dump($object);
	// var_dump($array0);
	// var_dump($array, 'test');
	// var_dump('$array');
	// $index = 'index';
	// $new = array_splice($array, array_search($index, array_keys($array)), 1);
	// var_dump($new);
	// var_dump($array);
?>
</body>
</html>