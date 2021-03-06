<?php
$module_list [] = new Circle ();

class Circle extends Module {
	public $style = "circle";
	
	private $id = 0;
	
	private $radius = 0;
	private $title_color = "#FFF";
	private $background_color = "#FFF";
	private $usage = "50";
	private $avg_width = 0;
	private $title_size = 20;
	private $des_title = "";
	private $des_title_color = "white";
	private $des_title_size = 20;
	private $des_h = 0;
	private $des_w = 0;
	
	public $objs = array();
	const OBJ_PATH = "path";
	const OBJ_TITLE = "title";
	const OBJ_PERCENT = "percent";
	const OBJ_POSITION_CIRCLE_X = "position_circle_x";
	const OBJ_POSITION_CIRCLE_Y = "position_circle_y";
	const OBJ_POSITION_TITLE_X = "position_title_x";
	const OBJ_POSITION_TITLE_Y = "position_title_y";
	
	protected function readPara($view) {
		$this->radius = getVal($view,"radius",200);
		$this->title_color = getVal($view,"title-color","white");
		$this->background_color = getVal($view,"background-color","gray");
		$this->usage = getVal($view,"usage","50");
		$this->title_size = getVal($view,"title-size","20");
		$this->des_title = getVal($view,"des-title","");
		$this->des_title_color = getVal($view,"des-title-color","white");
		$this->des_title_size = getVal($view,"des-title-size","20");
		parent::readPara($view);
	}
	
