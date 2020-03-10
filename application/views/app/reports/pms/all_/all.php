<style type="text/css">
    th{
        text-align: center;
    }
</style>
<form action="<?=base_url()?>search" method="get">
    <input name="keyword" type="text"  id="txtinput" >
</form>
<br>    <form id="evaluators">
<div class="row">
    <div class="col-md-3">
    <label>Select Appraisal Date</label>


   <select class="form-control" name="from">
         <option value="all">all</option>
        <?php foreach($get_appraisal_schedule as $from){ ?>

    <option value="<?php echo $from->appraisal_period_type_dates; ?>"><?php echo $from->appraisal_period_type_dates; ?></option>
        <?php } ?>
</select>
</div>


  <div class="col-md-3">
     <label>Select Appraisal Date</label>
   <select class="form-control" name="to">
         <option value="all">all</option>
        <?php foreach($get_appraisal_schedule as $to){ ?>

    <option value="<?php echo $to->appraisal_period_type_dates; ?>"><?php echo $to->appraisal_period_type_dates; ?></option>
        <?php } ?>
</select>

</div>
 

  <div class="col-md-6">
  <label>Company</label>
   <select class="form-control" name="c" id="company">
       <option value="all">all</option>
        <?php foreach($c as $c){ ?>

    <option value="<?php echo $c->company_id; ?>"><?php echo $c->company_name; ?></option>
        <?php } ?>
</select>

</div>
   </div>
   <div class="row">
    <div class="col-md-6">
    <label>Select Appraisal Date</label>

   <select class="form-control" name="qwe" id="qwe">
    <option value="val">Select Category</option>
    <option value="department">By Department</option>
    <option value="position">By Position</option>
    <option value="section">By Section</option>
    <option value="classification">By Classification</option>
    <option value="employee">By employee</option>
     <option value="location">By location</option>

</select>
</div>
  <div class="col-md-6 qwe"  id="employee" style="display:none">
  <label>employee</label>
    
</div>
  <div class="col-md-6 qwe"  id="location" style="display:none">
  <label>location</label>
   <select class="form-control" id="location_val" required="">

  </select>

</div>
  <div class="col-md-6 qwe"  id="section" style="display:none">
  <label>section</label>
   <select class="form-control" id="section_val" name="section" required="">

  </select>

</div>

  <div class="col-md-6 qwe"  id="position" style="display:none">
  <label>Position</label>
   <select class="form-control" id="position_val" required="">

  </select>

</div>

  <div class="col-md-6 qwe"  id="department" style="display:none">
  <label>Department</label>
   <select class="form-control" id="department_val" name="department" required="">

  </select>

</div>


  <div class="col-md-6 qwe" id="classification" style="display:none">
  <label>classification
  </label>
   <select class="form-control" id="classification_val" required=""> 
      
  </select>

</div>

   </div>
   <br>
   <button id ="flirters" class="btn btn-success btn-md">Display Report</button>
    </form>
<br>
   <hr style="border:1px solid #dd4b39;"><br>   
    <table id="example" class="table display nowrap" style="width:100%;text-align:center;">
        <thead style="text-align:center;">
            <tr>
                <th>Name</th>
                <th>Approver</th>
         
                <th>Status</th>
                <th>Appraisal Date</th>
                <th>Score </th>
                <th>Agreement</th>
               
            </tr>
        </thead>
        <tbody id="lsit">
        
           <?php foreach($get_all as $get_all){ ?>
            <tr>
                <td><?php echo $get_all->fullname ?></td>
                <td><?php $res = $this->report_pms_model->get_approver($get_all->approvers); echo $res->fullname?></td>
                <?php if($get_all->status== 'done'){?>
                <td style="background-color: #03CB72; color:white"><?php  echo 'Completed';  ?></td>
                <?php }else{ ?>
                 <td style="background-color: #E3435B;color:white"><?php  echo 'Not Initiated';  ?></td>
                 <?php } ?>
                <td><?php echo $get_all->appraisal_period_type_dates; ?></td>
                <td><?php echo $get_all->score.'( '.$get_all->score_equivalent.' )'; ?></td>
                <td><?php echo $get_all->agreement; ?></td>

             
            </tr>
        <?php } ?>
        </tbody>

    </table>

    <script type="text/javascript">
            $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
                        $(document).on('click','#flirters',function(ew) {
  ew.preventDefault();
  var data = $("#evaluators").serialize();
  $.ajax({
   data: data,
   type: "post",
   url: "<?php echo base_url().'app/report_pms/all/'?>",
   success: function(e){
    $('#lsit').html(e);
  }
});
});     $(document).on('change','#qwe',function(ew) {
                val = $("#company").val();     
                $('.qwe').css('display','none');
                if($('#qwe').val() == 'department'){
                        c = 'department';
                       $('#department').css('display','block');

                }else if($('#qwe').val() == 'classification'){
                        c = 'classification';
                       $('#classification').css('display','block');
                }else if($('#qwe').val() == 'section'){
                        c= 'section';
                       $('#section').css('display','block');
                }
                else if($('#qwe').val() == 'location'){
                        c ='location';
                       $('#location').css('display','block');
                }else if($('#qwe').val() == 'position'){
                        c = 'position';
                       $('#position').css('display','block');
                }else if($('#qwe').val() == 'employee'){
                        c = 'employee';
                       $('#employee').css('display','block');
                }


      $.ajax({ 
            url: "<?php echo site_url('app/report_pms/get_department_sec'); ?>",
            type: 'POST',
            dataType: "JSON",
            data: { "text1": val,'c':c },
            success: function(data) {
                $('#department_val').empty();
                $('#section_val').empty();
                $('#position_val').empty();
                $('#location_val').empty();
                $('#classification_val').empty();
                $.each(data, function(index, element){
                  if(element.qwe == 'department'){
                  $('#department_val').append(('<option value='+element.id+'>'+element.name+'</option'));
                }else if(element.qwe == 'classification'){
$('#classification_val').append(('<option value='+element.id+'>'+element.name+'</option'));
                }else if(element.qwe == 'location'){
$('#location_val').append(('<option value='+element.id+'>'+element.name+'</option'));
                }
                else if(element.qwe == 'position'){
$('#position_val').append(('<option value='+element.id+'>'+element.name+'</option'));
                }
                          else if(element.qwe == 'section'){
$('#section_val').append(('<option value='+element.id+'>'+element.name+'</option'));
                }
    });   


            }
          });




});
$(document).on('change','#company',function(ew) {
            $('.qwe').css('display','none');
            $("#qwe").val("val").change();

  });   


        $('#txtinput').autocomplete({
            source: function (request, response) {
                $.ajax({
                       url: "<?php echo site_url('app/report_pms/SearchResult'); ?>",
                    data: { term: request.term},
                    dataType: "json",
                    success: function (data) {

                        response($.map(data, function (item) {
                            return {
                                value: item.label,
                            };
                        }))
                    }
                })
            },
            focus: function() {
             return false;
            },
            select: function (event, ui) {
                return false;
            }
        }).data("ui-autocomplete")._renderItem = function (ul, item) {
             var  inner_html = '';
             inner_html = '<a>'+item.label + '</a><hr style="margin-top: 0px;margin-bottom: 0px;">';
            return $("<li></li>")
                    .data("ui-autocomplete-item", item)
                    .append(inner_html)
                    .appendTo(ul);
        };
 
    </script>