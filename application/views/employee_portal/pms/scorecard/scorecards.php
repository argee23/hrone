
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style type="text/css">

.nav>li>a:hover, .nav>li>a:focus, .nav .open>a, .nav .open>a:hover, .nav .open>a:focus {
    background:#fff;
}
.dropdown {
    background:#fff;
    border:1px solid #cccccc;
    border-radius:4px;
    width:20vw; 
}
.dropdown-menu>li>a {
    color:#428bca;
}
.dropdown ul.dropdown-menu {
    border-radius:4px;
    box-shadow:none;
    margin-top:20px;
    width:300px;

}
    textarea{

      max-width: 100%; 
    }

</style>

		<span id="message"></span>
	<div class="panel panel-success" id="general_page">


        <div class="panel-body">

            <div class="box-header with-border">
		
<div class="col-md-3"   style="padding-right:20px; border: 1px solid #00a65a;text-align:center;border-top: 7px solid #00a65a;">  

  <br><br>
     <img src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar" style="width:130px;height: auto;">
<div  style=" text-align:center"><h3 class="box-title" style="cursor: pointer;" onclick="get_employee_info_status('<?php echo $employee_id; ?>');"><strong style="color:#3c8dbc;"><?php echo $name; ?></strong></h3>
	
      <button id='update_form' class="btn btn-primary btn-block" onclick="dl(<?php if(!empty($employeeid)){echo $employeeid;}?>,'<?php if(!empty($doc_no->doc_no)){ echo $doc_no->doc_no; } ?>','<?php echo $ref_eval ?>',<?php echo $company; ?>)" >Ready for Evaluation</button>
	 <br>
	 <br>
	<div id="slim-scroll">
	   

		    					    <div style="width: 90%; height: 15px; border-bottom: 1px solid #4285f4; text-align: center">

  <span style="font-size: 15px; background-color: #fff; color:black; padding: 0 10px;">


     <i>General Appraisal Created By Admin</i><!--Padding is optional-->
  </span>
</div>		 <br>   			<?php if($general_forms){ foreach($general_forms as $general_forms){?>		

  <ul class="nav navbar-nav">

	<li  class="dropdown" id="4" onclick="get_criteria('<?php echo $general_forms->doc_no ?>','<?php echo $general_forms->form_title; ?>','<?php echo $general_forms->fid  ?>','<?php echo $employee_id; ?>');">
	  <a href="http://totoprayogo.com" class="dropdown-toggle" data-toggle="dropdown"><?php echo $general_forms->form_title; ?><i onclick="delete_me(<?php echo $general_forms->id; ?>,this);" class="fa fa-times-circle pull-right"></i> </a>
					 	
	</li>
  </ul>

  <br>
  <br>
  <br>
  <br>
  <?php }}else{?>
	<n class="text-info"> NO DATA FOUND.</n>
 <?php } ?>	
   		    					    <div style="width: 90%; height: 15px; border-bottom: 1px solid #4285f4; text-align: center">
  <span style="font-size: 15px; background-color: #fff; color:black; padding: 0 10px;">
     <i>General Appraisal Created By Creator</i><!--Padding is optional-->
  </span>
</div>		 <br>  	

     <button class="btn btn-success btn-xs pull-right" id="addButton" data-toggle="modal" data-target="#myModal4" style="width: 100%;"><span class="glyphicon glyphicon-plus"></span> Add New form </button>		<div id="c"><?php if($emple_forms){ foreach($emple_forms as $emple_forms){?>	

     	<br>	  	<br>	  	<br>	  	<br>	
 

   	  <ul class="nav navbar-nav">
   	

	<li class="dropdown" id="4" onclick="get_criteria_portal(<?php echo $employee_id ?>,<?php echo $emple_forms->fid ?>,'<?php echo $emple_forms->form_title; ?>','<?php echo $emple_forms->doc_no ?>');">

	  <a href="http://totoprayogo.com" class="dropdown-toggle" data-toggle="dropdown"><?php echo $emple_forms->form_title; ?>
    <i onclick="qwe(<?php echo $emple_forms->fid; ?>,this);" class="fa fa-times-circle pull-right"></i> </a>

	</li>
  </ul> 
 <?php }}else{?>
	<n class="text-info"> NO DATA FOUND.</n>
	<?php } ?>	
	 </div> 
