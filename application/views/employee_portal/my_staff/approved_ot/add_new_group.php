
<div class="col-md-12">

        <div class="col-md-1">

        </div>


        <div class="col-md-10">
            <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>employee_portal/my_staff_approved_ot/save_approved_ot_group/" >
     
                    <div class="form-group">
                    <label class="control-label col-sm-4" for="email">Date</label>
                        <div class="col-sm-8">
                          <input type="date" class="form-control" id="date" name="date">
                        </div>
                    </div>
                    
                    <div class="form-group">
                    <br>
                    <label class="control-label col-sm-4" for="email">Group Name</label>
                        <div class="col-sm-8">
                         <textarea class="form-control" colspan="3" name="group_name"></textarea>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                    <br>
                    <label class="control-label col-sm-4" for="email">Reason</label>
                        <div class="col-sm-8">
                           <textarea class="form-control" colspan="3" name="reason"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email"></label>
                        <div class="col-sm-8">
                           <button type="submit" class="col-md-12 btn btn-success" style="margin-top: 10px;">SAVE</button>
                        </div>
                    </div>
            </form>
        </div>


         <div class="col-md-1">

        </div>

</div>