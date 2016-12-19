<?php
require_once 'classes/class-wovax-es-ajax.php';
$ajax = new WOVAX_ES_Ajax();

$ajax->do_request();

die();