<?php 
       
         $pay_type_id = $this->uri->segment('4');      
        
         // echo $pay_type_id;
  ?> 


 <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">

 
                <?php if($pay_type_id == 1){ ?>
                    <label class="col-sm-4 control-label">PER</label>
                      <div class="col-sm-4"> 
                          <div id="check1"><input type="checkbox" class="checks" name="c_off" value="1" id="checkbox1" onclick="cutoff(this.value)"> 1 Cutoff</div>
                          <div id="check2"><input type="checkbox"  class="checks" name="c_off" value="2" id="checkbox2" onclick="cutoff()"> 2 Cutoff</div>
                          <div id="check3"> <input type="checkbox" class="checks"  name="c_off" value="3" id="checkbox3" onclick="cutoff()"> 3 Cutoff</div>
                          <div id="check4"> <input type="checkbox"  class="checks" name="c_off" value="4" id="checkbox4" onclick="cutoff()"> 4 Cutoff</div>
                          <div id="check5"><input type="checkbox"  class="checks" name="c_off" value="5" id="checkbox5" onclick="cutoff()"> 5 Cutoff</div>
                          <div id="pay_day"> <input type="checkbox"  class="checks" name="c_off" value="per_payday" id="per_payday" onclick="checkbox_checker(this.value);">Payday</div><br>
                      </div>

              <?php }else if($pay_type_id == 2) { ?>
                    <label class="col-sm-4 control-label">PER</label>
                      <div class="col-sm-4"> 
                        <div id="check1"><input type="checkbox" class="checks" name="c_off" value="1" id="checkbox1" onclick="cutoff(this.value)"> 1 Cutoff</div>
                        <div id="check2"><input type="checkbox"  class="checks" name="c_off" value="2" id="checkbox2" onclick="cutoff()"> 2 Cutoff</div>
                        <div id="pay_day"> <input type="checkbox"  class="checks" name="c_off" value="per_payday" id="per_payday" onclick="checkbox_checker(this.value);">Payday</div><br>
                    </div>

              <?php }else if($pay_type_id == 3){ ?>
                    <label class="col-sm-4 control-label">PER</label>
                      <div class="col-sm-4"> 
                            <div id="check1"><input type="checkbox" class="checks" name="c_off" value="1" id="checkbox1" onclick="cutoff(this.value)"> 1 Cutoff</div>
                            <div id="check2"><input type="checkbox"  class="checks" name="c_off" value="2" id="checkbox2" onclick="cutoff()"> 2 Cutoff</div>
                            <div id="pay_day"> <input type="checkbox"  class="checks" name="c_off" value="per_payday" id="per_payday" onclick="checkbox_checker(this.value);">Payday</div><br>
                      </div>

             <?php }else{ ?>
                    <label class="col-sm-4 control-label">PER</label>
                      <div class="col-sm-4"> 
                            <div id="check1"><input type="checkbox" class="checks" name="c_off" value="1" id="checkbox1" onclick="cutoff(this.value)"> 1 Cutoff</div>
                            <div id="pay_day"> <input type="checkbox"  class="checks" name="c_off" value="per_payday" id="per_payday" onclick="checkbox_checker(this.value);">Payday</div><br>
                      </div>
             <?php } ?>


            <br></br>    
            <br></br>    
            <br></br>    
            <br></br>    
            
         <button type="submit" class="btn btn-success pull-right" style="margin-right: 50px;" onclick="saving_set_automatic_edit_ne()"><i class="fa fa-floppy-o"></i>SAVE</button>   
</div>
</div>
</div>
</div>

