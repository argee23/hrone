<link href="<?php echo base_url()?>public/plugins/tost/toastr.css" rel="stylesheet"/>
<script src="<?php echo base_url()?>public/plugins/tost/toastr.js"></script>


<style type="text/css">


.nav>li>a:hover, .nav>li>a:focus, .nav .open>a, .nav .open>a:hover, .nav .open>a:focus {
    background:#fff;
}
.dropdown {
    background:#fff;
    border:1px solid #cccccc;
    border-radius:4px;
    width:300px;    
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
.dropdown ul.dropdown-menu:before {
    content: "";
    border-bottom: 10px solid #fff;
    border-right: 10px solid transparent;
    border-left: 10px solid transparent;
    position: absolute;
    top: -10px;
    right: 16px;
    z-index: 10;
}
.dropdown ul.dropdown-menu:after {  
    content: "";
    border-bottom: 12px solid #ccc;
    border-right: 12px solid transparent;
    border-left: 12px solid transparent;
    position: absolute;
    top: -12px;
    right: 14px;
    z-index: 9;
}
.dropdown ul.dropdown-menu li:hover .mega {
  display: block;
}

.mega {
  width: 600px;
  display: none;
  position: absolute;
  left: 300px;
  top: 0px;
  background: #FFF;
  border: 1px solid #cccccc;
  border-radius: 4px;
  -webkit-box-shadow: 2px 3px 5px 0px rgba(204,204,204,1);
-moz-box-shadow: 2px 3px 5px 0px rgba(204,204,204,1);
box-shadow: 2px 3px 5px 0px rgba(204,204,204,1);
}
.mega aside {
  float: left;
  width: 150px;
}
.mega .featured {
  float: right;
  width: 440px;
}
.mega .featured img {
  max-width: 400px;
}

.dataTable > thead > tr > th[id*="no"]:after{
    content: "" !important;
}


</style>

<br><br>

<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header">Section Management  </h2>
   


     
 
    
      <div class="panel panel-success">
        <div class="panel-heading">
              <h4 class="text-info" style="cursor: pointer"><i class="fa fa-sitemap"></i> Employee List</h4>
        </div>
        <div class="panel-body">
            <div class="col-md-12">
              
              <?php $type =  $this->pms_model->get_creator_($company_); if(!empty($type->creators_type)){ if(!empty($appraisal->cover_year)){ ?>
              <table class="table table-bordered" id="tablenodiv">
                  <thead>
                      <tr>   
<ul class="nav navbar-nav">
  <li class="dropdown">
    <a href="http://totoprayogo.com" class="dropdown-toggle" data-toggle="dropdown" >Select Form <span class="glyphicon glyphicon-triangle-bottom pull-right"></span> </a>
    <ul class="dropdown-menu">
    <?php if($general_forms){ foreach($general_forms as $general_forms){?>      
    <li class="li"><a target="_blank" style="cursor: pointer"><?php echo $general_forms->form_title?><span class=""></span></a><input type="checkbox" style="display:none;"  name="form_title" class="form_title" value="<?php echo $general_forms->form_part?>" data-value="<?php echo $general_forms->fid?>" >

        <div class="mega" style="padding: 18px;">
          <?php $e = $this->pms_model->get_criteria($general_forms->fid);  ?> 
              <dt>Criteria </dt>
                    <?php foreach($e as $e){ ?>
   
          <dd><?php echo $e->area ?></dd>
        <?php } ?>
           <?php $c = $this->pms_model->get_grading_table_admin($general_forms->fid);  ?> 
              <dt>Grading Scale</dt>
                    <?php foreach($c as $c){ ?>
   
          <dd><?php echo $c->score.' '. $c->score_equivalent; ?></dd>

        <?php } ?>
      </div></li>
    <input type="hidden" value="<?php echo $general_forms->fid?>" id="fid">

    <?php }} ?>
  <hr style="margin:0px;">  
 <li><a><center onclick="delete_all();">Apply</center></a></li>
   
    </ul>
  </li>					
  
  </ul>
  <form id="fe" method="POST" action="javascript:void(0)">
      


  
     <select id="appraisal" style="visibility:hidden;">
      <option  data-id="<?php
           if($appraisal->appraisal_period_type_id=='1'){ 
                  $q =  $appraisal->appraisal_period_type_dates.'-'.date("y",strtotime("-1 year"));
                  $galing  = $appraisal->appraisal_period_type_dates.'-'.date('y');
                  echo date("F d, Y", strtotime($q)).' to '.date("F d, Y", strtotime($galing));

          }else{  
               if(($appraisal->appraisal_order=='1') AND ($appraisal->appraisal_period_type_id != '4')){
                  $s  =  date("y",strtotime("-1 year")).'-'.$appraisal->from; 
                  $galis  = date('y').'-'.$appraisal->to;
                 echo  date("F d, Y", strtotime($s)) .' to '.date("F d, Y", strtotime($galis)); 
                 }else{ 
                     if($appraisals->appraisal_period_type_id == 4){
                            echo  date('M Y');
                     }else{  
                          $s  =  date("y",strtotime("-1 year")).'-'.$appraisal->from;    $galis  = date('y').'-'.$appraisal->to; echo date("F d, Y", strtotime($s)).' to '.date("F d, Y", strtotime($galis)) ;}}}?>"  data-value="<?php echo $appraisal->appraisal_period_type_dates?>" data-order="<?php echo $appraisal->appraisal_order; ?>" data-type="<?php echo $appraisal->appraisal_period_type; ?>"  data-before="<?php echo $appraisal->number_days; ?>"  data-co="<?php echo  $appraisal->cover_year; ?>" ><?php echo $appraisal->appraisal_period_type_dates; ?>
                            
       </option></select>
    
 <input type="text" style="visibility:hidden;" value="<?php echo $company; ?>" style="visibility:hidden;" name="company_id" id="company_id">
  <input id="appraisal_period_type_dates_appraisal" type="text" style="visibility:hidden;" name="appraisal_period_type_dates_appraisal" value="<?php echo $closest_appraisal; ?>">
    <?php if($appraisal->company_name){ ?>

    <input type="text" style="visibility:hidden;" value="<?php echo $appraisal->company_name; ?>" style="visibility:hidden;" name="company_name" id="appraisal_type">
  <?php }elseif($appraisal->pay_type_name){ ?>
     <input type="text" value="<?php   echo $appraisal->pay_type_name;  ?>" style="visibility:hidden;" name="pay_type_name" id="appraisal_type">
     <?php 
       }elseif($appraisal->appraisal_group_name){ ?>
        <input type="text" value="<?php  echo $appraisal->appraisal_group_name  ?>" style="visibility:hidden;" name="appraisal_group_name" id="appraisal_type">
      <?php } ?>
 
	</form>

	</div>
                        <th id="no" style="left:10px;"><center><input type="checkbox"  onclick="checkall(this);"></center></th>
                        <th><center>Name</center></th>
                        <th><center>Department</center></th>
                        <th><center>Section</center></th>
                        <th><center>Location</center></th>
                        <th><center>Classification</center></th>
                        <th><center>position</center></th>
                        
                      </tr>
                  </thead>
                  <tbody>
					       

                    <?php
                           foreach($employee_under_creator as $employee_under_creator){  

                   $res =  $this->pms_model->get_employee_creator($company,$employee_under_creator->department,$employee_under_creator->classification_id,$employee_under_creator->section,$employee_under_creator->location);
                   		

                           if(!empty($res->approver)){ 
                          	 $n = 0;
                               
                      ?>
                      <tr style="text-align: center;">
        
                              <td><input type="checkbox" name="check" class="check" value="<?php echo $employee_under_creator->employee_id; ?>" data-value="<?php echo $employee_under_creator->position_name ?>" data-id="<?php echo rand(); ?>"></td>

                                <td><a style="cursor: pointer;" onclick="scorecard(<?php echo $employee_under_creator->employee_id?>,'<?php echo $employee_under_creator->fullname; ?>',<?php echo $company; ?>);"><?php echo $employee_under_creator->fullname;?></a></td>

                                <td><?php echo $employee_under_creator->dept_name; ?></td>
                                <td><?php echo $employee_under_creator->section_name; ?></td>
                                <td><?php echo $employee_under_creator->location_name; ?></td>
                                <td><?php echo $employee_under_creator->classification; ?></td>
                                <td><?php echo $employee_under_creator->position_name; ?></td>
                           
                      </tr>
                    <?php $n++; } }   ?>
                  </tbody>
              </table>
              </div>
           
            </div>
          </div>
<?php }else{?>
     <center><h4><strong>NO APPRAISAL SCHEDULE IS CREATED FOR THIS YEAR</strong></h4></center>
<?php }}else{?>
       <center><h4><strong>NO CREATORS HAS BEEN SET</strong></h4></center>
<?php }?>

   <div id="employee_table">
            

               </div>

 
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
function scorecard(employee_id,fullname,company){

        $.ajax({
            url: "<?php echo base_url();?>employee_portal/pms/view_scorecards/"+employee_id+"/"+fullname+"/"+company,
             method:"POST",
              data:{checkbox_value:fullname,company:company},
            success: function(data){

              $('#create, #view').attr("disabled", "disabled");
              $('#employee_table').html(data);
              var position = $('#employee_table').position();
              scroll(0,position.top);
            }
        });
      }

$(".li").on('click',function (e) {
  e.stopPropagation();
   var cb = $(this).find("input[type='checkbox']");
   cb.prop('checked', !cb.prop('checked'));
   $(this).toggleClass("selected", cb.checked);
   $('span').attr('class','');
   $(this).find('span').attr('class','glyphicon glyphicon-ok');
    $(".form_title").prop('checked', false);
    $(this).find("input[type='checkbox']").prop('checked', true);



});

function checkall(source) {

  $('.check').not(source).prop('checked', source.checked);

}
            
  $(function () {
                $('#tablenodiv').DataTable({
                  "pageLength": 5,
            "sDom": "<'row-fluid'<'span6'f><'span6'p>r>t<'row-fluid'<'span6'l>>",
                  "columnDefs": [
                  { "orderable": false, "targets": 0 }
                ],
                  "pagingType" : "simple",
                  "paging": true,
                   lengthMenu: [[1,5, 10, 15, -1], [1,5, 10, 15, "All"]],
                  "lengthChange": true,
                  "searching": true,
                  "ordering": true,
                  "info": true,
                  "autoWidth": true
            
                });
              });


  function delete_all() {

    var checkbox_value2 = $('.form_title:checked').val();
    var checkbox = $('.check:checked');
       var fid = $('.form_title:checked').attr('data-value');

    if(checkbox.length > 0)
    {company_name = $('#company_name').val();
    company_id   = $('#company_id').val();

  appraisal_period_type  = $('#appraisal option:selected').attr('data-type');

cover_year= $('#appraisal option:selected').attr('data-co');
appraisal_period_type_dates = $('#appraisal option:selected').attr('data-value');
appraisal_period_type_dates_appraisal = $('#appraisal_period_type_dates_appraisal').val();

appraisal_type = $('#appraisal_type').val();


appraisal_coverage = $('#appraisal option:selected').attr('data-id');
appraisal_order = $('#appraisal option:selected').attr('data-order');
number_days = $('#appraisal option:selected').attr('data-before');

ref = $('#ref').val();

     var checkbox_value = [];
     var position= [];
     var ran= [];
     $(checkbox).each(function(){
      checkbox_value.push($(this).val());
      position.push($(this).attr('data-value'));
       ran.push($(this).attr('data-id'));
      
    });

     $.ajax({
       url: "<?php echo base_url();?>employee_portal/pms/save_general_form/",
       method:'POST',
       data:{checkbox_value:checkbox_value,checkbox_value2:checkbox_value2,cover_year:cover_year,appraisal_period_type_dates_appraisal:appraisal_period_type_dates_appraisal,appraisal_period_type:appraisal_period_type,appraisal_period_type_dates:appraisal_period_type_dates,appraisal_order:appraisal_order,appraisal_type:appraisal_type,fid:fid,position:position,ran:ran,appraisal_coverage:appraisal_coverage,number_days:number_days,ref:ref,company_id:company_id},
    
   
       success:function()
       {
         alert('qwe');
       },

     })
   }
   else
   {
     alert('Select atleast one records');
   }

  }







</script>

</div>
</div>  
