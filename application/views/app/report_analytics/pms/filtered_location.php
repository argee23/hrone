        <?php if($display_location){ ?>
     <canvas id="myChart" width="400" height="100"></canvas>
            <!-- <canvas id="bar-chart-grouped"></canvas> -->
            
            <table  class="table table-hover table-responsive table-bordered">
              <thead>
                <tr class="info">
                  <td><strong>location </strong></td>
                  <td ><strong>score </strong></td>
                </tr>
                <tr><td><?php echo $location; ?></td><td>
                  
  <?php foreach($display_count as $qwe){
                            if($qwe->grading_type == 1){ $i = $qwe->ranking; $n = $qwe->location_id; }else{ $i = $qwe->ranking; $n = $qwe->location_id;}
                        
                             
                            
                             $count = $this->report_analytics_model_pms->count4_location($i,$n);
                               $total = 0;  
                              foreach($count as $count){
                                  if($i== $count->score){
                                      $total += 1;
                                }
                             
                              }
                                    
                                   echo $qwe->score_equivalent.' :<strong>'.$total.'</strong><br>';
                             }
                         
                           ?>

                </td></tr>
              </thead>
              <tbody>

              </tbody>
            </table>


            </div>
              <div id="section-to-print">

            <button class="btn btn-danger" onclick="window.print();"><span class="glyphicon glyphicon-print"></span>Print this page</button>
            </div>
          <?php }else{ echo '<center>no reports found from this appraisal form</center>';} ?>


          <script type="text/javascript">
            var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?php foreach($display_location as $display_location){ if($grading_type->grading_type == 1){
         echo "'".$display_location->ranking.' '.$display_location->score_equivalent."', "; }else{ echo "'".$display_location->ranking."', ";}} ?>],
        datasets: [{
            label: '# of Votes',
            data: [   <?php 

                           foreach($display_count as $qwe){
                            if($qwe->grading_type == 1){ $i = $qwe->ranking; $n = $qwe->location_id; }else{ $i = $qwe->ranking; $n = $qwe->location_id;}
                             $ci = & get_instance();
                              $ci->load->model("app/report_analytics_model_pms");
                              $count = $ci->report_analytics_model_pms->count_location($i,$n);
                            if(!empty($count)){
                                $counts  = $count;
                            }else{
                                $counts = 0;
                            }
                             echo $counts.",";
                            }
                          
                            
                             ?>
                   ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
             
                min: 0,
                  stepSize:1
                }
            }]
        }
    }
});
          </script>  


