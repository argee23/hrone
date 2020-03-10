	<br>
    <form id="evaluators">
        <div class="row">
    <div class="col-md-6">
    <label>Select Appraisal Date</label>
   <select class="form-control" name="DataTable">
         <option value="all">all</option>
        <?php foreach($get_appraisal_schedule as $get_appraisal_schedule){ ?>

    <option value="<?php echo $get_appraisal_schedule->appraisal_period_type_dates; ?>"><?php echo $get_appraisal_schedule->appraisal_period_type_dates; ?></option>
        <?php } ?>
</select>
</div>
<div class="col-md-6">
     <label>Company</label>
   <select class="form-control" name="c">
       <option value="all">all</option>
        <?php foreach($c as $c){ ?>

    <option value="<?php echo $c->company_id; ?>"><?php echo $c->company_name; ?></option>
        <?php } ?>
</select>
</div>
</div>

<br>
    <button id ="filters" class="btn btn-success">Display Report</button>
    </form>
    <hr style="border:1px solid #dd4b39;">
    <table id="example" class="table display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Recommended by</th>
     
                <th>Recommendation</th>
               
             
            </tr>
        </thead>
        <tbody id="lsit">
     
            <?php foreach($comend as $comend){              
                    $res1 = $this->report_pms_model->get_evaluator($comend->employee_id);
                    $res = $this->report_pms_model->get_evaluator($comend->recommended_by);
                    $salary ='';
                    if($comend->salary_increase){
                        $salary .= '<b>Salary increase</b>'.': '.$comend->salary.'<br>';
                    }
                    if($comend->regularization){
                        $salary .='<b>regularization</b>'.': '.date("d-M-Y", strtotime($comend->date)).'<br>';
                    }   
                        if($comend->contract_renewal){
                        $salary .='<b>contract renewal:</b>'.$comend->from.' to '.$comend->to.'<br>';
                    }
                        if($comend->for_lateral_transfer){
                        $salary .= '<b>for lateral transfer</b>'.':'.$comend->c_position.','.$comend->c_department.'<br>';
                    }
                        if($comend->promotion){
                        $salary .= '<b>promotion</b>'.': '.$comend->pos.'<br>';
                    }

                    if($comend->demotion){
                        $salary .= '<b>demotion</b>'.': '. $comend->pos4.'<br>';
                    }

                    if($comend->extend_probationary_period){
                        $salary .= '<b>extend probationary period</b>'.': '.$comend->no_months.'<br>';
                    }
                    if($comend->retain_in_existing_position){
                        $salary .= '<b>retain in existing position</b>'.'<br>';
                    }
                   
                        if($comend->end_of_contract){
                        $salary .= '<b>end of contract</b>'.'<br>';
                    }?>

                    <tr><td><?php echo $res1->fullname; ?></td><td><?php echo $res->fullname; ?></td><td><?php echo $salary; ?></td>

            <?php }?>
   
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
            $(document).on('click','#filters',function(ew) {
  ew.preventDefault();
  var data = $("#evaluators").serialize();
  $.ajax({
   data: data,
   type: "post",
   url: "<?php echo base_url().'app/report_pms/evaluators/'?>",
   success: function(e){
    $('#lsit').html(e);
  }
});
});

    </script>
