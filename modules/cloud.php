<?php
$module_list [] = new Cloud ();

class Cloud extends Module {
	public $style = "cloud";
	
	private $id = 0;
	
	private $random_color = true;
	private $title_color = "white";
	private $title_size = "20";
	
	public $objs = array();
	const OBJ_TITLE = "title";
	protected $colors = array("0","1","2","3","4","5","6","7","8","9","a","b","c","d","e","f");
	
	protected function readPara($view) {
		parent::readPara($view);
		
		$this->height = getVal($view,"height",-1);
		$this->random_color = getVal($view,"random-color",false);
		$this->title_color = getVal($view,"title-color","white");
		$this->title_size = getVal($view,"title-size",20);
	}
	
	protected function randomColor() {
		$ary = array();
		
		if(!$this->random_color) {
			$ary[0] = $this->title_color;
			$ary[1] = $this->title_color;
			return $ary;
		}
		
		$color = "#";
		$color2 = "#";
		for ($i = 0; $i < 6; $i++) {
			$num = rand(0,15);
			$color = $color.$this->colors[$num];
			$color2 = $color.$this->colors[15 - $num];
		}
		$ary[0] = $color;
		$ary[1] = $color2;
		return $ary;
	}
	
	protected function encode($objects) {
		// init
		$this->id++;
		$this->outter_css = "";
		$obj_id = 0;
		$this->objs = array();
		
		// get number of elements
		$number = 0;
		foreach($objects as $object){ // calculate the summary
			$number++;
		}
		if($this->height == -1) {
			//$this->height = floor($this->title_size * $number * 0.5);
			$this->height = $this->width * 0.5;
		}
		
		// genCSS
		$tmp = $this->inner_css;
		$tmp = str_replace("[ID]",$this->id,$tmp);
		$tmp = str_replace("[HEIGHT]",$this->height,$tmp);
		$this->outter_css = $tmp;
		
		$angle = 0;
		$des = 0;
		foreach($objects as $object){ // loop each people range
			$obj_id++; // mark obj as obj_id
			$this->objs[$obj_id] = array();
			$tmp = $this->inner_css2;
			
			//$angle += rand(30,90);
			//$des = rand(0,1000)/3000;
			$angle += 40;
			$des = sin($obj_id*199)*0.35;
			
			$b_title = getVal($object, "title", "");
			$b_title_size = getVal($object, "title-size", $this->title_size);
			$b_colors = $this->randomColor();
			$b_x_sin = 0.5 + sin($angle/360*pi()) * $des;
			$b_y_sin = 0.5 + cos($angle/360*pi()) * $des;
			$b_x = $this->width  * $b_x_sin;
			$b_y = $this->height * $b_y_sin;
			
			$this->objs[$obj_id][self::OBJ_TITLE] = $b_title;
			
			$tmp = str_replace("[ID]",$this->id,$tmp);
			$tmp = str_replace("[OBJ_ID]",$obj_id,$tmp);
			$tmp = str_replace("[TITLE_COLOR]",$b_colors[0],$tmp);
			$tmp = str_replace("[TITLE_SIZE]",$b_title_size,$tmp);
			$tmp = str_replace("[TITLE_X]",$b_x,$tmp);
			$tmp = str_replace("[TITLE_Y]",$b_y,$tmp);
			
			$this->outter_css = $this->outter_css.' '.$tmp;
		}
	}
	
	protected function displayContent($objects) {
		// render
		$obj_id = 0;
		
		// gen objects
		echo '<div class="cloud_'.$this->id.' clearfix_after">';
		
		foreach($objects as $object){ // loop each people range
			$obj_id++;
			echo '
			<div class="obj_'.$obj_id.'">
				<p>'.$this->objs[$obj_id][self::OBJ_TITLE].'</p>
			</div>';
		}
		echo '</div>';
	}
	
	public $inner_css = '
	.cloud_[ID] {
		position: relative;
		text-align:justify;
		height:[HEIGHT]px;
	}
	';
	
	public $inner_css2 = '
	.cloud_[ID] .obj_[OBJ_ID] {
		color: [TITLE_COLOR];
		font-size:[TITLE_SIZE]px;
		position: absolute;
		left: [TITLE_X]px;
		top: [TITLE_Y]px;
	}
	';
}

?>