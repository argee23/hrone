


    <style>
/*Downloaded from https://www.codeseek.co/onedotsix/bootstrap-wide-responsive-org-chart-aBObWj */

/* TEMP 
***************************************************************************************************/
.content *{
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  position: relative;
}

.cf:before,
.cf:after {
    content: " "; /* 1 */
    display: table; /* 2 */
}

.cf:after {
    clear: both;
}

/**
 * For IE 6/7 only
 * Include this rule to trigger hasLayout and contain floats.
 */
.cf {
    *zoom: 1;
}

/* Generic styling */


.content{
  width: 100%;
  max-width: 1142px;
  margin: 0 auto;
  padding: 0 20px;
}

a:focus{
  outline: 2px dashed #f7f7f7;
}

@media all and (max-width: 767px){
  .content{
    padding: 0 20px;
  } 
}

.clas{
  padding: 0;
  margin: 0;
  list-style: none;   
}

.clas a{
  display: block;
  background: #ccc;
  border: 4px solid rgb(245,238,201);
  text-align: center;
  overflow: hidden;
  font-size: .7em;
  text-decoration: none;
  font-weight: bold;
  color: #333;
  height: 70px;
  margin-bottom: -26px;
  box-shadow: 4px 4px 9px -4px rgba(0,0,0,0.4);
  -webkit-transition: all linear .1s;
  -moz-transition: all linear .1s;
  transition: all linear .1s;
}


@media all and (max-width: 767px){
  .clas a{
    font-size: 1em;
  }
}


.clas a span{
  top: 50%;
  margin-top: -0.7em;
  display: block;
}

/*
 
 */

.administration > li > a{
  margin-bottom: 25px;
}

.director > li > a{
  width: 50%;
  margin: 0 auto 0px auto;
}

.subdirector:after{
  content: "";
  display: block;
  width: 0;
  height: 130px;
  background: red;
  border-left: 4px solid rgb(245,238,201);
  left: 45.45%;
  position: relative;
}

.subdirector,
.departments{
  position: absolute;
  width: 100%;
}

.subdirector > li:first-child,
.departments > li:first-child{  
  width: 18.59894921190893%;
  height: 64px;
  margin: 0 auto 92px auto;   
  padding-top: 25px;
  border-bottom: 1px solid rgb(245,238,201);
  z-index: 1; 
  visibility: hidden;
}

.subdirector > li:first-child{
  float: right;
  right: 27.2%;
  border-left: 4px solid rgb(245,238,201);
}



.subdirector > li:first-child a,
.departments > li:first-child a{
  width: 100%;
  display:none;
}

.subdirector > li:first-child a{  
  left: 15px;
  display: none;
}



  .subdirector > li:first-child{
    right: 10%;
    margin-right: 2px;
  }

  .subdirector:after{
    left: 49.8%;
  }

  .departments > li:first-child{
    left: 10%;
    margin-left: 2px;
  }
}


.departments > li:first-child a{
  right: 25px;
  display:none;
}

.department:first-child,
.departments li:nth-child(2){
  margin-left: 0;
  clear: left;  
}

.departments:after{
  content: "";
  display: block;
  position: absolute;
  width: 81.1%;
  height: 22px; 
  border-top: 4px solid rgb(245,238,201);
  border-right: 4px solid rgb(245,238,201);
  border-left: 4px solid rgb(245,238,201);
  margin: 0 auto;
  top: 130px;
  left: 9.1%
}

@media all and (max-width: 767px){
  .departments:after{
    border-right: none;
    left: 0;
    width:59.8%;
  }  
}

@media all and (min-width: 768px){
    /* this removes the top connector from the first li */
  /*.department:first-child:before,*/
    /* need to remove it from first department (second li) */
  .department:nth-child(2):before,
   .department:last-child:before{
    border:none;
  }
}

.department:before{
  content: "";
  display: block;
  position: absolute;
  width: 0;
  height: 22px;
  border-left: 4px solid rgb(245,238,201);
  z-index: 1;
  top: -22px;
  left: 57%;
  margin-left: -4px;
}

.department{
  border-left: 4px solid rgb(245,238,201);
  /* width: 18.59894921190893%; */
    /* use the calc() function and set the divisor to the number of departments  */
    width: calc(92% / 3);
  float: left;
  margin-left: 1.751313485113835%;
  margin-bottom: 60px;
}

.lt-ie8 .department{
  width: 18.25%;
}

@media all and (max-width: 767px){
  .department{
    float: none;
    width: 100%;
    margin-left: 0;
  }

  .department:before{
    content: "";
    display: block;
    position: absolute;
    width: 0;
    height: 60px;
    border-left: 4px solid white;
    z-index: 1;
    top: -60px;
    left: 0%;
    margin-left: -4px;
  }

  .department:nth-child(2):before{
    display: none;
  }
}

.department > a{
  margin: 0 0 -26px -4px;
  z-index: 1;
}

.department > a:hover{  
  height: 80px;
}

.department > ul{
  margin-top: 0px;
  margin-bottom: 0px;
}

.department li{ 
  padding-left: 25px;
  border-bottom: 4px solid rgb(245,238,201);
  height: 80px; 
}

