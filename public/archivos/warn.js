// JavaScript Document
function hello(){
	alert("hello!");
	
}
function range(value,min,max){
	return ((value<min)||(value>max))?false:true;
}


function warnAndSelect(obj,str){
        alert(str);
        obj.select();
}

function isNUM(obj){
	if(isNaN(obj.value)==true)
	{
		warnAndSelect(obj,popup_msg[popup_msg_13]+": "+ obj.value)
    	return false;
	}
	return true;
}
function inRange(obj){
	if (range(obj.value,0,255)==false)
	{
		warnAndSelect(obj,popup_msg[popup_msg_12]+": " + obj.value + " [0-255]");
		return false;
	}
	return true;
}

function isFilled(obj){
	if(trimAllblank(obj.value)=="")
	{
		warnAndSelect(obj,popup_msg[popup_msg_11]);
		return false;
	}
	return true
}

function isPosInt(num){
	re = /^\d+$/;
	return re.test(num);
}

function trimAllblank(s){
	// trim leading spaces 
  while (s.substring(0,1) == ' ') 
    s = s.substring(1,s.length);
	// trim trailing spaces
  while (s.substring(s.length-1,s.length) == ' ') 
    s = s.substring(0,s.length-1);
  return s;
}

function rangeCheck(obj,minint,maxint){
	re = /^\d+$/;
	if (isPosInt(obj.value)==false) {
		warnAndSelect(obj,"\'"+ obj.value + "\' "+popup_msg[popup_msg_43]+"!\'");
		return false;
	}
	if(range(obj.value,minint,maxint)==false){
	warnAndSelect(obj, "\'" + obj.value + "\' "+ popup_msg[popup_msg_12] +' ['+ minint + '-' + maxint + ']');
		return false;
	}
	return true;
	
}

function ipCheck(a,b,c,d,option){
	if(((trimAllblank(a.value)=="")&&(trimAllblank(b.value)=="")&&(trimAllblank(c.value)=="")&&(trimAllblank(d.value)==""))==false)
	{
	 
	 if(isFilled(a) == false)return false;	
	 if(isFilled(b) == false)return false;
	 if(isFilled(c) == false)return false;
	 if(isFilled(d) == false)return false;
	}
	else if(option)//should filled
	{
		warnAndSelect(a,popup_msg[popup_msg_44]);
		return false;
	}
	
	if((parstIntTrimLeadZero(a.value)==0)&&(parstIntTrimLeadZero(b.value)==0)&&(parstIntTrimLeadZero(c.value)==0)&&(parstIntTrimLeadZero(d.value)==0))
	{
		warnAndSelect(a,popup_msg[popup_msg_14]);
		return false;
	}
	if((parstIntTrimLeadZero(a.value)==255)&&(parstIntTrimLeadZero(b.value)==255)&&(parstIntTrimLeadZero(c.value)==255)&&(parstIntTrimLeadZero(d.value)==255))
	{
		warnAndSelect(a,popup_msg[popup_msg_15]);
		return false;
	}
	
	if(inRange(a) == false)	return false;
	if(inRange(b) == false)	return false;
	if(inRange(c) == false)	return false;
	if(inRange(d) == false)	return false;
	if(isNUM(a) == false)	return false;
	if(isNUM(b) == false)	return false;
	if(isNUM(c) == false)  return false;
	if(isNUM(d) == false) 	return false;	
	return true;
}

function getRadioCheckedIndex(radioobj){
	var value=0;
	for (i=0;i<radioobj.length;i++){
		if (radioobj[i].checked)
		   return i
	}
}
function wepCheck(obj,format,length){
	var maxlength ;
	if((format == 0) && ( length == 0))
		maxlength =5;//ascii ,64bits
	else if((format == 0) && ( length == 1))
			maxlength =13;//ascii, 128bits
	else if((format == 1) && ( length == 0))
			maxlength =10;//hex, 64bits
	else if((format == 1) && ( length == 1))
			maxlength = 26;//ascii, 128bits
	if(obj.value.length != maxlength)
	{	warnAndSelect(obj,popup_msg[popup_msg_17]+" " + maxlength + " "+popup_msg[popup_msg_18]);
		return false;
	}
	if(format == 0)//ascii
	{
		if(isAscii(obj.value) == false)
		{	warnAndSelect(obj,popup_msg[popup_msg_19]);
			return false;
		}
			
	}else if(format == 1)//hex
	{
		if(isHex(obj.value) == false)
		{	warnAndSelect(obj,popup_msg[popup_msg_21]);
			return false;
		}	
		
	}
	return true;
}
function wpaCheck(obj){	
	if(range(obj.value.length,8,64) == false)
	{	warnAndSelect(obj,popup_msg[popup_msg_20]);
		return false;
	}
	if(obj.value.length == 64)
	{
		if(isHex(obj.value) == false)
		{	warnAndSelect(obj,popup_msg[popup_msg_21]);
			return false;
		}	
	}
	else
	{
		if(isAscii(obj.value) == false)
		{	warnAndSelect(obj,popup_msg[popup_msg_19]);
				return false;
		}
	}
	return true;
}

function isAscii(str){
      var temp ;

	  for(var i =0 ;i<str.length;i++){
	     temp = str.charCodeAt(i);
		 if(temp < 32 || temp >=127)
		 	return false;
	  }
	  return true;
}
function isHex(str){
	var filter = /^[a-fA-F0-9]+$/;
	return filter.test(str);
		
}
function isAlphaNum(str){
	var filter = /^[a-zA-Z0-9]+$/;
	return filter.test(str);

}
function hexCheck(obj){
	if(isHex(obj.value) == false)
	{	warnAndSelect(obj,popup_msg[popup_msg_22]);
		return false;
	}
		return true;	
}
	
function asciiCheck(obj){
	if(isAscii(obj.value) == false)
	{	warnAndSelect(obj,popup_msg[popup_msg_23]);
		return false;
	}
		return true;
}
function alphanumCheck(obj){
	if(isAlphaNum(obj.value) == false)
	{	warnAndSelect(obj,popup_msg[popup_msg_64]);
		return false;
	}
		return true;
}
function equalCheck(obj,str,warn){
	if(obj.value == str)
	{	
		if(warn!=null)
			warnAndSelect(obj,warn);
		else 
			warnAndSelect(obj,obj.value + " "+popup_msg[popup_msg_24]+" '"+ str +"'");
		return false;
	}
		return true;	
}
function inUserListCheck(listobj,nameobj){
	for(i=0;i<listobj.length;i++)
		if(listobj[i].value == nameobj.value)
		{	
			warnAndSelect(nameobj,popup_msg[popup_msg_25]);	
			return false;	
		}
	return true;
}

function parstIntTrimLeadZero(strobj){
        i=0;
        var str = new String(strobj);
        while ((str.substring(i,i+1)=="0")&&(i<str.length-1))
             i++;
        return parseInt(str.substring(i,str.length))

}

function addZero(num){
	var t = parstIntTrimLeadZero(num);
	if(t<=9)
	  return "0"+t;
	else
	  return t;
}
function openTarget (form, features, windowName) {
	if (!windowName)
	windowName = popup_msg[popup_msg_26] + (new Date().getTime());
		window.open ('', windowName, features);
	form.target = windowName;

}