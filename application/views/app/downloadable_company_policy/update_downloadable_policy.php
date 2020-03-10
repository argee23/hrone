 <div class="modal-content">
     <div class="modal-header well well-sm bg-olive" >
        <h4 style="font-weight: serif;"><center>Add New Downloadable Form</center></h4>
      </div>
    <form enctype="multipart/form-data" method="post" action="<?php echo base_url()?>app/downloadable_company_policy/save_update_downloadable_policy/<?php echo $id."/".$company;?>" >
            
    <div class="col-sm-12">
        <div class="panel panel-default">
        <div class="panel-heading">
        <strong><a class="text-danger"><i>Accepted Files:jpg,jpeg,png,gif,pdf,xls,xlsx,docx,txt,doc,ppt,pptx </i></a></strong>
        </div>
        <div class="panel-body">
        <?php foreach($details as $d){?>
          <span class="dl-horizontal col-sm-11">
                <dt>Numbering</dt>
                <dd>
                 <select name="numbering" id="numbering" class="form-control" required>
                  <option value="" selected disabled>Select</option>
                    <?php for($i=1;$i <= 100; $i++){
                       $n = intval($i);
                       $res = '';
                       $roman_numerals = array(
                        'M'  => 1000,
                        'CM' => 900,
                        'D'  => 500,
                        'CD' => 400,
                        'C'  => 100,
                        'XC' => 90,
                        'L'  => 50,
                        'XL' => 40,
                        'X'  => 10,
                        'IX' => 9,
                        'V'  => 5,
                        'IV' => 4,
                        'I'  => 1);
                      foreach ($roman_numerals as $roman => $number) 
                      {
                          /*** divide to get  matches ***/
                          $matches = intval($n / $number);
                          /*** assign the roman char * $matches ***/
                          $res .= str_repeat($roman, $matches);
                   
                          /*** substract from the number ***/
                          $n = $n % $number;
                      }

                      ?>
                      <option value="<?php echo $i;?>" <?php if($i==$d->numbering){ echo "selected"; }?>><?php echo $res;?></option>
                    <?php } ?>
                  </select>
            </dd><br>
            <dt>File Title</dt>
            <dd>
              <textarea class="form-control" rows="3" required name="title"><?php echo $d->file_name;?></textarea>
            </dd><br>
            <dt>File Description</dt>
            <dd>
              <textarea class="form-control" rows="3" required name="description"><?php echo $d->file_description;?></textarea>
            </dd><br>
            <dt>Upload File</dt>
            <dd>
             <input type="file" name="file" id="file" value="">
              <input type="hidden" name="file_old" id="file_old" value="<?php echo $d->filename;?>">
            </dd>

          </span>
        <?php } ?>
        </div>
        </div>    
    </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Update</button>
        <button type="button" class="btn btn-default" onclick="location.reload();">Close</button>
      </div>
      </form>
      </div>

    </div>


<script>

   $('#modal').on('hidden.bs.modal', function () {
  $(this).removeData('bs.modal');
});

</script>