<div class="col-md-12" style="margin-top: 20px;">
  <?php echo $message;?>
</div>
<link href="<?php echo base_url()?>public/bootstrap/css/tables.css" rel="stylesheet">  
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<br><br><br>
<div>
    <!-- Start of Side View -->
    <div class="col-md-3">
     <div class="box box-solid box-success">
        <div class="box-header">
        <h5 class="box-title">Training and Seminar Requests</h5>
        </div>
        <div class="box-body fixed-panel-side-dos mCustomScrollbar" data-mcs-theme="dark">
          <ul class="nav nav-pills nav-stacked" >
                
                <li class="my_hover">
                    <a style="cursor: pointer;" onclick="location.reload();">ACTIVE TRAINING REQUEST</a>
                </li>

                <li class="my_hover">
                    <a style="cursor: pointer;" onclick="get_joined_unjoined_incoming(1);">INCOMING TRAININGS AND SEMINARS<br>(accepted request)</a>
                </li>

                <li class="my_hover">
                    <a style="cursor: pointer;" onclick="get_joined_unjoined_incoming(0);">INCOMING TRAININGS AND SEMINARS <br>(Declined request)</a>
                </li>

                 <li class="my_hover">
                    <a style="cursor: pointer;" onclick="incoming_history();">TRAINING REQUEST HISTORY</a>
                </li>

          </ul>
        </div>
      </div>
    </div>

  <div class="col-md-9" style="padding-bottom: 50px;">
      <div class="box box-success">
        <div class="panel panel-info">
              <div class="col-md-12" id="fetch_all_result"><br>
              <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>LIST OF TRAINING AND SEMINAR REQUESTS
              </h4></ol>
              <div style="height: 505px";>
                
                <?php foreach($details as $d){
                  $get_dates = $this->training_request_model->get_incoming_dates($d->training_seminar_id);
                ?>
               
                 <div class="col-md-12">
                    <div class="panel panel-default">
                      <div class="panel-heading"><n class="text-success"><strong><?php echo $d->training_title;?></strong></n>  
                       <span class="blink text-danger pull-right">
                             <a  style="cursor: pointer;color: red;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('employee_portal/training_request/respond_training_request')."/".$d->training_seminar_id;?>" class="pull-right"  >Respond to a <?php echo $d->training_type;?> request</a>
                      </span>
                      </div>
                      <div class="panel-body">

                        <span class="dl-horizontal col-sm-6">
                            <dt>Training Type</dt>
                            <dd><?php echo $d->training_type;?></dd>

                            <dt>Sub Type</dt>
                            <dd><?php echo $d->sub_type;?></dd>

                            <dt>Conducted By Type</dt>
                            <dd><?php echo $d->conducted_by_type;?></dd>

                            <dt>Conducted By</dt>
                            <dd><?php echo $d->conducted_by;?></dd>

                            <dt>Purpose / Objective</dt>
                            <dd><?php echo $d->purpose;?></dd>


                            <dt>Address Conducted</dt>
                            <dd><?php echo $d->training_address;?></dd>
                            
                        </span>

                        <span class="dl-horizontal col-sm-6">


                            <dt>Date From</dt>
                            <dd>
                                <?php 
                                  $month=substr($d->datefrom, 5,2);
                                  $day=substr($d->datefrom, 8,2);
                                  $year=substr($d->datefrom, 0,4);

                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                ?>

                            </dd>

                            <dt>Date To</dt>
                            <dd>
                                <?php 
                                  $month=substr($d->dateto, 5,2);
                                  $day=substr($d->dateto, 8,2);
                                  $year=substr($d->dateto, 0,4);

                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                ?>
                            </dd>

                            <dt>Fee Type</dt>
                            <dd><?php echo $d->fee_type;?></dd>

                            <dt>Attachment</dt>
                            <dd><?php echo substr($d->file_name,0,32);?>...</dd>

                            <dt>Fee Amount</dt>
                            <dd><?php echo $d->fee_amount;?></dd>

                            
                        </span>

                        <div class="col-md-12" style="padding-top: 10px;">
                          <div class="col-md-1"></div>
                          <div class="col-md-11">
                            <div class="datagrid">
                              <table>
                                <thead>
                                </thead>
                                <tbody>
                                  <tr class="alt">
                                    <td><b>Date</b></td>
                                    <td><b>Time</b></td>
                                    <td><b>Hours</b></td>
                                  </tr>
                                  <?php foreach($get_dates as $g)
                                  {?>
                                    <tr>
                                      <td>
                                           <?php 
                                            $month=substr($g->date, 5,2);
                                            $day=substr($g->date, 8,2);
                                            $year=substr($g->date, 0,4);

                                            echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                            ?>
                                      </td>
                                      <td><?php echo $g->time_from." to ".$g->time_to;?></td>
                                      <td><?php echo $g->hours;?></td>
                                    </tr>
                                  <?php } ?>
                                   <tr class="alt">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>

                <?php } ?>
              </div>
              </div>
              <div class="btn-group-vertical btn-block"> </div>   
        </div>             
      </div> 
    </div> 

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog">
       <div class="modal-content modal-md">
       </div>
    </div>
</div>

 <style type="text/css">
     .blink{
          
          font-family: cursive;
          animation: blink 2s linear infinite;
        }
   
              
        @keyframes blink{
        0%{opacity: 0;}
        50%{opacity: .5;}
        100%{opacity: 1;}
    } 
  </style>
 <!--//==========Start Js/bootstrap==============================//-->
  
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <!--//==========End Js/bootstrap==============================//-->
<script type="text/javascript">

function get_joined_unjoined_incoming(val)
{
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
            document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
            }
          }
         xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/training_request/get_joined_unjoined_incoming/"+val,false);
        xmlhttp2.send();
}
function update_reponse(val,id)
{
   var result = confirm("Are you sure you want to update your request response");
    if(result == true)
      {

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
              location.reload();
            }
          }
         xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/training_request/update_reponse/"+val+"/"+id,false);
        xmlhttp2.send();
      }
}

function incoming_history()
{
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
              document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
               $("#history").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
         xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/training_request/incoming_history/",false);
        xmlhttp2.send();
}

function filter_history()
{
    var response_status    = document.getElementById('response_status').value;
    var training_status   = document.getElementById('training_status').value;
    var date_from         = document.getElementById('date_from').value;
    var option            = document.getElementById('option').value;
    var training_type     = document.getElementById('training_type').value;
    var date_to           = document.getElementById('date_to').value;

    if(date_to == '')
    {
      date_to = 'not_included';
    }
    if(date_from == '')
    {
      date_from = 'not_included';
    }
    
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
              document.getElementById("filter_history_result").innerHTML=xmlhttp2.responseText;
               $("#history").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
         xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/training_request/filter_history_result/"+response_status+"/"+training_status+"/"+date_from+"/"+date_to+"/"+option+"/"+training_type,false);
        xmlhttp2.send();
}

function view_trainingsseminars(val)
{
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
              document.getElementById("fetch_all_result").innerHTML=xmlhttp2.responseText;
            }
          }
         xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/training_request/view_trainingsseminars/"+val,false);
        xmlhttp2.send();
}

</script>