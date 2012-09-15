<?php
$module_list [] = new D3Cloud ();

class D3Cloud extends Module {
	public $style = "d3cloud";
	
	private $id = 0;
	
	protected function readPara($view) {
		parent::readPara($view);
		
		if($this->height <= 0) $this->height = $this->width / 2;
	}
	
	protected function getCostmoizedContent() {
		return '<script type="text/javascript" src="js/d3.layout.cloud.js"></script>';
	}
	
	protected function getJS() {
		return '
		var fill = d3.scale.category20b();
		
		var layout = d3.layout.cloud().size(['.$this->width.', '.$this->height.'])
		  .words([
			"Hello", "world", "normally", "you", "want", "more", "words",
			"than", "this", "world", "normally", "you", "want", "more", "words",
			"than", "this", "world", "normally", "you", "want", "more", "words",
			"than", "this", "world", "normally", "you", "want", "more", "words",
			"than", "this", "world", "normally", "you", "want", "more", "words",
			"than", "this"].map(function(d) {
			return {text: d, size: 10 + Math.random() * 90};
		  }))
		  .rotate(function() { return ~~(Math.random() * 5) * 30 - 60; })
		  .spiral("archimedean")
		  .fontSize(function(d) { return d.size; })
		  .on("end", draw)
		  .start();
		  
		function draw(words) {
		d3.select("#d3cloud_'.$this->id.'").append("svg")
			.attr("width" , '.$this->width.')
			.attr("height", '.$this->height.')
		  .append("g")
			.attr("transform", "translate('.($this->width/2).','.($this->height/2).')")
		  .selectAll("text")
			.data(words)
		  .enter().append("text")
			.style("font-size", function(d) { return d.size + "px"; })
			.style("fill", function(d) { return fill(d.text.toLowerCase()); })
			.attr("text-anchor", "middle")
			.attr("transform", function(d) {
			  return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
			})
			.text(function(d) { return d.text; });
		}
		';
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
		$this->outter_css = $tmp;
	}
	
	protected function displayContent($objects) {
		// render
		$obj_id = 0;
		
		// gen objects
		echo '<div id="d3cloud_'.$this->id.'" class="d3cloud_'.$this->id.' clearfix_after">';
		echo '</div>';
	}
	
	public $inner_css = '
	.d3cloud_[ID] {
		position: relative;
		text-align:justify;
	}
	';
	
	public $inner_css2 = '
	';
}

?>