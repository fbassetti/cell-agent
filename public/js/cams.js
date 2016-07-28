var profile=0;
var group = "admin";
var nightmode = "";
var msgRecOK = new Array(item_name[_STOP_RECORD],item_name[_MANUAL_RECORD]);
var msgAlmOK = new Array(item_name[_ALARM_SENT],item_name[_MANUAL_ALARM]);
var msgSnpOK = new Array(item_name[_SAVE_OK],item_name[_SNAPSHOT]);
var msgSnpFail = new Array(item_name[_SAVE_FAIL],item_name[_SNAPSHOT]);
var msgTlkOK = new Array(item_name[_TALKING],item_name[_TALK]);
var msgLisOK = new Array(item_name[_LISTENING],item_name[_LISTEN]);

function checkSize(){
	if(document.ucx.fChgImageSize == 1){
		document.ucx.fChgImageSize = 0;
		avStop();
		document.ucx.height = document.ucx.ImgHeight;
		document.ucx.width = document.ucx.ImgWidth;
		avStart();
	}
}

function changeMode(val){
	window.location = "view.cgi?profile=" +val
}
function avGetCookie(){
	if(getCookie("Video") != null)
		v = (getCookie("Video")=="true") ? 1 : 0 ;
	if(getCookie("Audio") != null)
		a = (getCookie("Audio")=="true") ? 1 : 0;
}
function getVFlag(){
	return true;
}
var aflag = false;
function getAFlag(){
	return aflag;
}
function setAFlag(d){
	aflag = d;
}
function avStop(){
	videoEnable(false);
	audioEnable(false);
}
function avStart(){
	videoEnable(getVFlag());
	audioEnable(getAFlag());
}
function videoEnable(flag){
	if(flag)
		document.ucx.PlayVideo(profile);
	else
		document.ucx.StopVideo();
	setCookieYears("Video",flag,null,null,null,null);
}
// -3 : disabled
// -2 : OS sound not-available
// -1 : server occupied
// 0 : success
function audioEnable(flag){
	var ret = 0;
	if(flag)
		ret = document.ucx.PlayAudio();
	else
		document.ucx.StopAudio();
	if(ret ==  0)
		setCookieYears("Audio",flag,null,null,null,null);
	return ret;
}

///////////////////////////////////////////////////////////////////////////////

var filepath = "";
var flagRecording = false;
var cntRecording = 0;
function pathGetCookie(){
	var tpath=getCookie("CapPath");
	filepath = "";
	if((tpath!=null)&&(tpath!="null")){
		filepath = tpath;
	}
}

function addTrailSlash(s){
	if(s.substring(s.length-1,s.length) != "\\")
		s=s+"\\";
	return s;
}
//////////////////////////////////////////////////////////
function scale(f,obj){
	if((document.ucx.ImgWidth * f) >640)
		document.ucx.width = 640;
	else
		document.ucx.width = document.ucx.ImgWidth * f
	if((document.ucx.ImgHeight * f) >480)
		document.ucx.height = 480;
	else
		document.ucx.height = document.ucx.ImgHeight * f

	document.ucx.SetImgScale(f);
	scaleColor(f);
}

function scaleColor(f){
	var i;
	for(i=1;i<=3;i++){
		if(f==i)
			document.getElementById("scale"+i).className="style1";
		else
			document.getElementById("scale"+i).className="style3";
	}
}
function change(idx){
	window.location = "view.cgi?profile=" + idx;
}

var obja;
var intcss;
var blinkflag = false;
var blinkobj;
var blinktxt;
function blinkCSS(obj){
	if(blinkflag)
		obj.className = "t12 style8";
	else
		obj.className = "t12 style11";
	blinkflag = !blinkflag;
}

function Timer(pobj,pmsec){
	this.msec  = pmsec;
	this.obj	= pobj;
	this.bflag = false;
	this.int_timer = null;
	this.Blinking = function(){
		if(this.bflag)
			this.obj.className = "t12 style8";
		else
			this.obj.className = "t12 style11";
		this.bflag = !(this.bflag);
	}

	this.Start = function(){
		if(this.int_timer == null)
			this.int_timer  = window.setInterval(this.Blinking,this.msec);
	}
	this.Stop = function(){
		if(this.int_timer != null)
			window.clearInterval(this.int_timer);
	}
}
var rss;
function swapCSS(flag,obj,texton,textoff){
	if(flag){
		obja = obj.firstChild;
		obj.removeChild(obja);
		obj.innerText = texton;
		blinktxt = texton;
		obj.className = "t12 style8";
		blinkobj = obj;
	}
	else{
		obj.className = "style10";
		obja = document.createElement("a");
		obja.className = "a";
		obja.innerText = textoff;
		obja.href = "javascript:;";
		obj.innerText = "";
		obj.appendChild(obja);
	}
}

function listen(obj){
	setAFlag(!aflag);
	var ret = audioEnable(aflag);

	if(ret == -1)
		alert(popup_msg[popup_msg_5]);
	else if (ret == -2)
		alert(popup_msg[popup_msg_6]);
	else if (ret == -3)
		alert(popup_msg[popup_msg_7])
	else if (ret == -4)
		alert(popup_msg[popup_msg_3]);
	else if (ret < 0)
		alert(popup_msg[popup_msg_4]);
	//restoring the flag
	if(ret<0)
		setAFlag(!aflag);
	//swapCSS(aflag,obj,msgLisOK[0],msgLisOK[1]);
}
var tflag = false;
function setTFlag(d){
	tflag = d;
}

