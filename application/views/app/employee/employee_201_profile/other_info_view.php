<?php include('header.php');?>
        <div id="col_2">
        <div class="row">
        <div class="col-md-8">
        <div class="box box-success">
        <div class="panel panel-success">
          <div class="panel-heading"><strong>OTHER INFORMATION</strong><?php if(empty($employee_udf)){} else{  if($checker_inactive==0){?> ?><a onclick="other_info_edit('<?php echo $this->uri->segment("4"); ?>')" type="button" class="pull-right" data-toggle="tooltip" data-placement="left" title="Edit" ><i class="fa fa-pencil-square-o fa-2x text-success pull-right"></i></a><?php }} ?></div>
          <div class="box-body">
          <div class="panel panel-success">
            <br>

                 <div class="box-body">
                  <?php if(empty($employee_udf)) { echo "<h2 class='text-danger'>No Other info/s added.</h2>"; } else{ foreach ($employee_udf as $udf) {?>
                   <div class="col-md-12">
                    <div class="form-group">
                      <div class="col-sm-3">
                      <p><?php echo $udf->udf_label?></p>
                      </div>
                      <div class="col-sm-5">
                         <?php 
                            $data = $this->employee_201_profile_model->get_udf_data($udf->emp_udf_col_id,$this->uri->segment("4"));
                          
                              if(count($data)==0){ $datas=''; } else{ $datas = $data->data; } 
                          ?>
                          <label><?php echo $datas?></label>
                       
                      </div>
                    </div>
                    </div>
                  <?php } }?>
                 </div><!-- /.box-body --> 
                 <br>
           </div> 
        </div>
        </div>

        </div>
        </div>  
        </div>


        </div>  
</div>

<script>
    function other_info_edit(val)
    {          
            if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                
                document.getElementById("col_2").innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/employee_201_profile/other_info_edit/"+val,true);
            xmlhttp.send();
    }
</script>
        </div>
   </div>
 <?php include('footer.php');?>


