<style type="text/css">

  .infolist
  {
    text-align: center;
    font-family: 'Merriweather', serif;
    font-size:2em; 
    color: #fff;
    line-height:200%;
    border-radius:5px; 
  }
  .labelname
  {
    font-family: 'Merriweather', serif;
    font-size:1.1em; 
  }

  .listnow .btn-primary
  {
    background-color:#ff5b5b;
    font-family: 'Merriweather', serif;
    font-size:1.5em; 
  }
  .listnow .btn-primary
  {
    border-color:#ff5b5b; 
  }

  .listnow .btn-primary:active, .listnow .btn-primary:focus
  {
    outline: none;
  } 

  .tabsbar
  {
    
    margin-top:20px;
    border-radius-top:3px;
    
  }

  .tabsbar li a
  {
    
    font-family: 'Merriweather', serif;
    font-size:1.1em;
    color:#313b4b;


    
  }

  .tabsbar li #pets:hover
  {
    background-color:#1aa3a3;
    color:white;
  }

  .tabsbar li #vets:hover
  {
    background-color:#005b96;
    color:white;
  }


  .tabsbar li #shops:hover
  {
    background-color:#00C060;
    color:white;
  }

  .tabsbar li #trainer:hover
  {
    background-color:#930072;
    color:white;
  }


  #pets1
  {
    background-color:#1aa3a3;
    border:1px solid #1aa3a3;
  }
  #vets2
  {
    border:1px solid #005b96;;
    background-color:#005b96;
    
  }
  #shops3
  {
    border:1px solid #00C060;;
    background-color:#00C060;
    
  }

  #trainer4
  {
    border:1px solid #930072;
    background-color:#930072;
    
  }


  .nav-tabs {
    border-bottom: 1px solid #313b4b;
  }


  .nav-tabs>li.active>#pets, .nav-tabs>li.active>#pets:hover, .nav-tabs>li.active>#pets:focus 
  {
    background-color:#1aa3a3;
    color:white;
  }

  .nav-tabs>li.active>#vets, .nav-tabs>li.active>#vets:hover, .nav-tabs>li.active>#vets:focus 
  {
    background-color:#005b96;
    color:white;
  } 


  

  @media(max-width: 420px){
    .infolist{font-size: 1.5em;}
  }
  .table td {
   text-align: center;   
 }

 .inputBox{
  position: relative;
  box-sizing: border-box;
  margin-bottom: 50px;
}
.inputBox .inputText{
  position: absolute;
  font-size: 24px;
  line-height: 30px;
  transition: .5s;

}
.inputBox .input{
  position: relative;
  width: 100%;
  height: 30px;
  background: transparent;
  border: none;
  outline: none;
  font-size: 16px;
  border-bottom: 1px solid rgba(0,0,0,.5);

}
.focus .inputText{
  transform: translateY(-30px);
  font-size: 17px;
  opacity: 1;
  color: #00bcd4;

}

.button{

  height: 30px;
  border: none;
  outline: none;
  background: #03A9F4;
  color: #fff;
}