.department li a{
  background: #fff;
  top: 48px;  
  position: absolute;
  z-index: 1;
  width: 90%;
  height: 60px;
  vertical-align: middle;
  right: -1px;
  background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+CiAgPGxpbmVhckdyYWRpZW50IGlkPSJncmFkLXVjZ2ctZ2VuZXJhdGVkIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjAlIiB5MT0iMCUiIHgyPSIxMDAlIiB5Mj0iMTAwJSI+CiAgICA8c3RvcCBvZmZzZXQ9IjAlIiBzdG9wLWNvbG9yPSIjMDAwMDAwIiBzdG9wLW9wYWNpdHk9IjAuMjUiLz4KICAgIDxzdG9wIG9mZnNldD0iMTAwJSIgc3RvcC1jb2xvcj0iIzAwMDAwMCIgc3RvcC1vcGFjaXR5PSIwIi8+CiAgPC9saW5lYXJHcmFkaWVudD4KICA8cmVjdCB4PSIwIiB5PSIwIiB3aWR0aD0iMSIgaGVpZ2h0PSIxIiBmaWxsPSJ1cmwoI2dyYWQtdWNnZy1nZW5lcmF0ZWQpIiAvPgo8L3N2Zz4=);
  background-image: -moz-linear-gradient(-45deg,  rgba(0,0,0,0.25) 0%, rgba(0,0,0,0) 100%) !important;
  background-image: -webkit-gradient(linear, left top, right bottom, color-stop(0%,rgba(0,0,0,0.25)), color-stop(100%,rgba(0,0,0,0)))!important;
  background-image: -webkit-linear-gradient(-45deg,  rgba(0,0,0,0.25) 0%,rgba(0,0,0,0) 100%)!important;
  background-image: -o-linear-gradient(-45deg,  rgba(0,0,0,0.25) 0%,rgba(0,0,0,0) 100%)!important;
  background-image: -ms-linear-gradient(-45deg,  rgba(0,0,0,0.25) 0%,rgba(0,0,0,0) 100%)!important;
  background-image: linear-gradient(135deg,  rgba(0,0,0,0.25) 0%,rgba(0,0,0,0) 100%)!important;
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#40000000', endColorstr='#00000000',GradientType=1 );
}

.department li a:hover{
  box-shadow: 8px 8px 9px -4px rgba(0,0,0,0.1);
  height: 80px;
  width: 95%;
  top: 39px;
  background-image: none!important;
}

/* Department/ section colors */
.department.dep-a a{ background: #FFD600; }
.department.dep-b a{ background: #AAD4E7; }
.department.dep-c a{ background: #FDB0FD; }
.department.dep-d a{ background: #A3A2A2; }
.department.dep-e a{ background: #f0f0f0; }
    </style>



<div class="content" style="height: 500px;">
  
  <figure class="org-chart cf">
    <ul class="administration clas">
      <li>          
        <ul class="director clas">
          <li>
            <a href="#"><span>Hr Admin</span></a>
            <ul class="subdirector clas">

            </ul>
            <ul class="departments cf clas">               
              <li><a href="#"><span>Administration</span></a></li>
              
              <li class="department dep-a clas">
                <a href="#"><span>Evaluator</span></a>
                <ul class="sections clas">
                	<?php foreach($list as $list)	{ ?>
                  <li class="section"><a href="#"><span><?php echo $list->fullname.' level '.$list->evaluator; ?></span></a></li>
              <?php } ?>
                </ul>
              </li>
              <li class="department dep-b clas">
                <a href="#"><span>Approver</span></a>
                <ul class="sections clas">
                	<?php foreach($get_scorecard_approver_option2 as $get_scorecard_approver_option2){ ?>
                  <li class="section"><a href="#"><span><?php echo $get_scorecard_approver_option2->fullname.' level '.$get_scorecard_approver_option2->approval_level; ?></span></a></li>
                 	<?php } ?>
                </ul>
              </li>
              <li class="department dep-c clas">
                <a href="#"><span>Creator</span></a>
                <ul class="sections clas">
                <?php foreach($get_scorecard_creator_option3 as $get_scorecard_creator_option3){ ?>
                  <li class="section"><a href="#"><span><?php echo $get_scorecard_creator_option3->fullname?></span></a></li>
							<?php } ?>
                </ul>
              </li>
              <!-- remove enter department list item -->
              <!-- <li class="department dep-d">
                <a href="#"><span>Department D</span></a>
                <ul class="sections">
                  <li class="section"><a href="#"><span>Section D1</span></a></li>
                  <li class="section"><a href="#"><span>Section D2</span></a></li>
                  <li class="section"><a href="#"><span>Section D3</span></a></li>
                  <li class="section"><a href="#"><span>Section D4</span></a></li>
                  <li class="section"><a href="#"><span>Section D5</span></a></li>
                  <li class="section"><a href="#"><span>Section D6</span></a></li>
                </ul>
              </li> -->
              <!-- remove enter department list item -->
        
            </ul>
          </li>
        </ul> 
      </li>
    </ul>     
  </figure>


</div>


<script type="text/javascript">
$.fn.datepicker.dates.en.titleFormat="MM";
$(document).ready(function(){
    var date_input=$('input[name="date"]'); 
    date_input.datepicker({
      format: 'dd-mm',
      autoclose: true,
      startView: 1,
      maxViewMode: "months",
      orientation: "bottom left",
    })
  });

</script>

