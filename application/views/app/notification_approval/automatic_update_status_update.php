    <?php foreach($details_one as $d){?>
         <div class='col-md-12'>

                         <div class="col-md-3"><label><u>Company:</u></label></div>
                          <div class="col-md-9"  id='r_option'>
                             <select class="form-control" id="acompany" disabled>
                             <option value="" disabled selected>Select</option>
                             <?php foreach($companyList as $comp){?>
                                <option value="<?php echo $comp->company_id;?>" <?php if($d->company_id==$comp->company_id){ echo "selected"; };?>><?php echo $comp->company_name;?></option>
                             <?php } ?>
                             </select>
                          </div>
                </div>
                 <div class='col-md-12' style="margin-top: 5px;">
                         <div class="col-md-3"><label><u>No. of Days:</u></label></div>
                          <div class="col-md-9"  id='r_option'>
                             <input type="number" class="form-control" placeholder="Input number of days" id="adays" value="<?php echo $d->days;?>">
                          </div>
                </div>
                 <div class='col-md-12' style="margin-top: 5px;">
                         <div class="col-md-3"><label><u>Status:</u></label></div>
                          <div class="col-md-9"  id='r_option'>
                            <select class="form-control" id="astatus">
                              <option value="" disabled selected>Select</option>
                              <option value='approved' <?php if($d->status=='approved'){ echo "selected"; }?>>Approved</option>
                              <option value='cancelled'  <?php if($d->status=='cancelled'){ echo "selected"; }?>>Cancelled</option>
                              <option value='rejected'  <?php if($d->status=='rejected'){ echo "selected"; }?>>Rejected</option>
                            </select>
                          </div>
                </div>
                 <div class='col-md-12' style="margin-top: 5px;">
                         <div class="col-md-3"></div>
                          <div class="col-md-9"  id='r_option'>
                           <button class='col-md-12 btn btn-success' onclick="saveupdate_automatic_update_status();">SAVE</button>
                          </div>
                </div>
                         
              
          </div>
  <?php } ?>