.mic-info { color: #666666;font-size: 11px; }

.select2-selection__choice{
  color:black !important;
}

</style>

<ol class="breadcrumb">
  <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Form Management

    
  </h4></ol>

qweqwe


  <div class="modal" id="myModal"  tabindex="-1" role="dialog"  aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-small">
      <div class="modal-content">
        <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Form settings</h4>
         <hr class="prettyline">
       </div>     <?php  $form_location   = base_url()."app/pms/save_general_form_employee/";?>      
 
       <form role="form" method="POST" id="form4"  action="<?php echo $form_location;?>">


         <div class="modal-body">
           
           <div class="form-group">
            
            
             
            <label for="message-text">form title:</label>
            <input type="text" class="form-control" name="form_title" cid="form_title" placeholder="ex Key Result Areas 
" required>
            
          </div>
          
          <div class="form-group">
            <label for="recipient-name">Grading Type:</label>
            
            <div class="input-group">
              <span class="input-group-addon"><input type="hidden" name="company_" value="<?php  echo $this->uri->segment('4');  ?>">
                <input  type="radio" value="1" aria-label="..." name="radio">
              </span>
              <input type="text" class="form-control" aria-label="..." disabled="" value="numbers">
            </div><!-- /input-group -->
            <div class="input-group">
              <span class="input-group-addon">
                <input name="radio" type="radio" aria-label="..." value="2">
              </span>
              <input type="text" class="form-control" aria-label="..." disabled="" value="Percentage">
            </div><!-- /input-group -->
          </div>
          
          
          
          
          <div class="form-group">
           <label for="message-text">form description:</label>
           <textarea name="form_description" id="form_description" required class="form-control"></textarea>
           
         </div>
      
          
          <label for="message-text">weight:</label>                                      
          <div class="input-group">

            <input required="" name="weight" type="number" class="form-control" id="recipient-name">
            <span class="input-group-addon">%</span>
          </div>

              <div class="form-group">
          <label for="message-text">instruction:</label>
          <textarea name="instruction" id="instruction" class="form-control" required></textarea>
          
          
        </div>
          
        </div>

    
      <div class="modal-footer">
        <hr class="prettyline">

        <input type="submit" class=" btn btn-primary" value="submit" onclick="save_general_form()" >
        <button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancel</button>
</div>
      </div>
      


     

 
        </form>   
      </div>
    
  </div>  <!-- Modal content-->
</div>   <!-- Modal dialog-->
</div>  <!-- Modal mymodal-->







   <div class="panel panel-success">
                
                    <div class="panel-heading">
    <h3 class="panel-title" >
      <div class="row">
    
          <button class="btn btn-success btn-xs pull-right" id="addButton" data-toggle="modal" data-target="#myModal" value=""><span class="glyphicon glyphicon-plus"></span> Add New form </button>

  
      </div>
    </h3>
  </div>


  <br>
  <div class="panel-body" >

   <?php foreach($appraisal_form as $appraisal_form){ ?>
     <div class="row ">
      <div class="col-sm-4 col-md-4" >


       <h4 class="product-name"  style="padding-left:10px;"><strong><a class="" role="button" data-toggle="collapse" data-parent="#accordion"  href="#<?php echo $appraisal_form->fid; ?>"><div class="tooltop1"><?php echo $appraisal_form->form_title ?><span class="tooltiptext">Click to see the overview of the form</span></a></strong></h4>
     </div>
     
     
     <div class="col-sm-8 col-md-8" >
      <div class="col-sm-2 col-md-5"></div>
      <div  class="col-sm-10 col-md-7">
       <?php $res= $this->pms_model->qwe($appraisal_form->fid); ?>
       

      <?php  $company =  $this->uri->segment('4');  ?>  
 
      <a href="#" type="button" class="btn btn-primary btn-xs" onclick="manage_criteria(<?php echo $appraisal_form->fid; ?> , <?php echo $company?> );"  data-target='#my<?php echo $appraisal_form->fid;?>' ><i class="fa fa-user-plus"></i> View Criteria/Grading</a> 
      <a onclick="view_update_general_form(<?php echo $appraisal_form->fid ?>);" class="btn btn-primary btn-xs"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>Edit / View</a>
      <a class=" delete_form btn-xs btn btn-danger" data-id="<?php echo $appraisal_form->fid;?>"><i class="fa fa-trash fa-lg" aria-hidden="true"></i> Delete Form</a>
      


           
            
                 


    </div>

  </div> 


</div>                          
<div class="row" style="margin:5px;">
          <div id="<?php echo $appraisal_form->fid ?>" class="panel-collapse collapse well" style="height: 0px;">
                <div class="panel-body">
                     <h5><span class="label label-primary">Criteria</span></h5>
        
                    <table class="table table-bordered" style="background-color:white;"><thead><th><?php echo $appraisal_form->form_title; ?></th><th><?php echo $appraisal_form->form_description?></th><th>level</th><th>measurement</th><th>target</th></thead>       <tbody> <?php $res1= $this->pms_model->get_criteria($appraisal_form->fid);
              foreach($res1 as $res1){?> <tr>
              
                      <td nowrap><?php echo $res1->area ?></td>
                      <td><?php $res2= $this->pms_model->manage_area_weight_form($res1->criteria_id);
              foreach($res2 as $res2){?> 
                <table class="table table-bordered"  style="table-layout:fixed;"><tbody>
                  <tr>
                    <td style="width: 140px" ><?php echo $res2->description; ?></td><td style="width: 30px;" > <?php echo $res2->weight; ?>%</td>
                  </tr>
                </tbody>
                </table><?php } ?></td><td><?php echo $res1->level ?></td><td><?php echo $res1->measurement ?></td><td><?php echo $res1->target ?></td></tr></tbody><?php } ?></table>
                </div>
                 <div class="panel-body">
                     <h5><span class="label label-primary">Grading scale</span></h5>
  
                    <table class="table table-bordered" style="background-color:white;">
                      <thead><th>Score</th><th>Score equivalent</th><th>Scoring Guide</th></thead>
                      <tbody>
                      <?php $res4= $this->pms_model->get_grading_table($res2->fid);
              foreach($res4 as $res4){?> <tr><td>
                      <?php  echo $res4->score;?></td><td><?php echo $res4->score_equivalent; ?></td><td><?php echo $res4->scoring_guide ?></td></tr><?php } ?></tbody></table>
                </div>
            </div>


</div>




  <hr class="prettyline">



  <div class="modal"  id="my<?php echo $appraisal_form->fid;?>" role="dialog">
    <div class="modal-dialog modal-lg">
     <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Critera Form</h4>
        <hr class="prettyline">
      </div>

             <?php $s =  $this->uri->segment('4'); $form_location   = base_url()."app/pms/save_criteria_form/";?>     
<form role="form"  id="criteria_form" method="post" action="<?php echo $form_location;?>">

       <input type="hidden" name="idcriteria" value="<?php echo $appraisal_form->fid;?>">
       <div class="modal-body" id="largemodal" >
         <div class="row">
          <div class="col-sm-12">
            <ul class="nav nav-tabs tabsbar" role="tablist">
              <li class="active"><a href="#pet" role="tab" id="pets" data-toggle="tab">Required Fields</a></li>
              <li><a href="#vet" role="tab" data-toggle="tab" id="vets">Optional</a></li>
              
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
           
                <div class="tab-pane active" id="pet">

                  <div class="row" >
                    
                    <div class="form-group">
                      <input type="hidden" name="idcriteria" value="<?php echo $appraisal_form->fid;?>">
                      
                      <input type="hidden" name="company_" value="<?php  echo $this->uri->segment('4');  ?>">
                      <div class="col-md-6">
                        <label for="message-text">Area</label>
                        <input type="text" class="form-control" name="area_name" cid="form_title" required>
                      </div>
                      <div class="col-md-6">
                        <label for="message-text">Covered</label>
                    
                        <select class="s" name="cover[]" multiple="multiple">
                          <?php $res = $this->pms_model->position(); foreach($res as $res){?>
                            <option value="AL"><?php  echo $res->position_name?></option>
                            
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  
                  
                  <div class="row">
                    <div class="form-group">
                      <div class="col-md-6">
                        <label for="message-text">Description</label>
                        <textarea name="description[]" id="form_description" required class="form-control"></textarea>
                      </div>
                      <div class="col-md-3">
                        <label for="message-text">weight:</label>                                      
                        <div class="input-group">

                          <input required="" name="des_weight[]" type="number" class="form-control" id="recipient-name">
                          <span class="input-group- on">%</span></div>
                        </div>
                        <div class="col-md-3" style="margin-top:40px;">
                          <a href="#" class="addrow">Add new field</a>
                        </div>
                      </div>
                    </div>
                    <div id="app" ></div>
                    
                  </div>
                  <!--next vet div-->
                  <div class="tab-pane" id="vet">
                    <div class="row" >
                      <div class="form-group">
                        
                       
                        <div class="col-md-6">
                          <label for="message-text">Measurement</label>
                          <input type="text" class="form-control" name="measurement"  >
                        </div>
                        <div class="col-md-6">
                          <label for="message-text">Level:</label>                                      


                          <input name="level" type="number" class="form-control" id="recipient-name">
                        </div>
                      </div>
                    </div>
                    
                    
                    <div class="row">
                      <div class="form-group">
                        <div class="col-md-6">
                          <label for="message-text">Target</label>
                          <textarea name="target" id="form_description"  class="form-control"></textarea>
                        </div>
                        
                      </div>
                    </div>
                    

                  </div>
                  <!-- next Shop div-->

                  <!-- next div pet trainer-->
                  
                </div>
              </div>
            </div>       <div class="modal-footer">
              <input type="hidden" name="isEmpty" value="">
            
            <input type="submit" class=" btn btn-primary" value="submit" onclick="save_criteria_form('#my<?php echo $appraisal_form->fid ?>');" >


              <button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancel</button>
            </div>
            </form>
          </div>
          

          
    
      </div><!-- Modal content-->
    </div><!-- Modal dialog-->
  </div><!-- Modal mymodal-->

<?php }?>




</div> <!-- panel   -->

<div class="panel-footer">
  <div class="row text-center">
    <div class="col-xs-9">
      <h4 class="text-right">total weight of forms created:<strong><?php $weight = $tweight; echo $weight; ?>%</strong>  | 
      <?php if($weight < '100'){?>Warning weight percentage is short of<strong> <?php echo 100-$weight; ?>%</strong><?php }?><?php if($weight > '100'){?>Warning weight percentage is over of<strong> <?php echo $tweight-100; ?>%</strong><?php }?></h4>
    </div>
    
  </div>
</div>







