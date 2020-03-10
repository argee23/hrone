  <head>
     <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
   <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>

  </head>
<style type="text/css">
  .switch-field {
    display: flex;
    margin-bottom: 36px;
    overflow: hidden;
}

.switch-field input {
    position: absolute !important;
    clip: rect(0, 0, 0, 0);
    height: 1px;
    width: 1px;
    border: 0;
    overflow: hidden;
}

.switch-field label {
    background-color: #e4e4e4;
    color: rgba(0, 0, 0, 0.6);
    font-size: 14px;
    line-height: 1;
    text-align: center;
    
    margin-right: -1px;
    border: 1px solid rgba(0, 0, 0, 0.2);
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
    transition: all 0.1s ease-in-out;
}

.switch-field label:hover {
    cursor: pointer;
}

.switch-field input:checked + label {
    background-color: #a5dc86;
    box-shadow: none;
}

.switch-field label:first-of-type {
    border-radius: 4px 0 0 4px;
}

.switch-field label:last-of-type {
    border-radius: 0 4px 4px 0;
}

/* This is just for CodePen. */

.form {
    max-width: 600px;
    font-family: "Lucida Grande", Tahoma, Verdana, sans-serif;
    font-weight: normal;
    line-height: 1.625;
    margin: 8px auto;
    padding: 16px;
}

h2 {
    font-size: 18px;
    margin-bottom: 8px;
}


/* Important part */
#modal-dialog{
    overflow-y: initial !important
}
#modal-body{
  height: 450px;
       max-height: calc(100vh - 210px);
    overflow-y: auto;
}



</style>




<?php $company  = $this->uri->segment('5');   ?>

                  <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-primary btn-xs pull-right" data-toggle="modal" data-target="#mem"><i class="fa fa-plus"></i>Add New</button>
<button type="button" class="btn btn-danger btn-xs pull-right" id="deleteall_set_seperate" ><i class="fa fa-trash" ></i>Delete All Selected</button><br>
<!-- Trigger the modal with a button -->


<!-- Modal -->

 <?php $form_location   = base_url()."app/pms/opt2/";?>
<form id="creator_options" method="post" action="<?php echo $form_location;?>">
    <div id="mem" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >

  <div id="modal-dialog" class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
          <hr>
             <div class="row well">
          <div class="col-md-4">
            Select Department
            <select id="s" class="form-control"  name="department">
      
    <option value="all"  data-id="all" selected="">all</option>
      <?php $s = $this->pms_model->get_department($company); foreach($s as $e){?>

      <option data-id="<?php echo $e->department_id;?>" value="<?php  echo $e->department_id; ?>"><?php echo $e->dept_name ?></option>
      <?php } ?>
    </select>
    </div>
      <div class="col-md-4">
    Select section 
      <select class="form-control" name="section" id="section">
    <option value="all" selected="" id="all">all</option>
     <?php $s = $this->pms_model->get_section(); foreach($s as $section){?>
      <option value="<?php  echo $section->section_id; ?>"><?php echo $section->section_name ?></option>
      <?php } ?> -->
          
      </select>

    </div>
  <div class="col-md-4">
    Select classification<input type="hidden" name="company_" value="<?php  echo $this->uri->segment('5');  ?>">
      <select class="form-control" name="classification">
  <option value="all" selected="" id="all">all</option>
      <?php $s = $this->pms_model->get_classification($company); foreach($s as $classification){?>
      <option value="<?php  echo $classification->classification_id; ?>"><?php echo $classification->classification ?></option>
      <?php } ?>
      </select>

    </div>
      <div class="col-md-2">
        Select location
      <select class="form-control" name="location">
  <option value="all" selected="">all</option>
      <?php $s = $this->pms_model->get_location(); foreach($s as $location){?>

      <option value="<?php  echo $location->location_id; ?>"><?php echo $location->location_name ?></option>
      <?php } ?>
      </select>

    </div>
     <!--     <div class="col-md-2">
        Approver Level

      <?php    $qwe = array();  for($i=1; $i <= $number_of_scorecard->creator ; $i++){
           
              array_push($qwe,$i);
        
              
            }
       
              $qw = array();
                foreach($out as $e){   
                  
           
               
              array_push($qw,$e->approval_level);

                  
             }
          

             $array3 = array_diff($qwe, $qw);
             $page = array_values($array3);
              
       ?>
   <input type="text" name="level" value="<?php if(!empty($page[0])){ echo $page[0];}  ?>" class="form-control">
    </div> -->
       <div class="col-md-2">
  <br>

    </div>
