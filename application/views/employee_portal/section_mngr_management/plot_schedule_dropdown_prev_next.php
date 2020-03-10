  
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/spinner.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/zebra_dp/theme.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/jquery.mCustomScrollbar.css" />

    <!-- Inseparable -->
    <script type="text/javascript" src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/zebra_dp/zebra_datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url()?>public/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- fullCalendar -->
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/fullcalendar/fullcalendar.print.min.css" media="print">
    <script type="text/javascript" src="<?php echo base_url()?>public/plugins/daterangepicker/moment.js"></script>
    <script src="<?php echo base_url()?>public/plugins/fullcalendar/fullcalendar.min.js"></script>
    

     <script type="text/javascript" src="<?php echo base_url()?>public/angular.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/angular-route.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/employee_controller.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/slimscroll.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>public/admin.min.js"></script>
    
    <div id="filter_div">
          <?php 
           
            $fmonth=substr($date_from, 5,2);
            $fday=substr($date_from, 8,2);
            $fyear=substr($date_from, 0,4);

            $tmonth=substr($date_to, 5,2);
            $tday=substr($date_to, 8,2);
            $tyear=substr($date_to, 0,4);

            $begin = new DateTime( $date_from );
            $end = new DateTime( $date_to );
            $end = $end->modify( '+1 day' );

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);

            $f = new DateTime($date_from);
            $t = new DateTime($date_to);

            $today_days = $t->diff($f)->format("%a");
          ?>
<form class="form-horizontal" method="post" action="<?php echo base_url()?>employee_portal/section_mngr_management_plotting/save_employee_schedule/next_prev">
  <input type="hidden" name="month" id="month" value="<?php echo $month;?>">
  <input type="hidden" name="year" id="year" value="<?php echo $year;?>">
  <input type="hidden" name="group" id="group" value="<?php echo $group_id;?>">
  <input type="hidden" name="option" id="option" value="<?php echo $option;?>">
  

<div class="col-md-12">
  <div class="col-md-12">
    <div class="box box-default">
      <div class="panel panel-info">
          <br>
          <div class="col-md-12">
                 <div class="col-md-1">
                  <p> <a href="<?php echo base_url();?>employee_portal/section_mngr_management_plotting/plot_schedule_dropdown_prev_next/<?php echo $group_id.'/'.$month.'/'.$year.'/'.'previous'; ?>" class="btn btn-default btn-block"><b>PREVIOUS</b></a></p>
                </div>
                <div class="col-md-10">
                  <h3 class="text-center"><?php echo  date("F", mktime(0, 0, 0, $fmonth, 10))." ". $fday.' to '.date("F", mktime(0, 0, 0, $tmonth, 10))." ". $tday.", ". $tyear;?></h3>
                </div>
                <div class="col-md-1">
                  <p> <a href="<?php echo base_url();?>employee_portal/section_mngr_management_plotting/plot_schedule_dropdown_prev_next/<?php echo $group_id.'/'.$month.'/'.$year.'/'.'next'; ?>" class="btn btn-default btn-block"><b>NEXT</b></a></p>
               </div>
          </div>

