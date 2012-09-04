<?php
$module_list [] = new Line_List ();

class Line_List extends Module {
	public $style = "line_list";
	
	private $id = 0;
	
	private $height = 0;
	private $title_color = "white";
	private $line_color = "white";
	private $border_weight = "4";
	private $title_position = "left";
	
	const OBJ_TITLE = "title";
	
	protected function readPara($view) {
		$this->height = getVal($view,"height",200);
		$this->title_color = getVal($view,"title-color","white");
		$this->line_color = getVal($view,"line-color","white");
		$this->border_weight = getVal($view,"border-weight","5");
		$this->title_position = getVal($view,"title-position","left");
		
		parent::readPara($view);
	}
	
	protected function encode($objects) {
		// init
		$this->id++;
		$this->outter_css = "";
		$obj_id = 0;
		
		$padding = floor(($this->height * 0.1)/2);
		
		$tmp = $this->inner_css;
		$tmp = str_replace("[ID]",$this->id,$tmp);
		$tmp = str_replace("[HEIGHT]",$this->height,$tmp);
		$tmp = str_replace("[PADDING]",$padding,$tmp);
		$tmp = str_replace("[LINE_COLOR]",$this->line_color,$tmp);
		$tmp = str_replace("[BORDER_WEIGHT]",$this->border_weight,$tmp);
		$this->outter_css = $tmp;
		
		$number = 0;
		foreach($objects as $object){ // calculate the summary
			$number++;
		}
		if($number == 0) $number = 1;
		$avg_height = floor(($this->height) / $number);
		
		foreach($objects as $object){ // loop each people range
			$obj_id++; // mark obj as obj_id
			$tmp = $this->inner_css2;
			
			$b_title = getVal($object, "title", "");
			$b_title_color = getVal($object, "title-color", $this->title_color);
			
			$this->objs[$obj_id][self::OBJ_TITLE] = $b_title;
			
			$tmp = str_replace("[ID]",$this->id,$tmp);
			$tmp = str_replace("[OBJ_ID]",$obj_id,$tmp);
			
			$tmp = str_replace("[OBJ_COLOR]",$b_title_color,$tmp);
			$tmp = str_replace("[OBJ_TITLE_SIZE]",floor($avg_height*0.85),$tmp);
			$tmp = str_replace("[OBJ_TITLE_HEIGHT]",$avg_height,$tmp);
			
			$this->outter_css = $this->outter_css.' '.$tmp;
		}
	}
	
	protected function displayContent($objects) {
		// render
		$obj_id = 0;
		
		// gen objects
		echo '<div class="line_list_'.$this->id.' clearfix_after">';
		echo '
			<table>
				<tr>
					<td width="100%" class="describe">';
		echo '<p class="describe" style="color:'.$this->_describeColor.'">'.$this->_describeContent.'</p>';
		echo '
					</td>
					<td class="content">';
		echo '<div>';
		foreach($objects as $object){ // loop each people range
			$obj_id++; // mark obj as obj_id
			
			echo '
			<div class="obj obj_'.$obj_id.'">
				<p>'.$this->objs[$obj_id][self::OBJ_TITLE].'</p>
			</div>';
		}
		echo '</div>';
		echo '
					</td>
				</tr>
			</table>';
		echo '</div>';
	}
	
	public $inner_css = '
	.line_list_[ID] {
		height: [HEIGHT]px;
	}
	
	.line_list_[ID] table {
		width: 100%;
		height: 100%;
	}
	
	.line_list_[ID] td.content {
		padding:0 5px 0 5px;
	}
	
	.line_list_[ID] table td.content p {
		word-wrap: keep-all;
		word-break: keep-all;
		white-space:nowrap;
	}
	
	.line_list_[ID] td.describe {
		border: [BORDER_WEIGHT]px solid [LINE_COLOR];
		border-left: none;
		border-right: none;
		vertical-align: middle;
	}
	
	.line_list_[ID] td.describe p {
		padding:0;
		margin:0;
		vertical-align: middle;
		line-height:130%;
	}
	
	.line_list_[ID] .obj p {
		font-weight: bolder;
	}
	';
	
	public $inner_css2 = '
	.line_list_[ID] .obj_[OBJ_ID] p {
		color: [OBJ_COLOR];
		font-size:[OBJ_TITLE_SIZE]px;
		line-height:[OBJ_TITLE_HEIGHT]px;
	}
	';
}

?>