<style type="text/css">
    th{
        text-align: center;
    }
#tabls {
  display: block;
  height: 400px;
  overflow-y: scroll;
}

</style>
  
<br>    <form id="evaluators">

<div class="row">
<div class="col-md-6 col-md-offset-3">
  <div class="row">
<div class="col-md-12 ">
    <label>From</label>

   <select class="form-control" name="from">
         <option value="">Select Date</option>
        <?php foreach($get_appraisal_schedule as $from){ ?>

    <option value="<?php echo $from->appraisal_period_type_dates; ?>"><?php echo $from->appraisal_period_type_dates; ?></option>
        <?php } ?>
</select>
</div>
</div>
<div class="row">
<div class="col-md-12 ">
    <label>To</label>

   <select class="form-control" name="to">
         <option value="">Select Date</option>
        <?php foreach($get_appraisal_schedule as $to){ ?> 

    <option value="<?php echo $to->appraisal_period_type_dates; ?>"><?php echo $to->appraisal_period_type_dates; ?></option>
        <?php } ?>
</select>
</div>
</div>

  <div class="row">
<div class="col-md-12">
  <label>Company</label>
   <select class="form-control" name="c" id="c">
            
              <option value="">Select Company</option>
        <?php foreach($c as $c){ ?>

    <option value="<?php echo $c->company_id; ?>"><?php echo $c->company_name; ?></option>
        <?php } ?>
</select>

</div>
   </div>
   <br>
  <div class="row" >
    <div class="col-md-12">  <span style="margin-left: 140px;"> <b>By Group</b>     <input type="radio" name="s" id="scradio"><span style="margin-left: 50px;"></span>
    <b>By Employee</b>  <input type="radio" name="s" id="cradio"></div>
 </div>
  <div  id="lc" style="display:none;">



   <div class="row">
<div class="col-md-12">
    <label>Department</label>

   <select class="form-control" name="department" id='department'>
      
 
</select>
</div>
</div>
   <div class="row">
<div class="col-md-12">
    <label>Section</label>

   <select class="form-control" name="section" id="section">
 
</select>
</div>
</div>
   <div class="row">
<div class="col-md-12">
    <label>Classification</label> 

   <select class="form-control" name="classification" id="classification">
 
</select>
</div>
</div>

      
</div>
<div  style="display:none;" id="employee">
         <div class="row">
<div class="col-md-12">
  <label>Name</label>




         <select name="employee" id="txtinput" class="selectpicker" data-size="5" data-dropup-auto="false" data-live-search="true" data-width="100%" data-style="btn-default">
                 
                    </select>

</div>
   </div>
    

</div>
<br><br>
<div style="text-align: center;"> <button id ="flirters" class="btn btn-success btn-md">Display Report</button></div>
  
</div>


</div>


   <br>

    </form>
 
<br> 
  <hr style="border:1px solid #dd4b39;"><br>   
<div class="row" >
  <div class="col-md-12" id="request">
    
  </div>
 


    </div>
    <br><br>
        <span id='qws'></span>
        <span id='qwes'></span>

    <script type="text/javascript">

                        $(document).on('click','#flirters',function(ew) {
                          $('#qwes').empty();
  ew.preventDefault();
  $
  var data = $("#evaluators").serialize();
  $.ajax({
   data: data,
   type: "post",
   url: "<?php echo base_url().'app/report_pms/all/'?>",
   success: function(e){
    $('#request').html(e);
  }
});
});
                            $(document).on('change','#c',function(ew) {
 
  var c =  $('#c').val();
  $.ajax({
   data: {c : c},
    dataType: "JSON",
   type: "post",
   url: "<?php echo base_url().'app/report_pms/get_department/'?>",
            success: function(data) {
              $('#department').empty();
              $('#classification').empty();
              $('#txtinput').empty();
                  $('#department').append('<option>Select Department</option>')

                $.each(data[0], function(index, element){

                  $('#department').append($('<option>', {
    value: element.id,
    text: element.name
}));
});                                 $('#classification').append('<option>Select Classification</option>')
                                  $.each(data[1], function(index, element){
                  $('#classification').append($('<option>', {
    value: element.id,
    text: element.name
}));
    });   

                 $('#txtinput').append('<option>Select Name</option>')

                $.each(data[2], function(index, element){

                  $('#txtinput').append($('<option>', {
    value: element.id,
    text: element.name
}));
});       
 $('#txtinput').selectpicker('refresh');
            }


});
  });
                                                      $(document).on('change','#department',function(ew) {
 
  var c =  $('#department').val();
  $.ajax({
   data: {c : c},
    dataType: "JSON",
   type: "post",
   url: "<?php echo base_url().'app/report_pms/get_section/'?>",
            success: function(data) {

              $('#section').empty();
              $('#section').append('<option>Select section</option');
                $.each(data, function(index, element){
                  $('#section').append($('<option>', {
    value: element.id,
    text: element.name
}));
}); 
                                 


            }

});
  });

                                                      $(document).ready(function () {

        $('#txtinput').autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url().'app/report_pms/SearchResult/'?>",
                    data: { term: request.term},
                    dataType: "json",
                    success: function (data) {
                        $("#s").html('');

                        response($.map(data, function (item) {
                            return {
                                value: item.label,
                                label: item.value,
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
             inner_html = '<td>'+item.label + '</td><td><a style="cursor:pointer;" class="get" data-id = '+item.label+'>'+item.value + '</a></td>';
            return $("<tr></tr>")
                 
                    .append(inner_html)
                    .appendTo("#s");
        };
    });

    $(document).on('click','.get',function(){

        $('#txtinput').val($(this).text());
        $('#monk').val($(this).attr('data-id'));

    }); 
$("input:radio").change(function () {
if ($("#cradio").is(":checked")) {
             $("#lc").css("display", 'none');
              $("#employee").css('display','block');
                $("#lc :input").prop("disabled", true);
              $("#employee :input").prop("disabled", false);
              $('#employee_ble').css('display','block');
    }
    else if($("#scradio").is(":checked")) {
       $("#employee").css('display','none');
              $("#lc").css("display", 'block');
                 $("#employee :input").prop("disabled", true);
              $("#lc :input").prop("disabled", false);  
    }
});
      $('.selectpicker').selectpicker({
        // style: 'btn-info',
        // size: 4
      });

    </script>