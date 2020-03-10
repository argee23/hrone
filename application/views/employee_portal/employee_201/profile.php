<div class="col-md-9">
  <div class="panel panel-success">
    <div class="panel-heading">
      <h4><i class="glyphicon glyphicon-list"></i>PROFILE INFORMATION</h4>
    </div>
    <div class="panel-body">
    <div class="col-md-12">
      <?php if(empty($details))
      {
          echo "<h3 class='text-danger'><center>No Settings yet.</center></h3>";
      }
      else
      {
        echo "<div class='col-md-12'>".$details."</div>";
      }
      ?>
    </div>
    </div>
    
    <div class="panel-heading">
      <div id="checkk_res"></div>
       <?php if(empty($details)){} else {?>
      <center><h5><input type="checkbox" id="checkk" onclick="acknowledge();" <?php if($status > 0){ echo "checked"; }?>>&nbsp;<b>I have read and agreed to the Privacy Policy.</b></h5></center><?php } ?>
    </div>

  </div>
 </div>

<script type="text/javascript">
  function acknowledge()
  {
    if(document.getElementById('checkk').checked)
    {
      var a = '1';
    }
    else
    {
       var a = '0';
    }

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
              document.getElementById("checkk_res").innerHTML=xmlhttp2.responseText;
                setTimeout(function() {
                      $('#flashdata_result').fadeOut('fast');
                      }, 3000);
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/employee_201/acknowledge_content/"+a,false);
        xmlhttp2.send();

  }
</script>