

<div class="col-md-5" id="printProfile" >

<div class="row table-responsive">
<div class="col-md-12">

<div class="box box-success ">
<div class="panel panel-success" >
  <div class="panel-heading table-responsive " >
        <strong>
        <?php 
        //$key_location="1";
           $company_id =$this->uri->segment('4');
           $current_comp=$this->payroll_loan_category_model->get_company($company_id);
           if(!empty($current_comp)){
              echo $company_name = $current_comp->company_name;
           }else{
              echo $company_name="classification not exist";
           }
        
         ?>
      </strong><strong>(LOAN CATEGORY)</strong>

      

       <a onclick="add_new_category(<?php echo $company_id;?>)" type="button" class="btn btn-xs btn-default pull-right " data-toggle="tooltip" data-placement="left" title="Add Category"><i class="fa fa-plus text-danger"></i>Add New Category</a>
      
    
       </div>

  <div class="box-body table-responsive" >
  <div class="panel panel-success">
         <div class="box-body " >
         <div class="row">




      
          <div class="col-md-12" >
      <div class="form-group">
      
   <table class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>
               <th style="text-align:center;">ID</th>
                <th style="text-align:center;">Category</th>
                <th colspan="2" style="text-align:center;">Action</th>
            </tr>
        </thead>
        <tbody>
           <?php 
                $check = false;
                foreach($category as $categories){ ?>
                <tr>
                 <td align="center" ><?php echo $categories->id;  ?></td>
                  <td align="center" ><?php echo $categories->category;  ?></td>
                   <td align="center"> 

                    <!--Edit-->
                    <i class='fa fa-pencil-square-o fa-lg text-warning pull-center' data-toggle='tooltip' data-placement='left' title='Edit' onclick="category_table_edit('<?php echo $categories->id;?>')"></i></div>
       
                </td>
                <td align="center">     
             <?php 
             
                   //delete
          echo $delete = anchor('app/payroll_loan_category/delete_category/'.$categories->id,'<i class="fa fa-times-circle fa-lg text-danger delete pull-center"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Permanently Delete?','onclick'=>"return confirm('Are you sure you want to permanently delete ".$categories->category."?')"));

                ?>  </td>
             
              
                </tr>
                <?php $check = true;
                } ?>
              </tbody>
            </table>

            <?php if($check === false){ ?>
                <tr>
                  <p class='text-center' style='color:#ff0000;'><strong>No Loan Category Data yet.</strong></p>
                </tr>
            <?php } ?>



      </div>
      </div>

  
     </div> 
         </div><!-- /.box-body --> 

   </div>

   </div>
</div>

</div>
</div>

</div>
</div>
<div class="col-md-4"  id="col_3">
    
  </div>
