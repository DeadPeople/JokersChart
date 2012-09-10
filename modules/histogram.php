<?php
$module_list [] = new Histogram ();

class Histogram extends Module {
	public $style = "histogram";
	
	private $id = 0;
	
	private $radius = "";
	private $color = "#FFF";
	
	public $objs = array();
	const OBJ_TITLE = "title";
	const OBJ_DESCRIBE = "describe";
	
	protected function readPara($view) {
		parent::readPara($view);
		
		$this->height = getVal($view,"height",200);
		$this->radius = getVal($view,"radius","0");
		$this->color = getVal($view,"color","white");
	}
	
	private function getRadius() {
		$ret = "";
		
		$rs = explode(",", $this->radius);
		foreach($rs as $r){ 
			$ret = $ret.' '.$r.'px';
		}
		return $ret;
	}
	
	protected function encode($objects) {
		// init
		$this->id++;
		$this->outter_css = "";
		$obj_id = 0;
		$this->objs = array();
		
		// genCSS
		$tmp = $this->inner_css;
		$tmp = str_replace("[ID]",$this->id,$tmp);
		$tmp = str_replace("[HEIGHT]",$this->height,$tmp);
		$tmp = str_replace("[RADIUS]",$this->getRadius(),$tmp);
		$tmp = str_replace("[COLOR]",$this->color,$tmp);
		$this->outter_css = $tmp;
		
		$max_value = 0;
		$number = 0;
		
		foreach($objects as $object){ // calculate the summary
			$max_value = getVal($object, "value", 0) > $max_value ? 
						 getVal($object, "value", 0) : $max_value;
			$number++;
		}
		if($number == 0) $number = 1;
		$avg_width = floor(100 / $number);
		
		foreach($objects as $object){ // loop each people range
			$obj_id++; // mark obj as obj_id
			$this->objs[$obj_id] = array();
			$tmp = $this->inner_css2;
			
			$b_value = getVal($object, "value", 0);
			$b_title = getVal($object, "title", "");
			$b_describe = getVal($object, "describe", "");
			$b_color = getVal($object, "color", $this->color);
			$b_height = floor($this->height * $b_value / $max_value);
			
			$this->objs[$obj_id][self::OBJ_DESCRIBE] = $b_describe;
			$this->objs[$obj_id][self::OBJ_TITLE] = $b_title;
			
			$tmp = str_replace("[ID]",$this->id,$tmp);
			$tmp = str_replace("[OBJ_ID]",$obj_id,$tmp);
			
			$tmp = str_replace("[BLOCK_WIDTH]",$avg_width,$tmp);
			$tmp = str_replace("[BLOCK_HEIGHT1]",$this->height - $b_height,$tmp);
			$tmp = str_replace("[BLOCK_HEIGHT2]",$b_height,$tmp);
			$tmp = str_replace("[BLOCK_HEIGHT3]",0,$tmp);
			$tmp = str_replace("[BLOCK_COLOR]",$b_color,$tmp);
			
			$this->outter_css = $this->outter_css.' '.$tmp;
		}
	}
	
	protected function displayContent($objects) {
		// render
		$obj_id = 0;
		
		// gen objects
		echo '<div class="histogram_'.$this->id.' clearfix_after">';
		
		foreach($objects as $object){ // loop each people range
			$obj_id++;
			echo '
			<div class="obj_'.$obj_id.'">
				<span><p class="des">'.$this->objs[$obj_id][self::OBJ_DESCRIBE].'</p></span>
				<span></span>
				<span></span>
				<p>'.$this->objs[$obj_id][self::OBJ_TITLE].'</p>
			</div>';
		}
		echo '<div class="end">&nbsp;</div>';
		echo '</div>';
	}
	
	public $inner_css = '
	.histogram_[ID] {
		text-align:justify;
		letter-spacing:-3px;
	}
	
	.histogram_[ID] div {
		margin: 0;
		display:inline-block;
		height: 100%;
		vertical-align: top;
	}
	
	.histogram_[ID] .end {
		width:100%;
	}
	
	.histogram_[ID] div span {
		display:block;
		position: relative;
		width:100%;
	}
	
	.histogram_[ID] div span + span {
		border-radius:[RADIUS];
	}
	
	.histogram_[ID] div span + span + span {
		border-radius:0;
	}
	
	.histogram_[ID] div span p.des {
		position: absolute;
		bottom:10px;
		padding:0;
		margin:0;
		color:[COLOR];
		font-size: 18px;
		font-family: Microsoft YaHei, SimHei, Tahoma, Verdana, STHeiTi, simsun, sans-serif;
		text-shadow:none;
		text-align: left;
	}
	
	.histogram_[ID] div p {
		text-align: center;
		font-size: 14px;
		font-weight: bolder;
		font-family: SimHei, Microsoft YaHei, Tahoma, Verdana, STHeiTi, simsun, sans-serif;
		margin-top:4px;
		text-shadow: 0 0 1px;
		letter-spacing:0px;
	}
	';
	
	public $inner_css2 = '
	.histogram_[ID] .obj_[OBJ_ID] {
		width: [BLOCK_WIDTH]%;
	}
	
	.histogram_[ID] .obj_[OBJ_ID] span {
		height:[BLOCK_HEIGHT1]px;
	}
	
	.histogram_[ID] .obj_[OBJ_ID] span + span {
		background:[BLOCK_COLOR];
		height:[BLOCK_HEIGHT2]px;
	}
	
	.histogram_[ID] .obj_[OBJ_ID] span + span + span {
		height:[BLOCK_HEIGHT3]px;
	}
	
	.histogram_[ID] .obj_[OBJ_ID] p {
		color : [BLOCK_COLOR];
	}
	';
}

?>