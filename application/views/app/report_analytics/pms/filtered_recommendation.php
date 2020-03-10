      

        <?php if($display_recommendation){ ?>
     <canvas id="myChart" width="400" height="100"></canvas>
            <!-- <canvas id="bar-chart-grouped"></canvas> -->
            
            <table  class="table table-hover table-responsive table-bordered">
              <thead>
                <tr class="info">
                  <td><strong>Company </strong></td>
                  <td ><strong>Employee </strong></td>
                </tr>
                <tr><td><?php echo $location; ?></td><td>
                  
 
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
        labels: ['lateral transfer','Extend Probationary Period','Contract Renewal','Retain in Existing Position','Demotion','Promotion','Salary Increase','regularization'],
        datasets: [{
            label: '# of Votes',
            data: [<?php $s='lateral_transfer'; $q = array('for_lateral_transfer','extend_probationary_period','contract_renewal','retain_in_existing_position','demotion','promotion','salary_increase','regularization'); foreach($q as $q) { 
            		   $ci = & get_instance();
                              $ci->load->model("app/report_analytics_model_pms");
                              $count = $ci->report_analytics_model_pms->count_recommendation($q);
                            if($count > 0 ){
                                $counts  = $count;
                            }else{
                                $counts = 0;
                            }
                             echo $counts.",";
            } ?>
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
            }],
              xAxes: [{
                ticks: {
                    autoSkip: false,
                    maxRotation: 50,
                    minRotation: 50
                }
            }]
        }
    }
});
          </script>  


