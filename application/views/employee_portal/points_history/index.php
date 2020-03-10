<div style="margin-top: 40px">
  <div class="col-md-3">
	    <div class="box box-solid box-success">
	        <div class="box-header">
	        <h4 class="box-title">Employee Rewards Points</h4></div>
	        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
	          <ul class="nav nav-pills nav-stacked">
	          	<?php foreach($point_rewards_settings as $p){?>
	                <li class="my_hover">
	                    <a style="cursor: pointer;" onclick="get_points_history('<?php echo $p->code;?>');"><?php echo $p->title;?></a>
	                </li>
	            <?php } ?>
	          </ul>
	        </div>
	      </div>
	</div>

  <div class="col-md-9" style="height:500px;" id="main_res">
    <div class="panel box box-success" >

    </div>
  </div>
</div>


<script type="text/javascript">
	function get_points_history(code)
	{
		if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
              document.getElementById("main_res").innerHTML=xmlhttp2.responseText;
               $("#points_history").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/points_history/get_points_history/"+code,false);
        xmlhttp2.send();
	}
</script>