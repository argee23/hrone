<div class="modal-content">
      <div class="modal-header well well-sm bg-olive" >
      <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-success" style="color: white;"><center><b>EMPLOYEE REFERRAL POINTS</center></b></h4>
      </div>

   
      
      <div class="modal-body">
          

          <div class="panel panel-default" id="savedemployee">
          <div class="panel-heading">
          <strong><a class="text-danger">Assigned Employee Referral Points</i></a></strong>
          </div>

          <div class="panel-body">
            <span class="dl-horizontal col-sm-12">
              <div class="col-md-2"></div>
              <div class="col-md-8" style="padding-bottom: 30px;" id="">
                  <div class="col-md-12">


                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <input type="text" name="name" id="name" placeholder="Input Referral Name" class="form-control">
                        <input type='hidden' id="name_final">
                        <button class="col-md-12 btn btn-warning btn-sm" style="margin-top: 10px;" onclick="add_referral();"><i class="fa fa-plus"></i>ADD</button>
                    </div>
                  <div class="col-md-3"></div>
                  </div>
                  <br><br><br><br><br>
                   <div class="box box-danger" class='col-md-12'></div>

                  <div class="col-md-12" style="margin-top: 20px;" id="referrals">

                    <table class="table table-hover" id="ress">
                        <thead>
                          <tr class="danger">
                            <th style="width: 90%;">Name</th>
                            <th style="width: 10%;">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php $i=1; $string_l=""; foreach($referrals as $r){?>
                          <tr>
                            <td><?php echo $r->employee;?></td>
                            <td>
                              <a style='cursor:pointer;color:red;' aria-hidden='true' data-toggle='tooltip' title='Click to Remove Name' onclick="remove_referral('<?php echo $r->employee;?>','<?php echo $i;?>');" ><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                <input type="hidden" id="n<?php echo $i;?>">

                            </td>
                          </tr>
                        <?php $i++; 
                          $aa = $r->employee."milajove";
                          $string_l .= $aa;

                        } ?>
                        </tbody>
                    </table>

                    <input type="hidden" id="namess" name="namess" value="<?php echo $string_l;?>" style='width: 1000px;'>
                    <input type="hidden" id="allnames" name="allnames" value=""  style='width: 1000px;'>

                  </div>

              </div>
              <div class="col-md-2"></div>

              <div class="col-md-12">
                <n class="text-danger"><i>Note: Click the SAVE button to save the employee referral points changes.</i></n>
              </div>
            </span>
          </div>
          </div>

          <div class="modal-footer" id="forADDed">
            <button type="button" class="btn btn-success" style="display: none;" id="bb" onclick="save_referral('<?php echo $app_id;?>','<?php echo $applicant_id;?>','<?php echo $job_id;?>');">SAVE</button>
            <button type="button" class="btn btn-default" onclick="window.location.reload()">Close</button>
          </div>
     

  </div>
  
  <script type="text/javascript">

    $(function () {
        $('#ress').DataTable({
          "pageLength": 6,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
  </script>