<div class="row">
  <div class="col-md-3">
    <label>Company :</label>
    <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="qualifying()">
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
 }else{
  echo '<option selected="selected" value="0"> All Companies </option>';
 } 
?>      

      <?php 
        foreach($companyList as $company){
          if($_POST['company'] == $company->company_id){
            $selected = "selected='selected'";
          }
          else{
            $selected = "";
          }
      ?>
      <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
      <?php }?>
    </select>
  </div>
  <div class="col-md-3">
    <label>Correct Answer :</label>
    <select class="form-control select2" name="cor_ans" id="cor_ans" style="width: 100%;" onchange="qualifying()">
    <option selected="selected" value="2"> All Answers </option>
    <option value="1">Yes</option>
    <option value="0">No</option>
    </select>
  </div>
  <div class="col-md-3">
    <label> Status :</label>
    <select class="form-control" name="status" id="status" style="width: 100%;" onchange="qualifying()">
    <option selected="selected" value="2"> All Status </option>
    <option value="1">InActive</option>
    <option value="0">Active</option>
    </select>
  </div> 
</div>
    <!-- <div class="row"> -->
    <div class="col-md-12" id="fill" style="padding: 0 0 1% 0">
      <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <hr>
      </div>
    </div>
    <table id="questions" class="table table-bordered table-striped">
            <thead>
                <tr>
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
 }else{
  echo '<th>Company Name</th>';
 } 
?>                   

                    <th>Question</th>
                    <th>Correct Answer</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($questions as $questions){ ?>

                <tr>
<?php
if($this->session->userdata('recruitment_employer_is_logged_in')){
 }else{
  echo '<td>'.$questions->company_name.'</td>';
 } 
?> 
                    <td><?php echo $questions->question?></td>
                    <td><?php if($questions->correct_ans == 1){ echo "Yes"; } else { echo "No";}?></td>
                    <td><?php if($questions->InActive == 1){ echo "Inactive"; } else { echo "Active";}?></td>
                </tr>
                      <?php }?>
                     
             </tbody>
    </table>
    </div>