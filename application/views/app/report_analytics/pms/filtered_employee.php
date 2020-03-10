        <?php if($display_employee){ ?>
     <canvas id="myChart" width="400" height="100"></canvas>
            <!-- <canvas id="bar-chart-grouped"></canvas> -->

            <table  class="table table-hover table-responsive table-bordered">
              <thead>
                <tr class="info">
                  <td><strong>employee </strong></td>
                  <td ><strong>score </strong></td>
                </tr>
                <tr><td><?php echo $employee; ?></td><td>


                  
  <?php   $c = ''; $s = '';$qw  =  $this->report_analytics_model_pms->filter_employee($from,$to,$employee_id); foreach($qw as $qwe){
                            
                        
                             
                            
                                   
                             $ci = & get_instance();
                  	  $ci->load->model("app/report_analytics_model_pms");
                              $count = $ci->report_analytics_model_pms->count_employee($qwe->appraisal_period_type_dates,$employee_id);
                               $total = 0;  
                    
                                    
                                   echo date("d-M-Y", strtotime($count->appraisal_period_type_dates)).' :<b> '.$count->scor.'</b><br>';
                                  $c  += $count->scor;
                                  $s += 1;

                             }
                                  echo 'Total average score:'.round($c/$s);

                         
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
    type: 'bar',
    data: {
        labels: [<?php $filter =  $this->report_analytics_model_pms->filter_employee($from,$to,$employee_id); foreach($filter as $filter){
        		      echo "'".date("d-M-Y", strtotime($filter->appraisal_period_type_dates))."', "; 
        } ?>],
        datasets: [{
            label: 'yrtq',
            data: [   <?php 
            					$q  =  $this->report_analytics_model_pms->filter_employee($from,$to,$employee_id);
                           foreach($q as $q){
                         
                             $ci = & get_instance();
                  	  $ci->load->model("app/report_analytics_model_pms");
                              $count = $ci->report_analytics_model_pms->count_employee($q->appraisal_period_type_dates,$employee_id);
                            if(!empty($count)){
                                $counts  = $count->ranking;
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
        },
        legend: {
    	display: false
    },
       tooltips: {
    	callbacks: {
      	label: function(tooltipItem) {
        console.log(tooltipItem)
        	return tooltipItem.yLabel;
        }
      }
    }
    }
});
 	


          </script>  


