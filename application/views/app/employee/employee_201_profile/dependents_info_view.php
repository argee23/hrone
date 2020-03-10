<?php include('header.php');?>

        <div id="col_2">
                
              <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>DEPENDENTS</strong>


     <?php if($checker_inactive==0){
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
      ?>

      <a onclick="dependents_info_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>
    <?php } }?>

    </div>
  <div class="box-body">
  <div class="panel panel-success">
    <br>


       <div class="scrollbar_all" id="style-1">
         <div class="force-overflow">

       <?php foreach($dependent_info_view as $dependent_info){ ?>

       <div class="box-body">

        <div><label><?php echo $dependent_info->relationship_name; ?></label>
        <?php if($checker_inactive==0){?>
          <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/employee_201_profile/dependents_info_delete/'. $dependent_info->dependent_id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>


          <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="dependents_info_edit('<?php echo $dependent_info->dependent_id; ?>')"></i>

          <?php } ?>
        </div>


        <div class="col-md-12"><div class="box box-success"></div></div>

          <div class="row">

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>First name</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $dependent_info->first_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Middle name</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $dependent_info->middle_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Last name</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $dependent_info->last_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Name extension</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $dependent_info->name_ext; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Birthday</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo date('d M Y', strtotime($dependent_info->birthday)); ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Gender</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $dependent_info->gender_name; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Civil status</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $dependent_info->civil_status_name; ?></label>
            </div>
            </div>
            
            </div>
            </div>
            
            </div><!-- /.box-body -->   
    
     <?php } ?>
            
      <?php if(count($dependent_info_view)<=0){?>
      <tr>
        <td>
        <p class='text-center'><strong>No dependent(s) yet.</strong></p>
        </td>
      </tr>
      <?php } ?>

      </div>
      </div>
     
     <br>
     </div>
     </div> 
     </div>

</div>
</div>

</div>  
</div>
 </div>  
</div>

  <script>
      
    function dependents_info_add(val)
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
                direction: ['1852-01-01', currentdate] 
          });
        }
      }

      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/dependents_info_add/"+val,true);
      xmlhttp.send();
    }
      function dependents_info_edit(val)
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
                direction: ['1852-01-01', currentdate] 
          });
        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/dependents_info_edit/"+val,true);
      xmlhttp.send();
    }
     function genderr()
      {
        var val = document.getElementById('relation').value;
        if(val==71 || val==74 || val==75 || val==79)
        { 
            document.getElementById('gender').value=2;
            document.getElementById('gender').disabled=true;
        }
        else if(val==70 || val==73 || val==76 || val==78)
        {  document.getElementById('gender').value=1;
            document.getElementById('gender').disabled=true;
         }
        else{
          document.getElementById('gender').value="";
          document.getElementById('gender').disabled=false;

        }
      }

  </script>

  </div>
 </div>
 <?php include('footer.php');?>


