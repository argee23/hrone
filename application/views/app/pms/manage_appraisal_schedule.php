
<style type="text/css">

@import url('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/css/bootstrap.css');
@import url('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker3.css');
.datepicker table tr td.disabled,
.datepicker table tr td.disabled:hover {
  color: #b90000;
}
   

</style>


<?php  $s =  $this->uri->segment('4');?>

  <ul  class="nav nav-pills nav-justified" id="rowTab">

      <li><a data-toggle="tab" href="#manage_schedule"><i class="fa fa-code"></i>Manage Schedule</a></li>


     <li><a data-toggle="tab"  href="#manage_general_objectivess"><i class="fa fa-pencil-square-o"></i>Manage General Objectives</a></li>
           
      <li><a data-toggle="tab"  href="#manage_employee_objectivess"><i class="fa fa-pencil-square-o"></i>Manage Employee Objectives</a></li>
</ul>

<div class="tab-content">


    <div class="tab-pane" id="manage_schedule">

 

<ol>


    
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>&nbsp; Add Schedule </button>
</ol><br><br>
  <div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-small">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>

        </div>
        <?php $s =  $this->uri->segment('4'); $form_location   = base_url()."app/pms/save_pms_appraisal_schedule/";?>
        
        <form role="form"  id="appraisalschedule" method="post" action="<?php echo $form_location?>">
          <div class="modal-body">
            


            <div class="form-group">
              <label for="message-text">Covered Year:</label> 
              <div class="input-group date" id="datePicker">
                <input type="text" class="form-control" name="cover_year" id="cover_year" required />
                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
              </div>
            </div>
		
          

            <div class="form-group" >
              <label for="message">appraisal period type</label>
              <select class="form-control" id="qwe"  required name="appraisal_period_type">

                <option  disabled="" selected="" value="">select appraisal period type</option>
                <?php foreach($appraisal_period_type as $row){?>
                  <option value="<?php echo $row->id;?>"> <?php echo $row->appraisal_period_type; ?></option>
                <?php } ?>

              </select>
            </div>
		
				    <div class="form-group" id="eeeee" style="display:none">
			  <label id="select"></label>
              <div class="input-group date dates" id="datepicker1" style="display:none;" >
           
                  <input name="dp1[]" id="dp1" autocomplete="off" class="form-control">
                            <input type="date" class="form-control"  name="from_dp1[]" style="display:none;" />
                     <input type="date" class="form-control" name="to_dp1[]" style="display:none;" />
            
                <span style="visibility:hidden;" class="input-group-addon add-on"></span>
              </div>
			  
			   <div class="input-group date dates" id="datepicker2" style="display:none">
          
                         <input name="dp2[]" id="1st_source_dp2" class="dp2 form-control" placeholder="1st appraisal date" autocomplete="off" placeholder="1st appraisal date"   >
                         <input type="text"  style="display:none;"  class="form-control" placeholder="from" id="from_dp2_1" name="from_dp2[]" >
                         <input type="text"  style="display:none;"  class="form-control" placeholder="to"  id="to_dp2_1" name="to_dp2[]">


                         <input name="dp2[]" id="2nd_source_dp2" class="dp2 form-control" placeholder="2nd appraisal date"  autocomplete="off"  placeholder="2nd appraisal date"  >
                         <input type="text" style="display:none;" class="form-control" placeholder="from" id="from_dp2_2" name="from_dp2[]">
                         <input type="text"  style="display:none;" class="form-control" placeholder="to" id="to_dp2_2" name="to_dp2[]">





              
              
 
                <span style="visibility:hidden;" class="input-group-addon add-on"></span>
              </div>
			     <div class="input-group date dates" id="datepicker3" style="display:none">
                  <input name="dp3[]" class="form-control dp3"  id="1st_source_dp3" autocomplete="off"  placeholder="1st appraisal date"  >
               <input name="dp3[]" class="form-control dp3"  id="2nd_source_dp3" autocomplete="off" placeholder="2nd appraisal date"  >
                 <input name="dp3[]" id="3rd_source_dp3"  class="form-control dp3" autocomplete="off" class="form-control" placeholder="3rd appraisal date"  >
   <!-- 
                     <input type="date" class="form-control"  name="from_dp3[]" />
                     <input type="date" class="form-control" name="to_dp3[]" />
                     <input type="date" class="form-control"  name="from_dp3[]" />
                     <input type="date" class="form-control" name="to_dp3[]" />
                     <input type="date" class="form-control"  name="from_dp3[]" />  
                     <input type="date" class="form-control" name="to_dp3[]" /> -->

                        <input type="text" id="from_dp3_1"  name="from_dp3[]"  style="display:none;" >
                         <input type="text" id="to_dp3_1" name="to_dp3[]" style="display:none;">
                         <input type="text" id="from_dp3_2" name="from_dp3[]" style="display:none;">
                         <input type="text" id="to_dp3_2" name="to_dp3[]" style="display:none;">
                          <input type="text" id="from_dp3_3" name="from_dp3[]" style="display:none;">
                         <input type="text" id="to_dp3_3" name="to_dp3[]" style="display:none;">


         
                <span style="visibility:hidden;" class="input-group-addon add-on"></span>
              </div>
                
			     <div class="input-group date dates" id="datepicker4" style="display:none">
          <input type="number" class="form-control" max="31" min="1" name="dp4[]" onkeyup="if(this.value > 31){ this.value = null;}if(this.value < 1){ this.value=null;}" >
            <input type="date" class="form-control"  name="from_dp4[]" style="display:none;" />
                     <input type="date" class="form-control" name="to_dp4[]" style="display:none;" />
              </div><br><br>
			     <div class="input-group date dates" id="datepicker5" style="display:none">
                  
                    <input name="dp5[]" placeholder="1st appraisal date"   autocomplete="off" class="form-control dp5">
               <input name="dp5[]"  placeholder="2nd appraisal date"  autocomplete="off" class="form-control dp5">
                 <input name="dp5[]"  placeholder="3rd appraisal date"  autocomplete="off" class="form-control dp5">
                   <input name="dp5[]" placeholder="4th appraisal date"   autocomplete="off" class="form-control dp5">

                     <input type="date" class="form-control"  style="display:none;" name="from_dp5[]"  />
                     <input type="date" class="form-control" style="display:none;" name="to_dp5[]" />
                     <input type="date" class="form-control" style="display:none;" name="from_dp5[]" />
                     <input type="date" class="form-control" style="display:none;"name="to_dp5[]" />
                     <input type="date" class="form-control" style="display:none;" name="from_dp5[]" />
                     <input type="date" class="form-control" style="display:none;"name="to_dp5[]" />
                     <input type="date" class="form-control" style="display:none;" name="from_dp5[]" />
                     <input type="date" class="form-control" style="display:none;"name="to_dp5[]" />
              </div>
			  
			  
			   <label>Set Number of days before due date</label>
                <input type="number" class="form-control" name="w"  />
      
             
			  </div>
			   
			  
            <div class="form-group">
			<input type="hidden" name="company_" id="company_" value="<?php  echo $this->uri->segment('4');  ?>" >
              <label for="message">appraisal type</label>
              <select  required class="form-control" name="appraisal_type" onchange="showcontactchoices(this.value)">
                <option disabled="" selected="" value="">select appraisal type </option>
                
                <option value="group">
                  per group
                </option>
                <option value="company">
                  per company
                </option>
                <option value="period">
                 per payroll period group
               </option>
             </select>
           </div>
           <div class="form-group" id="show">
             
             
             
           </div>



           
           

         </div>
         
         <div class="modal-footer">
          <hr class="prettyline">
          
          <input type="submit" name="submit" class="btn btn-primary"  onclick="save_appraisal_schedule()" id="submit"  value="submit">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          
        </div>
      </form>
    </div>
  </div>
  </div>








