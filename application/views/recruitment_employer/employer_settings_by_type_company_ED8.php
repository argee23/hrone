
<form class="form-horizontal" method="post" action="<?php echo base_url()?>recruitment_employer/recruitment_employer_management/save_ed8_settings/<?php echo $company_id."/".$type;?>">

    <div class="col-md-12" style="margin-top: 30px;margin-bottom: 20px">
        <textarea name="content" style="width:100%">
          <?php if(!empty($details)){ echo $details; }?>
        </textarea>


    </div>

    <div class="col-md-12">
      <div class="col-md-3"></div><button type="submit" class="col-md-6 btn btn-success">SAVE ACKNOWLEDGMENT CONTENT</button><div class="col-md-3"></div>
    </div>

</form>
