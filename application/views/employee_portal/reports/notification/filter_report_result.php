
    <table class="col-md-12 table table-hover" id="crystal_reports" style="overflow: scroll;">
      <thead>
           <tr class="danger">
              <?php foreach($fields as $f)
                {
                  echo "<th>".$f->udf_label."</th>";
                }?>
            </tr>
       </thead>
        <tbody>
          <?php foreach($results as $r){?>
          <tr>
             <?php foreach($fields as $f)
                {
                  $title = $f->TextFieldName;
                  echo "<td>".$r->$title."</td>";
              }?>
          </tr>
        <?php } ?>
       </tbody>
    </table>
    
   
