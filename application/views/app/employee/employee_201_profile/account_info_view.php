<?php include('header.php');?>
        
        <div id="col_2">
                <div class="row">
<div class="col-md-8">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>ACCOUNT INFORMATION</strong>
   <?php if($checker_inactive==0){
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

    ?>
    <a onclick="account_info_edit('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Edit"><i class="fa fa-pencil-square-o fa-2x text-success pull-right"></i></a>
    <?php
}

     } ?>
    </div>
    </div>

    <div class="box-body">
    <div class="panel panel-success">
    <br>

          <div class="row">

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Bank</p>
            </div>
            <div class="col-sm-7">
              <label>
              <?php 
              $bank = '';
              if($account_info_view->bank != null){
                 $bank = $account_info_view->bank_name; 
              }
              echo $bank;
              ?>
              </label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Tin</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $account_info_view->tin; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Pagibig No.</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $account_info_view->pagibig; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Account No.</p>
            </div>
            <div class="col-sm-7">
              <label><?php echo $account_info_view->account_no; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="col-sm-4">
            <p>SSS No.</p>
            </div><div class="form-group">
            <div class="col-sm-7">
              <label><?php echo $account_info_view->sss; ?></label>
            </div>
            </div>
            </div>

            <div class="col-md-12">
            <div class="form-group">
            <div class="col-sm-4">
            <p>Philhealth No.</p
            >
            </div>
            <div class="col-sm-7">
              <label><?php echo $account_info_view->philhealth; ?></label>
            </div>
            </div>

            </div>
            </div>
    <br>
    </div><!-- /.box-body -->
    </div>
</div>
</div>

</div>  
</div>

<script>
  
    function account_info_edit(val)
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
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/account_info_edit/"+val,true);
      xmlhttp.send();

    }
</script>

        </div>

        </div>
 <?php include('footer.php');?>
