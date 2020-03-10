 <?php 
        $company_id = $this->uri->segment('5');
          $current_comp=$this->transaction_user_define_fields_model->get_company($company_id);
            if(!empty($current_comp)){
                 $company_name = $current_comp->company_name;
             }else{
                 $company_name="company not exist";
             }
         $this->uri->segment("5");
   ?>
<div class="row">
<div class="col-md-6">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>New Transaction Form(<?php echo $company_name; ?></strong><small>  </small></div>

  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/transaction_user_define_fields/save_udf_col_new/<?php echo $this->uri->segment("4");?>" >
  <!-- <div><?php echo form_input(array('id'=>'label','name'=>'label'));?></div>
   <?php echo form_close(); ?> -->
    <div class="box-body">
  
          <!-- SAME LANG DIN TO NUNG SA add_udf -->

             <div class="form-group"><!-- 
        <label for="company_id" class="col-sm-2 control-label">Company id</label> -->
        <div class="col-sm-10">
             <input type="hidden" class="form-control" name="company" id="company" placeholder="Company Id" value="<?php echo $company_id; ?>">

          <!-- <select class="form-control" name="company" id="company" required>
            <option selected="selected" value="" disabled="">~ Select Company ~</option>
            <option value="0">Select All Company</option>
              <?php 
                foreach($companyList as $company){
                  echo "<option value='".$company->company_id."' >".$company->company_name."</option>";
                }
              ?>
          </select>     -->
        </div>

      </div>




         <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Form Title</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="fname" id="fname" placeholder="Form Title"  onchange="return trim(this)" value="" required>
        </div>
      </div>

<!--   JULY 9 edit
        <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Document no.</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="iden" id="iden" placeholder="Document no." value="" required>
        </div>
      </div>  -->



      



       <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Form Description</label>
        <div class="col-sm-10">
          <TEXTAREA type="text" class="form-control" name="fdesc" id="fdesc"  onchange="return trim(this)" placeholder="Form Description" value="" required> </TEXTAREA>
        </div>
      </div>

   


<?php 
  if($this->uri->segment("4")!=""){
    $count=$this->uri->segment("4");
    $nof = "0"; 
  while($nof!=$count){
  $nof++;
  echo '  

      <div class="box box-default">
      </br>
        <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Label</label>
        <div class="col-sm-10">
                  <input type="text" class="form-control" name="label[]" id="label"  onchange="return trim(this)" placeholder="Label" value="" required>

          
        </div>
      </div>




      <div class="form-group">
        <label for="type" class="col-sm-2 control-label">Input Type</label>
        <div class="col-sm-10">
        
          <select class="form-control" name="type[]" id="type'.$nof.'" onchange="pagdatepicker('.$nof.');" data-toggle="collapse"  required>
              <option selected="selected" value="" disabled="">~ Select Type ~</option>
              <option value="Datepicker">Date picker</option>
              <option value="Selectbox">Select box</option>
              <option value="Textarea">Text area</option>
              <option value="Textfield">Text field</option>
          </select>
        </div>
      </div>

           <div class="form-group">
        <label for="accept_value" id="for_av'.$nof.'" class="col-sm-2 control-label" >Accept value</label>
        <div class="col-sm-10">
          <select class="form-control" name="accept_value[]" id="accept_value'.$nof.'" onchange="for_maxlength('.$nof.');" required>
              <option selected="selected" value="" disabled="">~ Select Accept Value ~</option>
              <option value="varchar">Alpha numeric only</option>
              <option value="text">Letters only</option>
              <option value="int">Numbers only</option>
          </select>
           <input type="hidden" class="form-control a_v'.$nof.'"  name="accept_value[]" id="accept_value'.$nof.'" value="datetime">
        </div>
      </div>
      <div class="form-group">
        <label for="max_length" id="for_ml'.$nof.'" class="col-sm-2 control-label"></label>
        <div class="col-sm-10">
            <input type="number" class="form-control" name="max_length[]" id="max_length'.$nof.'" value=""  min="1" required>
             <input type="hidden" class="form-control m_l'.$nof.'" name="max_length[]" id="max_length'.$nof.'" value="0">
        </div>
      </div>

      <div class="form-group">
        <label for="not_null" class="col-sm-2 control-label">Not null</label>
        <div class="col-sm-10">
          <br>
          <input type="hidden" value="no" name="not_null[]">
          <input type="checkbox" name="not_null[]" value="yes">
        </div>
      </div>
          </div>
    ';
   }
   }else{
       echo "";
    }

  
   ?>

    









          <button type="submit" class="btn btn-success btn pull-right"><i class="fa fa-floppy-o"></i> Save</button>
    </div><!-- /.box-body -->
  </form>
</div>
</div>


<div class="col-md-6" id="col_3"></div>
</div>  
</div>

