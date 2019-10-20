<?php
//Clase PHP para trabajar con archivos XML. CRUD...
/*
	Copyright (c) 2017 Arturo Vásquez Soluciones de Sistemas 2716
	Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
	The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

class artui{
	private $xmldir,$archivofis;
	private $valores=array();
	private $clases=array();
	private $class_ppal=array();
	private $nodos=array();
	private $perte=array();
	private $estrucxml_arr=array();
	private $archivoconf=array();
	private $menu_padre=array();
	private $submenu_padre=array();
	private $linkmenu_padre=array();
	private $pertenece_padre=array();
	private $niveles=array();
	private $cant_clases=0;
	private $cant_nodos=0;
	private $estrucxml,$anode,$encodetext,$nmclass,$mdcstr,$encodestat;
	private $primeravez=0;
	private $etiqcier;
	private $index_menu=0;
	private $index_submenu=0;
	private $index_linksubmenu=0;
	private $index_niveles=0;
	private $lastmenu;
	private $menudir,$menuhtmldir;
	private $namefilemenu;
	private $childs;
	private $cantmenuppal;
	private $i=0;
	private $u=0;
	//variables de los menus///////////////////////////////////////////////////
	private $lcabecera,$hcabecera,$lmenu,$hmenu,$nmenu,$forecabecera,$foremenu;
	///////////////////////////////////////////////////////////////////////////
	//IMPRIMIR CONTROLES HTML
	//PRINTHTML
	
	///Condition 1 – Presence of a static member variable
	private static $_instance = null;
	
	///Condition 2 – Locked down the constructor
	private function __construct() { } //Prevent any oustide instantiation of this class
	
	///Condition 3 – Prevent any object or instance of that class to be cloned
	private function __clone() { } //Prevent any copy of this object
	
	///Condition 4 – Have a single globally accessible static method
	public static function getInstance(){
		if( !is_object(self::$_instance) ) //or if( is_null(self::$_instance) ) or if( self::$_instance == null )
		self::$_instance = new artui();
		return self::$_instance;
	}
	
	function html($cadena){
		echo($cadena);
		return 0;
	}
	function input(){
		// 0 name 1 id 2 type 3 value (optional)
		if (func_num_args() == 0) {
    		die("You need to specify at least 3 arguments");
  		}
		else{
			if(func_num_args()>0 && func_num_args()<5){
		    	$name = func_get_arg(0);
				$id = func_get_arg(1);
				$type = func_get_arg(2);
				$value = func_get_arg(3);
				if(!empty($value)){
					$valuestr="value='".$value."'";
				}
				else{
					$valuestr="";
				}

				$inputstr="<input class='form-control' name='".$name."' id='".$id."' type='".$type."' ".$valuestr.">";
				$this->html($inputstr);
		    return;
			}
    	}
		return -1;
	}
	
	function textarea($nameid){
		$value="";
		$arguments=func_num_args();
		if (func_num_args() == 0) {
    		die("You need to specify at least 3 arguments");
  		}
		if($arguments[1]!=undefined){
			$value=$arguments[1];
		}
		echo("<textarea name='".$nameid."' id='".$nameid."'>".$value."</textarea>");
		return 0;
	}
	
	function button(){
		// 0 name 1 id 2 type 3 value (optional)
		if (func_num_args() == 0) {
    		die("You need to specify at least 3 arguments");
  		}
		else{
			if(func_num_args()>0 && func_num_args()<4){
		    $name = func_get_arg(0);
				$id = func_get_arg(1);
				$value = func_get_arg(2);
				if(!empty($value)){
					$valuestr=$value;
				}
				else{
					$valuestr="";
				}
				$inputstr="<button class=\"btn btn-primary\" name='".$name."' id='".$id."' type='button'>".$valuestr."</button>";
				$this->html($inputstr);
		    return;
			}
    }
		return -1;
	}
	function reset(){
		// 0 name 1 id 2 type 3 value (optional)
		if (func_num_args() == 0) {
    		die("You need to specify at least 3 arguments");
  		}
		else{
			if(func_num_args()>0 && func_num_args()<4){
		    $name = func_get_arg(0);
				$id = func_get_arg(1);
				$value = func_get_arg(2);
				if(!empty($value)){
					$valuestr=$value;
				}
				else{
					$valuestr="";
				}
				$inputstr="<button class=\"btn btn-primary\" name='".$name."' id='".$id."' type='reset'>".$valuestr."</button>";
				$this->html($inputstr);
		    return;
			}
    }
		return -1;
	}
	function submit(){
		// 0 name 1 id 2 type 3 value (optional)
		if (func_num_args() == 0) {
    		die("You need to specify at least 3 arguments");
	  	}
		else{
			if(func_num_args()>0 && func_num_args()<4){
		    $name = func_get_arg(0);
				$id = func_get_arg(1);
				$value = func_get_arg(2);
				if(!empty($value)){
					$valuestr=$value;
				}
				else{
					$valuestr="";
				}
				$inputstr="<button class=\"btn btn-primary\" name='".$name."' id='".$id."' type='submit'>".$valuestr."</button>";
				$this->html($inputstr);
		    	return;
			}
	    }
		return -1;
	}
	function select(){
		// 0 name 1 id 2 type 3 value (optional)
		if (func_num_args() == 0) {
			die("You need to specify at least 3 arguments");
		}
		else{
			if(func_num_args()>0){
				$nameid=func_get_arg(0);
				$arrayOpt=func_get_arg(1);
				$strOptions="";
				
				if(!is_array($arrayOpt)){
					die("Argument[2] MUST BE an ARRAY");
				}
				for($i=0;$i<count($arrayOpt);$i++){
					$val= $arrayOpt[$i];
					$strOptions.="<option value='".$val."'>".$val."</option>";
				}
				$inputstr="<select class='form-control' name='".$nameid."' id='".$nameid."'>".$strOptions."</select>";
				$this->html($inputstr);
				return;
			}
		}
		return -1;
	}
	function br($cadena){
		$this->html("<br\>");
	}
}
?>
