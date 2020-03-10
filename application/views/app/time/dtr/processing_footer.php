<script>
document.getElementById('proceso').innerHTML='PROCESS COMPLETE';
window.clearInterval(myTimeruu);
</script>
<style>
#fixedtop1{ display:none;}
</style>
<?php if($bilang_ng_bilang>0){?>
<style type="text/css">

#modalContainer {
	background-color:transparent;
	position:absolute;
	width:100%;
	height:100%;
	top:0px;
	left:0px;
	z-index:10000;
	background-image:url(tp.png); /* required by MSIE to prevent actions on lower z-index elements */
}

#alertBox {
	position:relative;
	width:300px;
	min-height:50px;
	margin-top:250px;
	border:2px solid #666666;
	background-color:#F2F5F6;
	background-image:url(alert.png);
	background-repeat:no-repeat;
	background-position:20px 30px;
}

#modalContainer > #alertBox {
	position:fixed;
}

#alertBox h1 {
	margin:0;
	font:bold 0.9em verdana,arial;
	background-color:#fff;
	color:#666666;
	border-bottom:1px solid #666666;
	padding:2px 0 2px 5px;
}

#alertBox p {
	font:1em verdana,arial;
	height:20px;

	text-align: center;
}

#alertBox #closeBtn {
	display:block;
	position:relative;
	margin:5px auto;
	padding:3px;
	border:2px solid #666666;
	width:70px;
	font:0.7em verdana,arial;
	text-transform:uppercase;
	text-align:center;
	color:#FFF;
	background-color:#78919B;
	text-decoration:none;
}





</style>
<script type="text/javascript">

var ALERT_TITLE = "Processing Done";
var ALERT_BUTTON_TEXT = "Ok";

if(document.getElementById) {
	window.alert = function(txt) {
		createCustomAlert(txt);
	}
}

function createCustomAlert(txt) {
	d = document;

	if(d.getElementById("modalContainer")) return;

	mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
	mObj.id = "modalContainer";
	mObj.style.height = d.documentElement.scrollHeight + "px";
	
	alertObj = mObj.appendChild(d.createElement("div"));
	alertObj.id = "alertBox";
	if(d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
	alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth)/2 + "px";
	alertObj.style.visiblity="visible";

	h1 = alertObj.appendChild(d.createElement("h1"));
	h1.appendChild(d.createTextNode(ALERT_TITLE));

	msg = alertObj.appendChild(d.createElement("p"));
	//msg.appendChild(d.createTextNode(txt));
	msg.innerHTML = txt;

	btn = alertObj.appendChild(d.createElement("a"));
	btn.id = "closeBtn";
	btn.appendChild(d.createTextNode(ALERT_BUTTON_TEXT));
	btn.href = "#";
	btn.focus();
	btn.onclick = function() { removeCustomAlert();return false; }

	alertObj.style.display = "block";
	
}

function removeCustomAlert() {
	document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
}
var tym_in_min=0;
var tym_in_sec  = document.getElementById('time_of_process').value;
if(tym_in_sec>60){
	tym_in_min = Math.floor(tym_in_sec/60);
	tym_in_sec = document.getElementById('time_of_process').value - tym_in_min * 60;
	}

alert('No. of DTR processed : <?php echo $bilang_ng_bilang;?>');

// alert('Process complete. <br/> No. of DTR processed : <?php //echo $bilang_ng_bilang;?> <br/> Process time : <?php //echo gmdate("H:i:s",((abs(strtotime($from_timer) - time()) / 60) * 60)) ;?> <br/>memory usage : <?php //echo (round((memory_get_usage()/1024/1024),2));?> mb');
</script>

<?php }?>