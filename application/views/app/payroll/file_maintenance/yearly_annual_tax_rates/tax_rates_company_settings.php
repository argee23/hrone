

<div class="col-md-6"  id="printProfile">
        <div class="btn-group-vertical btn-block">
          <?php 
            foreach($companyList as $loc){
            echo "<a onclick='gotoTaxRates(".$loc->company_id.")' type='button' class='btn btn-default btn-flat'><p class='text-left'><strong>".$loc->company_code."</strong></p></a>";
            }
          ?>
        </div>    
</div>

<div class="col-md-6 row table-responsive"  id="col_3">
    
</div>

