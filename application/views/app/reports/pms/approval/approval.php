	<br>
    <table id="example" class="table display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Approver</th>
         
                
                <th>View Appraisal Form</th>
        
            </tr>
        </thead>
        <tbody>
            <?php foreach($get_all_approval as $get_all_approval){ 
                if($approval_type =='pending'){
                       $q = $this->report_pms_model->get_approval_pending();
                }elseif($approval_type =='approved'){
                       $q = $this->report_pms_model->get_approval_approved($get_all_approval->doc_no);

                }}
             ?>
             <?php foreach($q as $q){ ?>
            <tr>
            
                <td><?php echo $q->fullname ?></td>
                <td><?php $res = $this->report_pms_model->get_approver($q->approvers); echo $res->fullname?></td>
       
                
                <td> <a target="_blank" style="width:98%;margin-left:1px;text-align:left;cursor: pointer;" href="<?php echo base_url().'app/report_pms/get_Score/'.$q->employee_id.'/'.$q->doc_no;?>"><i class='fa fa-calendar' ></i> <span>Export to Excel</span></td>
          



            </tr>
        <?php } ?>
        </tbody>

    </table>

    <script type="text/javascript">
            $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );

    </script>