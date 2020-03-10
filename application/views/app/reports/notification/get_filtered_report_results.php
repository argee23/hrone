
    <table class="col-md-12 table table-hover" id="results_reports" style="overflow: scroll;">
      <thead>
           <tr class="danger">
              <th>No.</th>
              <?php foreach($fields as $f)
                {
                  echo "<th>".$f->udf_label."</th>";
                }?>
            </tr>
       </thead>
        <tbody>
          <?php foreach($results as $r){?>
          <tr>
            <td><?php echo $r->doc_no;?></td>
             <?php foreach($fields as $f)
                {
                  $title = $f->TextFieldName;
                  echo "<td>".$r->$title."</td>";
              }?>
          </tr>
        <?php } ?>
       </tbody>
    </table>
    
   
