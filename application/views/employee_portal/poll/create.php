


<style type="text/css">
  body {
    padding-top: 20px
}

#custom_carousel .item {
    color: #000;
    background-color: #eee;
    padding: 20px 0;
}

#custom_carousel .controls {
    overflow-x: auto;
    overflow-y: hidden;
    padding: 0;
    margin: 0;
    white-space: nowrap;
    text-align: center;
    position: relative;
    background: #ddd
}

#custom_carousel .controls li {
    display: table-cell;
    width: 1%;
    max-width: 90px
}

#custom_carousel .controls li.active {
    background-color: #eee;
    border-top: 3px solid orange;
}

#custom_carousel .controls a small {
    overflow: hidden;
    display: block;
    font-size: 10px;
    margin-top: 5px;
    font-weight: bold
}
input[name=submit] {padding:5px 15px; background:#ccc; border:0 none;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    background-color:#4CAF50;
    color:white;
     }
input[name=cancel] {padding:5px 15px; background:#ccc; border:0 none;
    cursor:pointer;
    -webkit-border-radius: 5px;
    border-radius: 5px;
    background-color:#f44336;
    color:white;
     }

</style>

<br><br><br>
<br><br><br>

<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12">
<h2 class="page-header">Creators Page </h2>
   


     
 

      <div class="panel panel-success">
    
        <div class="panel-body">

            <div class="col-md-12">
              


<div class="container">
  <?php if(!empty($msg)){ echo $msg; } ?>
    <div class="row">
           <div class="featurette" id="about">
              <form  action="<?php echo base_url(); ?>employee_portal/poll/create" method="post">
            <!------------------------code---------------start---------------->
            <div class="container-fluid">
                <div id="custom_carousel" class="carousel slide">
                          <div class="controls">
                        <ul class="nav">
                            <li data-target="#custom_carousel" data-slide-to="0" class="active" >
                                <a href="#" onclick="poll_type('multiple_choice')"><img src="<?php echo base_url(); ?>public/img/choice.png" style="width: 50px;" ><small>Multiple Choice</small></a>
                            </li>
                            <li data-target="#custom_carousel" data-slide-to="1">
                                <a href="#" onclick="poll_type('open')" ><img src="<?php echo base_url(); ?>public/img/open.png" style="width: 50px;"><small>Open Minded</small></a>
                            </li>
                            <li data-target="#custom_carousel" data-slide-to="2">
                                <a href="#"><img src="<?php echo base_url(); ?>public/img/qanda.png" style="width: 50px;"><small>Q & A</small></a>
                            </li>
                            <li data-target="#custom_carousel" data-slide-to="3">
                                <a href="#"><img src="<?php echo base_url(); ?>public/img/trophy.png" style="width: :25px; height: 40px;"><small>Competitions</small></a>
                            </li>
                        </ul>
                    </div>
                     <div id="pol"><input type="hidden" name="poll_type" value="multiple_choice" /></div>
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="container-fluid">
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <h4>Ask a question and let participants choose from a list of answers.</h4>
                                       


            <div id="Multiple_Choice"><h5>Title</h5>
                    <input class="form-control" type="text" name="name">
                      <br>
        
              <div id="add_1" style="margin:15px;" class="row">
                  <h5>Question 1</h5><input class="form-control" type="text" name="question[]">
                  <Br>
                  <div   id="education_fields1" class="col-sm-10 nopadding">

                    <div class="form-group" >

                      <div class="input-group">
                               <div class="input-group-btn">
         <span style="margin-left:250px;"> <input type="file" id="uploadedFile" name="uploadedFile" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"><span>
                         

                        </div>
                        <input type="text" class="form-control" name="opt1[]" >

                        <div class="input-group-btn">
        
                          <button class="btn btn-success"  type="button" data-s="1" onclick="education_fields(this);"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>

                        </div>

                  </div>

                  </div> 
                  
                  </div>
                  </div><hr>

                  
                    
            </div>
          

                                    </div>
                                </div>
                                <span><button class="btn btn-success" type="button"  onclick="add();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add more question </button></span>
                            </div>  
                            <br>
                         
                         
                        </div>
                        <div class="item">
                            <div class="container-fluid">
                                <div class="row">
                                    
                                    <div class="col-md-12">
                                        <h4>
                                        Ask a question and let participants type in a free-form answer.then can upvote and downvote other answers. Great for gathering consensus.</h4>
                                        Title
                                        <input type="text" name="title_open" class="form-control">
                                        Question
                                        <input type="text" name="questionas" class="form-control">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="container-fluid">
                                <div class="row">
                                   
                                    <div class="col-md-9">
                                        <h4>Coming Soon</h4>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="container-fluid">
                                <div class="row">
                                    
                                    <div class="col-md-9">
                                        <h2>Coming soon</h2>
                                        <p>Create a series of questions, then let participants compete to answer fastest.
</p>
                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- End Item -->
                    </div>
                    <!-- End Carousel Inner -->
                    <br><br>

                <input class="pull-right" type='submit' name="submit" value="Submit"> 
                
                <a href="<?php echo base_url(); ?>employee_portal/poll" class="btn btn-danger pull-right btn-sm">
    <span class="glyphicon glyphicon-circle-arrow-left"></span> Back
</a>
              
                </div>
                <!-- End Carousel -->
            </div>
            </form>
            <!----Code------end----------------------------------->
        </div>
  </div>
</div>
<script type="text/javascript">
var add_q = 1;
var room = 1;
function add() {
 
    add_q++;
    var objTo = document.getElementById('Multiple_Choice')
    var divtest = document.createElement("div");
	divtest.setAttribute("class", "form-group removeclass"+add_q);
	var rdiv = 'removeclass'+add_q;  
    divtest.innerHTML = '<div  style="margin:15px;" id="add_'+add_q+'" class="row"><h5>Question'+' '+add_q+'</h5><input class="form-control" type="text" name="question[]"><div class="col-sm-10" id="education_fields'+add_q+'" nopadding"><div class="form-group"><br><div class="input-group"><input type="text"class="form-control" name="opt'+add_q+'[]"><div class="input-group-btn"><button data-s="'+add_q+'" class="btn btn-success" type="button"   onclick="education_fields(this);"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button></div></div></div></div></div><hr>';
    
    objTo.appendChild(divtest)
}
function education_fields(i) {
 	a = $(i).attr('data-s');
    room++;
    var objTo = document.getElementById('education_fields'+a)
    var divtest = document.createElement("div");
	divtest.setAttribute("class", "form-group removeclass"+room);
	var rdiv = 'removeclass'+room;
    divtest.innerHTML = '<div class="form-group"><div class="input-group"><div class="input-group-btn"><span style="margin-left:250px;"> <input type="file" id="uploadedFile" name="uploadedFile" class="form-control" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"><span></div><input type="text"  class="form-control" name="opt'+a+'[]"><div class="input-group-btn"> <button class="btn btn-danger" type="button" onclick="remove_education_fields('+ room +');"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> </button></div></div></div></div><div class="clear">';
    
    objTo.appendChild(divtest)
}
   function remove_education_fields(rid) {
	   $('.removeclass'+rid).remove();
   }
   function poll_type(type){

   			$('#pol').html('<input type="hidden" name="poll_type" value="'+type+'" />');
   }
   $(document).ready(function (ev) {
    $('#custom_carousel').on('slide.bs.carousel', function (evt) {
        $('#custom_carousel .controls li.active').removeClass('active');
        $('#custom_carousel .controls li:eq(' + $(evt.relatedTarget).index() + ')').addClass('active');
    })
});
</script>