<?php
$module_list = array ();

class Module {
	public static $global_width = 0;
	
	public $style = "module";
	public $inner_css = "";
	public $outter_css = "";
	
	public $width = -1;
	public $_titleColor = "white";
	public $_describeColor = "white";
	public $_describeContent = "";
	
	public function displayView($view) {
		// init value
		$this->readPara($view);
			
		// print block view
		echo '<div class="view_block" style="
			background:'.getVal($view, "background", "black").';
			width:'.$this->width.'px;
		">';
		
		// print title
		$this->displayTitle($view->{"title"});
		// encode content view
		$this->encode($view->{'objects'});
		// print content view
		$this->displayContent($view->{'objects'});
		// print css
		$this->displayCSS();
		// print describe
		$this->displayDescribe();
		
		echo '</div>';
	}
	
	protected function displayTitle($title) {
		echo '
			<h2 style="color:'.$this->_titleColor.';">
				'.$title.'
			</h2>
		';
	}
	
	protected function encode($view) {}
	
	protected function displayContent($objects) {}
	
	protected function displayCSS() {
		echo '
			<style type="text/css">
				'.$this->outter_css.'
			</style>
		';
	}
	
	protected function displayDescribe() {
		echo '
			<p class="describe" style="color:'.$this->_describeColor.'">
				'.$this->_describeContent.'
			</p>
		';
	}
	
	protected function readPara($view) {
		$this->width = getVal($view, "width", Module::$global_width);
		$this->_titleColor = getVal($view, "color", "white");
		$this->_describeColor = getVal($view, "describe-color", "white");
		$this->_describeContent = getVal($view, "describe", "");
	}
	
	public static function getVal($ary, $key, $default) {
		 if(isset($ary->{$key})) {
		 	return $ary->{$key};
		 }
		 return $default;
	}
}

// require all
$modules = glob("modules/*.php");
foreach ( $modules as $m ) {
	require_once($m);
}

// find module in list.
function getModule($style) {
	global $module_list;
	foreach ( $module_list as $m ) {
		if($style == $m->style) {
			return $m;
		}
	}
	return NULL;
}
?>