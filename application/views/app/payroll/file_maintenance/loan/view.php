
<div class="col-md-8" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
	   		<strong>
				<?php 
				//$key_location="1";
				   $company_id =$this->uri->segment('4');
				   $current_comp=$this->payroll_loan_model->get_company($company_id);
				   if(!empty($current_comp)){
				   		echo $company_name = $current_comp->company_name;
				   }else{
				   		echo $company_name="classification not exist";
				   }
				
			   ?>
			</strong><strong>(LOAN TYPE)</strong>

      

		   <a onclick="add_new_loan(<?php echo $company_id;?>)" type="button" class="btn btn-xs btn-default pull-right " data-toggle="tooltip" data-placement="left" title="Add Loan"><i class="fa fa-plus text-danger"></i>Add New Loan</a>
      
    
 			 </div>

  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">




      
         	<div class="col-md-12" >
			<div class="table-responsive">
			
   <table id="example1" class="table table-striped table-hover table-bordered table-responsive">
        <thead>
            <tr>
                <th style="text-align:center;">LOAN ID</th>
                <th style="text-align:center;">LOAN TYPE</th>
                <th style="text-align:center;">CATEGORY</th>
                <th style="text-align:center;">LOAN CODE</th>
                <th style="text-align:center;">DESCRIPTION</th>
                <th style="text-align:center;">ALLOW TO FILE</th>
                <th style="text-align:center;">STATUS</th>
                <th style="text-align:center;">ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($loan as $loans){if($loans->InActive == 0){ $inactive = 'Enabled';}else{ $inactive = 'Disabled';}?>

                  <tr <?php if($loans->InActive == 1){echo 'style="color:#999;""';}else{echo 'class="text-success"';} ?>>
                    <td align="center"><?php echo $loans->loan_type_id;  ?></td>
                    <td align="center"><?php echo $loans->loan_type;  ?></td>
                   
                        <?php 
                          $loan_category = $loans->loan_category;
                        foreach($category as $cat){
                          if($loan_category == $cat->id){
                           echo "<td align='center'>".$cat->category."</td>";
                          }else{
                            echo "";
                          }
                        
                        }
                        ?>

                  <td align="center"><?php echo $loans->loan_type_code;  ?></td>
                  <td align="center"><?php echo $loans->loan_type_desc;  ?></td>
                  <td align="center"><?php if($loans->allow_to_file==1){ echo "yes"; } else{ echo "no"; }?></td>
                  <td align="center"><?php echo $inactive?></td>

                    <td align="center">

                    <?php if($loans->InActive == 0){ ?>


                            <?php
                                      $to_edit_enabled= $this->session->userdata('check_leave_type_edit_enabled_icon');  
                                     echo $edit = '<i class="fa fa-pencil pull-right data-toggle="tooltip" data-placement="left" title="Edit '.$loans->loan_type.'" onclick="loan_table_edit('.$loans->loan_type_id.')"></i>'; 
                                    ?>
                            
                             <br>
                           
                            <a href="<?php echo base_url()?>app/payroll_loan_type/deactivate_loan_type/<?php echo $loans->loan_type_id;?>"><i <?php echo $this->session->userdata('check_leave_type_todisable_icon'); ?> class="hidden"  data-toggle="tooltip" data-placement="left" title="Click to Disable <?php echo $loans->loan_type?>'" onclick="return confirm('Are you sure you want to disable <?php echo $loans->loan_type?> loan type?')"></i></a>
                           
                            <br>

                             <a href="<?php echo base_url()?>app/payroll_loan_type/delete_loans/<?php echo $loans->loan_type_id;?>/<?php echo $loans->company_id;?>"><i class="fa fa-remove fa-lg text-success pull-right"  data-toggle="tooltip" data-placement="left" title="Click to Delete <?php echo $loans->loan_type?>'" onclick="return confirm('Are you sure you want to delete <?php echo $loans->company_id.' : '.$loans->loan_type?> loan type?')"></i></a>
                      
                      
                    <?php 



                    }else{?>

                        <i <?php echo $this->session->userdata('check_leave_type_edit_disabled_icon'); ?>  class="hidden" data-toggle="tooltip" data-placement="left" title="cannot edit: enable first <?php //echo $leave_type->leave_type?>'"></i>

                        <br>

                        <a href="<?php echo base_url()?>app/payroll_loan_type/activate_loan_type/<?php echo $loans->loan_type_id;?>"><i <?php echo $this->session->userdata('check_leave_type_toenable_icon'); ?> class="hidden" data-toggle="tooltip" data-placement="left" title="Click to Enable <?php echo $loans->loan_type?>'" onclick="return confirm('Are you sure you want to enable <?php echo $loans->loan_type?> loan type?')"></i></a>
                        
                        <br>
                       
                        <i class="fa fa-remove fa-lg text-muted pull-right"  data-toggle="tooltip" data-placement="left" title="cannot delete : enable first "></i>
                        
                    <?php 

                    }?>
                    </td>
                  </tr>
                  <?php }?>

                </tbody>
            </table>

			</div>
			</div>

	
		 </div> 
  </div><!-- /.box-body --> 

   </div>
   </div>

</div>

</div>
</div>
</div>
</div>


 <script>
    function applyFilter()
    {  
    var company    = "<?php echo $company;?>";
         
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
     xmlhttp.open("GET","<?php echo base_url();?>app/payroll_loan_type/loan_table_result/"+company,false);
    xmlhttp.send();
    }


 
  
  </script>

</div>
</div>
<div class="col-md-4"  id="col_3">
		
	</div>
