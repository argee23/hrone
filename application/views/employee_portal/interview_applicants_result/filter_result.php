       <table class="table table-hover" id="status">
          <thead>
            <tr class="danger">
              <th>Applicant</th>
              <th>Job Title</th>
              <th>Details</th>
              <th>Admin Comment</th>
              <th>Interview Result</th>
              <th>Interviewer Comment</th>
              <th>Message to Applicant</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

          <?php foreach($applicants as $gt){?>
            <tr>  
              <td><?php echo $gt->fullname;?></td>
              <td><?php echo $gt->job_title;?></td>
              <td>
                  <n class="text-danger">Date Applied: </n><?php echo $gt->date_applied;?><br>
                  <n class="text-danger">Interview Date and time: </n><?php echo $gt->applicant_official_date."(".$gt->applicant_official_time.")";?>
              </td>
              <td><?php echo $gt->admin_comment;?></td>
              <td>
                <div id="orig_status<?php echo $gt->id_;?>"><?php if(empty($gt->interview_result)){ echo "No result yet"; } else{ echo $gt->interview_result; }?></div>
                <div id="upd_status<?php echo $gt->id_;?>" style='display: none;'>
                   <select class="form-control" id="status<?php echo $gt->id_;?>">
                      <option value="passed">Passed</option>
                      <option value="failed">Failed</option>
                      <option value="not_attended">X</option>
                   </select>
                </div>
              </td>
              <td>
                <div id="orig_comment<?php echo $gt->id_;?>"><?php echo $gt->interviewer_comment;?></div>
                <div id="upd_comment<?php echo $gt->id_;?>" style='display: none;'>
                  <input type="hidden" id="comment_final<?php echo $gt->id_;?>">
                  <textarea class="form-control" rows="2" id="comment<?php echo $gt->id_;?>"><?php echo $gt->interviewer_comment;?></textarea>
                </div>
              </td>


              <td>
                <div id="orig_mess<?php echo $gt->id_;?>"><?php echo $gt->applicant_message;?></div>
                <div id="upd_mess<?php echo $gt->id_;?>" style='display: none;'>
                  <input type="hidden" id="mess_final<?php echo $gt->id_;?>">
                  <textarea class="form-control" rows="2" id="mess<?php echo $gt->id_;?>"><?php echo $gt->applicant_message;?></textarea>
                </div>
              </td>


              <td>
              <div id="orig_action<?php echo $gt->id_;?>">
                <?php if(empty($gt->interview_result)){?>
                   <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="update_status('<?php echo $gt->id_;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Update Applicant Status'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                 <?php } else{ echo "-"; } ?>
              </div>
              <div id='upd_action<?php echo $gt->id_;?>' style='display: none;'>
                  <a style='cursor:pointer;color:green;' style="margin-top: 20px;margin-left: 10px;"  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick='save_status("<?php echo $gt->id_;?>","<?php echo $id;?>");'><i  class="fa fa-check fa-lg  pull-left"></i></a>
                 <a  style="margin-top: 20px;margin-left: 10px;color:red;" onclick='cancel("<?php echo $gt->id_;?>");' aria-hidden='true' data-toggle='tooltip' title='Click to cancel numbering update'><i  class="fa fa-times fa-lg  pull-left"></i></a>
              </div>

              </td>
            </tr>
          <?php } ?>

          </tbody>
        </table>
         