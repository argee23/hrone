<style type="text/css">
#fixedtop1 { margin: auto;
  width: 30%;
  padding: 10px; }
#center250a { margin: auto; background-color: #fff; opacity: .8; }
</style>

<div show_div  id="fixedtop1">
<table id="center250a" height="31" border="1" cellpadding="0" cellspacing="0" >
  <tr>
    <td align="center"><img src="<?php echo base_url().'public/img/'?>/ajax-loader.gif" id="pico" width="220" height="19"><br/><txt style="color:#000;" id="proceso"></txt></td>
  </tr>
</table>
</div>

<input type="hidden" id="time_of_process" value="0" />
<input type="hidden" value="<?php echo $from_timer = date("Y-m-d H:i:s");?>" />
