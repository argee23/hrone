 <?php foreach ($data as $d) { ?>
 <div class="col-md-12">
                <div class='col-md-8'>
                         <div class="col-md-3"><label><u>Form Name:</u></label></div>
                          <div class="col-md-9"  id='r_option'> <input type='text' class='form-control' value="<?php echo $d->title?>" id='request_form_list'>
                          <input type="hidden" id="edit_form_title">
                          </div>
                </div>
          <div class='col-md-2'><button class='btn btn-success' onclick="update_request_form_list(<?php echo $d->id?>);">UPDATE</button></div>
        </div>
<?php } ?>