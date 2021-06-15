function sendHttpPost(_url,_data=""){//post方法发送数据
	xmlHttp=createXmlHttp();
	if(!xmlHttp){
		alert("创建xmlhttprequest对象失败");
	}else{
		url=_url;
		xmlHttp.onreadystatechange = callback;
		xmlHttp.open("POST",url,true);
		xmlHttp.setRequestHeader("Content-Type","application/x-www-form-urlencoded");//post方法声明
		xmlHttp.send(_data);
	}
}

function sendHttpUp2(_url,_data){//上传
	xmlHttp=createXmlHttp();
	if(!xmlHttp){
		alert("创建xmlhttprequest对象失败");
	}else{
		url=_url;
		xmlHttp.onreadystatechange = callback3;
		xmlHttp.open("POST",url,true);
		xmlHttp.send(_data);
	}
}

function createXmlHttp(){
	if(window.XMLHttpRequest){
		xmlHttp2 = new XMLHttpRequest(); 
		if(xmlHttp2.overrideMimeType){
			xmlHttp2.overrideMimeType("text/xml");
		}
	}else if(window.ActiveXobject){
		var activeName =["MSXML2.XMLHTTP","Microsoft.XMLHTTP"];
		for(var i=0; i<activeName.length; i++){
			try{
				xmlHttp2 = new ActiveXobject(activeName[i]);
				break;
			}
			catch(e){}
		}     
	}else{
		xmlHttp2=false;
	}
	return xmlHttp2;
}

function callback(){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){//获取服务器返回的数据//获取纯文本数据
			var result=xmlHttp.responseText;
			console.log(result);
			var json = eval("(" + result + ")");
			switch (json.action){
				case 'addart':
					prompt1(json.text);
					gb(json.id);
					if(typeof json.pathkey === "undefined"){}else{showFile(json.pathkey);}
					break;
				case 'showfile':
					xsbox(json.txt);
					break;
				case 'index':
				case 'delline':
				case 'showhide':
				case 'dellist':
				case 'draft':
				case 'release':
				case 'check':
				case 'settop':
				case 'movesort':
					ts(json.text);
					break;
				case 'sendid':
					setnewcode(60,json.text);
					break;
				default:break;
			}
		}
	}
}

function ts(str){
	hint=document.getElementById('hint');
	hint.innerHTML=str;
	hint.style.display="block";
	setTimeout("ts2(hint)",600);
}

function ts2(hint){
	location.reload();
}

function gb(id){
	aid=document.getElementById('aid');
	aid.value=id;
}

function xsbox(str){
	var imgbox=document.getElementById('imagebox');
	var imglist=document.getElementById('imagelist');
	imglist.innerHTML=str;
	imgbox.style.display='block';
}

function setnewcode(time,tstext){
	var key=time;
	var mailcode=document.getElementById('mailcode');
	if(tstext==''){
		mailcode.disabled=true;
		ddin=setInterval(function(){
			time--;
			if(time>0){
				mailcode.value = '等待 '+time+' 秒'
			}else{
				mailcode.value = '重新获取';
				mailcode.disabled=false;
				clearInterval(ddin);
			}
		},1000);
	}else{alert(tstext);}
}

function callback3(){
	if(xmlHttp.readyState == 4){
		if(xmlHttp.status == 200){//获取服务器返回的数据//获取纯文本数据
			var result=xmlHttp.responseText;
			//console.log(result);
			var json = eval("(" + result + ")");
			//console.log(json.text);
			switch (json.action){
				case 'upaid':
					xsbox(json.txt);
					break;
				case 'upfile':
					ts3(json.text);
					changepic(json.url[0]);
					break;
				default:break;
			}
		}
	}
}

function changepic(str){
	var userphoto=document.getElementById('userphoto');
	var userpic=document.getElementById('userpic');
	userphoto.src=str;
	userpic.value=str;
}
/**
function sendHttpGet(_url,_data=""){//get方法发送数据
	xmlHttp=createXmlHttp();
	if(!xmlHttp){
		alert("创建xmlhttprequest对象失败");
	}else{
		url=_url;
		url=url+"?"+_data;
		xmlHttp.onreadystatechange = callback2;
		xmlHttp.open("GET",url,true);
		xmlHttp.send(null);
	}
}


**/