</div>	
</div>
</div>

<div class="col-md-9" id="main" style="max-height: 100%; " >  	</div>


			</div>
      	</div>
    </div>
 <div class="modal" id="myModal4"  tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-small">
      <div class="modal-content">
        <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Form settings</h4>
         <hr class="prettyline">
       </div>     <?php  $form_location   = base_url()."employee_portal/pms/save_general_form_employee/";?>      
 
       <form role="form" method="POST" id="form4" action="javascript:void(0)" onsubmit="save_general_form_employee(<?php echo $employee_id ?>,<?php echo $employee_id ?>);">
            
    <?php if(!empty($appraisal->cover_year)){ ?>
    <input type="hidden"  value="<?php echo $appraisal->appraisal_period_type_dates; ?>" name="appraisal_period_type_dates" id="appraisal_period_type_dates">
    <input type="hidden" value="<?php echo $appraisal->cover_year; ?>" name="cover_year" id="cover">
    <input type="hidden"  value="<?php echo $appraisal->appraisal_period_type; ?>" name="appraisal_period_type" id="appraisal_period_type">

    <?php if($appraisal->company_name){ ?>

    <input type="hidden" value="<?php echo $appraisal->company_name; ?>"  name="appraisal_type" id="appraisal_type">
  <?php }elseif($appraisal->pay_type_name){ ?>
     <input type="hidden" value="<?php   echo $appraisal->pay_type_name;  ?>"  name="appraisal_type" id="appraisal_type">
     <?php 
       }elseif($appraisal->appraisal_group_name){ ?>
        <input type="hidden" value="<?php  echo $appraisal->appraisal_group_name  ?>" name="appraisal_type" id="appraisal_type">
      <?php } ?>
<?php }else{
  echo '';
} ?>
        
         <div class="modal-body">
           
           <div class="form-group">
            
            
             
            <label for="message-text">form title:</label>
            <input type="text" class="form-control" name="form_title" cid="form_title" placeholder="ex Key Result Areas" required>
            
          </div>
          
          <div class="form-group">
            <label for="recipient-name">Grading Type:</label>
            
            <div class="input-group">
              <span class="input-group-addon"><input type="hidden" name="company_" value="<?php  echo $this->uri->segment('4');  ?>">
                <input  type="radio" value="1" aria-label="..." name="radio">
              </span>
              <input type="text" class="form-control" aria-label="..." disabled="" value="numbers">
            </div><!-- /input-group -->
            <div class="input-group">
              <span class="input-group-addon">
                <input name="radio" type="radio" aria-label="..." value="2">
              </span>
              <input type="text" class="form-control" aria-label="..." disabled="" value="Percentage">
            </div><!-- /input-group -->
          </div>
          
          
          
          
          <div class="form-group">
           <label for="message-text">form description:</label>
           <textarea name="form_description" id="form_description" required class="form-control"></textarea>
           
         </div>
      
          
          <label for="message-text">weight:</label>                                      
          <div class="input-group">

            <input required="" name="weight" type="number" class="form-control" id="recipient-name">
            <span class="input-group-addon">%</span>
          </div>

              <div class="form-group">
          <label for="message-text">instruction:</label>
          <textarea name="instruction" id="instruction" class="form-control" required></textarea>
          
          
        </div>
          
        </div>

    
      <div class="modal-footer">
        <hr class="prettyline">

          <input type="submit" class="btn btn-success" value="submit">
        <button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancel</button>
</div>	
      </div>
      


     


        </form>   
     
      </div>

  </div>  <!-- Modal content-->
