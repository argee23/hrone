<?php include('header.php');?>
        
        <div id="col_2">
                
                <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>CHARACTER REFERENCE</strong>

     <?php if($checker_inactive==0){
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

      ?>
      <a onclick="character_ref_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>
    <?php 
}

  } ?>
    </div>
  <div class="box-body">
  <div class="panel panel-success">
    <br>

       <div class="scrollbar_all" id="style-1">
       <div class="force-overflow">

       <?php foreach($employee_character_ref as $character_ref){ ?>
       <div class="box-body">

        <?php 
        $character_title = "";
        foreach($UserTitles as $title){
          if($title->param_id === $character_ref->reference_title){?>
            <?php $character_title = $title->cValue; ?>
          <?php }
        }
        ?>
        <div><label><?php echo $character_title.' '.$character_ref->reference_name; ?></label>

     <?php if($checker_inactive==0){?>

        <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/employee_201_profile/character_ref_delete/'. $character_ref->character_reference_id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>

        <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="character_ref_edit('<?php echo $character_ref->character_reference_id; ?>')"></i></div>
      <?php } ?>

       <div class="col-md-12"><div class="box box-success"></div></div>

          <div class="row">

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Position</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $character_ref->reference_position; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Company</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $character_ref->reference_company; ?></label>
            </div>
            </div>            
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Address</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $character_ref->reference_address; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Contact No.</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $character_ref->reference_contact; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Email add</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $character_ref->reference_email; ?></label>
            </div>
            </div>

            </div>
            </div>
     
       </div><!-- /.box-body -->   
    
     <?php } ?>
            
      <?php if(count($employee_character_ref )<=0){?>
      <tr>
        <td>
        <p class='text-center'><strong>No Character reference(s) yet.</strong></p>
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
     function character_ref_add(val)
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
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/character_ref_add/"+val,true);
      xmlhttp.send();
    }
    function character_ref_edit(val)
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
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/character_ref_edit/"+val,true);
      xmlhttp.send();
    }

</script>

        </div>

        </div>
 <?php include('footer.php');?>


