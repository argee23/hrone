<style type="text/css">.modal-dialog{
    overflow-y: initial !important
}
.modal-body{
  height: 450px;
       max-height: calc(100vh - 210px);
    overflow-y: auto;
}</style>

<?php  $company = $this->uri->segment('5'); ?>
<?php  $c = $this->uri->segment('5'); ?>
<button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#mem"><i class="fa fa-plus"></i>Add New</button>
<button type="button" class="btn btn-danger btn-xs pull-right" id="deleteall" ><i class="fa fa-trash" ></i>Delete All Selected</button>
<br>
<br>

  <?php $form_location   = base_url()."app/pms/get_approvers/";?>
<form id="approvers" method="post" action="<?php echo $form_location;?>">
    <div id="mem" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >

  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
   <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
          <hr>
             <div class="row well">
          <div class="col-md-4">
           Select Department
            <select id="s" class="form-control"  name="department1">

    <option value="all" selected="">all</option>
      <?php $s = $this->pms_model->get_department($company); foreach($s as $e){?>

      <option data-id="<?php echo $e->department_id ?>" value="<?php  echo $e->department_id; ?>"><?php echo $e->dept_name ?></option>
      <?php } ?>
    </select>
    </div>
      <div class="col-md-4">
    Select section
      <select class="form-control" name="section" id="section">
  <option value="all" selected="" id="all">all</option>
        <?php $s = $this->pms_model->get_section(); foreach($s as $section){?>
      <option value="<?php  echo $section->section_id; ?>"><?php echo $section->section_name ?></option>
      <?php } ?> -->      </select>

<input type="hidden" name="company_" value="<?php  echo $this->uri->segment('5');  ?>">
    </div>
  <div class="col-md-4">
    Select classification
      <select class="form-control" name="classification1">
  <option value="all" selected="" id="all">all</option>
      <?php $s = $this->pms_model->get_classification($company); foreach($s as $classification){?>
      <option value="<?php  echo $classification->classification_id; ?>"><?php echo $classification->classification ?></option>
      <?php } ?>
      </select>

    </div>
      <div class="col-md-2">
        Select location
      <select class="form-control" name="location1">
  <option value="all" selected="">all</option>
      <?php $s = $this->pms_model->get_location(); foreach($s as $location){?>

      <option value="<?php  echo $location->location_id; ?>"><?php echo $location->location_name ?></option>
      <?php } ?>
      </select>

    </div>
        <input type="hidden" id="max" value="<?php echo $max->approver ?>">
<!--         <div class="col-md-4">
        Approver Level
			
      <?php  if(!empty($number_of_scorecard->approver)){  $qwe = array(); 
            if($number_of_scorecard->approver < $max->approver){ for($i=1; $i <= $number_of_scorecard->approver ; $i++){
   


              array_push($qwe,$i);
        
              
            }
       
              $qw = array();
                foreach($out as $e){   
                  
           
               
              array_push($qw,$e->approval_level);

                  
             }
			        $array3 = array_diff($qwe, $qw);
             $page = array_values($array3);?>
			    <input type="text" name="level" class="form-control" required value="<?php if(!empty($page[0])){ echo $page[0];}  ?>">
   <?php }else{?>
           <p><small style="color:red">you reached the maximum level of approver</small></p>
              <?php }}else{  ?>
		  <input type="text" name="level" class="form-control" disabled required value="<?php if(!empty($page[0])){ echo $page[0];}  ?>">
	 <?php } ?>
	
      
              
       

    </div> -->
</div>
      </div>

      <div class="modal-body">
   
<br>

      <input type="hidden" name="id" value="<?php echo $this->uri->segment('4'); ?>">
            <input type="hidden" name="group_id" value="<?php echo $this->uri->segment('5'); ?>">




        
         <div class="table-responsive">
    <table class="table table-bordered" id="datatable" >
      <thead>
        <tr class="danger"> 
        <th>Select</th>
        <th>employee id</th>
        <th>Name</th>
        <th>Approver Level</th>
    
      </tr>
      </thead>
      <tbody id="lsit">    
    
   
  

              <?php foreach($opt2 as $qwe){?>

							   <tr>
           
				     <td><input type="checkbox" name="mem[]" class="checkqwe" value="<?php echo $qwe->employee_id; ?>"></td>
              <td><?php echo $qwe->employee_id; ?></td>
              <td><?php echo $qwe->fullname;?></td>
                       <td>
                        <select class="form-control"  name="alevel<?php echo $qwe->employee_id ?>">
              
                  <?php $c = $this->pms_model->opts_xist_approver($qwe->employee_id,$company);
                      ?>
                                <option selected="">Select Approver Level</option>
                   
                            <?php
                             for($i=1; $i <= $max->approver ; $i++)
                              { ?>
                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                              <?php  } ?>
             
                     
              
             
                  </select>
              </td>
           </tr> 

                  
          <?php } ?>
      
              

          </tbody>
        </table>
      </div>
      </div>
      <div class="modal-footer">
      
        <input type="submit"  name="submit" class="btn btn-primary" disabled onclick="save_approvers('<?php echo $this->uri->segment('4'); ?>')" id="submitbutton"  value="submit">
      </div>
    </div>
  </div>