// -3 : disabled
// -2 : os mic not-available
// -1 : server occupied
// 0 : success
function talkEnable(f){
	var ret = 0;
	if(f)
		ret = document.ucx.TalkOn();
	else
		document.ucx.TalkOff();
	return ret;
}

function talk(obj){
	setTFlag(!tflag);
	var ret  = talkEnable(tflag);
	if(ret == -1)
		alert(popup_msg[popup_msg_0]);
	else if (ret == -2)
		alert(popup_msg[popup_msg_1]);
	else if (ret == -3)
		alert(popup_msg[popup_msg_2]);
	else if (ret == -4)
		alert(popup_msg[popup_msg_3]);
	else if (ret < 0)
		alert(popup_msg[popup_msg_4]);

	//restoring the flag
	if(ret < 0)
		setTFlag(!tflag);
//	swapCSS(tflag,obj,msgTlkOK[0],msgTlkOK[1]);
}

function browse(){
	if((t = document.ucx.OpenFolder(filepath))!= ""){
		filepath = addTrailSlash(t);
		setCookieYears("CapPath",filepath);
	}
}

function snap(obj){
	if(filepath == ""){
		browse();
		if(filepath == ""){ return;}
	}
	document.ucx.SnapFileName = filepath;
	ret = document.ucx.SnapVideo();
	if(ret!=0){
		//swapCSS(true,obj,msgSnpFail[0],msgSnpFail[1]);
	}
	else{
		//swapCSS(true,obj,msgSnpOK[0],msgSnpOK[1]);
	}
	window.setTimeout("clearMsg('snp','"+ msgSnpOK[0] +"','"+ msgSnpOK[1] + "')",500);
}

function clearMsg(tdid,mesgon,mesgoff){
	var obj = document.getElementById(tdid);
	//swapCSS(false,obj,mesgon,mesgoff);
}
function record(obj){
	if(flagRecording == false){
		if(recordStart()!=false){
			flagRecording = true;
			//swapCSS(flagRecording,obj,msgRecOK[0],msgRecOK[1]);
		}
	}
	else{
		recordStop();
		flagRecording = false;
		//swapCSS(flagRecording,obj,msgRecOK[0],msgRecOK[1]);
	}
}

var wholepath="";
function recordStart(){
	if(filepath == ""){
		browse();
		if(filepath == ""){
			return false;
		}
	}
	fileDate=new Date();
	filename = "";
	cntRecording++;
	if(cntRecording > 30000)
		cntRecording=1;
	filename = filename +(fileDate.getFullYear())+ addZero((fileDate.getMonth()+ 1 ))+addZero(fileDate.getDate())+"_"+addZero(fileDate.getHours())+ addZero(fileDate.getMinutes()) + addZero(fileDate.getSeconds())+ "_" + cntRecording + ".avi";
	wholepath = filepath+filename;
	document.ucx.AVIRecStart(wholepath);
	rint = window.setInterval("getRecordState()",1000);
}

function recordStop(){
	document.ucx.AVIRecEnd()
	window.clearInterval(rint);
}
// -1: no space
// -2: resolution or framerate change
// -3: source format changed
// -4: file access error
function getRecordState(){
	var ret;
	if((ret =document.ucx.AVIRecStatus )!=0){
		recordStop();
		flagRecording = false;
		//swapCSS(flagRecording,document.getElementById("recordtd"),msgRecOK[0],msgRecOK[1]);
		document.ucx.AVIRecStatus= 0;
		if(ret == -1)
			alert(popup_msg[popup_msg_59]);
		else if(ret == -2)
			alert(popup_msg[popup_msg_60])
		else if(ret == -3)
			alert(popup_msg[popup_msg_61]);
		else if(ret == -4)
			alert(popup_msg[popup_msg_62]+" (" + wholepath+")" );
	}
}

function alarmtrig(tdobj){
	var obj = document.formalarm;
	obj.alarm.value = 1;
	obj.target = "hid";
	obj.submit();
	//swapCSS(true,tdobj,msgAlmOK[0],msgAlmOK[1]);
	window.setTimeout("clearMsg('altd','" +msgAlmOK[0]+"','"+msgAlmOK[1]+"')",500);
}

$(document).ready(function(){
	if(!$.browser.msie){
		return alert('Este navegador no soporta la opción de cámara. Por favor utilice Internet Explorer.');
	}
	//document.getElementById("location").appendChild(document.createTextNode(item_name[_LOCATION]));
	$('#record').html(document.createTextNode(item_name[_MANUAL_RECORD]));
	$("#snapshot").html(document.createTextNode(item_name[_SNAPSHOT]));
	$("#browse").html(document.createTextNode(item_name[_BROWSE]));
	$("#talk").html(document.createTextNode(item_name[_TALK]));
	$("#listen").html(document.createTextNode(item_name[_LISTEN]));
	$("#alarm").html(document.createTextNode(item_name[_MANUAL_ALARM]));

	if($("#ucx") == null) { return; }
	if(group != "guest"){
		$("#ctltb").hide(); avGetCookie();
	}
	else{
		setAFlag(true);
	}

	$.get('/web/locales/index/get-cam/loc_id/'+$('#local').val(),function(d){
	    document.ucx.RemoteHost = d.host;
	    document.ucx.RemotePort = d.port;
	    document.ucx.UserName = d.user;
	    document.ucx.Password = d.pass;
	    pathGetCookie();
	    avStart();
	    scaleColor(1);
	    if(document.ucx.longErrCode != 5){
			checkIntv = window.setInterval("checkSize()",2000);
	    }
	    else {
			$('#ucx').replaceWith('<h2>C&aacute;mara no disponible</h2>');
	    }
	},'json');
});