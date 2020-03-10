 <div class="col-md-12" style="padding-top:10px;">
 <div class="col-md-1" class="form-control"></div>
 <div class="col-md-11">
 <table class="col-md-12 table table-bordered " id='table_others'>
    <thead class='text-success'>
      <tr>
        <th>No.</th>
        <th>Field Name</th>
        <th>Input Type</th>
        <th>Input Format</th>
       </tr>
    </thead>
      <tbody>
     <?php for($x = 1; $x <= $no_fields; $x++){?>
        <tr>
          <td><?php echo $x."."?></td>
          <td> <input type="text" placeholder="Input field title" class="form-control" id="title<?php echo $x?>"></td>
          <td> <select class="form-control" id="input_type<?php echo $x?>" onchange='input_format(<?php echo $x?>,this.value);'>
            <option selected disabled>Select</option>
            <option>text</option>
            <option>dropdown</option>
            <option>datepicker</option>
        </select></td>
          <td id='format<?php echo $x;?>'></td>
        </tr>       
      <?php } ?>                   
      </tbody>
  </table>
  </div>
</div>