<div class="table-responsive">
  <table id="appraisal_schedule" class="table">
    <thead>
      <tr>
       
       
        <th>Covered year </th>
        <th>Appraisal type</th>
        <th>Appraisal period type</th>
        <th>No. of days before due date</th>
        <th>Date of Evaluation</th>
        <th>Action</th>
        
      </tr>
      
      
    </thead>
    <tbody>

     <?php   foreach($res as $res){ ?>
       <tr>
               
        
         <td><?php echo $res->cover_year ?></td>
         <td><?php if(!empty($res->appraisal_group_name)){echo '<i>Per group:</i> '.$res->appraisal_group_name;}elseif(!empty($res->pay_type_name)){echo '<i>Per payroll period group: </i>'.$res->pay_type_name;}elseif(!empty($res->company_name)){echo '<i>Per Compan: </i>'.$res->company_name; }  ?></td>
         <td><?php echo $res->appraisal_period_type; ?></td>
            <td><?php echo $res->number_days; ?></td>
            <td><?php foreach($result as $qwe){
              if($qwe->appraisal_period_type_dates == '1'){
              $q = 'Every '.$qwe->appraisal_period_type_dates.'st'.' day of the month';
            }elseif($qwe->appraisal_period_type_dates == '2'){
               $q = 'Every '.$qwe->appraisal_period_type_dates.'nd'.' day of the month';


            } 
              elseif($qwe->appraisal_period_type_dates == '3'){
               $q = 'Every '.$qwe->appraisal_period_type_dates.'rd'.' day of the month';


            }else{
              $q = 'Every '.$qwe->appraisal_period_type_dates.'th'.' day of the month';
            } 
          
             if($res->appraisal_period_type == 'monthly'){ echo $q.'<br>';}else{ echo date("F d, Y", strtotime($qwe->cover_year.'-'.$qwe->appraisal_period_type_dates)).'<br>'; }} ?></td>
         <td>     <div class="tooltop1"> <button class=" btn btn-warning btn-sm" onclick="view_update_appraisal_schedule(<?php echo $res->mid ?>,<?php echo $this->uri->segment('4'); ?>);"><span class="glyphicon glyphicon-pencil"></span></button><span class="tooltiptext">edit</span></div>
         
           <div class="tooltop1"><button class="delete_type_schedule btn btn-danger btn-sm" data-id="<?php echo $res->mid?>" data-value="<?php echo $res->ref?>"> <span class="glyphicon glyphicon-trash"></span></button><span class="tooltiptext">delete</span></div>
            
           </tr>
         <?php   }     ?>
       </tbody>
     </table>
   </div>

    </div>

    <div class="tab-pane" id="manage_general_objectivess">
          <ol>


    
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#genwral"><i class="fa fa-plus"></i>&nbsp;Add Objectives</button>
</ol><br>
  <div id="genwral" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-small">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>

        </div>
        <?php $s =  $this->uri->segment('4'); $form_location   = base_url()."app/pms/save_pms_general/";?>
        
        <form role="form"  id="pms_ob" method="post" action="<?php echo $form_location?>">
          <div class="modal-body">
            
