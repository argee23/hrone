
  <style type="text/css">
    .dtr_center{
      text-align: center;
    }
.datagrid table { 
  border-collapse: collapse; 
  text-align: left; 
  width: 100%; 
} 
.datagrid {
  font: normal 10px/100% Arial, Helvetica, sans-serif; 
  background: #fff; 
  overflow: hidden; 
  border: 1px solid <?php echo $bg_color_genpay;?>; -webkit-border-radius: 3px; -moz-border-radius: 3px; 
  border-radius: 3px; 
  
}
.datagrid table td, .datagrid table th { 
  padding: 3px 5px; 

}
/*.datagrid table thead th { 
  padding: 3px 5px; 

}*/

.datagrid table thead th {
  background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, <?php echo $bg_color_genpay;?>), 
    color-stop(1, <?php echo $overlay_genpay;?>) );
  background:-moz-linear-gradient( center top, <?php echo $bg_color_genpay;?> 5%, <?php echo $overlay_genpay;?> 100% );
  filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_color_genpay;?>', endColorstr='<?php echo $overlay_genpay;?>');
  background-color:<?php echo $bg_color_genpay;?>; 
  color:<?php echo $font_color_genpay;?>; 
  font-size: 12px; 
  font-weight: bold;
  border-left: 1px solid #0070A8; 
} 
.datagrid table thead th:first-child { 
  border: none; 
}

.datagrid table tbody .alt td { 
  background: #E1EEF4;
  color: #00496B; 
}
.datagrid table tbody td:first-child { 
  border-left: none; 
}
.datagrid table tbody tr:last-child td { 
  border-bottom: none; 
}
.datagrid table tfoot td div { 
  border-top: 1px solid <?php echo $bg_color_genpay;?>;
  background: #E1EEF4;
} 
.datagrid table tfoot td { 
  padding: 0; font-size: 12px 
} 
.datagrid table tfoot td div{ 
  padding: 2px; 
}
.datagrid table tfoot td ul { 
  margin: 0; padding:0; 
  list-style: none; 
  text-align: right; 
}
.datagrid table tfoot  li { 
  display: inline; 
}
.datagrid table tfoot li a { 
  text-decoration: none; 
  display: inline-block;  
  padding: 2px 8px; 
  margin: 1px;
  color: <?php echo $font_color_genpay;?>;
  border: 1px solid <?php echo $bg_color_genpay;?>;-webkit-border-radius: 3px; -moz-border-radius: 3px; 
  border-radius: 3px; 
  background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, <?php echo $bg_color_genpay;?>), color-stop(1, <?php echo $overlay_genpay;?>) );
  background:-moz-linear-gradient( center top, <?php echo $bg_color_genpay;?> 5%, <?php echo $overlay_genpay;?> 100% );filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='<?php echo $bg_color_genpay;?>', endColorstr='<?php echo $overlay_genpay;?>');
  background-color:<?php echo $bg_color_genpay;?>; 
}
.datagrid table tfoot ul.active, .datagrid table tfoot ul a:hover { 
  text-decoration: none;border-color: <?php echo $bg_color_genpay;?>; 
  color: <?php echo $font_color_genpay;?>; 
  background: none; background-color:<?php echo $overlay_genpay;?>;

}
.datagrid table tbody td { 
  color: #00496B; 
  border-left: 1px solid #E1EEF4;
  
  font-size: 12px;
  font-weight: normal; 
}
div.dhtmlx_window_active, div.dhx_modal_cover_dv { position: fixed !important; }


.datagrid{
  width: 100%;
 margin: auto;
 overflow-x: scroll;
}

.locked_prompt_class{
  font-size: 1.5em;
  height: 100px;
  font-weight: bold;
  text-align: center;
  vertical-align: middle;
  line-height: 100px; 
  color: #ff0000;
}
.locked_prompt_class_span{
  color:#000;font-style: italic;text-transform: lowercase; 
}
.datagrid a#reg_hol_rd { 
color: #ff0000;
}
.datagrid a#reg_hol_rd_with_logs { 
color: #000;
}
  </style> 