</div>   <!-- Modal dialog-->
</div>  <!-- Modal mymod   -->

    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/datepicker/datepicker3.css">
    <script src="<?php echo base_url()?>public/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
	$(document).ready(function() {
    $('#slim-scroll').slimScroll({
    	size: '4px',
        height: '450',
        color:'black',
        allowPageScroll: true

    });
});

	function delete_me(fid,source){
	
		    $.ajax({
            url: "<?php echo base_url();?>employee_portal/pms/delete_form_score/",
                 type: 'POST',
            data:{'fid':fid},
            success: function(data){
           
                $(source).parent().parent().fadeOut(1600);
            }
        });

	}

	function get_criteria(id,elem,fid,employeeid){
  

  
        $.ajax({
            url: "<?php echo base_url();?>employee_portal/pms/get_criteria/",
            data:{'id':id,'elem':elem,'fid':fid,'employeeid':employeeid},
            type: 'POST',
            success: function(data){
           
              $('#main').html(data);
            }
        });
      
	}
		function get_criteria_portal(employeeid,id,elem,doc_no){

        $.ajax({
            url: "<?php echo base_url();?>employee_portal/pms/get_criteria_portal/",
            data:{'id':id,'elem':elem,'employeeid':employeeid,doc_no:doc_no},
            type: 'POST',
            success: function(data){
           
              $('#main').html(data);
            }
        });
      
	}

	function get_employee_info_status(employeeid,doc_no,elem){


        $.ajax({
            url: "<?php echo base_url();?>employee_portal/pms/get_employee_info_status/",
            data:{'doc_no':doc_no,'elem':elem,'employeeid':employeeid},
            type: 'POST',
            success: function(data){
           
              $('#main').html(data);
            }
        });
      
	}

	function save_general_form_employee(id,employee){
		
         	$.ajax({ 
                url: "<?php echo base_url('employee_portal/pms/save_general_form_employee') ?>",
                type: 'POST',
                 data: $('#form4').serialize()+ "&id=" + id,
                cache:'false',
                dataType:'json',
         		success: function(data) {
				 //  if(e == 'true'){
                   $('#message').show();
                   $('#message').html("<div class='alert alert-success alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>Record has been inserted successfully</div>").fadeOut(10000);
                   $('#myModal4').modal('hide');
                   	document.getElementById("form4").reset();
 	
                     
      				 $('#c').append('<br><br><br><br><ul class="nav navbar-nav"><li class="dropdown" id="4" onclick="get_criteria_portal('+employee+','+data.fid+','+data.form_title+','+"'"+data.doc_no+"'"+');"><a href="http://totoprayogo.com" class="dropdown-toggle" data-toggle="dropdown">'+data.form_title+'<i class="fa fa-times-circle pull-right"></i> </a></li></ul>')           //  }else{ 
                //   $('#message').show();
                //   $('#message').html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>"+e+"</div>").fadeOut(10000);
                //   $('#myModal').modal('hide');
                  
                //   manage_general_form();                
                // }
                
                
                
              }

            });
        	
            }


       
        
           


          
        function dl(id,doc_no,ref,company) {
   


        if(ref == 'false' ){

      
  alert('no evaluator');   

}else{

     $.ajax({
       url: "<?php echo base_url();?>employee_portal/pms/evaluation_for/"+company,
       method:"POST",
       data:{'id':id,'doc_no':doc_no,'ref':ref},
         beforeSend: function(){
           toastr.info('Please wait ');
           toastr.clear();
        },
   
       success:function()
       {
         toastr.success('insertion is completed');
       }
     })
  }


}

    </script>



    <style type="text/css">
    	.fileUpload {
		    position: relative;
		    overflow: hidden;
		    margin: 10px;
		}
		
		.fileUpload input.upload {
		    position: absolute;
		    top: 0;
		    right: 0;
		    margin: 0;
		    padding: 0;
		    font-size: 20px;
		    cursor: pointer;
		    opacity: 0;
		    filter: alpha(opacity=0);
		}
    </style>}
