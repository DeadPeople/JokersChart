<?php
require_once 'modules/module.php';

function getVal($ary, $key, $default) {
	return Module::getVal($ary, $key, $default);
}
?>