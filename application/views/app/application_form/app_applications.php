
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
<br>
<title>Job Applications</title>
<style>
.item:hover {
	/*background-color: #D7EFF7;*/
	background-color: #D7E0F5;
}
</style>

<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>

<body ng-app="jobApp" ng-controller="appCtrl" ng-init="getApplications()" class="content-body">
<!-- STATUS FILTERS -->
  <div class="col-md-12">
      <div class="col-md-12"><?php echo $message;?></div>
      <?php echo validation_errors(); ?>
  </div>   
    <div class="col-md-3" style="padding-top: 20px;">

    <div class="col-md-12">
      <div class="box box-success">
        <div class="panel panel-info">
              <h4 class='text-danger'><center>Search Application Here. . </center></h4>
              <div class="col-md-12"><br>
                <div class="col-md-12">
                  <select class="form-control" id="search_category">
                    <option value="">Select</option>
                    <option value="company">Company</option>
                    <option value="job_title">Job title</option>
                  </select>
                </div>
                <div class="col-md-12" style="padding-top: 10px;">
                  <input type="text" class="form-control" placeholder="Enter Search Criteria" id="search_title">
                <input type="hidden" id="search_ftitle">
                </div>

                <div class="col-md-12" style="padding-top: 10px;">
                  <button class="col-md-12 btn btn-success" onclick="get_search();">SEARCH</button>
                </div>

              </div>
              <div class="btn-group-vertical btn-block"> </div>   
        </div>             
      </div> 
    </div>

    <div class="col-md-12">
      <div class="box box-success">
        <div class="panel panel-info">
              <div class="col-md-12"><br>
                <ul class="nav nav-pills nav-stacked">
                 <li  class="my_hover"><a style='cursor: pointer;' onclick="get_status_applications_list('all');"><i class='fa fa-circle-o'></i>All</a></li>

               <?php foreach ($statusList as $stat) { ?>

                 <li  class="my_hover"><a style='cursor: pointer;' onclick="get_status_applications_list('<?php echo $stat->idd;?>');"><i class='fa fa-circle-o'></i><?php echo ucwords($stat->status_title); ?>
                 <?php if($stat->count==0){} else{?><span class="badge badge-warning"><?php echo $stat->count;?></span><?php }?></a></li>
             <?php
              } ?>
                </ul>

                 <style type="text/css">
                  .badge-warning {
                    background-color: #f89406;
                  }
                  .badge-warning:hover {
                    background-color: #c67605;
                  }
                </style>
              </div>
              <div class="btn-group-vertical btn-block"> </div>   
        </div>             
      </div> 
    </div>
    </div> 

    <div class="col-md-9" style="padding-top: 30px;">
      <div class="box box-default">
        <div class="panel panel-info">
        <div class="col-md-12" id="fetch_all_result_action" style="height:auto;">

          <div class="col-md-12" style="margin-top: 20px;">
                <h4 style="font-family: serif;"><center>Applicant Job Application/s</center></h4>
          <div class="col-md-12">
          <n class='text-info'><i>Showing <?php echo count($jobs);?> Entries. . </i></n>
          </div>
          <div class="col-md-12 well well-sm bg-darken-3" style="padding-top: 20px;">
         <?php foreach($jobs as $j)
          {

            $resume = $this->application_forms_model->check_resume_status($j->job_id,$j->employee_info_id);
            $requirements =  '';
            $questions =  '';
                 ?>
          <!-- APPLICATIONS VIEW -->
                    <div class="col-md-6">
                      <div class="box box-widget widget-user-2 item" >
                            <div class="well well-sm bg-aqua" style="height:100px;">
                              <div class="widget-user-image">
                              <?php if(empty($j->logo)){?>
                                <img class="img-circle" src="<?php echo base_url() . 'public/company_logo/' ?>default_logo" alt="company">
                              <?php } else{?>
                                 <img class="img-circle" src="<?php echo base_url() . 'public/company_logo/' ?><?php echo $j->logo;?>" alt="company">
                              <?php } ?>
                              </div>
                              <h5 class="widget-user-username"><?php echo $j->company_name;?></h5>
                              <h5 class="widget-user-desc"><?php echo $j->position_name;?></h5>
                            </div>

                            <div class="box-footer no-padding">
                              <ul class="nav nav-stacked hover">
                                <li><a href="#">Date Applied <span class="pull-right"><?php echo $j->date_applied;?></span></a></li>
                              
                                <li>


                                <?php if($j->ApplicationStatus==2 || $j->ApplicationStatus==3 || $j->ApplicationStatus==4){?>
                                  <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status_updates')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$j->ApplicationStatus;?>" >Status <span class="pull-right"><n style="color:<?php echo $j->color_code;?>"><?php echo $j->status_title;?></n></span></a>
                                <?php } 
                                else if($j->ApplicationStatus==1)
                                {
                                    $get_active_interview = $this->application_forms_model->get_applicant_active_interview($j->id);
                                    if(empty($get_active_interview)){}
                                    else
                                    {
                                      
                                      $get_active_interview = $this->application_forms_model->get_applicant_active_interview_details($j->id,$get_active_interview);
                                      if(!empty($get_active_interview->response))
                                      {
                                          if($get_active_interview->response=='Accept' || $get_active_interview->response=='Decline')
                                          {?>

                                            <a style="cursor: pointer;" data-toggle='modal' data-target='#modal'  href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" >Status <span class="pull-right label bg-olive">View <?php echo $get_active_interview->response;?> Interview Details</span></a>

                                          <?php }
                                          else
                                          {
                                            if($get_active_interview->company_response=='Accept' || $get_active_interview->company_response=='Decline')
                                            {?>
                                               <a style="cursor: pointer;" data-toggle='modal' data-target='#modal'  href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" >Status <span class="pull-right label bg-olive">View <?php echo $get_active_interview->response;?> Interview Details</span></a>
                                            <?php }
                                            else if($get_active_interview->company_response=='Reschedule')
                                            {
                                                if(empty($get_active_interview->company_resched_applicant_response)){
                                            ?>
                                               <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" class="blink" id="blink"><b>Status <span class="pull-right"><n  style="color:<?php echo $j->color_code;?>">Respond to company invitation</n></span></b></a>
                                            <?php } else{ ?>
                                              <a style="cursor: pointer;" data-toggle='modal' data-target='#modal'  href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" >Status <span class="pull-right label bg-olive">View <?php echo $get_active_interview->response;?> Interview Details</span></a>
                                            <?php }}
                                            else
                                            {
                                          ?>

                                            <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" class="blink" id="blink"><b>Status <span class="pull-right"><n  style="color:<?php echo $j->color_code;?>">Waiting for company response</n></span></b></a>
                                          


                                          <?php } }
                                      } 
                                      else
                                      {?>

                                        <a style="cursor: pointer;" data-toggle='modal' data-target='#modal' href="<?php echo base_url('app/application_forms/application_status')."/".$j->id."/".$j->employee_info_id."/".$j->job_id."/".$get_active_interview->interview_process_id."/".$get_active_interview->numbering."/".$get_active_interview->id;?>" class="blink" id="blink"><b>Status <span class="pull-right"><n  class='text-info'>Respond to <?php echo $get_active_interview->title;?> Invitation</n></span></b></a>
                                      
                                      <?php }

                                    }
                                }
                                else{ ?>
                                      <!-- <a style="cursor: pointer;" >Status <span class="pull-right"><n style="color:<?php //echo $j->color_code;?>"><?php //echo $j->status_title;?></n></span></a> -->
                                       <a style="cursor: pointer;">Status <span class="pull-right"><n style="color:<?php echo $j->color_code;?>">Application Today</n></span></a>
                                <?php }?>


                                </li>




                                <li>
                                    <a style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/application_forms/manage_questions')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>">Employer Questions <span class="pull-right label bg-olive">Answer</span></a>
                                </li>

                                <li>
                                <?php $check_req  = $this->application_forms_model->check_pending_requirements_uploaded($j->job_id); 
                                  if($check_req==1){?>
                                    <a style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/application_forms/manage_requirements')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>">Requirements <span class="pull-right label bg-olive">View Uploaded Requirements</span></a>
                                <?php }
                                  else{
                                ?>
                                   <a style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/application_forms/manage_requirements')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>" class="blink" id="blink">Requirements <span class="pull-right text-info"><b>Pending required requirements</b>
                                   </span></a>
                                <?php } ?>
                                </li>

                                <li><a href="#">Resume Status <span class="pull-right label bg-olive"><?php if($resume==0){ echo "Not yet Viewed"; } else{ echo "Viewed"; }?></span></a></li>
                                
                                <li><a  style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/application_forms/view_other_applicants')."/".$j->employee_info_id."/".$j->job_id;?>" >View Other Applicants<span class="pull-right label bg-olive">View</span></a></li>

                                <?php foreach($point_rewards_settings as $p){

                                  $checker_with_referral = $this->application_forms_model->checker_with_referral_applicant($j->id,$j->employee_info_id,$j->job_id);

                                  ?>
                                    


                                     <li><a  style="cursor: pointer;" data-toggle='modal' data-target='#modall' href="<?php echo base_url('app/application_forms/referral_points_applicant')."/".$j->id."/".$j->employee_info_id."/".$j->job_id;?>" <?php if($checker_with_referral == 0){ ?> class="blink" id="blink" <?php } ?> >

                                    <?php if($checker_with_referral == 0){ echo "<b>".$p->title." <span class='pull-right'><n class='text-info'> Assign Employee Referral</n></span></b>"; } else { echo $p->title; ?> <span class="pull-right label bg-olive">View Assigned Referral</span> <?php }?>
                                    </a></li>

                                <?php } ?>

                               
                              </ul>
                            </div>
                          </div>
                    </div>
                    <!-- END APPLICATIONS VIEW -->
                       <?php }?>
                    </div>
                       </div>
                       </div>  
                       <div class="btn-group-vertical btn-block"> </div> 
                  </div>
            </div> 
          </div> 
        
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
       <div class="modal-dialog">
           <div class="modal-content modal-md">
           </div>
        </div>
    </div>

      <div class="modal fade" id="modall" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">

       <div class="modal-dialog">
           <div class="modal-content modal-lg">
           </div>
        </div>
    </div>

    <style type="text/css">
      .modal {
    }
    .vertical-alignment-helper {
        display:table;
        height: 100%;
        width: 120%;

    }
    .vertical-align-center {
        /* To center vertically */
        display: table-cell;
        vertical-align: left;

    }
    .modal-content {
        /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
     /*   width:inherit;
        height:inherit;*/
        /* To center horizontally */
        margin: 0 auto;
        margin-left:-60px;
    }

    .blink{
          
          font-family: cursive;
          color: white;
          animation: blink 1s linear infinite;
        }
   
              
        @keyframes blink{
        0%{opacity: 0;}
        50%{opacity: .5;}
        100%{opacity: 1;}
    }      
           
        

    </style>

    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript">
      function get_status_applications_list(val)
      {
           if(window.XMLHttpRequest)
            {
              xmlhttp=new XMLHttpRequest();
            }
          else
            {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                    document.getElementById("fetch_all_result_action").innerHTML=xmlhttp.responseText;
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/application_forms/get_status_applications_list/"+val,true);
            xmlhttp.send();
      }
      function get_search()
      {
        var category = document.getElementById('search_category').value;
        var data  = document.getElementById('search_title').value; 
        function_escape('search_ftitle',data);
        var datas = document.getElementById('search_ftitle').value;
        if(category=='' || data=='')
        {
            alert("Please fill up all fields to continue");
        }
        else
        {
            if(window.XMLHttpRequest)
            {
              xmlhttp=new XMLHttpRequest();
            }
           else
            {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                    document.getElementById("fetch_all_result_action").innerHTML=xmlhttp.responseText;
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/application_forms/get_search/"+category+"/"+data,true);
            xmlhttp.send();
        }
      }

      function add_referral()
      {
        var name = document.getElementById('name').value;
        

        if(name==''){ alert('Fill referral field to continue'); }
        else
        {
         

          var all = document.getElementById('namess').value;

          var res = all +=name + "milajove";
          document.getElementById('namess').value=res;

          function_escape('allnames',res);
          var fname = document.getElementById('allnames').value;
          $('#bb').show();
         
            if(window.XMLHttpRequest)
            {
              xmlhttp=new XMLHttpRequest();
            }
           else
            {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                    document.getElementById("referrals").innerHTML=xmlhttp.responseText;
                    $("#ress").DataTable({
                        lengthMenu: [[-1, 10, 25, 50, 100], ['All', 10, 25, 50, 100]]             
                        });
                    document.getElementById('name').value='';
                    document.getElementById('name_final').value='';
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/application_forms/add_referral/"+fname,true);
            xmlhttp.send();
        }
      }

      function remove_referral(val,i)
      {
          var result = confirm("Are you sure you want to delete" + val +"?");
          if(result == true)
          {

          var all = document.getElementById('namess').value;
          var res = all.replace(val+"milajove", "");
          document.getElementById('namess').value=res;

          function_escape('allnames',res);

          var final = document.getElementById('allnames').value;

          if(final=='')
          {
            alert('Add one employee name to continue');
            document.getElementById('namess').value=val+"milajove";
            function_escape('allnames',val+"milajove");
          }
          else
          {
           $('#bb').show();
           if(window.XMLHttpRequest)
            {
              xmlhttp=new XMLHttpRequest();
            }
           else
            {
              // code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                    document.getElementById("referrals").innerHTML=xmlhttp.responseText;
                     $("#ress").DataTable({
                        lengthMenu: [[-1, 10, 25, 50, 100], ['All', 10, 25, 50, 100]]             
                        });
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/application_forms/add_referral/"+final,true);
            xmlhttp.send();
          }
       }

      }

      function save_referral(app_id,applicant_id,job_id)
      {
        $('#bb').show();
        var names = document.getElementById('allnames').value;

        if(names==''){ alert('Add atleast one employee to continue'); }
        else
        {

            if(window.XMLHttpRequest)
            {
              xmlhttp=new XMLHttpRequest();
            }
           else
            {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
              xmlhttp.onreadystatechange=function()
                {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                        location.reload();
                    }
                  }
            xmlhttp.open("GET","<?php echo base_url();?>app/application_forms/save_referral/"+app_id+"/"+applicant_id+"/"+job_id+"/"+names,true);
            xmlhttp.send();
        }
      }

      function function_escape(ids,titles)
      {
       var a = titles.replace(/\?/g, '-a-');
       var b = a.replace(/\!/g, "-b-");
       var c = b.replace(/\//g, "-c-");
       var d = c.replace(/\|/g, "-d-");
       var e = d.replace(/\[/g, "-e-");
       var f = e.replace(/\]/g, "-f-");
       var g = f.replace(/\(/g, "-g-");
       var h = g.replace(/\)/g, "-h-");
       var i = h.replace(/\{/g, "-i-");
       var j = i.replace(/\}/g, "-j-");
       var k = j.replace(/\'/g, "-k-");
       var l = k.replace(/\,/g, "-l-");
       var m = l.replace(/\'/g, "-m-");
       var n = m.replace(/\_/g, "-n-");
       var o = n.replace(/\@/g, "-o-");
       var p = o.replace(/\#/g, "-p-");
       var q = p.replace(/\%/g, "-q-");
       var r = q.replace(/\$/g, "-r-");
       var s = r.replace(/\^/g, "-s-");
       var t = s.replace(/\&/g, "-t-");
       var u = t.replace(/\*/g, "-u-");
       var v = u.replace(/\+/g, "-v-");
       var w = v.replace(/\=/g, "-w-");
       var x = w.replace(/\:/g, "-x-");
       var y = x.replace(/\;/g, "-y-");
       var z = y.replace(/\%20/g, "-z-");
       var aa = y.replace(/\./g, "-zz-");
       var bb = aa.replace(/\</g, "-aa-");
       var cc = bb.replace(/\>/g, "-bb-");
       document.getElementById(ids).value=cc;
    }
    </script>