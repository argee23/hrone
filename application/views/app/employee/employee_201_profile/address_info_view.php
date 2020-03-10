<?php include('header.php');?>
        
        <div id="col_2">
                
 <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>ADDRESS</strong> 

   <?php if($checker_inactive==0){
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

    ?>
   <a onclick="address_info_edit('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil-square-o fa-2x text-success pull-right"></i></a>
   <?php
}
    } ?>

   </div>

    <div class="box-body">


            <div class="row">
            <div class="col-md-12">
            
            <div class="panel panel-danger">
            <div class="panel-heading">Permanent Address</div>
            <div class="panel-body">

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Addrress</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $address_info_view->permanent_address; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>City</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $address_info_view->permanent_city_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Province</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $address_info_view->permanent_province_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Years of stay</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $address_info_view->permanent_address_years_of_stay; ?></label>
            </div>
            </div>
            </div>

            </div>
            </div>

            <div class="panel panel-warning">
            <div class="panel-heading">Present Address</div>
            <div class="panel-body">
            
            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Address</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $address_info_view->present_address; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>City</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $address_info_view->present_city_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Province</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo  $address_info_view->present_province_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Years of stay</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $address_info_view->present_address_years_of_stay; ?></label>
            </div>
            </div>
            </div>

            
            </div>
            </div>
            </div>
            </div>


     </div>
    </div><!-- /.box-body -->
</div>
</div>

</div>  
</div>

<script>
  
     function address_info_edit(val)
    {          

      if (window.XMLHttpRequest)
      {
        xmlhttp=new XMLHttpRequest();
      }
      else
      {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
      xmlhttp.onreadystatechange=function()
      {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {  
          document.getElementById("col_2").innerHTML=xmlhttp.responseText;
        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/address_info_edit/"+val,true);
      xmlhttp.send();
    }
      function getPercities(val)
    {  
            
        if (window.XMLHttpRequest)
          {
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            
            document.getElementById("per_city").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/view_perCities/"+val,true);
        xmlhttp.send();

    }
    function getPrecities(val,option)
    {  
        var xmlhttp;

         
        if (window.XMLHttpRequest)
          {
          xmlhttp=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp.onreadystatechange=function()
          {
          if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
            
            document.getElementById("pre_city").innerHTML=xmlhttp.responseText;
            }
          }
        xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/view_preCities/"+val,true);
        xmlhttp.send();
     
    }   

    function copy_permanent()
    {
         if(document.getElementById("copy").checked)
         {    
            document.getElementById('copy_id_value').value='1';

            address = document.getElementById('per_address').value;  
            document.getElementById('copy_address').value=address;
            document.getElementById('address').value=address;
            $("#copy_address").show();
            $("#pre_address").hide();
            document.getElementById('copy_address').disabled=true;

            province = document.getElementById('per_province').value;  
            document.getElementById('copy_province').value=province;
            document.getElementById('province').value=province;
            $("#copy_province").show();
            $("#pre_province").hide();
            document.getElementById('copy_province').disabled=true;
           
            cities = document.getElementById('per_city').value;  
            document.getElementById('copy_city').value=cities;
            document.getElementById('city').value=cities;
            $("#copy_city").show();
            $("#pre_city").hide();
            document.getElementById('copy_city').disabled=true;
           
            stay = document.getElementById('per_stay').value;  
            document.getElementById('copy_stay').value=stay;
            document.getElementById('stay').value=stay;
            $("#copy_stay").show();
            $("#pre_stay").hide();
            document.getElementById('copy_stay').disabled=true;
           

         }
         else{
            document.getElementById('copy_id_value').value='0';

            $("#pre_address").show();
            $("#copy_address").hide();
            document.getElementById('copy_address').value="";
            document.getElementById('address').value="";

             $("#pre_stay").show();
             $("#copy_stay").hide();
             document.getElementById('copy_stay').value="";
             document.getElementById('stay').value="";

             $("#pre_province").show();
             $("#copy_province").hide();
             document.getElementById('province').value="";

             $("#pre_city").show();
             $("#copy_city").hide();
             document.getElementById('city').value="";

         }
    
    }
</script>

        </div>

        </div>
 <?php include('footer.php');?>
