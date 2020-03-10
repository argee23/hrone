<div class="row">
<div class="col-md-8">

<div class="box box-danger">
<div class="panel panel-danger">
  <div class="panel-heading"><strong>CONTACT INFORMATION</strong> (edit)</div>

    <form method="post" action="<?php echo base_url()?>app/employee_201_profile/contact_info_modify/<?php echo $this->uri->segment("4");?>" >

    <div class="box-body">


            <div class="row">
            <div class="col-md-6">


            <div class="form-group">
              <label for="mobile1">Mobile No. 1 <i class="text-danger"><?php if(empty($mobile_)) { echo "<br> ( No setting set up by admin.You're free to use any format.)"; } else{ echo "(Format:".$mobile_.")"; } ?></i></label>
              <input type="text" name="mobile1" class="form-control" placeholder="Mobile No. 1" value="<?php echo $contact_info_view->mobile_1; ?>" 
              <?php if(empty($mobile_)) {} else{ ?> pattern="<?php echo $mobile?>" <?php } ?>>
            </div>
            <div class="form-group">
              <label for="mobile1">Mobile No. 3 <i class="text-danger"><?php if(empty($mobile_)) { echo "<br> ( No setting set up by admin.You're free to use any format.)"; } else{ echo "(Format:".$mobile_.")"; } ?></i></label>
              <input type="text" name="mobile3" class="form-control" placeholder="Mobile No. 3" value="<?php echo $contact_info_view->mobile_3; ?>" 
              <?php if(empty($mobile_)) {} else{ ?> pattern="<?php echo $mobile?>" <?php } ?>>
            </div>

            <div class="form-group" >
              <label for="tel1">Telephone NO. 1  <i class="text-danger"><?php if(empty($tel_)) { echo "<br> ( No setting set up by admin.You're free to use any format.)"; } else{ echo "(Format:".$tel_.")"; } ?></i></label>
              <input type="text" name="tel1" class="form-control" placeholder="Telephone No. 1" value="<?php echo $contact_info_view->tel_1; ?>"
               <?php if(empty($tel_)) {} else{ ?> pattern="<?php echo $tel?>" <?php } ?> >
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" class="form-control" placeholder="email" value="<?php echo $contact_info_view->email; ?>">
            </div>

            <div class="form-group">
              <label for="facebook">facebook</label>
              <input type="text" name="facebook" class="form-control" placeholder="facebook" value="<?php echo $contact_info_view->facebook; ?>">
            </div>


            </div>
            
            <div class="col-md-6">
            <div class="form-group">
              <label for="mobile2">Mobile No. 2 <i class="text-danger"><?php if(empty($mobile_)) { echo "<br> ( No setting set up by admin.You're free to use any format.)"; } else{ echo "(Format:".$mobile_.")"; } ?></i></label>
              <input type="text" name="mobile2" class="form-control" placeholder="Mobile No. 2" value="<?php echo $contact_info_view->mobile_2; ?>"
               <?php if(empty($mobile_)) {} else{ ?> pattern="<?php echo $mobile?>" <?php } ?>>
            </div>
              <div class="form-group">
              <label for="mobile1">Mobile No. 4 <i class="text-danger"><?php if(empty($mobile_)) { echo "<br> ( No setting set up by admin.You're free to use any format.)"; } else{ echo "(Format:".$mobile_.")"; } ?></i></label>
              <input type="text" name="mobile4" class="form-control" placeholder="Mobile No. 4" value="<?php echo $contact_info_view->mobile_4; ?>" 
              <?php if(empty($mobile_)) {} else{ ?> pattern="<?php echo $mobile?>" <?php } ?>>
            </div>
            <div class="form-group" >
              <label for="tel2">Telephone NO. 2 <i class="text-danger"><?php if(empty($tel_)) { echo "<br> ( No setting set up by admin.You're free to use any format.)"; } else{ echo "(Format:".$tel_.")"; } ?></i></label>
              <input type="text" name="tel2" class="form-control" placeholder="Telephone No. 2" value="<?php echo $contact_info_view->tel_2; ?>" 
               <?php if(empty($tel_)) {} else{ ?> pattern="<?php echo $tel?>" <?php } ?>>
            </div>

            <div class="form-group">
              <label for="instagram">Instagram</label>
            <input type="text" name="instagram" class="form-control" placeholder="instagram" value="<?php echo $contact_info_view->instagram; ?>">
            </div>

            <div class="form-group">
              <label for="twitter">Twitter</label>
            <input type="text" name="twitter" class="form-control" placeholder="twitter" value="<?php echo $contact_info_view->twitter; ?>">
            </div>

            
            </div>
            </div>

    <div class="form-group">
     <button type="submit" class="form-control btn btn-danger"><i class="fa fa-floppy-o"></i> SAVE CHANGES</button>
     </div>
    </div><!-- /.box-body -->
    </form>
</div>
</div>

</div>  
</div>


