<div class="col-md-12" >
  <div class="tab-content">
    <div class="tab-pane active" id="p_info">
      <div class="panel panel-success">
        <div class="panel-heading"><h4 class="text-danger">Interview Result
          <button class="btn btn-success btn-xs pull-right">FILTER</button>
        </h4></div>

        <div class="col-md-12">

        <div class="col-md-3"></div>
        <div class="col-md-6" style="margin-top: 5px;">

            <div class="col-md-12">
              <div class="col-md-5" style="margin-top: 10px;">
                  <input type="date" class="form-control">
              </div>
              <div class="col-md-2"  style="margin-top: 10px;"><center>to</center></div>
              <div class="col-md-5"  style="margin-top: 5px;">
                  <input type="date" class="form-control">
              </div>
            </div>
            <div class="col-md-12">
              <div class="col-md-5" style="margin-top: 10px;">
                  <input type="time" class="form-control">
              </div>
              <div class="col-md-2"  style="margin-top: 10px;"><center>to</center></div>
              <div class="col-md-5"  style="margin-top: 5px;">
                  <input type="time" class="form-control">
              </div>
            </div>
            <div class="col-md-12">  
              <div class="col-md-12"  style="margin-top: 5px;">
                  <select class="form-control">
                      <option value="" selected disabled>Select Interview Result</option>
                      <option>All</option>
                      <option>Passed</option>
                      <option>Failed</option>
                      <option>X</option>on>
                  </select>
              </div>
            </div>
            <div class="col-md-12">  
              <div class="col-md-12"  style="margin-top: 5px;">
                  <button class="col-md-12 btn btn-success btn-sm">FILTER</button>
              </div>
            </div>
        </div>
        <div class="col-md-3"></div>
        </div>


        <div class="panel-body" style="height:440px;">
      
          <table class="table table-hover" id="status">
          <thead>
            <tr class="danger">
              <th>Applicant</th>
              <th>Job Title</th>
              <th>Date Applied</th>
              <th>Interview Date/Time</th>
              <th>Interview Result</th>
              <th>Admin Comment</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

          <?php foreach($applicants as $gt){?>
            <tr>  
              <td><?php echo $gt->fullname;?></td>
              <td><?php echo $gt->job_title;?></td>
              <td><?php echo $gt->date_applied;?></td>
              <td><?php echo $gt->applicant_official_date."(".$gt->applicant_official_time.")";?></td>
              <td>
                <div id="orig_status<?php echo $gt->id_;?>"><?php if(empty($gt->interview_result)){ echo "No result yet"; } else{ echo $gt->interview_result; }?></div>
                <div id="upd_status<?php echo $gt->id_;?>" style='display: none;'>
                   <select class="form-control" id="status<?php echo $gt->id_;?>">
                      <option>Passed</option>
                      <option>Failed</option>
                      <option>X</option>
                   </select>
                </div>
              </td>
              <td>
                <div id="orig_comment<?php echo $gt->id_;?>"><?php echo $gt->admin_comment;?></div>
                <div id="upd_comment<?php echo $gt->id_;?>" style='display: none;'>
                  <input type="hidden" id="comment_final<?php echo $gt->id_;?>">
                  <textarea class="form-control" rows="2" id="comment<?php echo $gt->id_;?>"><?php echo $gt->admin_comment;?></textarea>
                </div>
              </td>
              <td>
              <div id="orig_action<?php echo $gt->id_;?>">
                <?php if(empty($gt->interview_result)){?>
                   <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="update_status('<?php echo $gt->id_;?>');" aria-hidden='true' data-toggle='tooltip' title='Click to Update Applicant Status'  ><i  class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>
                 <?php } else{ echo "-"; } ?>
              </div>
              <div id='upd_action<?php echo $gt->id_;?>' style='display: none;'>
                  <a style='cursor:pointer;color:green;' style="margin-top: 20px;margin-left: 10px;"  aria-hidden='true' data-toggle='tooltip' title='Click to save changes' onclick='save_status("<?php echo $gt->id_;?>");'><i  class="fa fa-check fa-lg  pull-left"></i></a>
                 <a  style="margin-top: 20px;margin-left: 10px;color:red;" onclick='cancel("<?php echo $gt->id_;?>");' aria-hidden='true' data-toggle='tooltip' title='Click to cancel numbering update'><i  class="fa fa-times fa-lg  pull-left"></i></a>
              </div>

              </td>
            </tr>
          <?php } ?>

          </tbody>
        </table>
         
        </div>
      </div>
    </div>
  </div>
</div>
