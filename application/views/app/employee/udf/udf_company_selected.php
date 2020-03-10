<table class="table">
  <tbody>
    <tr>
    <div class="btn-group-vertical btn-block">
    <?php $check=0; ?>
    <?php foreach($user_define_field as $user_define_fields) :?>
      <tr>
        <td><?php 
               $company_id = $user_define_fields->company_id;
              
               $current_comp=$this->employee_user_define_fields_model->get_company($company_id);
                 if(!empty($current_comp)){ ?>

                <b><?php   echo $company_name = $current_comp->company_name; ?></b>
                
                <?php }else{
                    echo $company_name="company not exist";
                 }

              ?>
                
        </td>
        <td>
          <?php echo "<a onclick='viewUDFCol($user_define_fields->emp_udf_col_id)' data-toggle='tooltip' data-placement='right' title='view' class='btn btn-flat btn-link'><p class='text-left'><strong>".$user_define_fields->udf_label."</strong></p></a>"; ?>
        </td>
        <td>


<!--           <a  class="fa fa-times-circle fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php //echo site_url('app/employee_user_define_fields/del_udf_col/'. $user_define_fields->emp_udf_col_id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a> -->

          <?php 


    echo $delete = anchor('app/employee_user_define_fields/del_udf_col/'.$user_define_fields->emp_udf_col_id,'<i class="'.$udf_del.' fa fa-'.$system_defined_icons->icon_delete.' pull-right fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_delete_color.';"></i>',array('data-toggle'=>'tooltip','data-placement'=>'left','title'=>'Delete','onclick'=>"return confirm('Are you sure you want to delete?')"));


          // echo "<i class='".$udf_edit." fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick='editUDFCol($user_define_fields->emp_udf_col_id)'></i>"; 

      echo '<i class="'.$udf_edit.' fa fa-'.$system_defined_icons->icon_edit.' pull-right fa-'.$system_defined_icons->icon_size.'x" style="color:'.$system_defined_icons->icon_edit_color.';" data-toggle="tooltip" data-placement="left" title="Edit" onclick="editUDFCol('.$user_define_fields->emp_udf_col_id.')"></i>';


          ?>

          <?php 
              if($user_define_fields->udf_type == 'Selectbox'){
                 //echo "<i class='fa fa-plus-circle fa-lg text-primary pull-right' data-toggle='tooltip' data-placement='left' title=' Add option' onclick='addUDFOption($user_define_fields->emp_udf_col_id)'></i>";
                 echo "<i class='".$udf_edit." fa fa-list fa-lg text-primary pull-right' data-toggle='tooltip' data-placement='left' title=' View option' onclick='viewUDFOPT($user_define_fields->emp_udf_col_id)'></i>";  
              }
           ?>
          

        </td>

      </tr>
    <?php 
    $check++;
    endforeach; ?>
        <?php if($check==0){?>
        <tr>
          <td>
          <p class='text-left'><strong>No result(s) found.</strong></p>
          </td>
        </tr>
        <?php } ?>
    </tr>
  </tbody>
</table>