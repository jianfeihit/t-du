<?php echo $this->smarty_insert_scripts(array('files'=>'jquery-1.9.1.js,jquery-ui-1.10.2.js')); ?> 

<link rel="stylesheet" type="text/css" href="js/fancy/jquery.fancybox.css">
<script type="text/javascript" src="js/fancy/jquery.fancybox.js"></script>

<dt><a href='add_consignee.php' id="fancy" data-fancybox-type="iframe" data-type="add_consignee_box" class="buthui new">添加常用收货人</a></dt>
            <script type="text/javascript">
            $(document).ready(function () {
          
          
              // 详情页弹框逻辑
              console.log($("#fancy"));
              $("#fancy").fancybox({
                maxWidth  : 1000,
                maxHeight : 800,
                fitToView : false,
                width   : '80%',
                height    : '80%',
                autoSize  : false,
                closeClick  : false,
                openEffect  : 'none',
                closeEffect : 'none'
              });
               
            });
            </script>

