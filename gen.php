<?php 
	require_once 'modules/module.php';
	require_once 'func/controller.php';
	require_once 'test.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<script type="text/javascript" src="js/d3.v2.min.js"></script>
		<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/reset.css" />
		<link rel="stylesheet" type="text/css" href="css/main.css" />
		<link rel="stylesheet" type="text/css" href="css/module.css" />
	</head>
<?php
	$body = json_decode($content);
	$width = getVal($body,'width',900);
	$line_cut = getVal($body,'line-cut',false);
	$content = $body->{'content'};
	
	Module::$global_width = $width;
?>
<body>
	<div id="content" style="width:<?php echo $width;?>px;">
		<?php
			foreach($content as $view){
				$m = getModule($view->{'style'});
				if($m != NULL) { // display block
					$m->displayView($view);
					if($line_cut) echo "<div class='cut_line'></div>";
				} else {
					echo "not in module list<br/>";
				}
			}
		?>
	</div>
</body>
</html>