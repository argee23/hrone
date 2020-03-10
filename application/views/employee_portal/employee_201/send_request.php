<div class="col-md-9">
  <div class="panel panel-success">
    <div class="panel-heading"> 
      <center><h4><b><i>POLICY IN UPDATING INFORMATION</b></h4>
        I certify that the statements made by me are true and correct and I authorize <u><b><?php echo $company_name;?></b></u> to verify these statements before or during any period of my employment. I agree that any misrepresentation or falsehood shall be the basis for my immediate termination/dismissal from employment.
      </center></i>
    </div>

    <div class="panel-body">
         <div class="panel panel-danger">
                <div class="box box-default" class='col-md-12' style="height: 370px;overflow:auto;"><br>
                   <?php  if($pending!=0) { ?>
       <div class="col-md-12">
        <div class="col-md-12"  style="margin-top: 10px;">
            <table class="table table-bordered">
              <thead>
                <tr class="success">
                  <th colspan="3"><center><h3 class="text-success">Waiting for HR Approval</h3></center></th>
                </tr>
              </thead>
              <tbody>  
                <tr>
                    <td align='center'><b>Topic</b></td>
                    <td  align='center'><b>Action</b></td>
                    <td  align='center'><b>Status</b></td>
                </tr>
                <?php  foreach ($topicss as $k) {?>
                  <tr>
                    <td width='40%'><center><n class="text-danger"><?php echo $k->topic_title?></n></center></td>
                    <td width='30%'>
                      <?php $checkers = $this->employee_201_model->checker_req($k->request_id,$k->request_topic_id); foreach($checkers as $c) {?>
                         <n style='padding-left: 30px;'><?php echo $c->action?> </n><br>
                        <?php } ?>  
                    </td> 
                    <td>
                    <?php $checkers = $this->employee_201_model->checker_req($k->request_id,$k->request_topic_id); foreach($checkers as $c) {?>
                         <n style='padding-left: 30px;' class="<?php if($c->status=='Pending'){ echo "text-success"; } elseif($c->status=='Approved'){ echo "text-danger"; } else{ echo "text-info"; } ?>"><?php echo $c->status?> </n><br>
                        <?php } ?>
                    </td>
                   
                  </tr>
                  <?php } ?>
              </tbody>
            </table>
        </div>
                
            </div>
                <?php } elseif($personal!=0 || $family!=0 || $educational!=0 || $employment!=0 || $training!=0 || $character!=0 || $dependents!=0 || $inventory!=0 || $skills!=0 || $other_info!=0){?>
                <div class="col-md-12" id="main_fetch_div">
                 <div class="col-md-7">
                    <textarea rows="14" width="100" class="col-md-10 form-control" id="message"> </textarea> 
                    <input type="hidden" id="ids">
                   <button class="col-md-12 btn btn-success" style="margin-top: 10px;" onclick="save_request();" id='send_id'>Send For Information Request</button>
                   <div id="send_load" style="display:none;margin-top: 5px;"><center><i class="text-primary fa fa-spinner fa-spin" style="font-size:30px"></i> loading . . .</center></div>
                 </div> 
                  <div class='col-md-5'>
                  <div class="box box-solid box-default" style='height:340px;overflow: auto;'>
                      <?php if($personal > 0){?>
                      <div class="col-md-12">
                      <n class='text-danger' style='font-weight:bold;'><input type='hidden' value='1' id='personal'>Personal Information</n>
                            <ul>
                             <input type="checkbox" class="personal" value="Update" checked>&nbsp; Update
                            </ul>
                      </div>
                      <?php } else{ echo "<input type='hidden' value='0' id='personal'>"; } ?>

                      <?php if($other_info > 0){?>
                      <div class="col-md-12">
                      <n class='text-danger' style='font-weight:bold;'><input type='hidden' value='1' id='other'>Other Information</n>
                            <ul>
                             <input type="checkbox" class="other" value="Update" checked>&nbsp; Update
                            </ul>
                      </div>
                      <?php } else{ echo "<input type='hidden' value='0' id='other'>"; }

                      if($family > 0){ ?>
                      <div class="col-md-12">
                       <n class='text-danger' style='font-weight:bold;'><input type='hidden' value='1' id='family'>Family Data</n>
                        <ul>
                        <?php 
                            $checker= $this->employee_201_model->checker('employee_id',$this->session->userdata('employee_id'),'emp_family_for_update','emp_family_for_delete');
                            if($checker[0] > 0) { ?>
                             <input type="checkbox" checked class="family" value='Add'>&nbsp; Add New <br>
                             <?php } else{ echo '<input type="hidden" class="family" value="Add">';} if($checker[1] > 0) {?>
                             <input type="checkbox" checked class="family" value='Update'>&nbsp; Update Data <br>
                             <?php } else{ echo '<input type="hidden" class="family" value="Update">';}   if($checker[2] > 0) {?>
                              <input type="checkbox" checked class="family" value='Delete'>&nbsp; Delete Data <br>
                             <?php } else{ echo '<input type="hidden" class="family" value="Delete">';}  ?>
                        </ul>
                      </div>
                      <?php } else{ echo "<input type='hidden' value='0' id='family'>"; } 
                      if($educational > 0) {?>
                      <div class="col-md-12">
                           <n class='text-danger' style='font-weight:bold;'><input type='hidden' value='1' id='education'>Educational Attainment</n>
                           <ul>
                        <?php 
                            $checker= $this->employee_201_model->checker('employee_info_id',$this->session->userdata('id'),'emp_education_for_update','emp_education_for_delete');
                            if($checker[0] > 0) { ?>
                             <input type="checkbox"  checked class="education" value='Add' checked>&nbsp; Add New <br>
                             <?php } else{ echo '<input type="hidden" class="education" value="Add">'; } if($checker[1] > 0) {?>
                             <input type="checkbox"  checked class="education" value='Update' checked>&nbsp; Update Data <br>
                             <?php } else{ echo '<input type="hidden" class="education" value="Update">'; } if($checker[2] > 0) {?>
                              <input type="checkbox"  checked class="education" value='Delete' checked>&nbsp; Delete Data <br>
                             <?php } else{ echo '<input type="hidden" class="education" value="Delete">'; } ?>
                             </ul>
                      </div>
                      <?php } else{ echo "<input type='hidden' value='0' id='education'>"; }
                      if($employment > 0) {?>
                      <div class="col-md-12">
                       <n class='text-danger' style='font-weight:bold;'><input type='hidden' value='1' id='employment'>Employment Experience</n>
                           <ul>
                          <?php 
                            $checker= $this->employee_201_model->checker('employee_info_id',$this->session->userdata('id'),'emp_work_experience_for_update','emp_work_experience_for_delete');
                            if($checker[0] > 0) { ?>
                             <input type="checkbox" value='Add' class="employment" checked>&nbsp; Add New <br>
                             <?php } else{ echo '<input type="hidden" class="employment" value="Add">'; } if($checker[1] > 0) {?>
                             <input type="checkbox" value='Update' class="employment" checked>&nbsp; Update Data <br>
                             <?php } else{ echo '<input type="hidden" class="employment" value="Update">'; }  if($checker[2] > 0) {?>
                              <input type="checkbox" value='Delete'  class="employment" checked>&nbsp; Delete Data <br>
                             <?php } else{ echo '<input type="hidden" class="employment" value="Delete">'; }  ?>
                             </ul>
                      </div>
                      <?php } else{ echo "<input type='hidden' value='0' id='employment'>"; } if($training > 0) {?>
                      <div class="col-md-12">
                         <n class='text-danger' style='font-weight:bold;'><input type='hidden' value='1' id='training'>Trainings and Seminars</n>
                           <ul>
                        <?php 
                            $checker = $this->employee_201_model->checker('employee_info_id',$this->session->userdata('id'),'emp_trainings_seminars_for_update','emp_trainings_seminars_for_delete');
                            if($checker[0] > 0) { ?>
                             <input type="checkbox"  class="training" value='Add'  checked>&nbsp; Add New <br>
                             <?php }  else{ echo '<input type="hidden" class="training" value="Add">'; } if($checker[1] > 0) {?>
                             <input type="checkbox"  class="training" value='Update' checked>&nbsp; Update Data <br>
                             <?php } else{ echo '<input type="hidden" class="training" value="Update">'; } if($checker[2] > 0) {?>
                              <input type="checkbox"  class="training" value='Delete' checked>&nbsp; Delete Data <br>
                             <?php } else{ echo '<input type="hidden" class="training" value="Delete">'; } ?>
                             </ul>
                      </div>
                      <?php } else{ echo "<input type='hidden' value='0' id='training'>"; }
                      if($character > 0){?>
                      <div class="col-md-12">
                          <n class='text-danger' style='font-weight:bold;'><input type='hidden' value='1' id='character'>Character Reference</n>
                           <ul>
                        <?php 
                            $checker = $this->employee_201_model->checker('employee_info_id',$this->session->userdata('employee_id'),'emp_character_reference_for_update','emp_character_reference_for_delete');
                            if($checker[0] > 0) { ?>
                             <input type="checkbox" class="character" value="Add" checked>&nbsp; Add New <br>
                             <?php } else{ echo '<input type="hidden" class="character" value="Add">'; } if($checker[1] > 0) {?>
                             <input type="checkbox" class="character" value="Update" checked>&nbsp; Update Data <br>
                             <?php } else{ echo '<input type="hidden" class="character" value="Update">'; } if($checker[2] > 0) {?>
                              <input type="checkbox" class="character" value="Delete" checked>&nbsp; Delete Data <br>
                             <?php } else{ echo '<input type="hidden" class="character" value="Delete">'; } ?>
                             </ul>
                      </div>
                      <?php } else{ echo "<input type='hidden' value='0' id='character'>"; }
                      if($dependents > 0) {?>
                      <div class="col-md-12">
                        <n class='text-danger' style='font-weight:bold;'><input type='hidden' value='1' id='dependents'>Dependents</n>
                           <ul>
                        <?php 
                            $checker = $this->employee_201_model->checker('employee_id',$this->session->userdata('employee_id'),'emp_dependents_for_update','emp_dependents_for_delete');
                            if($checker[0] > 0) { ?>
                             <input type="checkbox"  class="dependents" value="Add" checked>&nbsp; Add New <br>
                             <?php } else{ echo '<input type="hidden" class="dependents" value="Add">'; } if($checker[1] > 0) {?>
                             <input type="checkbox"  class="dependents" value="Update" checked>&nbsp; Update Data <br>
                             <?php } else{ echo '<input type="hidden" class="dependents" value="Update">'; } if($checker[2] > 0) {?>
                              <input type="checkbox"  class="dependents" value="Delete" checked>&nbsp; Delete Data <br>
                             <?php } else{ echo '<input type="hidden" class="dependents" value="Delete">'; } ?>
                             </ul>
                      </div>
                      <?php } else{ echo "<input type='hidden' value='0' id='dependents'>"; }
                      if($inventory > 0) { ?>
                      <div class="col-md-12">
                        <n class='text-danger' style='font-weight:bold;'><input type='hidden' value='1' id='inventory'>Inventory</n>
                           <ul>
                        <?php 
                            $checker= $this->employee_201_model->checker('employee_id',$this->session->userdata('employee_id'),'emp_inventory_for_update','emp_inventory_for_delete');
                            if($checker[0] > 0) { ?>
                             <input type="checkbox" class="inventory" value="Add" checked>&nbsp; Add New <br>
                             <?php } else{ echo '<input type="hidden" class="inventory" value="Add">'; } if($checker[1] > 0) {?>
                             <input type="checkbox" class="inventory" value="Update" checked>&nbsp; Update Data <br>
                             <?php } else{ echo '<input type="hidden" class="inventory" value="Update">'; } if($checker[2] > 0) {?>
                              <input type="checkbox" class="inventory" value="Delete" checked>&nbsp; Delete Data <br>
                             <?php } else{ echo '<input type="hidden" class="inventory" value="Delete">'; }?>
                             </ul>
                      </div>
                      <?php } else{ echo "<input type='hidden' value='0' id='inventory'>"; }
                      if($skills > 0) {?>
                      <div class="col-md-12">
                       <n class='text-danger' style='font-weight:bold;'><input type='hidden' value='1' id='skills'>Skills</n>
                           <ul>
                        <?php 
                            $checker= $this->employee_201_model->checker('employee_info_id',$this->session->userdata('id'),'emp_skills_for_update','emp_skills_for_delete');
                            if($checker[0] > 0) { ?>
                             <input type="checkbox" class="skills" value="Add" checked>&nbsp; Add New <br>
                             <?php }  else{ echo '<input type="hidden" class="skills" value="Add">'; } if($checker[1] > 0) {?>
                             <input type="checkbox" class="skills" value="Update" checked>&nbsp; Update Data <br>
                             <?php }  else{ echo '<input type="hidden" class="skills" value="Update">'; } if($checker[2] > 0) {?>
                              <input type="checkbox" class="skills" value="Delete" checked>&nbsp; Delete Data <br>
                             <?php } else{ echo '<input type="hidden" class="skills" value="Delete">'; }?>
                             </ul>
                      </div>
                      <?php } else{ echo "<input type='hidden' value='0' id='skills'>"; }?>
                      </div>
                  </div>
                </div>
                <?php } else{ 
                  if(empty($history)){ echo "<h1 style='text-indent:20px;font-weight:bold;1'>No history found!</h1>"; } else{
                  foreach($history as $h) {?>
                  <div class="col-md-12">
                    <div class="col-md-12" >
                      <div class="box box-solid">
                        <div class="box-header with-border bg-gray disabled color-palette">
                        <i style="font-weight: bold;">Date Filed: <n class='text-info'> <?php echo $h->date_created?></n> </i>
                        </div>
                        <div class="box-body" style="overflow: auto;">
                          <dl class="dl-horizontal text-default">
                          <div class="col-md-12" >
                          <table class='col-md-8 table table-bordered'>
                            <thead>
                              <tr class='success'>
                                 <td align='center'><b>Topic</b></td>
                                <td  align='center'><b>Action</b></td>
                                <td  align='center'><b>Status</b></td>
                                <td  align='center'><b>Date Updated</b></td>
                              </tr>
                            </thead>
                            <tbody>
                          <?php $statt = $this->employee_201_model->topics_status($h->request_id); 
                          foreach($statt as $s) {?>
                          <tr>
                              <td align='center'><?php echo $s->topic_title?></td>
                              <td align='center'>
                                <?php $statt_action = $this->employee_201_model->topics_status_action($s->request_topic_id); 
                                  foreach($statt_action as $stat){ echo "<n>".$stat->action."<br>";}
                                ?>
                              </td>
                              <td align='center'>
                                <?php $statt_action = $this->employee_201_model->topics_status_action($s->request_topic_id); 
                                  foreach($statt_action as $stat){ echo "</n> <n class='text-success'>".$stat->status."</n><br>";}
                                ?>
                              </td>
                              <td align='center'><?php echo $stat->date_updated?></td>
                            </tr>
                          <?php } ?>
                          </tbody>
                        </table>
                        </div>
                          </dl>
                        </div>
                      </div>
                      </div>
                    </div>
                <?php } }} ?>
              </div>  
          </div>
          <div class="btn-group-vertical btn-block"> </div> 
      </div>
    </div>
  </div>
