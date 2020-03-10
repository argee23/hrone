 <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Incoming Trainings and Seminar</h4></ol>
                  
  <div class="col-md-12">

    <div class="col-md-2" id="mila"></div>

    <div class="col-md-8">
      <select class="form-control" onchange="filter_incoming_by_company(this.value);">
        <option value="all">All Company</option>
        <?php
          foreach ($companyList as $c) {
            echo "<option value='".$c->company_id."'>".$c->company_name."</option>";
          }
        ?>
      </select>
    </div>

    <div class="col-md-2"></div>

    <br><br><br>     
    <div class="box box-danger" class='col-md-12'></div>

    <div class="col-md-12" style="padding-top: 10px;" id="filterresultincoming">

        <table class="table table-hover" id="incomingtrainings">
            <thead>
                <tr class="danger">
                  <th>ID</th>
                  <th>Training Title</th>
                  <th>Date Added</th>
                  <th>Training Date</th>
                  <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($details as $d){?>
              <tr>
                  <td><?php echo $d->training_seminar_id;?></td>
                  <td><?php echo $d->training_title;?></td>
                  <td>
                        <?php 
                          $month=substr($d->date_added, 5,2);
                          $day=substr($d->date_added, 8,2);
                          $year=substr($d->date_added, 0,4);

                          echo date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                        ?>
                  </td>
                  <td>
                     <?php 
                          $month=substr($d->datefrom, 5,2);
                          $day=substr($d->datefrom, 8,2);
                          $year=substr($d->datefrom, 0,4);

                          $month1=substr($d->dateto, 5,2);
                          $day1=substr($d->dateto, 8,2);
                          $year1=substr($d->dateto, 0,4);


                          $from = date("F", mktime(0, 0, 0, $month, 10))." ". $day.", ". $year;
                          $to = date("F", mktime(0, 0, 0, $month1, 10))." ". $day1.", ". $year1;

                          if($from==$to){ echo $from; } else{ echo $from." to ".$to; }
                        ?>

                  </td>
                  <td>
                       <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_edit_color;?>' onclick="edit_incoming_trainingsseminars(<?php echo $d->training_seminar_id;?>);"  aria-hidden='true' data-toggle='tooltip' title='Update Settings'><i class="fa fa-<?php  echo $system_defined_icons->icon_edit;?> fa-lg  pull-left"></i></a>

                       <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_view_color;?>' onclick="view_incoming_trainingsseminars(<?php echo $d->training_seminar_id;?>);" aria-hidden='true' data-toggle='tooltip' title='View Settings'><i class="fa fa-<?php  echo $system_defined_icons->icon_view;?> fa-lg  pull-left"></i></a>

                       <a style='cursor:pointer;color:<?php echo $system_defined_icons->icon_delete_color;?>' onclick="delete_incoming_trainings(<?php echo $d->training_seminar_id;?>);" aria-hidden='true' data-toggle='tooltip' title='Delete Incoming Trainings and Semianr'><i class="fa fa-<?php  echo $system_defined_icons->icon_delete;?> fa-lg  pull-left"></i></a>


                  </td>
              </tr>
            <?php } ?>
            </tbody>
        </table>


    </div>

  </div>                 