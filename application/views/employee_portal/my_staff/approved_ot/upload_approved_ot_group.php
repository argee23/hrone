
<div class="col-md-12">

        <div class="col-md-1">

        </div>


        <div class="col-md-10">
            <form enctype="multipart/form-data" target="_blank" method="post" action="<?php echo base_url()?>employee_portal/my_staff_approved_ot/save_upload_approved_ot_group/" >
     
                    <div class="form-group">
                    <label class="control-label col-sm-3" for="email">File</label>
                    <div class="col-md-9">
                        <div class="col-md-12 btn btn-info" id="upload">
                            <input type="file" name="file" id="file" ng-model="first_name" accept=".xls,.xlsx" required>
                        </div>
                    </div> 
                    </div>
                    <div class="form-group">
                    <br><br>
                    <label class="control-label col-sm-3" for="email">Action</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="action" id="action" required>
                                      <option value="" disabled selected >Select Action</option>
                                      <option>Save</option>
                                      <option>Review</option>
                            </select>
                        </div>
                    </div>
                   
                    <input type="hidden" name="id" name="id" value="<?php echo $id;?>">
                    <input type="hidden" name="date" name="date" value="<?php echo $date;?>">

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email"></label>
                        <div class="col-sm-9">
                           <button type="submit"  name="import"  class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;">SAVE</button>
                        </div>
                    </div>
            </form>

        </div>


         <div class="col-md-1">

        </div>

</div>