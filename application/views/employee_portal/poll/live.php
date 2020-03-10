

    <script src="<?php echo base_url()?>public/chartjs/Chart.min.js"></script>
        <script src="<?php echo base_url()?>public/chartjs/moment.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
         <script src="<?php echo base_url()?>public/plugins/push/bin/push.min.js"></script>

<div class="not" style="margin:0 15px">
 
    <div data-spy="scroll" data-target="#navbar-example3" data-offset="0">

  <?php


  if($this->uri->segment(5) == 'multiple_choice'){?>

      
    <?php foreach($polling as $polling){?>

        <div id="ref<?php echo $polling->id ?>" style="height: 100vh">
     <div class="a" id="<?php echo $polling->id ?>" style="width:100%; height:400px;"></div>
        
      <?php  $qwe =  $this->poll_model->get_opt($polling->id); ?>
      <table class="table" style="visibility: hidden;">
        <tbody>
      <?php $in = 0; foreach($qwe as $qwe){?>
          <tr><td> <?php echo $qwe->opts; ?></td>

               <td  class="5<?php echo $polling->id; ?>"    data-inc="<?php echo $in; ?>" data-tit="<?php echo $polling->question ?>" data-opt="<?php echo $qwe->opts ?>" id="<?php echo $qwe->id.$polling->id ?>"><?php echo  $qwe->count; ?></td>

               
             </tr>

      <?php $in++; } ?>
        </tbody>
      </table>
    </div> 

  <?php } ?>
</div>
<?php }elseif($this->uri->segment(5) == 'open'){ ?>
            <table class="table"><tbody> <?php foreach($polling as $polling){?>
              <tr><td><?php echo $polling->name ?></td></tr>
              <?php } ?></tbody></table>
<?php } ?>
 


</div>
<div class="not" id="not">
</div>


  <script src="<?php echo base_url('node_modules/socket.io/node_modules/socket.io-client/socket.io.js');?>"></script>
  

<script type="text/javascript">
  $('.wrapper').children().hide();
  $('.not').show();






    var socket = io.connect( 'http://'+window.location.hostname+':3000' );

$(".a").each(function() {
 var q = $(this).attr('id');
 var aert = [];
  var erwt = [];



 $(".5"+q).each(function() {
           aert.push($(this).attr('data-opt'));
           erwt.push('4');
           tile = $(this).attr('data-tit');
   })
 Highcharts.chart(q, {
    chart: {
        type: 'bar',
        animation: Highcharts.svg, // don't animate in old IE
        marginRight: 10,
        events: {
            load: function () {
               var series = this.series[0];
                setInterval(function(){
                // set up the updating of the chart each second
                  
                      
                    $(".5"+q).each(function() {
                  var y = parseInt($(this).text());
                  series.data[parseInt($(this).attr('data-inc'))].update(y);
                  
              
                
                   
            })
               }, 1000);   

            }

        }
    },

    time: {
        useUTC: false
    },

    title: {
        text: tile     
    },

    accessibility: {
        announceNewData: {
            enabled: true,
            minAnnounceInterval: 15000,
            announcementFormatter: function (allSeries, newSeries, newPoint) {
                if (newPoint) {
                    return 'New point added. Value: ' + newPoint.y;
                }
                return false;
            }
        }
    },

    xAxis: {
        categories: aert,
       
    },

    yAxis: {
        title: {
            text: 'Value'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },

    tooltip: {
        headerFormat: '<b>{series.name}</b><br/>',
        pointFormat: '123'
    },
      plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true,
               
                 
               
                }
            }
        },
    legend: {
        enabled: false
    },

    exporting: {
        enabled: false
    },

    series: [{
        name: 'Random data',
        data:erwt
    }]
});
});

//  var ctx = document.getElementById('myChart').getContext('2d');


//   var chart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//          labels: ['wer','rtet'],
//         datasets: [{
//             label: '# of Votes',
//             data: [1,1],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//             borderColor: [
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)'
//             ],
//             borderWidth: 1
//         },
//         {
//             label: '# of Votes',
//             data: [1,1],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//             borderColor: [
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero: true
//                 }
//             }]
//         },
        
//     }
// });






    var socket = io.connect( 'http://'+window.location.hostname+':3000' );

      socket.on( 'new_message', function( data ) {

   
      
      
      $('#'+data.id).html(data.count);
 
      

  });

          Push.create("Hello world!",{
            body: "This is example of Push.js Tutorial",
            icon:"http://localhost/hrone/public/img/cropped.png",
      
            timeout: 5000,
            onClick: function () {
                window.focus();
                this.close();
            }
        }); 
      
      $("#clear-button").click(function(){ 
           Push.clear();
      });
      $("#check-button").click(function(){ 
            console.log(Push.Permission.has());
      });

// document.addEventListener('DOMContentLoaded', function () {

//         var s =[];
// $(".4").each(function() {
//    s.push($(this).val());
   
// })
// var a =[];
// $(".question").each(function() {
//    a.push($(this).text());
   
// })

//         var myChart = Highcharts.chart('container', {
//             chart: {
//                 type: 'bar'
//             },
//             title: {
//                 text: 'Fruit Consumption'
//             },
//             xAxis: {
//                 categories:a
//             },
//             yAxis: {
//                 title: {
//                     text: 'Fruit eaten'
//                 }
//             },
//             series: [{
//                 name: 'Jane',
//                 data: [1, 0, 4]
//             }, {
//                 name: 'John',
//                 data: [5, 7, 3]
//             }]
//         });
//     });

</script>
