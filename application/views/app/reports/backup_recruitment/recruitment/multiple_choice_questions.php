    <div class="row">
      <div class="col-md-3">
          <label>Company :</label>
          <select class="form-control select2" name="company" id="company" style="width: 100%;" onchange="multiple_choice()">
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
            }else{
                $selected = "";
            }
            ?>
            <option value="<?php echo $company->company_id;?>"><?php echo $company->company_name;?></option>
            <?php }?>
          </select>
      </div>
      <div class="col-md-3">
        <label> Status :</label>
        <select class="form-control" name="status" id="status" style="width: 100%;" onchange="multiple_choice()">
        <option selected="selected" value="2"> All Status</option>
        <option value="0">Active</option>
        <option value="1">Inactive</option>
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
                    <th>Choices</th>
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
                    <td>
                        <?php 
                          $choices = $this->reports_model->get_choices($questions->id);
                          $no = 1; 
                          foreach($choices as $mc){
                            echo "<div>".$no.") ".$mc->mc_choice."</div>";
                            $no++;
                          }
                        ?>  
                    </td>
                    <td><?php if($questions->InActive == 1){ echo "Inactive"; } else { echo "Active";}?></td>
                </tr>
                      <?php }?>
                     
             </tbody>
    </table>
    </div>