<?php $salary_rate = $this->uri->segment("4");?>
<label>COMPUTATION</label>
  <div class="box box-info"></div>
    <br>
    <div class="well">
    <table class="table table-striped">
    <thead>
    	<tr>
      	<th></th>
      	<!--<th>AMOUNT(PHP)</th>-->
        <th style="width:1%"></th>
      	<th>FORMULA</th>
    	</tr>
    </thead>
    <tbody>

      <tr>
        <td>Pay Check Amount</td>
        <!-- <td><label><?php //echo $computation->pay_check_amount; ?></label></td> -->
        <td><font color="blue"> = </font></td>
        <?php if($salary_rate === '3'){?>
        <td><label>
        <font color="red"> ( </font> Salary amount 
        <font color="orange"> * </font> No. of Days Monthly
        <font color="red"> ) </font>
        <font color="green"> / </font> 2
        </label></td>
        <?php } ?>
        <?php if($salary_rate === '4'){?>
        <td><label>
        Salary amount 
        <font color="green"> / </font> 2
        </label></td>
        <?php } ?>
      </tr>
      <tr>
        <td>Hourly Amount</td>
        <!-- <td><label><?php //echo $computation->hourly_amount; ?></label></td> -->
        <td><font color="blue"> = </font></td>
        <?php if($salary_rate === '3'){?>
        <td><label>
        Salary amount 
        <font color="green"> / </font> No. of hours
        </label></td>
        <?php } ?>
        <?php if($salary_rate === '4'){?>
        <td><label>
        <font color="brown"> ( </font> 
        <font color="red"> ( </font> Salary amount 
        <font color="green"> / </font> No. of Days Yearly
        <font color="red"> ) </font> <br>
        <font color="orange"> * </font> No. of Months yearly
        <font color="brown"> ) </font>
        <font color="green"> / </font> No. of Hours
        </label></td>
        <?php } ?>
      </tr>
      <tr>
        <td>Daily Amount</td>
        <!-- <td><label><?php //echo $computation->daily_amount; ?></label></td> -->
        <td><font color="blue"> = </font></td>
        <?php if($salary_rate === '3'){?>
        <td><label>
        Salary amount 
        </label></td>
        <?php } ?>
        <?php if($salary_rate === '4'){?>
        <td><label>
        <font color="red"> ( </font> Salary amount 
        <font color="green"> / </font> No. of Days Yearly
        <font color="red"> ) </font> <br>
        <font color="orange"> * </font> No. of Months yearly
        </label></td>
        <?php } ?>
      </tr>
      <tr>
        <td>Monthly amount</td>
        <!-- <td><label><?php //echo $computation->monthly_amount; ?></label></td> -->
        <td><font color="blue"> = </font></td>
        <?php if($salary_rate === '3'){?>
        <td><label>
        Salary amount 
        <font color="orange"> * </font> No. of Days Monthly
        </label></td>
        <?php } ?>
        <?php if($salary_rate === '4'){?>
        <td><label>
        Salary amount 
        </label></td>
        <?php } ?>
      </tr>
    </tbody>
    </table>
    </div>