<input type="hidden" name="company_" id="company_" value="<?php  echo $this->uri->segment('4');  ?>" >
           <div class="form-group">
            <label for="message">Position</label>
              <select name="position" multiple class="s form-control">
                <?php $e =$this->pms_model->position(); foreach($e as $e){?>
                <option value="<?php echo $e->position_name?>"><?php echo $e->position_name?></option>
             <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="message">Objective Topic</label>
              <input class="form-control"  required="" type="text" name="topics">
            </div>
             <div class="form-group">
              <label  for="message">Employee Details</label>
              <input class="form-control" required="" type="text" name="details">
            </div>


       
      

           
           

         </div>
         
         <div class="modal-footer">
          <hr class="prettyline">
          
          <input type="submit" name="submit" class="btn btn-primary"  onclick="save_general()" id="submit"  value="submit">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          
        </div>
      </form>
    </div>
  </div>
  </div>

     <table id="manage_general_objectives" class="table">
    <thead>

      <tr>
       
       
        <th>Position</th>
         <th>objective topics</th>
         <th>objective details</th>
    
        <th>Action</th>
        
      </tr>
      
      
    </thead>
    <tbody>
    
             <?php   foreach($manage_general_objectives as $manage_general_objectives){ ?>
       <tr>
        
        
         <td><?php echo $manage_general_objectives->position?></td>
         <td><?php echo $manage_general_objectives->objective_topics?></td>
         <td><?php echo $manage_general_objectives->objective_details?></td>
      
         <td><div class="tooltop1"><button class=" btn btn-warning btn-sm" onclick="view_update_general_objectives(<?php echo $manage_general_objectives->id ?> ,<?php echo $s; ?>);"><span class="glyphicon glyphicon-pencil"></span></button><span class="tooltiptext">edit</span></div>
         <div class="tooltop1">
           <button class="delete_general_objectives btn btn-danger btn-sm" data-id="<?php echo $manage_general_objectives->id?>"> <span class="glyphicon glyphicon-trash"></span></button><span class="tooltiptext">delete</span></div>
            
           </tr>
        <?php } ?>
       </tbody>
     </table>
    </div>

    <div class="tab-pane" id="manage_employee_objectivess">
      
      <ol>


    
    <!-- Trigger the modal with a button -->
    <button type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#empoyee"><i class="fa fa-plus"></i>&nbsp; Add Employee Objectives</button>
</ol><br>
  <div id="empoyee" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-small" id="modelDialog1">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>

        </div>
        <?php $s =  $this->uri->segment('4'); $form_location   = base_url()."app/pms/save_pms_employee/";?>
        
        <form role="form"  id="pms_obemployee" method="post" action="<?php echo $form_location?>">
          <div class="modal-body">
            



      
    <div class="form-group">
              <label for="message">Employee</label>
                <select class="e form-control"   name="name" required="">
                <?php $e =$this->pms_model->employee(); foreach($e as $e){?>
                <option value="<?php echo $e->fullname?>"><?php echo $e->fullname?></option>
             <?php } ?>
              </select>
            </div>
      
             <div class="form-group">
              <label  for="message">Objectives</label>
              <input class="form-control" type="text" name="objectives" required="">
            </div>
              <div class="form-group">
              <label  for="message">Objectives details</label>
              <input class="form-control" type="text" name="odetails" required="">
            </div>

<input type="hidden" name="company_" id="company_" value="<?php  echo $this->uri->segment('4');  ?>" >
           
           

         </div>
         
         <div class="modal-footer">
          <hr class="prettyline">
          
          <input type="submit" name="submit" class="btn btn-primary"  onclick="save_employee()" id="submit"  value="submit">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          
        </div>
      </form>
    </div>
  </div>
  </div>

           <table id="manage_employee_objectives" class="table table">
    <thead>

      <tr>
       
         
         <th>Name</th>
         <th>objectives</th>
       <th>objectives details</th>
        <th>Action</th>
        
        
      </tr>
      
      
    </thead>
    <tbody>

     <?php   foreach($manage_employee_objectives as $manage_employee_objectives){ ?>
       <tr>
        
        
         <td><?php echo $manage_employee_objectives->name?></td>
         <td><?php echo $manage_employee_objectives->objectives?></td>
          <td><?php echo $manage_employee_objectives->objective_details?></td>

      
         <td>   <div class="tooltop1">   <button class=" btn btn-warning btn-sm" onclick="view_update_employee_objectives(<?php echo $manage_employee_objectives->id ?>,<?php echo $s; ?>);"><span class="glyphicon glyphicon-pencil"></span></button><span class="tooltiptext">edit</span></div>
         
         <div class="tooltop1">  <button class="delete_employee_objectives btn btn-danger btn-sm" data-id="<?php echo $manage_employee_objectives->id?>"> <span class="glyphicon glyphicon-trash"></span></button><span class="tooltiptext">delete</span></div>
            
           </tr>
     <?php } ?>
       </tbody>
     </table>
 
    </div>

 
</div>

   
    

</div>
    <?php  $w =  $this->pms_model->lock($this->uri->segment('4'));?> <input type="hidden" id="w" value="<?php if(!empty($w->lock)){ echo $w->lock;} ?>"> 
<script type="text/javascript">


  $(document).on('change','.dp2',function(){
    
        var split1st = $('#1st_source_dp2').val(); 1-20
        var dateArray1 = split1st.split('-');
        var split2nd = $('#2nd_source_dp2').val(); 2-21
        var dateArray2 = split2nd.split('-');
    
 
      $('#from_dp2_1').val(dateArray2[0]+'-'+(parseFloat(dateArray2[1])+parseFloat(1)));
      $('#to_dp2_1').val($('#1st_source_dp2').val());
      $('#from_dp2_2').val(dateArray1[0]+'-'+(parseFloat(dateArray1[1])+parseFloat(1)));
      $('#to_dp2_2').val($('#2nd_source_dp2').val()); 
      
  });
    $(document).on('change','.dp3',function(){
    
        var split1st = $('#1st_source_dp3').val();
        var dateArray1 = split1st.split('-');
        var split2nd = $('#2nd_source_dp3').val();
        var dateArray2 = split2nd.split('-');
        var split3rd = $('#3rd_source_dp3').val();
        var dateArray3 = split3rd.split('-');

    

      $('#from_dp3_1').val(dateArray3[0]+'-'+(parseFloat(dateArray3[1])+parseFloat(1)));
      $('#to_dp3_1').val($('#1st_source_dp3').val());
      $('#from_dp3_2').val(dateArray1[0]+'-'+(parseFloat(dateArray1[1])+parseFloat(1)));
      $('#to_dp3_2').val($('#2nd_source_dp3').val());
      $('#from_dp3_3').val(dateArray2[0]+'-'+(parseFloat(dateArray2[1])+parseFloat(1)));
      $('#to_dp3_3').val($('#3rd_source_dp3').val());
      
  });

  $.fn.datepicker.dates.en.titleFormat="MM";
$(document).ready(function(){
    var date_input=$('#dp1'); 
    date_input.datepicker({
      format: 'MM-dd',
      autoclose: true,
      startView: 1,
      maxViewMode: "months",
      orientation: "bottom left",
    })
        var date_input=$('.dp2'); 
    date_input.datepicker({
      format: 'MM-dd',
      autoclose: true,
      startView: 1,
      maxViewMode: "months",
      orientation: "bottom left",
    })
          var date_input=$('.dp3'); 
    date_input.datepicker({
      format: 'MM-dd',
      autoclose: true,
      startView: 1,
      maxViewMode: "months",
      orientation: "bottom left",
    })
              var date_input=$('.dp5'); 
    date_input.datepicker({
      format: 'MM-dd',
      autoclose: true,
      startView: 1,
      maxViewMode: "months",
      orientation: "bottom left",
    })

  });
	$(document).ready(function(){
				
				$(document).on('change','#qwe',function(){
					$('#eeeee').css('display','block');
					
					if($('#qwe').val()==1){
							$('.dates').css('display','none')
							$('#datepicker1').css('display','inline');
					}else if($('#qwe').val()==2){
					$('.dates').css('display','none')
						$('#datepicker2').css('display','inline');
					}
					else if($('#qwe').val()==3){
						$('.dates').css('display','none')
						$('#datepicker3').css('display','inline');
					}
					else if($('#qwe').val()==4){
						$('.dates').css('display','none')
						$('#datepicker4').css('display','inline');
					}
						else if($('#qwe').val()==5){
						$('.dates').css('display','none')
						$('#datepicker5').css('display','inline');
					}
					$('#select').text('Pick a date '+ '('+$('#qwe').val()+')');
					
		
				});
              if($('#w').val() == '1'){
  $(document).find("input,button,textarea,select").attr("disabled", "disabled");
  }
	});
</script>