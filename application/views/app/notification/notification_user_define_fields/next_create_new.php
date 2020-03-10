 <?php 
        $company_id = $this->uri->segment('5');
          //echo $company_id."UDN ni NEMZ";
          $current_comp=$this->notification_user_define_fields_model->get_company($company_id);
            if(!empty($current_comp)){
                 $company_name = $current_comp->company_name;
             }else{
                 $company_name="company not exist";
             }
         $this->uri->segment("5");
         //echo $this->uri->segment('4');
   ?>
<div class="row">
<div class="col-md-6">

<div class="box box-success">
<div class="panel panel-success">
  <div class="panel-heading"><strong>New Notification Form(<?php echo $company_name; ?></strong><small>  </small></div>

  <form class="form-horizontal" method="post" action="<?php echo base_url()?>app/notification_user_define_fields/save_udn_col_new/<?php echo $this->uri->segment("4");?>" >
 
    <div class="box-body">
  
          <!-- SAME LANG DIN TO NUNG SA add_udf -->

            <div class="form-group"><!-- 
        <label for="company_id" class="col-sm-2 control-label">Company id</label> -->
        <div class="col-sm-10">
             <input type="hidden" class="form-control" name="company" id="company" placeholder="Company Id" value="<?php echo $company_id; ?>">

        </div>

      </div>


         <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Form Title</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" name="fname" id="fname" placeholder="Form Title"  onchange="return trim(this)" value="" required>
        </div>
      </div>


       <div class="form-group">
        <label for="label" class="col-sm-2 control-label">Form Description</label>
        <div class="col-sm-10">
          <TEXTAREA type="text" class="form-control" name="fdesc" id="fdesc"  onchange="return trim(this)" placeholder="Form Description" value="" required> </TEXTAREA>
        </div>
      </div>

   <div class="form-group">
        <label for="type" class="col-sm-2 control-label">Issuance Type</label>
        <div class="col-sm-10">
        
          <select class="form-control" name="issuance_type" id="issuance_type" data-toggle="collapse"  required>
              <option selected="selected" value="" disabled="">~ Select ~</option>
              <option value="1">with approver</option>
              <option value="0">no approver</option>
          </select>
        </div>
      </div>


<?php 
  if($this->uri->segment("4")!=""){
    $count=$this->uri->segment("4");
    $nof = "0"; 
  while($nof!=$count){
  $nof++;
  //echo" <input type='hidden' class='form-control' name='nof' id='nof'  value='$count' required>";
  //echo $nof;
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
          <select class="checks form-control" name="type[]" id="type'.$nof.'" onchange="pagdatepicker('.$nof.');" data-toggle="collapse"  required>
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
            <input type="number" class="form-control" name="max_length[]" id="max_length'.$nof.'" value=""  min="1"  required>
            <input type="hidden" class="form-control m_l'.$nof.'" name="max_length[]" id="max_length'.$nof.'" value="0">
        </div>
      </div>

      <div class="form-group">
        <label for="not_null" class="col-sm-2 control-label">Not null</label>
        <div class="col-sm-10">
          <br>
       
          <input type="checkbox" name="not_null[]" value="yes" checked>
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

