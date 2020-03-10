 <div class="modal-content">
      <div class="modal-header well well-sm bg-olive" >
      <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-success" style="color: white;"><center><b><?php echo $job_details->company_name;?></center></b></h4>
        <h5><center><?php echo $job_details->job_title;?></center> </h5>
      </div>
      <input type="hidden" id="current_date" value="<?php echo date('Y-m-d');?>">
      <div class="modal-body" id='mila'>

          <div class="col-md-12">
              <?php

               foreach($application as $rca){
                $final_res = 'false';
              ?>

                <div class="panel panel-default">
                    <div class="panel-heading">
                      <strong><a class="text-danger"><center>Interview Process : <?php echo $rca->title;?> </center></i></a></strong>
                    </div>
                    <div class="panel-body">
                      <span class="dl-horizontal col-sm-12">
                       <div class="col-md-6">
                          <div class="col-md-5"><label class="pull-right">When</label></div>
                          <div class="col-md-7">
                                <?php 
                                  $month=substr($rca->interview_date, 5,2);
                                  $day=substr($rca->interview_date, 8,2);
                                  $year=substr($rca->interview_date, 0,4);

                                  echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                ?>
                          </div>
                        </div>

                        <div class="col-md-6" style='margin-top: 5px;'>
                          <div class="col-md-5"><label class="pull-right">Time</label></div>
                          <div class="col-md-7">
                              <?php echo $rca->interview_time;?>
                          </div>
                        </div>

                        <div class="col-md-6"  style='margin-top: 5px;'>
                          <div class="col-md-5"><label class="pull-right">Message</label></div>
                          <div class="col-md-7">
                            <?php echo $rca->interview_message;?>
                          </div>
                        </div>

                        <div class="col-md-6"  style='margin-top: 5px;'>
                          <div class="col-md-5"><label class="pull-right">Addresss</label></div>
                          <div class="col-md-7">
                            <?php echo $rca->interview_address;?>
                          </div>
                        </div>

                        <?php  
                            if(empty($rca->response))
                            {?>
                              
                                <div class="col-md-12"  style='margin-top: 5px;'>
                                  <div class="col-md-5"><label class="pull-right">Applicant Response</label></div>
                                  <div class="col-md-7">
                                      <select class="form-control" name="response_first" id="response_first" onchange="get_first_interview_reponse(this.value);">
                                        <option value="" selected disabled>Select</option>
                                        <option>Accept</option>
                                        <option>Decline</option>
                                        <option>Reschedule</option>
                                      </select>
                                  </div>
                                </div>
                              
                                <input type="hidden" id="awhen_checker" value="<?php echo $rca->interview_date;?>">
                                <div class="col-md-12 callout callout-info" style='margin-top: 15px;display: none;' id="for_first_response_resched">
                                  <div class="col-md-3"><label class="pull-right">Requested Date</label></div>
                                  <div class="col-md-9"><input type="date" class="form-control" id="awhen" name="awhen" placeholder="Date of Interview"  onchange="check_date(event);"></div>
                                  <div class="col-md-3"  style='margin-top: 5px;'><label class="pull-right">Requested Time</label></div>
                                  <div class="col-md-9"  style='margin-top: 5px;'>
                                        <input type="time" class="form-control" id="atime" name="atime" placeholder="From">
                                  </div>
                                  <div class="col-md-3"  style='margin-top: 5px;'><label class="pull-right">Reason</label></div>
                                  <div class="col-md-9"  style='margin-top: 5px;'>
                                        <textarea class="form-control" rows="3" name="amessage" id="amessage" placeholder="Reason for Rescheduling the Interview Invitation"></textarea>
                                        <input type="hidden" id="amessage_final">
                                  </div>
                               
                                </div>

                               

                                <button class="col-md-12 btn btn-success btn-md" style="margin-top: 20px;" onclick="save_first_interview_response('<?php echo $rca->id;?>','response');">SAVE RESPONSE</button>
                            <?php }
                            else if($rca->response=='Reschedule')
                            {?> 

                               <div class="col-md-12 callout callout-info" style='margin-top: 15px;'>
                                  <div class="col-md-12">
                                    <div class="col-md-5"><label class="pull-right" style="color: black;">Request Date</label></div>
                                    <div class="col-md-7">
                                      <n class="text-danger"> <?php 
                                        $month=substr($rca->resched_date, 5,2);
                                        $day=substr($rca->resched_date, 8,2);
                                        $year=substr($rca->resched_date, 0,4);

                                        echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                      ?></n>
                                    </div>
                                  </div>

                                  <div class="col-md-12" style='margin-top: 5px;'>
                                    <div class="col-md-5"><label class="pull-right" style="color: black;">Requested Time</label></div>
                                    <div class="col-md-7">
                                        <n class="text-danger"><?php echo $rca->resched_time;?></n>
                                    </div>
                                  </div>

                                  <div class="col-md-12"  style='margin-top: 5px;'>
                                    <div class="col-md-5"><label class="pull-right" style="color: black;">Message</label></div>
                                    <div class="col-md-7">
                                        <n class="text-danger"><?php echo $rca->resched_reason;?></n>
                                    </div>
                                  </div>

                              <?php if(empty($rca->company_response))
                              {?> 

                                  <div class="col-md-12" style='margin-top: 5px;'>
                                    <div class="col-md-5"><label class="pull-right" style="color: black;">Company Response</label></div>
                                    <div class="col-md-7">
                                      <n class="text-danger"><b>NO RESPONSE YET</b></n>
                                    </div>
                                  </div>

                              <?php }
                              else
                              { 
                                if($rca->company_response=='Accept' || $rca->company_response=='Decline'){?>

                                  <div class="col-md-12" style='margin-top: 5px;'>
                                    <div class="col-md-5"><label class="pull-right" style="color: black;">Company Response</label></div>
                                    <div class="col-md-7">
                                      <n class="text-danger"><?php echo $rca->company_response;?></n>
                                    </div>
                                  </div>

                                <?php } else{?>

                                    <div class="col-md-12" style='margin-top: 5px;'>
                                    <div class="col-md-5"><label class="pull-right" style="color: black;">Company Response</label></div>
                                    <div class="col-md-7">
                                       <n class="text-danger"><?php echo $rca->company_response;?></n>
                                    </div>
                                  </div>


                                   <div class="col-md-12" style='margin-top: 5px;'>
                                    <div class="col-md-5"><label class="pull-right" style="color: black;">Final Date</label></div>
                                    <div class="col-md-7">
                                       <n class="text-danger">
                                         <?php 
                                          $month=substr($rca->new_date, 5,2);
                                          $day=substr($rca->new_date, 8,2);
                                          $year=substr($rca->new_date, 0,4);

                                          echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                                        ?>
                                       </n>
                                    </div>
                                  </div>


                                   <div class="col-md-12" style='margin-top: 5px;'>
                                    <div class="col-md-5"><label class="pull-right" style="color: black;">Final Time</label></div>
                                    <div class="col-md-7">
                                       <n class="text-danger"><?php echo $rca->new_time;?></n>
                                    </div>
                                  </div>

                                  <?php if(empty($rca->company_resched_applicant_response))
                                  {
                                      $final_res = 'true';
                                  ?>
                                      <div class="col-md-12" style='margin-top: 5px;'>
                                        <div class="col-md-5"><label class="pull-right" style="color: black;">Applicant Reponse</label></div>
                                        <div class="col-md-7">
                                           <select class="form-control" name="response_first" id="response_last">
                                            <option value="" selected disabled>Select</option>
                                            <option>Accept</option>
                                            <option>Decline</option>
                                          </select>
                                        </div>
                                      </div>



                                  <?php }
                                  else
                                  {?>
                                     <div class="col-md-12" style='margin-top: 5px;'>
                                      <div class="col-md-5"><label class="pull-right" style="color: black;">Applicant Reponse</label></div>
                                      <div class="col-md-7">
                                         <n class="text-danger"><?php echo $rca->company_resched_applicant_response;?>ed</n>
                                      </div>
                                    </div>
                                  <?php }


                                } ?> 

                              <?php }?>
                              </div>
                              <?php
                              }
                              else
                              {?>

                              <div class="col-md-12 callout callout-info" style='margin-top: 15px;'>
                               <div class="col-md-12" style='margin-top: 5px;'>
                                    <div class="col-md-5"><label class="pull-right" style="color: black;">Applicant Response</label></div>
                                    <div class="col-md-7">
                                      <?php echo $rca->response;?>
                                    </div>
                              </div>

                           <?php  } if($final_res == 'true'){ ?>
                            <button class="col-md-12 btn btn-success btn-md" style="margin-top: 20px;" onclick="save_last_employee_response('<?php echo $rca->id;?>');">SAVE RESPONSE</button>
                                      
                           <?php } } ?>

                      </span>
                  </div>
                </div>

          </div>

      </div>

      <div class="modal-footer">
      </div>
        
  </div>
  
  <script type="text/javascript">
    function get_first_interview_reponse(val)
    {
      if(val=='Reschedule')
      {
        $('#for_first_response_resched').show();
      }
      else
      {
        $('#for_first_response_resched').hide();
      }
    }

    function save_first_interview_response(id,option)
    {
         var response = document.getElementById('response_first').value;
         var today =  document.getElementById('current_date').value;

        if(response=='Reschedule')
        {
          var date = document.getElementById('awhen').value;
          var date_checker = document.getElementById('awhen_checker').value;
          var time = document.getElementById('atime').value;
          var message = document.getElementById('amessage').value;

          function_escape('amessage_final',message);
          var message_final = document.getElementById('amessage_final').value;


          if(date > today)
          {
            var datetrue = 'true';
          } else { var datetrue = 'false'; }
        }
        else
        {
          var date = 'not_included';
          var time = 'not_included';
          var message_final = 'not_included';
          var datetrue = 'true';
        }

      if(date=='' || time=='' || message=='')
      {
        alert("Please fill up all fields");
      }
      else if(datetrue=='false')
      {
        alert("Please select valid interview date to continue");
      }
      else
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/application_forms/save_first_interview_response/"+response+"/"+date+"/"+time+"/"+message_final+"/"+id+"/"+option,false);
        xmlhttp2.send();
      }
    }

    function save_last_employee_response(id)
    {
      var response = document.getElementById('response_last').value;
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
        xmlhttp2.open("GET","<?php echo base_url();?>app/application_forms/save_last_employee_response/"+id+"/"+response,false);
        xmlhttp2.send();

      
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