<div id="table-scroll" class="table-scroll" style="margin-top: 40px;">

    <div class="table-wrap">
    <table class="main-table">
      <thead>
       
        <tr>
          <th class="fixed-side" scope="col">No</th>
          <th class="fixed-side" scope="col">Name</th>
          <?php foreach($daterange as $date){

                $datef = $date->format('Y-m-d');
                $dated = $date->format('d');
                $day =  date("D", strtotime($datef)); 
                $tmonth= substr($datef, 5,2);
                $tday=substr($datef, 8,2);
                $m =  date("m", strtotime($datef));
                $formatted =  date("F d", strtotime($datef));
                $formattedday =  date("d", strtotime($datef));
                ?>

                 <td><center><n class="text-danger"><b><?php echo $formatted.'<br>['.$day.']';?></b></n></center><br>
                  <select name="working_sched" id="working_sched" class="form-control select2" style="width: 150px;" onchange="schedule_all(this.value,'<?php echo $formattedday;?>');">
                    <option value="" disabled selected="">Select</option>
                    <option value="restday"> Rest Day</option>
                    <option disabled value="">~~ Regular Whole day Schedule ~~</option>
                    <?php 
                    $ws_regular=$this->plot_schedule_model->get_ws_regular_all();
                    if(!empty($ws_regular)){
                      foreach($ws_regular as $whole_sched){
                                    //reg_ : regular working schedule / whole day
                        echo '<option style="color:#65D8D3;" value="reg_'.$whole_sched->time_in.' to '.$whole_sched->time_out.'">'.$whole_sched->time_in.' to '.$whole_sched->time_out.'</option>';
                      } 
                    }else{
                      echo '<option value="" disabled>  </option>';
                    }
                    ?>
                    <option disabled value="">~~ Half Schedule ~~</option>
                    <?php 
                    $ws_halfday=$this->plot_schedule_model->get_ws_halfday_all();

                    if(!empty($ws_halfday)){
                      foreach($ws_halfday as $half_sched){
                                    //haf_ : halfday working schedule
                        echo '<option style="color:#16810B;" value="haf_'.$half_sched->time_in.' to '.$half_sched->time_out.'">'.$half_sched->time_in.' to '.$half_sched->time_out.'</option>';
                      } 
                    }
                    else{
                      echo '<option value="" disabled>  </option>';
                    }
                    ?>
                    <option disabled value="">~~ Restday/Holiday Schedule ~~</option>
                    <?php 
                    $ws_rd_hol=$this->plot_schedule_model->get_ws_restday_holiday_all();

                    if(!empty($ws_rd_hol)){
                      foreach($ws_rd_hol as $rd_hol_sched){
                                    //rdh : restday holiday working schedule
                        echo '<option style="color:#DC172C;" value="rdh_'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'">'.$rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out.'</option>';
                      } 
                    }
                    else{
                      echo '<option value="" disabled> </option>';
                    }
                    ?>
                  </select>
                </td>

          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php $i=1; foreach ($emp as $ee) { ?>

              <tr>
                <tr>
                <td class="fixed-side"><?php echo $i.').';?>
                <td class="fixed-side" style="width: 200px;"><center><?php echo $ee->first_name.' '.$ee->last_name;?><br><n class="text-danger">[<?php echo $ee->employee_id;?>]</n></center> </td>
                <?php foreach($daterange as $date){
                      $datef = $date->format('Y-m-d');
                      $formattedday =  date("d", strtotime($datef));
                      $get_date = $this->section_mngr_management_plotting_model->get_emp_schedule($ee->employee_id,$datef,$month);

                        if(empty($get_date))
                        {
                            $value_date = "";
                        }
                        else
                        {
                          if(!empty($get_date->restday) AND $get_date->restday==1)
                          {
                              $value_date = 'restday';
                          }
                          else
                          {
                              if(!empty($get_date->shift_in) AND !empty($get_date->shift_out))
                              {
                                 $value_date = $get_date->shift_in.' to '.$get_date->shift_out;
                              }
                              else
                              {
                                 $value_date = '';
                              }
                          }

                        }
                      $check_if_payslip_posted = $this->section_mngr_management_plotting_model->check_date_payslip_posted($datef,$ee->employee_id,$month); 

                      ?>
                      <td>
                       <input type="hidden" id="emp_<?php echo $i;?>" value="<?php echo $ee->employee_id;?>">
                       <?php if(!empty($check_if_payslip_posted))
                       { echo $value_date; } else{?>

                           <select id="<?php echo $ee->employee_id.'_'.$formattedday;?>" name="<?php echo $ee->employee_id.'_'.$formattedday;?>" class="form-control" 
                            onchange="change_border(this.value,'<?php echo $formattedday;?>','<?php echo $i;?>');"  <?php if(empty($value_date)){?> style='border:1px solid #FF0000;' <?php } else{?> style='border:1px solid #7FFFD4;' <?php } ?> >
                            <option value="" disabled selected="">Select</option>
                            <option value="restday" <?php if($value_date=='restday'){ echo "selected"; }?>> Rest Day</option>
                            <option disabled value="not_included">~~ Regular Whole day Schedule ~~</option>
                            <?php 
                            $ws_regular=$this->general_model->get_ws_regular($ee->classification_id,$ee->company_id);
                            if(!empty($ws_regular)){
                              foreach($ws_regular as $whole_sched){
                                $value_checker = $whole_sched->time_in.' to '.$whole_sched->time_out;
                                          //reg_ : regular working schedule / whole day
                                ?>
                                <option style="color:#65D8D3;" value="reg_<?php echo $whole_sched->time_in.' to '.$whole_sched->time_out;?>" <?php if($value_date==$value_checker){ echo "selected"; }?> ><?php echo $whole_sched->time_in.' to '.$whole_sched->time_out;?></option>
                                <?php } 
                              }else{
                                echo '<option value="not_included" disabled>  </option>';
                              }
                              ?>
                              <option disabled value="">~~ Half Schedule ~~</option>
                              <?php 
                              $ws_halfday=$this->plot_schedule_model->get_ws_halfday($ee->classification,$ee->company_id);

                              if(!empty($ws_halfday)){
                                foreach($ws_halfday as $half_sched){
                                 $value_checker = $half_sched->time_in.' to '.$half_sched->time_out;
                                        //haf_ : halfday working schedule
                                 ?>
                                 <option style="color:#16810B;" value="haf_<?php echo $half_sched->time_in.' to '.$half_sched->time_out;?>" <?php if($value_date==$value_checker){ echo "selected"; }?> ><?php echo $half_sched->time_in.' to '.$half_sched->time_out;?></option>
                                 <?php } 
                               }
                               else{
                                echo '<option value="not_included" disabled>  </option>';
                              }
                              ?>
                              <option disabled value="">~~ Restday/Holiday Schedule ~~</option>
                              <?php 
                              $ws_rd_hol=$this->plot_schedule_model->get_ws_restday_holiday($ee->classification_id,$ee->company_id);

                              if(!empty($ws_rd_hol)){
                                foreach($ws_rd_hol as $rd_hol_sched){
                                  $value_checker = $rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out;
                                        //rdh : restday holiday working schedule
                                  ?>
                                  <option style="color:#DC172C;" value="rdh_<?php echo $rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out;?>" <?php if($value_date==$value_checker){ echo "selected"; }?>><?php echo $rd_hol_sched->time_in.' to '.$rd_hol_sched->time_out;?></option>
                                  <?php 
                                } 
                              }
                              else{
                                echo '<option value="not_included" disabled> </option>';
                              }
                              ?>
                            </select>

                       <?php } ?>
                       
                    </td>
                    <?php } ?>
              </tr>

       <?php $i++;  } echo "<input type='hidden' value='".$i."' id='count_employee'>"; ?>
      </tbody>
    </table>
  </div>
</div>


        <center><button type="submit" class="btn btn-success" style="margin-top: 10px;"> SAVE SCHEDULE</button></center>
      <br>
 </div>  
   </div>
 </div>
    
</form>

</div>
<style type="text/css">
  .table-scroll {
  position:relative;
  max-width:96%;
  margin:auto;
  overflow:hidden;
  border:1px solid #000;
}
.table-wrap {
  width:100%;
  overflow:auto;
}
.table-scroll table {
  width:100%;
  margin:auto;
  border-collapse:separate;
  border-spacing:0;
}
.table-scroll th, .table-scroll td {
  padding:5px 10px;
  border:1px solid #000;
  background: #7FFFD4;
  white-space:nowrap;
  vertical-align:top;
}
.table-scroll thead, .table-scroll tfoot {
  background:#7FFFD4;
}
.clone {
  position:absolute;
  top:0;
  left:0;
  pointer-events:none;
}
.clone th, .clone td {
  visibility:hidden
}
.clone td, .clone th {
  border-color:transparent
}
.clone tbody th {
  visibility:visible;
  color:red;
}
.clone .fixed-side {
  border:1px solid #000;
  background:#eee;
  visibility:visible;
}
.clone thead, .clone tfoot{background:transparent;}
</style>

 <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>


<script type="text/javascript">
  // requires jquery library
jQuery(document).ready(function() {
   jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');   
 });

 
    
      function previous_next(option)
      {
        var month = document.getElementById('month').value;
        var year = document.getElementById('year').value;
        var group = document.getElementById('group').value;

        if (window.XMLHttpRequest)
        {
          xmlhttp2=new XMLHttpRequest();
        }
        else
            {// code for IE6, IE5
              xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp2.onreadystatechange=function()
            {
              if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
              {
                document.getElementById("filter_div").innerHTML=xmlhttp2.responseText;
              }
            }
            xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/section_mngr_management_plotting/previous_next/"+option+"/"+month+"/"+year+"/"+group,false);
            xmlhttp2.send();
          }

          function schedule_all(val,dated)
          {
            var count_employee = document.getElementById('count_employee').value;

            for (i = 1; i < count_employee; i++) { 
             var employee = document.getElementById('emp_'+i).value;
             var idd = employee+'_'+dated;
             document.getElementById(idd).value=val;
             var data_check = document.getElementById(idd).value;
             if(data_check=='')
             {
              $('#'+idd).css({'border': '1px solid #FF0000'});
             }
             else
             {
              $('#'+idd).css({'border': '1px solid #7FFFD4'});
             }

            
           }


         }


         function change_border(val,dated , i)
         {
             var employee = document.getElementById('emp_'+i).value;
             var idd = employee +'_'+dated;
             if(val=='')
             {
              $('#'+idd).css({'border': '1px solid #FF0000'});
             }
             else
             {
              $('#'+idd).css({'border': '1px solid #7FFFD4'});
             }
         }
       </script>