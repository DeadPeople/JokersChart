<?php
$module_list [] = new Sector ();

class Sector extends Module {
	public $style = "sector";
	
	private $id = 0;
	
	private $radius = 0;
	private $title_color = "#FFF";
	private $value_color = "#FFF";
	private $background_color = "#FFF";
	private $distance = "#FFF";
	
	public $objs = array();
	const OBJ_DES = "des";
	const OBJ_PATH = "path";
	const OBJ_TITLE = "title";
	const OBJ_PERCENT = "percent";
	const OBJ_POSITION_VALUE_X = "position_value_x";
	const OBJ_POSITION_VALUE_Y = "position_value_y";
	const OBJ_POSITION_TITLE_X = "position_title_x";
	const OBJ_POSITION_TITLE_Y = "position_title_y";
	
	protected function readPara($view) {
		$this->radius = getVal($view,"radius",200);
		$this->title_color = getVal($view,"title-color","white");
		$this->value_color = getVal($view,"value-color","white");
		$this->background_color = getVal($view,"background-color","gray");
		$this->distance = getVal($view,"distance","0");
		parent::readPara($view);
	}
	
	protected function encode($objects) {
		// init
		$this->id++;
		$this->outter_css = "";
		$obj_id = 0;
		
		$tmp = $this->inner_css;
		$tmp = str_replace("[ID]",$this->id,$tmp);
		
		$my_des = $this->radius * 3;
		
		$tmp = str_replace("[HEIGHT]",$my_des,$tmp);
		$tmp = str_replace("[WIDTH]",$my_des,$tmp);
		$tmp = str_replace("[TITLE_SIZE]",$this->radius * 0.25,$tmp);
		$this->outter_css = $tmp;
		
		$summary = 0;
		$number = 0;
		
		foreach($objects as $object){ // calculate the summary
			$summary += getVal($object, "value", 0);
			$number++;
		}
		if($number == 0) $number = 1;
		
		//------- init pie view
		$basePointX     = $my_des/2;
		$basePointY     = $my_des/2;
		$angleSum1      = 0;
		$angleSum2      = 0;
		//-------
		
		foreach($objects as $object){ // loop each people range
			$obj_id++; // mark obj as obj_id
		
			$tmp = $this->inner_css2;
			
			$b_value = getVal($object, "value", 0);
			$b_percent = floor($b_value / $summary * 100)/10;
			$b_title = getVal($object, "title", "");
			$b_title_color = getVal($object, "title-color", $this->title_color);
			$b_value_color = getVal($object, "value-color", $this->value_color);
			$b_describe = getVal($object, "describe", "");
			$b_background_color = getVal($object, "background-color", $this->background_color);
			$b_distance = getVal($object, "distance", $this->distance);
			
			if($b_percent == floor($b_percent)) $b_percent = $b_percent.".0";
			
			$tmp = str_replace("[ID]",$this->id,$tmp);
			$tmp = str_replace("[OBJ_ID]",$obj_id,$tmp);
			
			$tmp = str_replace("[OBJ_TITLE_COLOR]",$b_title_color,$tmp);
			$tmp = str_replace("[OBJ_VALUE_COLOR]",$b_value_color,$tmp);
			$tmp = str_replace("[OBJ_BACK_COLOR]",$b_background_color,$tmp);
			
			// draw pie
		    $currentX       = 0;
		    $currentY       = 0;
		    $offsetX1       = 0; // new postion range
		    $offsetY1       = 0;
		    $offsetX2       = 0;
		    $offsetY2       = 0;
		    $offsetXt       = 0; // txt position - title
		    $offsetYt       = 0;
		    $offsetXv       = 0; // txt position - value
		    $offsetYv       = 0;
		    $offsetXb       = 0; // txt position - block
		    $offsetYb       = 0;
		    $radius         = $this->radius;
			$angle          = 360 * $b_value / $summary;
			
			$angleSum2 = $angleSum1 + $angle;
			$offsetX1 = $radius * cos($angleSum1*pi()/180);
			$offsetY1 = $radius * sin($angleSum1*pi()/180);
			$offsetX2 = $radius * cos($angleSum2*pi()/180);
			$offsetY2 = $radius * sin($angleSum2*pi()/180);
			
			$v_percet = 0.5 + (5 - $b_percent) / 30;
			$offsetXv =  $radius*$v_percet * cos(($angleSum1+$angleSum2)/2*pi()/180) + $basePointX;
			$offsetYv = -$radius*$v_percet * sin(($angleSum1+$angleSum2)/2*pi()/180) + $basePointY;
			
			$t_percet = 1.25;
			$offsetXt =  $radius*$t_percet * cos(($angleSum1+$angleSum2)/2*pi()/180) + $basePointX;
			$offsetYt = -$radius*$t_percet * sin(($angleSum1+$angleSum2)/2*pi()/180) + $basePointY;
			
			$offsetXb =  $b_distance * cos(($angleSum1+$angleSum2)/2*pi()/180);
			$offsetYb = -$b_distance * sin(($angleSum1+$angleSum2)/2*pi()/180);
			//echo "<br/>";
			$tmp = str_replace("[OBJ_X]",$offsetXb,$tmp);
			$tmp = str_replace("[OBJ_Y]",$offsetYb,$tmp);
			
			$currentX = $basePointX+$offsetX2;
			$currentY = $basePointY-$offsetY2;
			
			$offsetY1 *= -1;
			
			$pointPath = "M".$basePointX.",".$basePointY;
			$pointPath = $pointPath." l".$offsetX1.",".$offsetY1;
			
			if($angle < 180 ) {
				$pointPath = $pointPath." A".$radius.",".$radius." 0 0 0 ";
			} else {
				$pointPath = $pointPath." A".$radius.",".$radius." 0 1 0 ";
			}
			$pointPath = $pointPath.$currentX.",".$currentY;
			$pointPath = $pointPath." L".$basePointX.",".$basePointY."z";
			$fillColor  = "fill:white";
			
			$angleSum1 = $angleSum2;
			
			$this->objs[$obj_id][self::OBJ_TITLE] = $b_title;
			$this->objs[$obj_id][self::OBJ_DES] = $my_des;
			$this->objs[$obj_id][self::OBJ_PATH] = $pointPath;
			$this->objs[$obj_id][self::OBJ_PERCENT] = $b_percent;
			$this->objs[$obj_id][self::OBJ_POSITION_VALUE_X] = $offsetXv;
			$this->objs[$obj_id][self::OBJ_POSITION_VALUE_Y] = $offsetYv;
			$this->objs[$obj_id][self::OBJ_POSITION_TITLE_X] = $offsetXt;
			$this->objs[$obj_id][self::OBJ_POSITION_TITLE_Y] = $offsetYt;
			
			$this->outter_css = $this->outter_css.' '.$tmp;
		}
	}
	
