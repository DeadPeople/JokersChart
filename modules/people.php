<?php
$module_list [] = new People ();

class People extends Module {
	public $style = "people";
	
	private $id = 0;
	
	protected function encode($objects) {
		// init
		$this->id++;
		$this->outter_css = "";
		$obj_id = 0;
		
		// genCSS
		foreach($objects as $object){ // loop each people range
			$obj_id++;
			$tmp = $this->inner_css;
			
			$color = $this->getVal($object, 'color', 'black');
			$size = $this->getVal($object, 'size', 33);
			$size_hand = floor($size / 4) - 1;
			$size_body = $size - $size_hand * 2 - 2;
			$size_body_height = floor($size_hand * 4.3);
			$size_foot = floor(($size_body - 1) / 2);
			$size_foot_height = floor($size_body_height * 1.2);
			$size_height = $size_hand + 1 + $size_body_height + $size_foot_height;
			
			$tmp = str_replace("[ID]",$this->id,$tmp);
			$tmp = str_replace("[OBJ_ID]",$obj_id,$tmp);
			$tmp = str_replace("[COLOR]",$color,$tmp);
			$tmp = str_replace("[SIZE]",$size,$tmp);
			$tmp = str_replace("[SIZE_HEIGHT]",$size_height,$tmp);
			$tmp = str_replace("[SIZE_BODY]",$size_body,$tmp);
			$tmp = str_replace("[HEIGHT_BODY]",$size_body_height,$tmp);
			$tmp = str_replace("[LEFT_BODY]",$size_hand+1,$tmp);
			$tmp = str_replace("[RIGHT_BODY]",$size - $size_hand,$tmp);
			$tmp = str_replace("[TOP_BODY]",$size_body+1,$tmp);
			$tmp = str_replace("[SIZE_HAND]",$size_hand,$tmp);
			$tmp = str_replace("[SIZE_FOOT]",$size_foot,$tmp);
			$tmp = str_replace("[HEIGHT_FOOT]",$size_foot_height,$tmp);
			$tmp = str_replace("[TOP_FOOT]",$size_height - $size_foot_height,$tmp);
			$tmp = str_replace("[RIGHT_FOOT]",$size - $size_hand - 1 - $size_foot,$tmp);
			
			$this->outter_css = $this->outter_css.' '.$tmp;
		}
	}
	
	protected function displayContent($objects) {
		// render
		$obj_id = 0;
		foreach($objects as $object){ // loop each people range
			$obj_id++;
			for ($i = 0; $i <= $object->{'value'}; $i++) {
				echo '
				<span class="people_'.$this->id.'_'.$obj_id.'">
					<span class="circle head"></span>
					<span class="circle hand"></span>
					<span class="circle hand"></span>
					<span class="       body"></span>
					<span class="circle body"></span>
					<span class="circle foot"></span>
					<span class="circle foot"></span>
				</span>';
			}
		}
	}
	
	public $inner_css = '
	.people_[ID]_[OBJ_ID] {
		width:[SIZE]px;
		height:[SIZE_HEIGHT]px;
		margin: 0 5px 5px 0;
		position:relative;
		display:inline-block;
		
		/*transform: scale(0.5);
		-webkit-transform: scale(0.5);
		-moz-transform: scale(0.5);
		-ms-transform: scale(0.5);
		-o-transform: scale(0.5);*/
	}
	
	.people_[ID]_[OBJ_ID] span {
		background:[COLOR];
		
		position:absolute;
		display:block;
	}
	
	.people_[ID]_[OBJ_ID] .head {
		width:[SIZE_BODY]px;
		height:[SIZE_BODY]px;
		left:[LEFT_BODY]px;
		top:0;
	}
	
	.people_[ID]_[OBJ_ID] .hand {
		width:[SIZE_HAND]px;
		height:[HEIGHT_BODY]px;
		left:0;
		top:[TOP_BODY]px;
	}
	
	.people_[ID]_[OBJ_ID] .hand + .hand {
		left:[RIGHT_BODY]px;
	}
	
	.people_[ID]_[OBJ_ID] .body {
		width:[SIZE_BODY]px;
		height:[HEIGHT_BODY]px;
		left:[LEFT_BODY]px;
		top:[TOP_BODY]px;
	}
	
	.people_[ID]_[OBJ_ID] .body + .body {
		width:[SIZE]px;
		height:[SIZE_HAND]px;
		left:0px;
		top:[TOP_BODY]px;
	}
	
	.people_[ID]_[OBJ_ID] .foot {
		width:[SIZE_FOOT]px;
		height:[HEIGHT_FOOT]px;
		left:[LEFT_BODY]px;
		top:[TOP_FOOT]px;
	}
	
	.people_[ID]_[OBJ_ID] .foot + .foot {
		left:[RIGHT_FOOT]px;
	}
	';
}

?>