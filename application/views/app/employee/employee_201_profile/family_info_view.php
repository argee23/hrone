<?php include('header.php');?>
        
        <div id="col_2">
                
                <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>FAMILY</strong>

     <?php if($checker_inactive==0){


      ?>
      <a onclick="family_info_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>
      <?php }?>
      </div>


  <div class="box-body">
  <div class="panel panel-success">
    <br>

   <div class="scrollbar_all" id="style-1">
   <div class="force-overflow">

       <?php foreach($family_info_view as $family_info){ ?>

       <div class="box-body">

          <label><?php echo $family_info->relationship_name; ?></label>
           <?php if($checker_inactive==0){?>
          <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/employee_201_profile/family_info_delete/'. $family_info->family_id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>
<?php
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{
?>
          <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="family_info_edit('<?php echo $family_info->family_id; ?>')"></i>



          <?php } } ?>
      </div>

       <div class="col-md-12"><div class="box box-success"></div></div>

          <div class="row">

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Name</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $family_info->name; ?></label>
            </div>
            </div>
            </div>


            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Occupation</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $family_info->occupation; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Contact No.</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $family_info->contact_no; ?></label>
            </div>
            </div>
            </div>


            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Birthday</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo date('d M Y', strtotime($family_info->birthday)); ?></label>
            </div>
            </div>
            </div>

             <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Age</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $this->employee_201_model->calculate_interval($family_info->birthday);?></label>
            </div>
            </div>
            </div>

            <?php if($family_info->relationship==72){ ?>
            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Marriage date</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo date('d M Y', strtotime($family_info->date_of_marriage)); ?></label>
            </div>
            </div>
            </div>
            <?php } ?>

            </div><!-- /.box-body -->   
    
     <?php } ?>
            
    <?php if(count($family_info_view)<=0){?>
    <tr>
      <td>
      <p class='text-center'><strong>No Family(ies) yet.</strong></p>
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
  function family_info_edit(val)
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
          $('#date_of_marriage').Zebra_DatePicker({
                direction: ['1952-01-01', currentdate] 
          });
        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/family_info_edit/"+val,true);
      xmlhttp.send();

    }
     function family_info_add(val)
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
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/family_info_add/"+val,true);
      xmlhttp.send();
    }

</script>

        </div>

        </div>
 <?php include('footer.php');?>


