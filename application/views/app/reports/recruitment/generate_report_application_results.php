<div class="col-md-12" style="overflow:scroll;">


  <table class="table table-hover" id="generate_report_results">
    <thead>
      <tr class="danger">
      <?php foreach($crystal_report as $cc){?>
        <th><?php echo $cc->label;?></th>
      <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($details as $d) {
      ?>
      <tr>
         <?php foreach($crystal_report as $cc){
          $cc_field = $cc->field;
         
          $data = $d->$cc_field;
          
         ?>
          <td><?php echo $data;?></td>
         <?php } ?>
      </tr>
      <?php } ?>
    </tbody>
  </table>




</div>
   