</div>
      </div>

      <div id="modal-body" class="modal-body">
   
<br>

      <input type="hidden" name="id" value="<?php echo $this->uri->segment('5'); ?>">
     <input type="hidden" name="group_id" value="<?php echo $this->uri->segment('5'); ?>">




        
         <div class="table-responsive">
    <table class="table table-bordered" id="example" >
      <thead>
        <tr class="danger"> 

  <td></td>
        <th>employee id</th>
        <th>Name</th>
          <th>Option</th>
      </tr>
      </thead>
      <tbody>   



       
              <?php $s = 0 ;foreach($opt2 as $qwe){?>
            <tr>
           
              <td><?php echo $s; $s++; ?></td>
              <td><?php echo $qwe->employee_id; ?></td>
              <td><?php echo $qwe->fullname;?></td>
                  <td> <button type="button" name="submit" class="btn btn-primary save_score_option2"  data-id="<?php echo $qwe->employee_id; ?>" data-value="<?php echo $company ?>" value="Select as Creator">select</button></td>
          
           </tr>          
          <?php } ?>
    

      
              

          </tbody>
        </table>
      </div>
      </div>
      <div class="modal-footer">

       
      </div>
    </div>

  </div>
</div>
</div>

</form>



<br>

  
 <div class="table-responsive">
    <table class="table table-bordered" id="delete_scorecard_option2" >
      <thead>
        <tr class="danger"> 
          <th><input type="checkbox" id="check" class="check"></th>
          
                  <th>Creators Name</th>
                  <th>Classification</th>
                  <th>location</th>
                  <th>department</th>
          <th>section</th>
                  <th>option</th>
            

        
        </tr>
      </thead>
      <tbody>
        <?php $number = 0; foreach($out as $out){
    
        ?> 
       <tr>
       <td><input type="checkbox" class="check" name="check" value="<?php echo $out->ref ?>"></td>
        
        <td><?php echo $out->fullname; ?></td>
        <td><?php $get_class = $this->pms_model->get_count_classification_creator($company,$out->creator);if($get_class>1){echo 'multiple classification';}else{ echo $out->classification;} ?></td>
        <td><?php $get_loc = $this->pms_model->get_count_location_creator($company,$out->creator);if($get_loc>1){ echo 'multiple locations';}else{ echo $out->location_name; }?></td>
<td><?php $get_dept = $this->pms_model->get_count_dept_creator($company,$out->creator);if($get_dept>1){ 
  echo 'multiple departments';}else{ echo $out->dept_name; }  ?></td>
        <td><?php $get_section = $this->pms_model->get_count_section_creator($company,$out->creator);if($get_section>1){ echo 'multiple sections';}else{ echo $out->section_name;}?></td>



        <td>
       <div class="tooltop1"> <button class="delete_scorecard_option2 btn btn-danger btn-sm" data-id ="<?php echo $out->ref ?>" ><span class="glyphicon glyphicon-trash"></span></button><span class="tooltiptext">delete</span></div>

<!--           <div class="tooltop1"><button onclick="view_scorers('<?php echo $out->creator ?>');" class=" btn btn-success btn-sm" data-toggle="modal" data-target="#multiple"  data-id ="<?php echo $out->option2_id ?>" ><span class="glyphicon glyphicon-eye-open"></span></button><span class="tooltiptext">view</span></div> -->
    </td>
 

      
    </tr>
  <?php } ?>
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
      <?php  $w =  $this->pms_model->lock($this->uri->segment('5'));?> <input type="hidden" id="w" value="<?php if(!empty($w->lock)){ echo $w->lock;} ?>"> 
      <script type="text/javascript">

 

        if($('#w').val() == '1'){
  $(document).find("input,button,textarea,select").attr("disabled", "disabled");
  }

function get_modal(c,creator,get_modal_location){

     
            $.ajax({ 

              url: "<?php echo base_url();?>app/pms/"+get_modal_location+"",
              data:{c:c,creator:creator},
              type: 'POST',
   
                
                success: function(data) {
           
                     $('#ceho').html(data);
          
              }

            });
}  

 
  $(document).ready(function() {
    $('#example').DataTable({paging: false});
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
    


</script>
