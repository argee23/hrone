	<br>
    <table id="example" class="table display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Evaluator</th>
     
              
                 <th>View Appraisal Form</th>
             
            </tr>
        </thead>
        <tbody>
            <?php foreach($get_all_evaluation as $get_all_evaluation){ 
                if($evaluation_type =='pending'){
                       $q = $this->report_pms_model->get_evaluation_pending();
                }elseif($evaluation_type =='evaluated'){
                       $q = $this->report_pms_model->get_evaluation_evaluated($get_all_evaluation->doc_no);

                }}
             ?>
             <?php foreach($q as $q){ ?>
            <tr>
                <td><?php echo $q->fullname ?></td>
                <td><?php $res = $this->report_pms_model->get_evaluator($q->evaluators); echo $res->fullname?></td>
        
         
                <td><a>Click To View</a></td>
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