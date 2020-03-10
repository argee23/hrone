<?php include('header.php');?>
        
        <div id="col_2">
              <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">

  <div class="panel-heading"><strong>  PERSONAL INFORMATION</strong> 
  <?php if($checker_inactive==0){
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

    ?>
    <a onclick="personal_info_edit('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil-square-o fa-2x text-success pull-right"></i></a>
  <?php 
  
}

} 


  ?>
  </div>

    <div class="box-body">
    <div class="panel panel-success">
    <br>

        <div class="row">

          <div class="col-md-12">
          <div class="form-group">
            <div class="col-sm-4">
            <p>Title</p>
            </div>
            <div class="col-sm-7">
              <label>
                  <label><?php echo $personal_info_view->title_name; ?></label>
              </label>
            </div>
          </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>First Name</p>
              </div>
              <div class="col-sm-7">
                <label><?php echo $personal_info_view->first_name; ?></label>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group" >
              <div class="col-sm-4">
              <p>Middle Name</p>
              </div>
              <div class="col-sm-7">
                <label><?php echo $personal_info_view->middle_name; ?></label>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>Last Name</p>
              </div>
              <div class="col-sm-7">
                <label><?php echo $personal_info_view->last_name; ?></label>
              </div>
            </div>
          </div>

          <?php if($personal_info_view->name_extension!=''){ ?>
          <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>Name extension</p>
              </div>
              <div class="col-sm-7">
                <label><?php echo $personal_info_view->name_extension; ?></label>
              </div>
            </div>
          </div>
          <?php } ?>

          <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>Nickname</p>
              </div>
              <div class="col-sm-7">
                <label><?php echo $personal_info_view->nickname; ?></label>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>Birthday</p>
              </div>
              <div class="col-sm-7">
                  <label><?php echo date('d M Y', strtotime($personal_info_view->birthday)); ?></label>
              </div>
            </div>
          </div>
           <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>Age</p>
              </div>
              <div class="col-sm-7">
                  <label><?php echo $this->employee_201_model->calculate_interval($personal_info_view->birthday);?></label>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>Place of Birth</p>
              </div>
              <div class="col-sm-7">
                  <label><?php echo $personal_info_view->birth_place; ?></label>
              </div>     
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>Gender</p>
              </div>
              <div class="col-sm-7">
                  <label><?php echo $personal_info_view->gender_name; ?></label>
              </div>
            </div>
          </div>


          <div class="col-md-12">
            <div class="form-group">
                <div class="col-sm-4">
                <p>Civil Status</p>
                </div>
              <div class="col-sm-7">
                  <label><?php echo $personal_info_view->civil_status_name; ?></label>
              </div>                            
            </div>
          </div>
          
          <div class="col-md-12">               
            <div class="form-group">
                <div class="col-sm-4">
                <p>Blood Type</p>
                </div>
                <div class="col-sm-7">
                  <label><?php echo $personal_info_view->blood_type_name; ?></label>
                </div>  
              </div>
          </div>

          <div class="col-md-12">
              <div class="form-group">
                <div class="col-sm-4">
                <p>Citizenship</p>
                </div>
                <div class="col-sm-7">
                  <label><?php echo $personal_info_view->citizenship_name; ?></label>
                </div>  
              </div><!-- /.form-group -->
          </div>

          <div class="col-md-12">
              <div class="form-group">
                <div class="col-sm-4">
                <p>Religion</p>
                </div>
                <div class="col-sm-7">
                  <label><?php echo $personal_info_view->religion_name; ?></label>
                </div>  
              </div><!-- /.form-group -->
            </div>
            </div>

     <br>
     </div>
    </div><!-- /.box-body -->
</div>
</div>

</div>  
</div>
  </div>
</div>
<script>
    function personal_info_edit(val)
    {          

      var today = new Date();
      var dd    = today.getDate();
      var mm    = today.getMonth()+1;
      var yyyy  = today.getFullYear();

      if(dd<10) {
          dd = '0'+dd
      } 

      if(mm<10) {
          mm = '0'+mm
      } 

      currentdate = yyyy + '-' + mm + '-' + dd;

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
            $('#birthday').Zebra_DatePicker({
                direction: ['1952-01-01', currentdate] 
            });
        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/personal_info_edit/"+val,true);
      xmlhttp.send();

    }
</script>
 <?php include('footer.php');?>

