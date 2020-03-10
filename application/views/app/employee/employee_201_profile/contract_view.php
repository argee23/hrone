
<input type="hidden" id="session_nextstep" value="<?php echo $this->session->userdata('session_nextstep');?>">
<?php include('header.php');?>
        
<div id="col_2">           


<div class="row">
<div class="col-md-8">
<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>CONTRACT</strong>
     <?php if($checker_inactive==0){
if($edit_employee=="hidden "){
echo "<i class='fa fa-pencil pull-right text-danger' title='Not Allowed. Check User Rights'> </i>";
}else{

      ?>
        <a onclick="contract_add('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Add"><i class="fa fa-plus-square fa-2x text-success pull-right"></i></a>
    <?php } }?></div>

  <div class="box-body">
  <div class="panel panel-success">
    <br>
       <div class="scrollbar_all" id="style-1">
         <div class="force-overflow">

            <div class="col-md-12">
            <div class="form-group">   
       <?php foreach($contract_view as $contract){ 
         $from =  date('d M Y', strtotime($contract->start_date));
          $to = date('d M Y', strtotime($contract->end_date));
        ?>

          <div class="panel panel-danger">
                  <div class="panel-heading">
               <strong><?php  if($contract->isActive==0){$active='active';} else{ $active='closed contract';} echo $from." - ".$to." as ".$contract->employment_name; ?> (<?php echo $active; ?>) </strong>

                <?php if($checker_inactive==0){?>

                 <a  class="fa fa-trash fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/employee_201_profile/contract_delete/'. $contract->contract_id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>

                <?php if($active=='active'){ ?>
                <a  class="fa fa-power-off fa-lg text-success delete pull-right" data-toggle="tooltip" data-placement="right" title="Inactive" href="<?php echo site_url('app/employee_201_profile/contract_inactive/'. $contract->contract_id.''); ?>" onClick="return confirm('Are you sure you want to inactive contract?')"></a>
                <?php } ?>
                <?php if($active=='inactive'){ ?>
                <a  class="fa fa-power-off fa-lg text-warning delete pull-right" data-toggle="tooltip" data-placement="right" title="Active" href="<?php echo site_url('app/employee_201_profile/contract_active/'. $contract->contract_id.''); ?>" onClick="return confirm('Are you sure you want to active contract?')"></a>
                <?php } ?>

                <i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick="contract_edit('<?php echo $contract->contract_id; ?>')"></i>
                <?php } ?>

                </div>
                  <div class="box-body">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th colspan="3" class='text-warning'>Contract Details</th>
                        
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Date Start</td>
                        <td colspan="2"> <label><?php echo date('d M Y', strtotime($contract->start_date)); ?></label>  </td>
                        
                      </tr>
                      <tr>
                        <td>Date End</td>
                        <td colspan="2"><label><?php echo date('d M Y', strtotime($contract->end_date)); ?></label></td>
                        
                      </tr>
                       <tr>
                        <td>Employment Type</td>
                        <td colspan="2"><label><?php echo $contract->employment_name; ?>
                      </tr>
                        <tr>
                        <td>Remarks</td>
                        <td colspan="2"><label><?php echo $contract->remark?></label></td>
                        
                      </tr>
                     
                      <tr>
                        <td colspan="2">  <a href="<?php echo base_url(); ?>app/employee_201_profile/download_contract/<?php echo $contract->file; ?>"
              type="button" class="btn btn-info btn-xs" title="Download File" ><i class="fa fa-download"></i> Download File</a>  </td>
                      </tr>

                    </tbody>
                  </table>
                  </div>
                  </div> 
    
     <?php } ?>
            
      <?php if(count($contract_view)<=0){?>
      <tr>
        <td>
        <p class='text-center'><strong>No Contract created yet.</strong></p>
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
  </div>  
</div>

<script>
   function contract_add(val)
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
          $('#start_date').Zebra_DatePicker({
          });
          $('#end_date').Zebra_DatePicker({
                direction: true
          });

        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/contract_add/"+val,true);
      xmlhttp.send();
    }

    function contract_edit(val)
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
          $('#start_date').Zebra_DatePicker({
            
          });
          $('#end_date').Zebra_DatePicker({
             
          });
        }
      }
      xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/contract_edit/"+val,true);
      xmlhttp.send();
    }

  $(document).ready(function(){
    
      var a =  document.referrer;
      var url = a.split('/');
      var check_url = url[url.length-4];
      if(check_url=='dashboard')
      {
          var sess = document.getElementById('session_nextstep').value;
          var s = sess.split('/');
          var ss = s[s.length-1];
          
          if(ss=="contract_close")
          { alert("Click the power off icon button to close contract"); }
          else {  contract_add(<?php echo $this->uri->segment("4"); ?>);  }
      }
      else
      {}
      
  });
</script>

        </div>

        </div>
 <?php include('footer.php');?>


