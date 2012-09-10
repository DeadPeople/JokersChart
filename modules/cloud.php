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
	
	protected function readPara($view) {
		parent::readPara($view);
		
		$this->height = getVal($view,"height",-1);
		$this->random_color = getVal($view,"random-color",true);
		$this->title_color = getVal($view,"title-color","white");
		$this->title_size = getVal($view,"title-size",20);
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
			$this->height = floor($this->title_size * $number * 0.3);
		}
		
		// genCSS
		$tmp = $this->inner_css;
		$tmp = str_replace("[ID]",$this->id,$tmp);
		$tmp = str_replace("[HEIGHT]",$this->height,$tmp);
		$this->outter_css = $tmp;
		
		
		foreach($objects as $object){ // loop each people range
			$obj_id++; // mark obj as obj_id
			$this->objs[$obj_id] = array();
			$tmp = $this->inner_css2;
			
			$b_title = getVal($object, "title", "");
			
			$this->objs[$obj_id][self::OBJ_TITLE] = $b_title;
			
			$tmp = str_replace("[ID]",$this->id,$tmp);
			$tmp = str_replace("[OBJ_ID]",$obj_id,$tmp);
			
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
		text-align:justify;
		height:[HEIGHT]px;
	}
	';
	
	public $inner_css2 = '
	.cloud_[ID] .obj_[OBJ_ID] {
		width: [BLOCK_WIDTH]%;
	}
	';
}

?>