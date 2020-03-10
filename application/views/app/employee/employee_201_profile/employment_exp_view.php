<?php include('header.php');?>
        
        <div id="col_2">
        <div class="row">
        <div class="col-md-8">

        <div class="box box-success">
        <div class="panel panel-success">
          <div class="panel-heading"><strong>EMPLOYMENT EXPERIENCE</strong>

        <?php if($checker_inactive==0){?>
          <a onclick="employment_exp_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>
        <?php } ?>
        </div>
          <div class="box-body">
            <div class="panel panel-success">
            <br>

            	 <div class="scrollbar_all" id="style-1">
                 <div class="force-overflow">

            	 <?php foreach($employee_employment_exp as $employment_exp){ ?>

            	 <div class="box-body">

                 <div><label><?php echo $employment_exp->position_name; ?></label>

                <?php if($checker_inactive==0){?>
                  <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/employee_201_profile/employment_exp_delete/'. $employment_exp->work_experience_id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>

<?php
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

?>
                  <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="employment_exp_edit('<?php echo $employment_exp->work_experience_id; ?>')"></i>
<?php
}
?>


                </div>
                <?php } ?>
            	 <div class="col-md-12"><div class="box box-success"></div></div>

                  <div class="row">

                    <div class="col-md-12">
                    <div class="form-group">
                    <div class="col-sm-4">
                    <p>Company name</p>
                    </div>
                    <div class="col-sm-7">
                      <label><?php echo $employment_exp->company_name; ?></label>
                    </div>
                    </div>
                    </div>

                    <div class="col-md-12">
                    <div class="form-group">
                    <div class="col-sm-4">
                    <p>Company address</p>
                    </div>
                    <div class="col-sm-7">
                      <label><?php echo $employment_exp->company_address; ?></label>
                    </div>
                    </div>
                    </div>

                    <div class="col-md-12">
                    <div class="form-group">
                    <div class="col-sm-4">
                    <p>Company Contact No.</p>
                    </div>
                    <div class="col-sm-7">
                      <label><?php echo $employment_exp->company_contact; ?></label>
                    </div>
                    </div>
                    </div>

                    <div class="col-md-12">
                    <div class="form-group">
                    <div class="col-sm-4">
                    <p>Salary</p>
                    </div>
                    <div class="col-sm-7">
                      <label><?php echo $employment_exp->salary; ?></label>
                    </div>
                    </div>
                    </div>

                    <div class="col-md-12">
                    <div class="form-group">
                   <div class="col-sm-4">
                    <p>Date started</p>
                    </div>
                    <div class="col-sm-7">
                      <label><?php echo date('d M Y', strtotime($employment_exp->date_start)); ?></label>
                    </div>
                    </div>
                    </div>

                    <div class="col-md-12">
                    <div class="form-group">
                    <div class="col-sm-4">
                    <p>Date ended</p>
                    </div>
                    <div class="col-sm-7">
                      <?php if($employment_exp->date_end!=null){ ?>
                      <label><?php echo date('d M Y', strtotime($employment_exp->date_end)); ?></label>
                      <?php } ?>
                      <?php if($employment_exp->date_end==null){ ?>
                      <label>Present work</label>
                      <?php } ?>
                    </div>
                    </div>
                    </div>

                    <div class="col-md-12">
                    <div class="form-group">
                    <div class="col-sm-4">
                    <p>Job description</p>
                    </div>
                    <div class="col-sm-7">
                      <label><?php echo $employment_exp->job_description; ?></label>
                    </div>
                    </div>
                    </div>

                    <div class="col-md-12">
                    <div class="form-group">
                    <div class="col-sm-4">
                    <p>Reason(s) for leaving</p>
                    </div>
                    <div class="col-sm-7">
                      <label><?php echo $employment_exp->reason_for_leaving; ?></label>
                    </div>
                    </div>

                    </div>

                    </div>            
               </div><!-- /.box-body -->   
            
             <?php } ?>
                    
              <?php if(count($employee_employment_exp)<=0){?>
              <tr>
                <td>
                <p class='text-center'><strong>No Employment experience(s) yet.</strong></p>
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
      function employment_exp_add(val)
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
          $('#date_start').Zebra_DatePicker({
              direction: ['1852-01-01', currentdate],
              pair: $('#date_end')
          });
          $('#date_end').Zebra_DatePicker({
                direction: [true,currentdate]
          });

        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/employment_exp_add/"+val,true);
      xmlhttp.send();

    }
    function employment_exp_edit(val)
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
          $('#date_start').Zebra_DatePicker({
              direction: ['1852-01-01', currentdate],
              pair: $('#date_end')
          });
          $('#date_end').Zebra_DatePicker({
                direction: [true,currentdate]
          });

        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/employment_exp_edit/"+val,true);
      xmlhttp.send();
    }
    function date_end_experience(val)
    {
      
      if(document.getElementById('isPresent_').checked)
        { 
            document.getElementById('isPresent').value='no';
            document.getElementById('date_end').disabled=true;
            document.getElementById('date_end').value='';
        } 
        else
        { 
            document.getElementById('isPresent').value='yes';
            document.getElementById('date_end').disabled=false;
        }
    }
</script>

        </div>

        </div>
 <?php include('footer.php');?>


