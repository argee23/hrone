<?php 
    $nof = $this->uri->segment("4");
        if($nof!=""){
         $count=$nof;
         $noff = "0"; 
       while($noff!=$count){
         $noff++;
   echo '  
      
        <br></br>
        <label for="for-disobedience" id="fordisobedience[]" class="col-sm-3 control-label">Disobedience</label>
        <div class="col-sm-7">
                  <input type="text" class="form-control" name="disobedience[]" id="disobedience"  onchange="return trim(this)" placeholder="Disobedience" value="" required>

          
        </div>
     
     <br></br>

      <label for="for-numday" id="fornumdays[]" class="col-sm-3 control-label">No. of Days</label>
        <div class="col-sm-7">
                  
                   <select name="numdays[]"" id="numdays" class="form-control" placeholder="No. of Days"  required="required">
                                                                    
                                                                    <option value="0" selected="">0</option>
                                                                    <option value="1" selected="">1</option>
                                                                    <option value="2" selected="">2</option>
                                                                    <option value="3" selected="">3</option>
                                                                    <option value="4" selected="">4</option>
                                                                    <option value="5" selected="">5</option>
                                                                    <option value="6" selected="">6</option>
                                                                    <option value="7" selected="">7</option>
                                                                    <option value="8" selected="">8</option>
                                                                    <option value="9" selected="">9</option>
                                                                    <option value="10" selected="">10</option>
                                                                    <option value="11" selected="">11</option>
                                                                    <option value="12" selected="">12</option>
                                                                    <option value="13" selected="">13</option>
                                                                    <option value="14" selected="">14</option>
                                                                    <option value="15" selected="">15</option>
                                                                    <option value="16" selected="">16</option>
                                                                    <option value="17" selected="">17</option>
                                                                    <option value="18" selected="">18</option>
                                                                    <option value="19" selected="">19</option>
                                                                    <option value="20" selected="">20</option>
                                                                    <option value="21" selected="">21</option>
                                                                    <option value="22" selected="">22</option>
                                                                    <option value="23" selected="">23</option>
                                                                    <option value="24" selected="">24</option>
                                                                    <option value="25" selected="">25</option>
                                                                    <option value="26" selected="">26</option>
                                                                    <option value="27" selected="">27</option>
                                                                    <option value="28" selected="">28</option>
                                                                    <option value="29" selected="">29</option>
                                                                    <option value="30" selected="">30</option>
                                                                    <option value="31" selected="">31</option>
                                                                    <option value="0" selected="">Select</option>
                                                                    
                                                                 </select> 
          
        </div>
     
     <br></br>

      <label for="for-suspun" id="forsuspun[]"  class="col-sm-3 control-label">Suspension/Punishment</label>
        <div class="col-sm-7">
        
                 <select name="suspun[]" id="suspun'.$noff.'" class="form-control" onchange="parasaothers('.$noff.');" placeholder="Suspension/Punishment"  required="required">   
                                 
                        <option value="1">Suspension/supensyon</option>
                        <option value="2">Dismissal/Pagkakatanggal</option>
                        <option value="3">Others</option>
                        <option value="0" selected="selected">Select</option>        
                      </select> 
                    <label>for others:</label>
                     <textarea class="form-control" name="suspun[]" id="suspuntext'.$noff.'"  onchange="return trim(this)" placeholder="Suspension/Punishment" required="required" disabled></textarea>

        </div>
     
     <br></br>

       </div>
        <br></br>  
       
        <br></br>                             
    ';
   }
   }else{
       echo "";
    }

  
   ?> 
    
