<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>System Help Search Results

    <div class="pull-right" style="width:55%;margin-right: -130px;" >   
        <input type="text"  placeholder="Enter Search Criteria (results will be based on keyword setup) &nbsp;" name="search2" id="search2" style="font-size:11px;width: 60%;height:30px;text-align: right;">
          <input type="hidden"  id="search2_final">
        <button type="submit" style="height: 30px;background-color: #6495ED;font-size:11px;width: 40px;" onclick="keyword_search('<?php echo $filter[0];?>','<?php echo $filter[1];?>','<?php echo $filter[2];?>','<?php echo $filter[3];?>',);"><i class="fa fa-search"></i></button>
    </div>

</h4></ol>
<div class="col-md-12"><br>
<div class="col-md-12" id="keyword_searchh">

  <?php  if(empty($results)){ echo "<h3 class='text-danger'><center><i class='fa fa-exclamation'></i>No Results found.</center></h3>"; } else{?>

 
   
  <div class="col-md-12" style="margin-top: 20px;">
         <table id="results" class="table table-hover">
            <thead>
                <tr class="success">
                    <th style="width:2px;"></th>
                    <th style="width: 48px;">Question</th>
                    <th style="width: 50px;">Answer</th>
                </tr>
            </thead>
            <tbody>
              <?php $i=1; foreach($results as $r){
                $keywords =  $this->system_help_model->get_keywords($r->id);
              ?>
                <tr>
                    <td><?php echo $i.").";?></td>
                    <td>
                        <?php echo $r->question;?>
                        <n class='text-danger' style='font-size:12px;'><br>
                         <i><b>Others :</b> <?php echo $r->module;?>-><?php echo $r->topic;?>-><?php echo $r->subtopic;?></i>
                        </n>  
                        <n class='text-warning' style='font-size:12px;'><br>
                          <i><b><?php if(empty($keywords)){ echo "No keyword found."; } else{?> Keywords : <?php foreach($keywords as $k){ echo $k->keyword.","; } ?><?php } ?>
                          </b> </i>
                         <br>
                        </n> 

                    </td>
                    <td>
                      <?php echo $r->answer;?>
                      <n class='text-danger' style='font-size:12px;'><br>
                         <i><?php if(!empty($r->attachment)){ ?>
                            <a style='cursor:pointer;'  href="<?php echo base_url(); ?>app/system_help/download_system_help/<?php echo $r->attachment; ?>" aria-hidden='true' data-toggle='tooltip' title='Click to Dowload Attachment for question -  <?php echo $r->question;?>'>Download Attach File</a>
                         <?php }?></i>
                      </n>   
                    </td>
                    
                </tr>
              <?php $i++; } ?>
            </tbody> 
        </table> 
  </div>

  <?php } ?>
   
</div>


<style type="text/css">
  body{
  background-color: #f0f0f0;
  float: center;
  }
  hr.style4 {
    border-top: 1px dotted #8c8b8b;
  }

  /*input[type=text] {
  width: 100px;
  transition: ease-in-out, width .35s ease-in-out;
  }

  input[type=text]:focus {
    width: 250px;
  }*/

 
</style>

</div>  
<div class="btn-group-vertical btn-block"> </div>   

    