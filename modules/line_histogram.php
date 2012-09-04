<?php
$module_list [] = new Line_Histogram ();

class Line_Histogram extends Module {
	public $style = "line-histogram";
	
	private $id = 0;
	
	private $color = "#FFF";
	private $object_height = 0;
	private $object_background = "transparent";
	private $object_title_color = "black";
	
	public $objs = array();
	const OBJ_TITLE = "title";
	const OBJ_VALUE = "value";
	
	protected function readPara($view) {
		$this->color = getVal($view,"color","white");
		$this->object_height = getVal($view,"object-height",50);
		$this->object_background = getVal($view,"object-background","transparent");
		$this->object_title_color = getVal($view,"object-title-color","transparent");
		parent::readPara($view);
	}
	
	protected function encode($objects) {
		// init
		$this->id++;
		$this->outter_css = "";
		$obj_id = 0;
		
		$tmp = $this->inner_css;
		$tmp = str_replace("[ID]",$this->id,$tmp);
		$tmp = str_replace("[OBJECT_HEIGHT]",$this->object_height,$tmp);
		$tmp = str_replace("[OBJECT_BACKGROUND]",$this->object_background,$tmp);
		$tmp = str_replace("[TITLE_SIZE]",floor($this->object_height / 2),$tmp);
		$this->outter_css = $tmp;
		
		foreach($objects as $object){ // loop each people range
			$obj_id++; // mark obj as obj_id
			$tmp = $this->inner_css2;
			
			$b_value = getVal($object, "value", 0);
			$b_title = getVal($object, "title", "");
			$b_title_color = getVal($object, "title-color", $this->object_title_color);
			$b_front_color = getVal($object, "front-color", $this->color);
			
			$this->objs[$obj_id][self::OBJ_TITLE] = $b_title;
			$this->objs[$obj_id][self::OBJ_VALUE] = $b_value;
			
			$tmp = str_replace("[ID]",$this->id,$tmp);
			$tmp = str_replace("[OBJ_ID]",$obj_id,$tmp);
			$tmp = str_replace("[BLOCK_VALUE]",$b_value,$tmp);
			$tmp = str_replace("[BLOCK_COLOR]",$b_front_color,$tmp);
			$tmp = str_replace("[TITLE_COLOR]",$b_title_color,$tmp);
			
			
			$this->outter_css = $this->outter_css.' '.$tmp;
		}
	}
	
	protected function displayContent($objects) {
		// render
		$obj_id = 0;
		
		// gen objects
		echo '<div class="line_histogram_'.$this->id.' clearfix_after">';
		foreach($objects as $object){ // loop each people range
			$obj_id++; // mark obj as obj_id
			
			echo '
			<div class="obj obj_'.$obj_id.'">
				<span class="back"></span>
				<p>&nbsp;'.$this->objs[$obj_id][self::OBJ_TITLE].'</p>
				<p>'.$this->objs[$obj_id][self::OBJ_VALUE].'%&nbsp;</p>
			</div>';
		}
		echo '</div>';
	}
	
	public $inner_css = '
	.line_histogram_[ID] {
	}
	
	.line_histogram_[ID] .obj {
		width: 100%;
		background: [OBJECT_BACKGROUND];
		position:relative;
		height:[OBJECT_HEIGHT]px;
		margin:0 0 10px 0;
	}
	
	.line_histogram_[ID] .obj p {
		display:inline-block;
		height:[OBJECT_HEIGHT]px;
		line-height:[OBJECT_HEIGHT]px;
		position:absolute;
		font-weight:bolder;
		font-size:[TITLE_SIZE]px;
		font-family: Microsoft YaHei, SimHei, Tahoma, Verdana, STHeiTi, simsun, sans-serif;
	}
	
	.line_histogram_[ID] .obj p + p {
		right:0;
	}
	
	.line_histogram_[ID] .obj span {
		height:100%;
		position:absolute;
		left:0;
	}
	';
	
	public $inner_css2 = '
	.line_histogram_[ID] .obj_[OBJ_ID] .back {
		width:[BLOCK_VALUE]%;
		background:[BLOCK_COLOR];
	}
	
	.line_histogram_[ID] .obj_[OBJ_ID] p {
		color:[TITLE_COLOR];
	}
	';
}

?>