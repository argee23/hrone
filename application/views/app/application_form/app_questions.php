 <div class="modal-content">
      <div class="modal-header well well-sm bg-olive" >
      <button type="button" class="close" onclick="window.location.reload()">&times;</button>
        <h4 class="modal-title text-success" style="color: white;"><center><b><?php echo $job_details->company_name;?></center></b></h4>
        <h5><center><?php echo $job_details->job_title;?></center> </h5>

      </div>

      <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/application_forms/save_answers/<?php echo $job_id;?>" >


      <div class="modal-body">
       <div class="panel panel-default">
        <div class="panel-heading">
        <strong>
             <ul class="nav nav-tabs">
             <li class="active"> 
                  <a data-toggle="tab" style="cursor: pointer;" onclick="get_questions('<?php echo $job_id;?>','<?php echo $applicant_id;?>','<?php echo $app_id;?>','qualifying');"><b> <i></i>Qualifying Questions</b></a>
              </li>
              <li> 
                  <a data-toggle="tab" style="cursor: pointer;" onclick="get_questions('<?php echo $job_id;?>','<?php echo $applicant_id;?>','<?php echo $app_id;?>','multiple_choice');"><b> <i></i>Multiple Choice Questions</b></a>
              </li>
              <li> 
                  <a data-toggle="tab" style="cursor: pointer;" onclick="get_questions('<?php echo $job_id;?>','<?php echo $applicant_id;?>','<?php echo $app_id;?>','hypothetical');"><b> <i></i>Hypothetical Questions</b></a>
              </li>
              
          </ul>
       </strong>
        </div>
        <div class="panel-body" id="questions_action">
          <input type="hidden" id="type" value="qualifying">
           <span class="dl-horizontal col-sm-12">
                 <?php if(count($qq)==0){ echo "<h3>No Qualifying Question/s found.</h3>";} else{ $i=1; foreach($qq as $q){?>
                   <br>
                  <div class="col-md-12">
                      <h5> <n class="text-danger"><?php echo $i.")";?> </n><?php echo $q->question;?> </h5>
                  </div>
                  <div class="col-md-12">
                    <div class="col-md-12"><n class="text-danger"><i>Answer : <?php if($q->correct_ans==1){ echo "yes"; } else{ echo "no"; }?></i></n></div>
                  </div>
                   <br>
                  <?php $i++; } } ?>
              </span>
      
        </div>
        </div>

      </div>
     

      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
      </div>
    </form>
  </div>
  
<script type="text/javascript">
  function get_questions(job,applicant_id,app_id,type)
  {
    
    if (window.XMLHttpRequest)
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
                document.getElementById("questions_action").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/application_forms/get_questions/"+job+"/"+applicant_id+"/"+app_id+"/"+type,true);
            xmlhttp.send();

  }

</script>