</div>
    
<script>
  function save_request()
  {
  	$("#send_id").hide();
  	$("#send_load").show();
    var msg = '----' + document.getElementById('message').value;
    function_escape("ids",msg); 
    var msg_req= document.getElementById("ids").value;
    
    var d_personal = document.getElementById('personal').value;
     var d_other = document.getElementById('other').value;

    if(d_personal==1)
      {
        var personal = document.getElementsByClassName("personal");
        var personal_data='data-';
        for (i=0;i<1; i++)
              {
                if (personal[i].checked === true)
                {
                  personal_data +=personal[i].value + "-";
                }
              }
      }
    else { var personal_data='none'; }
    
    if(d_other==1)
      {
        var other = document.getElementsByClassName("other");
        var other_data='data-';
        for (i=0;i<1; i++)
              {
                if (other[i].checked === true)
                {
                  other_data +=other[i].value + "-";
                }
              }
      }
    else { var other_data='none'; }
  
    var d_family = document.getElementById('family').value;
    if(d_family==1)
      {
        var family = document.getElementsByClassName("family");
        var family_data='data-';
        var family_uncheck='data-';
        for (i=0;i<3; i++)
              {
                if (family[i].checked === true)
                {
                  family_data +=family[i].value + "-";
                } else { family_uncheck +=family[i].value + "-"; }
              }
      }
    else { var family_data='none'; var family_uncheck='none'; }

  

    var d_education = document.getElementById('education').value;
    if(d_education==1)
      {
        var education = document.getElementsByClassName("education");
        var education_data='data-';
        var education_uncheck='data-';
        for (i=0;i<3; i++)
              {
                if (education[i].checked === true)
                {
                  education_data +=education[i].value + "-";
                } else { education_uncheck +=education[i].value + "-"; }
              }
      }
    else { var education_data='none'; var education_uncheck='none'; }


    var d_employment = document.getElementById('employment').value;
    if(d_employment==1)
      {
        var employment = document.getElementsByClassName("employment");
        var employment_data='data-';
         var employment_uncheck='data-';
        for (i=0;i<3; i++)
              {
                if (employment[i].checked === true)
                {
                  employment_data +=employment[i].value + "-";
                } else { employment_uncheck +=employment[i].value + "-"; }
              }
      }
    else { var employment_data='none'; var employment_uncheck='none'; }



    var d_training = document.getElementById('training').value;
    if(d_training==1)
      {
        var training = document.getElementsByClassName("training");
        var training_data='data-';
        var training_uncheck='data-';
        for (i=0;i<3; i++)
              {
                if (training[i].checked === true)
                {
                  training_data +=training[i].value + "-";
                } else { training_uncheck +=training[i].value + "-"; }
              }
      }
    else { var training_data='none';  var training_uncheck='none'; }

    var d_character = document.getElementById('character').value;
    if(d_character==1)
      {
        var character = document.getElementsByClassName("character");
        var character_data='data-';
        var character_uncheck='data-';
        for (i=0;i<3; i++)
              {
                if (character[i].checked === true)
                {
                  character_data +=character[i].value + "-";
                } else { character_uncheck +=character[i].value + "-"; }
              }
      }
    else { var character_data='none';  var character_uncheck='none'; }

    var d_dependents = document.getElementById('dependents').value;
    if(d_dependents==1)
      {
        var dependents = document.getElementsByClassName("dependents");
        var dependents_data='data-';
        var dependents_uncheck='data-';
        for (i=0;i<3; i++)
              {
                if (dependents[i].checked === true)
                {
                 dependents_data +=dependents[i].value + "-";
                } else { dependents_uncheck +=dependents[i].value + "-"; }
              }
      }
    else { var dependents_data='none'; var dependents_uncheck='none';  }

     var d_inventory = document.getElementById('inventory').value;
    if(d_inventory==1)
      {
        var inventory = document.getElementsByClassName("inventory");
        var inventory_data='data-';
        var inventory_uncheck='data-';
        for (i=0;i<3; i++)
              {
                if (inventory[i].checked === true)
                {
                  inventory_data +=inventory[i].value + "-";
                } else { inventory_uncheck +=inventory[i].value + "-"; }
              }
      }
    else { var inventory_data='none';  var inventory_uncheck='none';}

    var d_skills = document.getElementById('skills').value;
    if(d_skills==1)
      {
        var skills = document.getElementsByClassName("skills");
        var skills_data='data-';
        var skills_uncheck='data-';
        for (i=0;i<3; i++)
              {
                if (skills[i].checked === true)
                {
                 skills_data +=skills[i].value + "-";
                } else { skills_uncheck +=skills[i].value + "-"; }
              }
      }
    else { var skills_data='none'; var skills_uncheck='none'; }

    if(personal_data=='data-' && family_data=='data-'  &&  education_data=='data-'  &&  training_data=='data-'  &&  character_data=='data-'  &&  dependents_data=='data-'  && inventory_data=='data-'  &&  skills_data=='data-'  && employment_data=='data-')
      { alert('Please check atleast one topic to continue'); }
    else{  
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
                  document.getElementById("main_fetch_div").innerHTML=xmlhttp.responseText;
                }
              }
                xmlhttp.open("GET","<?php echo base_url();?>employee_portal/employee_201/send_update_request/"+msg_req+"/"+personal_data+"/"+family_data+"/"+
                  education_data+"/"+employment_data+"/"+training_data+"/"+character_data+"/"+dependents_data+"/"+inventory_data+"/"+skills_data+"/"+family_uncheck+"/"+
                  education_uncheck+"/"+employment_uncheck+"/"+training_uncheck+"/"+character_uncheck+"/"+dependents_uncheck+"/"+inventory_uncheck+"/"+skills_uncheck+"/"+other_data,true);
                xmlhttp.send();
      } }
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



 