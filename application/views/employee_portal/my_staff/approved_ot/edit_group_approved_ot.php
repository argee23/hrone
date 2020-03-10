
<div class="col-md-12">

        <div class="col-md-1">

        </div>


        <div class="col-md-10">
            <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>employee_portal/my_staff_approved_ot/save_update_approved_ot_group/" >
                <?php foreach($details as $d) {?>

                        <div class="form-group">
                        <label class="control-label col-sm-4" for="email">Date</label>
                            <div class="col-sm-8">
                              <input type="date" class="form-control" id="date" name="date" value="<?php echo $d->date;?>" disabled>
                              <input type="hidden" name="id" value="<?php echo $id;?>">
                            </div>
                        </div>
                            
                        <div class="form-group">
                        <br>
                        <label class="control-label col-sm-4" for="email">Group Name</label>
                            <div class="col-sm-8">
                             <textarea class="form-control" colspan="3" name="group_name"><?php echo $d->group_name;?></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                        <br>
                        <label class="control-label col-sm-4" for="email">Reason</label>
                            <div class="col-sm-8">
                               <textarea class="form-control" colspan="3" name="reason"><?php echo $d->reason;?></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email"></label>
                            <div class="col-sm-8">
                               <button type="submit" class="col-md-12 btn btn-success" style="margin-top: 10px;">UPDATE</button>
                            </div>
                        </div>

                <?php } ?>
            </form>
        </div>


         <div class="col-md-1">

        </div>

</div>