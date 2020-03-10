
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-danger">
      <div class="panel-heading">   
      <strong>
<?php 
$company_id=$this->uri->segment('4');
$cname=$this->general_model->get_company_info($company_id);
$company_name=$cname->company_name;
echo $company_name;
?>
    </strong>
      <input type="hidden" name="company_id" id="company_id" value="<?php echo $company_id; ?>">
      </div>
        <div class="panel-body">

          <div class="col-md-12">
              <div class="btn-group-vertical btn-block">

              <?php 
                
                      echo "<a onclick='brandmng(".$company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Biometrics Brand Management</strong></p></a>";

                      echo "<a onclick='view_selected_action(".$company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Biometrics Type/Name Management</strong></p></a>";

                      echo "<a onclick='view_selected_action(".$company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>Biometrics Setup Management</strong></p></a>";
                  
              ?>
              </div>

          </div>



        </div>






    </div>
  </div>
</div>
