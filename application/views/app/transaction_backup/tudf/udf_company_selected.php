<table class="table">
  <tbody>
    <tr>
    <div class="btn-group-vertical btn-block">
    <br>
    <?php 
        $company_id = $this->uri->segment('4');
         $company_id;
    ?>

    <a onclick="addNewUDFCol_new(<?php echo $company_id; ?>)" type="button" class="pull-right" data-toggle="tooltip" data-placement="right" title="Add"><i class="fa fa-plus-square fa-2x text-primary delete pull-right"></i></a>
    <?php $check=0; ?>
    <?php foreach($udfLists as $udfList) :?>
      <tr>
        <td>
          <?php echo "<a onclick='viewUDFCol($udfList->id)' data-toggle='tooltip' data-placement='right' title='view fields' class='btn btn-flat btn-link'><p class='text-left'><strong>".$udfList->form_name."</strong></p></a>"; ?>
        </td>
        <td>


          <a  class="fa fa-times-circle fa-lg text-danger delete pull-right" data-toggle="tooltip" data-placement="right" title="Delete" href="<?php echo site_url('app/transaction_user_define_fields/del_udf_col_new/'. $udfList->id.''); ?>" onClick="return confirm('Are you sure you want to delete?')"></a>




  <!-- <a href="<?php echo base_url('app/transaction_user_define_fields/excel') ?>" class="btn btn-success btn-lg">Download template</a> -->



          <?php echo "<i class='fa fa-pencil-square-o fa-lg text-warning pull-right' data-toggle='tooltip' data-placement='left' title='Edit' onclick='editUDFCol1($udfList->id)'></i>"; ?>

<!--
 <?php echo "<i class='fa fa-plus-square fa-lg text-primary delete pull-right' data-toggle='tooltip' data-placement='left' title='Add' onclick='addNewUDFCol1($udfList->id)'></i>"; ?> -->







          <?php 
              if($udfList->form_type == 'Selectbox'){
                 echo "<i class='fa fa-list fa-lg text-primary pull-right' data-toggle='tooltip' data-placement='left' title=' View option' onclick='viewUDFOPT($udfList->id)'></i>";  
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