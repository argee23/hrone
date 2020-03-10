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
        
              <?php if(!empty($appraisal->cover_year)){ ?>
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
   
    <?php if(!empty($appraisal->cover_year)){ ?>
    <input type="text" style="visibility:hidden;" value="<?php echo $appraisal->appraisal_period_type_dates; ?>" name="appraisal_period_type_dates" id="appraisal_period_type_dates">
  	<input type="text" style="visibility:hidden;" value="<?php echo $appraisal->cover_year; ?>" name="cover_year" id="cover">
    <input type="text" style="visibility:hidden;" value="<?php echo $appraisal->appraisal_period_type; ?>" name="cover_year" id="appraisal_period_type">
    

  <input id="appraisal_period_type_dates_appraisal" type="text" style="visibility:hidden;" name="appraisal_period_type_dates_appraisal" value="<?php echo $closest_appraisal; ?>">
    <?php if($appraisal->company_name){ ?>

    <input type="text" style="visibility:hidden;" value="<?php echo $appraisal->company_name; ?>" style="visibility:hidden;" name="company_name" id="appraisal_type">
  <?php }elseif($appraisal->pay_type_name){ ?>
     <input type="text" value="<?php   echo $appraisal->pay_type_name;  ?>" style="visibility:hidden;" name="pay_type_name" id="appraisal_type">
     <?php 
       }elseif($appraisal->appraisal_group_name){ ?>
        <input type="text" value="<?php  echo $appraisal->appraisal_group_name  ?>" style="visibility:hidden;" name="appraisal_group_name" id="appraisal_type">
      <?php } ?>
<?php }else{
  echo '';
} ?>
	</form>
  
	</div>
                        <th id="no" style="left:10px;"><center><input type="checkbox"  onclick="checkall(this);"></center></th>
                        <th><center>Name</center></th>
                        <th><center>Department</center></th>
                        <th><center>Section</center></th>
                        <th><center>Location</center></th>
                        <th><center>Classification</center></th>
                        <th><center>position</center></th>
                        <th><center>Status</center></th>
                      </tr>
                  </thead>
                  <tbody>
					   

                    <?php foreach ($employee_under_creator as $employee_under_creator) { ?>

                      <tr style="text-align: center;">
                              <td><input type="checkbox" name="check" class="check" value="<?php echo $employee_under_creator->employee_id; ?>" data-value="<?php echo $employee_under_creator->position_name ?>" data-id="<?php echo rand(); ?>"></td>

                                <td><a style="cursor: pointer;" onclick="scorecard(<?php echo $employee_under_creator->employee_id?>,'<?php echo $employee_under_creator->fullname; ?>');"><?php echo $employee_under_creator->fullname;?></a></td>

                                <td><?php echo $employee_under_creator->dept_name; ?></td>
                                <td><?php echo $employee_under_creator->section_name; ?></td>
                                <td><?php echo $employee_under_creator->location_name; ?></td>
                                <td><?php echo $employee_under_creator->classification; ?></td>
                                      <td><?php echo $employee_under_creator->position_name; ?></td>
      <?php if($employee_under_creator->form_tagging == ''){ ?>
                                 <td style="background-color: 
                                 #E3435B; color:white;";>Pending</td>
                               <?php  }elseif($employee_under_creator->form_tagging =='for evaluation'){?>
                                   <td style="background-color: 
                                 #03CB72;color:white";>Evaluation</td>
                               <?php }elseif($employee_under_creator->form_tagging =='for evaluation'){?>
                                   <td style="background-color: 
                                 #03CB72;color:white";>Evaluation</td>
                               <?php }  ?>
                      </tr>
                    <?php } ?>
                  </tbody>
              </table>
              </div>
           
            </div>
          </div>
<?php }else{?>
     <center><h4><strong>NO APPRAISAL SCHEDULE IS CREATED FOR THIS YEAR</strong></h4></center>
<?php }?>

   <div id="employee_table">
            

               </div>

 
<script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
function scorecard(employee_id,fullname){

        $.ajax({
            url: "<?php echo base_url();?>employee_portal/pms/view_scorecards/"+employee_id+"/"+fullname,
             method:"POST",
              data:{checkbox_value:fullname},
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
  appraisal_period_type  = $('#appraisal_period_type').val();
cover_year= $('#cover').val();
appraisal_period_type_dates = $('#appraisal_period_type_dates').val();
appraisal_period_type_dates_appraisal = $('#appraisal_period_type_dates_appraisal').val();
appraisal_type = $('#appraisal_type').val();

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
       data:{checkbox_value:checkbox_value,checkbox_value2:checkbox_value2,cover_year:cover_year,appraisal_period_type_dates_appraisal:appraisal_period_type_dates_appraisal,appraisal_period_type_dates:appraisal_period_type_dates,appraisal_period_type:appraisal_period_type,appraisal_period_type_dates:appraisal_period_type_dates,appraisal_type:appraisal_type,fid:fid,position:position,ran:ran},
         beforeSend: function(){
           toastr.info('Please wait ');
           toastr.clear();
        },
   
       success:function()
       {
         toastr.success('insertion is completed');
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
