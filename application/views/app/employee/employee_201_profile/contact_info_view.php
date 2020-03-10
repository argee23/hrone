<?php include('header.php');?>
        
        <div id="col_2">
                
            <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>CONTACT INFORMATION </strong>
       <?php if($checker_inactive==0){
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

        ?>
          <a onclick="contact_info_edit('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil-square-o fa-2x text-success pull-right"></i></a>
      <?php } } ?>
      </div>

    <div class="box-body">
    <div class="panel panel-success">
    <br>

            <div class="row">

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Mobile No. 1</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $contact_info_view->mobile_1; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Mobile No. 2</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $contact_info_view->mobile_2; ?></label>
            </div>
            </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Mobile No. 3</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $contact_info_view->mobile_3; ?></label>
            </div>
            </div>
            </div>
            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Mobile No. 4</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $contact_info_view->mobile_4; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Telephone No. 1</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $contact_info_view->tel_1; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Telephone No. 2</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $contact_info_view->tel_2; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Email</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $contact_info_view->email; ?></label>
            </div>
            </div>
            </div>
            
            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Facebook</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $contact_info_view->facebook; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Instagram</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $contact_info_view->instagram; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Twiiter</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $contact_info_view->twitter; ?></label>
            </div>
            </div>
            
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
      function contact_info_edit(val)
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
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/contact_info_edit/"+val,true);
      xmlhttp.send();
    }
  </script>

        </div>

        </div>
 <?php include('footer.php');?>


