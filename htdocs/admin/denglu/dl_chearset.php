<?php

require 'lib/denglu_cache.php';
require 'lib/denglu_data.php';
//require 'denglu_api.class.php';
include 'Denglu.php';

$Denglu = new Denglu($denglu_cache['denglu_appid'],$denglu_cache['denglu_appkey'],'utf');

?>