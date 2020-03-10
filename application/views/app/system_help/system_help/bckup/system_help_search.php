<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>
<?php foreach($details as $d){ echo $d->portal." | ".$d->module; }?></h4></ol>
  <div class="col-md-12"><br>

 

  <div class="col-md-12" id="system_help_file_maintenance_view">

        <div class="col-md-3"></div> 
        <div class="col-md-6">
            
             <div class="col-md-12">
               <select class="form-control" name="topic" required onchange="get_sub_topic_list(this.value,'subtopic_add');">
                  <option value="">Select Topic</option>
                  <?php foreach($topic as $t){?>
                    <option value="<?php echo $t->topic_id;?>"><?php echo $t->topic;?></option>
                  <?php } ?>
               </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                <select class="form-control" name="subtopic_add" id="subtopic_add" required>
                    <option value="">Select Sub Topic</option> 
                </select>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                 <input type="text" class="form-control" placeholder="Input Question" name="question" required>
              </div>

              <div class="col-md-12" style="margin-top: 10px;">
                  <button class="col-md-12 btn btn-success btn-md"><i class="fa fa-search"></i>SEARCH</button>
              </div>
             

        </div>
        <div class="col-md-3"></div>

  </div>  
  <br><br><br>   <br><br><br> <br><br><br><br>
  <div class="box box-danger" class='col-md-12'></div> 

  <div class="col-md-12">
     <div class="panel panel-danger">
      <div class="panel-heading">
        <h4>Question : </h4> 
      </div>
      <div class="panel-body">
          <h4>Answer :</h4>
      </div>

      <div class="heading panel-danger">
        <n>Administrator->File Maintenance->Department</n>
      </div>
    </div>
  </div>

   <div class="col-md-12">
     <div class="panel panel-danger">
      <div class="panel-heading">
        <h4>Question : </h4> 
      </div>
      <div class="panel-body">
          <h4>Answer :</h4>
      </div>
      <div class="panel-heading panel-default">
        <n>Administrator->File Maintenance->Department</n>
      </div>
    </div>
  </div>



</div>  
<div class="btn-group-vertical btn-block"> </div>  


  

              
   
    