	protected function displayContent($objects) {
		// render
		$obj_id = 0;
		
		// gen objects
		echo '<div class="sector_'.$this->id.' clearfix_after">';
		
		foreach($objects as $object){ // loop each people range
			$obj_id++;
			
			echo '
			<div class="obj obj_'.$obj_id.'">
				<svg width="'.$this->objs[$obj_id][self::OBJ_DES].'" 
				height="'.$this->objs[$obj_id][self::OBJ_DES].'" version="1.1"
				xmlns="http://www.w3.org/2000/svg"
				>
					<path d="'.$this->objs[$obj_id][self::OBJ_PATH].'" />
					<text 	x="'.$this->objs[$obj_id][self::OBJ_POSITION_VALUE_X].'" 
							y="'.$this->objs[$obj_id][self::OBJ_POSITION_VALUE_Y].'">
							'.$this->objs[$obj_id][self::OBJ_PERCENT].'
					</text>
					<text 	x="'.$this->objs[$obj_id][self::OBJ_POSITION_TITLE_X].'" 
							y="'.$this->objs[$obj_id][self::OBJ_POSITION_TITLE_Y].'">
						'.$this->objs[$obj_id][self::OBJ_TITLE].'
					</text>
				</svg>
			</div>';
		}
		echo '</div>';
	}
	
	public $inner_css = '
	.sector_[ID] {
		text-align:justify;
		height: [HEIGHT]px;
		width: [WIDTH]px;
		position: relative;
		margin: 0 auto;
	}
	
	.sector_[ID] .obj {
		position: absolute;
	}
	
	.sector_[ID] .obj svg text {
		font-size:[TITLE_SIZE]px;
		font-weight: bolder;
		font-family: Microsoft YaHei, SimHei, Tahoma, Verdana, STHeiTi, simsun, sans-serif;
		letter-spacing: -3px;
		text-anchor:middle;
		alignment-baseline:  middle ;
	}
	';
	
	public $inner_css2 = '
	.sector_[ID] .obj_[OBJ_ID] {
		left: [OBJ_X]px;
		top: [OBJ_Y]px;
	}
	
	.sector_[ID] .obj_[OBJ_ID] svg path {
		fill:[OBJ_BACK_COLOR];
	}
	
	.sector_[ID] .obj_[OBJ_ID] svg text {
		fill:[OBJ_VALUE_COLOR];
	}
	
	.sector_[ID] .obj_[OBJ_ID] svg text + text {
		fill:[OBJ_TITLE_COLOR];
	}
	';
}

?>