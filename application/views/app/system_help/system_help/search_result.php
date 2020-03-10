<ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>System Help Search Results
<button class="btn btn-success btn-xs pull-right" style="margin-right: 5px;"  onclick="collapse('filtering_result');">FILTER</button>
</h4></ol>
<div class="col-md-12"><br>
     <div class="col-md-3"></div>
     <div class="col-md-6" id="filtering_result" style="display: none;">
          <div class="col-md-6">
            <select class="form-control" name="portalsearch" id="portalsearch" required onchange="get_module_list(this.value,'modulesearch');">
               <?php if(empty($portal_list))
                {
                  echo "<option value=''>No portal found.</option>";
                }
                else
                {?>
                  <option value="">Select Portal</option>
                  <?php if(empty($this->session->userdata('user_role'))){} else{?><option value="All">All</option><?php }?>
                  <?php foreach($portal_list as $p){?>
                      <option value="<?php echo $p->portal_id;?>"><?php echo $p->portal;?></option>
                  <?php }  }  ?>
            </select>
          </div>
          <div class="col-md-6">
            <select class="form-control" name="modulesearch" id="modulesearch" required onchange="get_topic_list(this.value,'topics','search');">
                <option value="">Select Module</option>
            </select>
          </div>
          <div class="col-md-6" style="margin-top: 10px;">
            <select class="form-control" name="topics" id="topics" required onchange="get_subtopic_list(this.value,'subtopics','search');">
                <option value="">Select Topic</option>
            </select>
          </div>
          <div class="col-md-6" style="margin-top: 10px;">
            <select class="form-control" name="subtopics" id="subtopics" required>
                <option value="">Select Sub Topic</option> 
             </select>
          </div>
          <div class="col-md-12" style="margin-top: 10px;margin-bottom: 30px;">
               <input type="hidden" id="search_" value="<?php echo $search;?>">
               <input type="hidden" id="search_final">
               <button class="col-md-12 btn btn-default btn-sm" style="border:1px solid #DEB887;" onclick="search_filter_results('portalsearch','modulesearch','topics','subtopics','filter_results_search');"><i class="fa fa-arrow-right"></i><b>FILTER NOW</b></button>
          </div>
     </div>
     <div class="col-md-3"></div>
  
<div class="col-md-12" id="filter_results_search">

  <?php  if(empty($results)){ echo "<h3 class='text-danger'><center><i class='fa fa-exclamation'></i>No Results found.</center></h3>"; } else{?>

         <table id="results" class="table table-hover">
            <thead>
                <tr class="danger">
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
                         <i><b><?php if(empty($keywords)){ echo "No keyword found."; } else{?>  Keywords : <?php foreach($keywords as $k){ echo $k->keyword.","; } ?> <?php }  ?></b></i>
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

</style>

</div>  
<div class="btn-group-vertical btn-block"> </div>   

    