	protected function encode($objects) {
		// init
		$this->id++;
		$this->outter_css = "";
		$obj_id = 0;
		
		$tmp = $this->inner_css;
		$tmp = str_replace("[ID]",$this->id,$tmp);
		
		$this->des_h = $this->radius * 2.2;
		$this->des_w = $this->radius * 3;
		
		//------- init pie view
		$basePointX     = $this->des_w/2;
		$basePointY     = $this->des_h/2;
		$angleSum1      = 90;
		$angleSum2      = 0;
		$top			= 0;
		
		$number 		= 0;
		foreach($objects as $object){ // calculate the summary
			$number++;
		}
		if($number == 0) $number = 1;
		$this->avg_width = ($this->usage/100) * $this->radius / $number;
		//-------
		
		$tmp = str_replace("[HEIGHT]",$this->des_h,$tmp);
		$tmp = str_replace("[WIDTH]",$this->des_w,$tmp);
		$tmp = str_replace("[DES_TITLE_COLOR]",$this->des_title_color,$tmp);
		$tmp = str_replace("[DES_TITLE_SIZE]",$this->des_title_size,$tmp);
		$tmp = str_replace("[DES_TITLE_X]",$basePointX,$tmp);
		$tmp = str_replace("[DES_TITLE_Y]",$basePointY,$tmp);
		$this->outter_css = $tmp;
		
		foreach($objects as $object){ // loop each people range
			$obj_id++; // mark obj as obj_id
		
			$tmp = $this->inner_css2;
			
			$b_value = getVal($object, "value", 0);
			$b_percent = floor($b_value)/10;
			$b_title = getVal($object, "title", "");
			$b_title_color = getVal($object, "title-color", $this->title_color);
			$b_describe = getVal($object, "describe", "");
			$b_background_color = getVal($object, "background-color", $this->background_color);
			$b_title_size = getVal($object, "title-size", $this->title_size);
			
			if($b_percent == floor($b_percent)) $b_percent = $b_percent.".0";
			
			$tmp = str_replace("[ID]",$this->id,$tmp);
			$tmp = str_replace("[OBJ_ID]",$obj_id,$tmp);
			
			$tmp = str_replace("[OBJ_TITLE_COLOR]",$b_title_color,$tmp);
			$tmp = str_replace("[OBJ_BACK_COLOR]",$b_background_color,$tmp);
			$tmp = str_replace("[OBJ_TITLE_SIZE]",$b_title_size,$tmp);
			$tmp = str_replace("[OBJ_VALUE_SIZE]",$b_title_size * 1.5,$tmp);
			
			// draw pie
		    $offsetX1       = 0; // new postion range
		    $offsetY1       = 0;
		    $offsetX2       = 0;
		    $offsetY2       = 0;
		    $offsetX3       = 0; // new postion range - 2
		    $offsetY3       = 0;
		    $offsetX4       = 0;
		    $offsetY4       = 0;
		    $offsetXt		= 0; // title position
		    $offsetYt		= 0;
		    $offsetXo		= 0; // circle position
		    $offsetYo		= 0;
		    $radius         = $this->radius - ($obj_id-1)*$this->avg_width;
		    $radius2        = $this->radius - ($obj_id-0.2)*$this->avg_width;
		    $radiusHalf     = ($radius + $radius2) / 2;
			$angle          = 360 * $b_value / 100;
			
			// painter
			$angleSum2 = $angleSum1 + $angle;
			$offsetX1 = $radius * cos($angleSum1*pi()/180);
			$offsetY1 = $radius * sin($angleSum1*pi()/180);
			$offsetX2 = $radius * cos($angleSum2*pi()/180);
			$offsetY2 = $radius * sin($angleSum2*pi()/180);
			$offsetX3 = $radius2 * cos($angleSum1*pi()/180);
			$offsetY3 = $radius2 * sin($angleSum1*pi()/180);
			$offsetX4 = $radius2 * cos($angleSum2*pi()/180);
			$offsetY4 = $radius2 * sin($angleSum2*pi()/180);
			
			$OX11 = $basePointX+$offsetX1;
			$OY11 = $basePointY-$offsetY1;
			$OX12 = $basePointX+$offsetX2;
			$OY12 = $basePointY-$offsetY2;
			$OX21 = $offsetX4-$offsetX2;
			$OY21 = $offsetY2-$offsetY4;
			$OX22 = $basePointX+$offsetX3;
			$OY22 = $basePointY-$offsetY3;
			
			// title
			$top += $b_title_size * 1.8;
			$hei = $this->radius - $top;
			
			$offsetXt = sqrt(pow($this->radius,2) - pow($hei,2));
			$offsetYt = $hei;
			$_offsetXt = floor($basePointX + $offsetXt + $b_title_size);
			$_offsetYt = floor($basePointY + $hei);
			$offsetXt = $basePointX - $offsetXt - $b_title_size;
			$offsetYt = $basePointY - $offsetYt;
			
			// circle
			$angleSum2 = asin($hei / $this->radius);
			$offsetXo = $radiusHalf * cos($angleSum2);
			$offsetYo = $radiusHalf * sin($angleSum2);
			$offsetXo = $basePointX - $offsetXo;
			$offsetYo = $basePointY - $offsetYo;
			
			
			$offsetY1 *= -1;
			
			$pointPath = "M".$OX11.",".$OY11;
			if($angle < 180 ) {
				$pointPath = $pointPath." A".$radius.",".$radius." 0 0 0 ";
			} else {
				$pointPath = $pointPath." A".$radius.",".$radius." 0 1 0 ";
			}
			$pointPath = $pointPath.$OX12.",".$OY12;
			$pointPath = $pointPath." l".$OX21.",".$OY21." ";
			if($angle < 180 ) {
				$pointPath = $pointPath." A".$radius2.",".$radius2." 0 0 1 ";
			} else {
				$pointPath = $pointPath." A".$radius2.",".$radius2." 0 1 1 ";
			}
			$pointPath = $pointPath.$OX22.",".$OY22;
			$pointPath = $pointPath." z";
			$fillColor  = "fill:white";
			
			$this->objs[$obj_id][self::OBJ_TITLE] = $b_title;
			$this->objs[$obj_id][self::OBJ_PATH] = $pointPath;
			$this->objs[$obj_id][self::OBJ_PERCENT] = $b_percent;
			$this->objs[$obj_id][self::OBJ_POSITION_CIRCLE_X] = $offsetXo;
			$this->objs[$obj_id][self::OBJ_POSITION_CIRCLE_Y] = $offsetYo;
			$this->objs[$obj_id][self::OBJ_POSITION_TITLE_X] = $offsetXt;
			$this->objs[$obj_id][self::OBJ_POSITION_TITLE_Y] = $offsetYt;
			
			$tmp = str_replace("[OBJ_TITLE_X]",$_offsetXt,$tmp);
			$tmp = str_replace("[OBJ_TITLE_Y]",$_offsetYt,$tmp);
			
			$this->outter_css = $this->outter_css.' '.$tmp;
		}
	}
	