</div>
</div>

</form>

<div class="table-responsive">
        <table  class="table table-striped" id="delete_approvers">
          <thead>
            <tr class="table-info">
        <th><input type="checkbox" id="check" class="check"></th>
             <th>name</th>
              <th>section</th>
              <th>classification</th>
              <th>department</th>
              <th>location</th>

              <th>Option</th>
            

             
            </tr>
          </thead>
          <tbody>
          <?php $number = 0; foreach($out as $out){?> 
              <tr>
        
<td>
    <input type="checkbox" class="check" name="check" value="<?php echo $out->approver_id ?>">
</td>

<td class="cname">
    <?php echo $out->fullname; ?>   
</td>

<td class="csection"><?php $get_section = $this->pms_model->get_count_section_approver($company,$out->approver_id,$out->ref);
              if($get_section>1){ 
                echo 'multiple sections';
              }elseif($out->secc =='all'){ echo 'all';
              }else{ echo $out->section_name;}?>
</td>

<td class="cclassification">
  <?php $get_class = $this->pms_model->get_count_classification_approver($company,$out->approver_id);
                  if($get_class>1){
                      echo 'multiple classification';
                  }elseif($out->class=='all'){
                          echo 'all';
                  }else{ echo $out->classification;
                  } ?>
                          
</td>

<td class="cdepartment">
      <?php $get_dept = $this->pms_model->get_count_dept_approver($company,$out->approver_id);if($get_dept>1){ 
      echo 'multiple departments';}elseif($out->dep=='all'){echo 'all';}else{ echo $out->dept_name; }  ?>
    
</td>
<td class="clocation">
  <?php $get_loc = $this->pms_model->get_count_location_approver($company,$out->approver_id,$out->ref);if($get_loc>1){ echo 'multiple locations';}elseif($out->loca=='all'){ echo 'all';}else{ echo $out->location_name; }?>  
  </td>

              <td><div class="tooltop1"><button class=" btn btn-warning btn-sm" ><span class="glyphicon glyphicon-pencil"></span></button><span class="tooltiptext">edit</span></div>
   <?php $w =  rand(); ?>
        <div class="tooltop1"><button class="delete_approvers btn btn-danger btn-sm" data-id ="<?php echo $out->approver_id ?>" ><span class="glyphicon glyphicon-trash"></span></button><span class="tooltiptext">delete</span></div>
        <div class="tooltop1"><button  onclick="view_approvers('<?php echo $out->approver_id ?>',<?php echo $w;?>);" data-toggle="modal" data-target="#multiple" id="<?php echo $w; ?>" class=" btn btn-success btn-sm"  data-id ="<?php echo $out->aid ?>" ><span class="glyphicon glyphicon-eye-open"></span></button><span class="tooltiptext">view</span></div></td>
            </tr>
              <?php  } ?>
          </tbody>
        </table>
     </div>
	 
	    <div class="modal fade" id="multiple" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    
    <div id="ceho"></div>    

    </div>
  </div>
  </div>
      <?php  $w =  $this->pms_model->lock($this->uri->segment('5'));?> <input type="hidden" id="w" value="<?php if(!empty($w->lock)){ echo $w->lock; } ?>"> 
      <script type="text/javascript">


        function view_approvers(q,id){
            cname= $.trim($(this).closest('tr').children('td.fname').text());
         cclassification = $.trim($('#'+id).closest('tr').children('td.cclassification').text());
         cdepartment = $.trim($('#'+id).closest('tr').children('td.cdepartment').text());
         clocation =  $.trim($('#'+id).closest('tr').children('td.clocation').text());
         csection =  $.trim($('#'+id).closest('tr').children('td.csection').text());

   $.ajax({ 

              url: "<?php echo base_url();?>app/pms/get_multi_apro",
              data:{q:q,cname:cname,cclassification:cclassification,cdepartment:cdepartment,clocation:clocation,csection:csection},
              type: 'POST',
   
                
                success: function(data) {
           
                     $('#ceho').html(data);
          
              }

            });
      
}  


        $('.checkqwe:input[type=checkbox]').on('change', function (e) {

    if ($('input[type=checkbox]:checked').length >  $('#max').val()) {
        $(this).prop('checked', false);
        alert("allowed only "+$('#max').val());
    }
});
  $(document).ready(function() {
    $('#datatable').DataTable({ pageLength : 5,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'all']]});
} );

  $('#s').change(function(){

	val = $("#s option:selected").attr('data-id');
      $.ajax({ 
            url: "<?php echo site_url('app/pms/get_department_sec'); ?>",
            type: 'POST',
            dataType: "JSON",
            data: { "text1": val },
            success: function(data) {
              $('#section').empty();
                $.each(data, function(index, element){
                  $('#section').append($('<option>', {
    value: element.id,
    text: element.name
}));
    });   


            }
          });
	  
  });
            if($('#w').val() == '1'){
  $(document).find("input,button,textarea,select").attr("disabled", "disabled");
  }
 $(document).on('click','.checkqwe:input[type=checkbox]',function(){
        $('#submitbutton').prop('disabled',$('input.checkqwe:checked').length == 0);
    });

</script>