<title><?php echo $this->session->userdata('sys_name');?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600"
rel="stylesheet">
<link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
<link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
<!-- //=======================export to excel -->
<script type="text/javascript" src="<?php echo base_url()?>/public/jquery-1.9.0.js"></script>
<script type="text/javascript">
$(function(){
$('#export').click(function(){
     //getting values of current time for generating the file name
        var dt = new Date();
        var day = dt.getDate();
        var month = dt.getMonth() + 1;
        var year = dt.getFullYear();
        var hour = dt.getHours();
        var mins = dt.getMinutes();
        var postfix = year + "-" + month + "-" + day ;
        //creating a temporary HTML link element (they support setting file names)
        var a = document.createElement('a');
        //getting data from our div that contains the HTML table
        var data_type = 'data:application/vnd.ms-excel';
        var table_div = document.getElementById('tableWrap');
        var table_html = table_div.outerHTML.replace(/ /g, '%20');
        a.href = data_type + ', ' + table_html;
        //setting the file name
        a.download = postfix + '_Mass_Transaction_Encoding' + '.xls';
        //triggering the function
        a.click();
        //just in case, prevent default behaviour
        e.preventDefault();
})
})
</script>


<?php

    $pay_period=$this->plot_schedule_model->get_assigned_payroll_period_latest_date($company_id);  
                if(!empty($pay_period)){           
    $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from;
    $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;
                             
    $from =$pay_period->year_from.'-'.$pay_period->month_from.'-'.$pay_period->day_from;
    $to = $pay_period->year_to.'-'.$pay_period->month_to.'-'.$pay_period->day_to;

    $pay_code_id= $pay_period->id;

    }else{  //wala pang payroll period
    }

    $group_detail=$this->plot_schedule_model->get_group_detail($group_id); 
    if(!empty($group_detail)){
        $group_name= $group_detail->group_name;

    }else{
        $group_name='group not found';
    }

      $company=$this->general_model->get_company_info($company_id);
      if(!empty($company)){
        $company_name =$company->company_name;
        $company_logo =$company->logo;
        $company_address =$company->company_address;
        $company_contact_no =$company->company_contact_no;
        $company_tin =$company->TIN;
      }else{
        $company_name ='company not found';
        $company_logo ='company not found';
        $company_address ='company not found';
        $company_contact_no ='company not found';
        $company_tin ='company not found';
      }

?>


<input type="hidden" value="<?php echo $company_id; ?>" id="company_id">
<input type="hidden" value="<?php echo $group_id; ?>" id="group_id">
<form name="f" method="post" action="<?php echo base_url()?>app/plot_schedules/save_admin_group_plot_sched/<?php echo $group_id;?>/<?php echo $company_id;?>/<?php echo $pay_code_id;?>" > 
<h3 class="text-danger"><center><label>Plot working Schedules</label></center></h3>
<dic class="col-md-12">
    <div style="border-top:2px solid #000;height:100%;padding-bottom: 20px;" id="tablewrap">
    <br>

        <div class="col-md-12" style="padding-top: 20px;padding-bottom: 5px;">
         <div class="panel panel-default">
            <div class="panel-heading" style="height: 70px;">
                  <div class="col-md-2"><label>Select Payroll Period</label></div>
                   <div class="col-md-4">
                        <select name="" id=""  class="form-control" onchange="what_payroll_period(this.value)" style="border:1px solid red;">
                            <option selected disabled>Select Payroll Period</option>
                                <?php 
                                $payroll_period=$this->plot_schedules_model->get_assigned_payroll_period($company_id,$group_id);  
                                if(!empty($payroll_period)){
                                    foreach($payroll_period as $pay_period){

                                    $df= date("F", mktime(0, 0, 0, $pay_period->month_from, 10))." ".$pay_period->day_from." ".$pay_period->year_from;
                                    $dt= date("F", mktime(0, 0, 0, $pay_period->month_to, 10)). " ".$pay_period->day_to." ".$pay_period->year_to;

                                        echo '<option value="'.
                                        $pay_period->year_from.'-'.$pay_period->month_from.'-'.$pay_period->day_from.
                                        ' to '.$pay_period->year_to.'-'.$pay_period->month_to.'-'.$pay_period->day_to.
                                        ' ">'.$df. ' to '. $dt. '</option>';
                                    }
                                }else{
                                    echo '<option disabled> company has no payroll period yet . please add first. </option>';
                                }

                                ?>
                        </select>
                    </div>
                    <div class="col-md-2"><label>Group Name</label></div>
                        <div class="col-md-4">
                         <n class="text-danger"> <u><?php echo $group_name; ?></u></n>
                        </div>
                    </div>
            </div>
        </div>
           
        
        <div style="width:100%;overflow: scroll;height:auto;height: 100%;" >
            <table class="table table-bordered table-striped">
                <thead>
                    <tr class="success">
                        <th> Employee ID</th>
                        <th> Employee Name</th>
                        <th> Date Registered </th>
                    </tr>
                     <tr>
                        <td colspan="3"><center>Select Payroll Period to continue.</center></td>
                    </tr>
            </table>
        </div>
    </div>
</div>
</div>
</form>


<script>
function what_payroll_period(val){
   
       var company_id = document.getElementById("company_id").value;
       var group_id = document.getElementById("group_id").value;
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
            
            document.getElementById("tablewrap").innerHTML=xmlhttp2.responseText;
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>app/plot_schedules/admin_group_plot_sched_2/"+val+"/"+company_id+"/"+group_id,false);
        xmlhttp2.send();

}

</script> 