	protected function displayContent($objects) {
		// render
		$obj_id = 0;
		
		// gen objects
		echo '<div class="circle_'.$this->id.' clearfix_after">';
		
		foreach($objects as $object){ // loop each people range
			$obj_id++;
			
			echo '
			<div class="obj obj_'.$obj_id.'">
				<div class="ctnr">
				<svg width="'.$this->des_w.'" 
				height="'.$this->des_h.'" version="1.1"
				xmlns="http://www.w3.org/2000/svg"
				>
					<path d="'.$this->objs[$obj_id][self::OBJ_PATH].'" />
					<circle cx="'.$this->objs[$obj_id][self::OBJ_POSITION_CIRCLE_X].'" 
							cy="'.$this->objs[$obj_id][self::OBJ_POSITION_CIRCLE_Y].'" 
							r="'.($this->avg_width * 0.2).'" />
					<line	x1="'.$this->objs[$obj_id][self::OBJ_POSITION_CIRCLE_X].'"
							y1="'.$this->objs[$obj_id][self::OBJ_POSITION_CIRCLE_Y].'"
							x2="'.ceil($this->objs[$obj_id][self::OBJ_POSITION_TITLE_X]-1).'"
							y2="'.ceil($this->objs[$obj_id][self::OBJ_POSITION_TITLE_Y]-1).'" />
				</svg>
				<p class="title">
					<span>'.$this->objs[$obj_id][self::OBJ_PERCENT].'</span>
					'.$this->objs[$obj_id][self::OBJ_TITLE].'
				</p>
				</div>
			</div>';
		}
		echo '
			<p class="obj key">'.$this->des_title.'</p>';
		echo '</div>';
	}
	
	public $inner_css = '
	.circle_[ID] {
		text-align:justify;
		height: [HEIGHT]px;
		width: [WIDTH]px;
		position: relative;
		margin: 0 auto;
	}
	
	.circle_[ID] .obj {
		position: absolute;
	}
	
	.circle_[ID] .obj .ctnr {
		position: relative;
		height: [HEIGHT]px;
		width: [WIDTH]px;
	}
	
	.circle_[ID] .obj .ctnr svg {
		position: absolute;
	}
	
	.circle_[ID] .obj .ctnr p.title {
		padding-right:5px;
		font-weight:bolder;
	}
	
	.circle_[ID] p.key {
		font-size:[DES_TITLE_SIZE]px;
		color:[DES_TITLE_COLOR];
		left: [DES_TITLE_X]px;
		top:[DES_TITLE_Y]px;
		text-shadow: 0 0 2px black;
	}
	';
	
	public $inner_css2 = '
	.circle_[ID] .obj_[OBJ_ID] {
		left: [OBJ_X]px;
		top: [OBJ_Y]px;
	}
	
	.circle_[ID] .obj_[OBJ_ID] .ctnr p.title {
		border-bottom:2px solid [OBJ_TITLE_COLOR];
	}
	
	.circle_[ID] .obj_[OBJ_ID] .ctnr p.title {
		color:[OBJ_TITLE_COLOR];
		font-size: [OBJ_TITLE_SIZE]px;
		position:absolute;
		right:[OBJ_TITLE_X]px;
		bottom:[OBJ_TITLE_Y]px;
	}
	
	.circle_[ID] .obj_[OBJ_ID] .ctnr p.title span {
		color:[OBJ_BACK_COLOR];
		font-size:[OBJ_VALUE_SIZE]px;
	}
	
	.circle_[ID] .obj_[OBJ_ID] .ctnr svg path {
		fill:[OBJ_BACK_COLOR];
	}
	
	.circle_[ID] .obj_[OBJ_ID] .ctnr svg circle {
		fill:[OBJ_TITLE_COLOR];
	}
	
	.circle_[ID] .obj_[OBJ_ID] .ctnr svg line {
		stroke:[OBJ_TITLE_COLOR];
		stroke-width:2;
	}
	';
}

?>