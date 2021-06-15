function sendMail(path){//获取邮箱验证码
	var ajcode=document.getElementById("ajcode").value;
	var sendid=document.getElementById("sendid").value;
	var dotype=document.getElementById("do").value;
	if(sendid==''){alert('请输入邮箱或手机号');return false;}
	var type='';
	var myreg=/^[1][3,4,5,6,7,8,9][0-9]{9}$/;
	var reg = /^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})$/;
	if(!myreg.test(sendid)){
		if(!reg.test(sendid)){alert("请输入正确的邮箱或手机号");return false;}else{type='email';}
	}else{type='tell';}
	
	url = path + 'include/action/sendCode.php';
	data="ajcode="+ajcode;
	data+="&sendid="+sendid;
	data+="&type="+type;
	data+="&do="+dotype;
	sendHttpPost(url,data);
}

function change_index(path,db=''){//改变顺序
	var indexs = document.getElementsByName("num[]");
	var ajcode=document.getElementById("ajcode").value;
	var arr1=new Array();
	var arr2=new Array();
	for(i=0;i<indexs.length;i++){
		arr1.push(indexs[i]['alt']);
		arr2.push(indexs[i]['value']);
	}
	if(arr1.length<1){
		alert('没有可操作的分类');
        return;
	}
	url = path + 'include/action/actiondo.php';
	data="ajcode="+ajcode;
	data+="&idexid="+arr1;
	data+="&idexval="+arr2;
	data+="&db="+db;
	sendHttpPost(url,data);
}

function change_index2(path,option=''){//改变顺序，配置
	var indexs = document.getElementsByName("num[]");
	var ajcode=document.getElementById("ajcode").value;
	var arr1=new Array();
	var arr2=new Array();
	for(i=0;i<indexs.length;i++){
		arr1.push(indexs[i]['alt']);
		arr2.push(indexs[i]['value']);
	}
	if(arr1.length<1){
		alert('没有可操作的分类');
        return;
	}
	url = path + 'include/action/actiondo.php';
	data="ajcode="+ajcode;
	data+="&idexid2="+arr1;
	data+="&idexval="+arr2;
	data+="&option="+option;
	sendHttpPost(url,data);
}

function delLine(sid,path,db=''){//删除一条数据
	if(confirm('确定删除?')){
		var ajcode=document.getElementById("ajcode").value;
		url = path + 'include/action/actiondo.php';
		data="ajcode="+ajcode;
		data+="&delline="+sid;
		data+="&db="+db;
		sendHttpPost(url,data);
	}
}

function delLine2(sid,path,option=''){//删除一条数据2
	if(confirm('确定删除?')){
		var ajcode=document.getElementById("ajcode").value;
		url = path + 'include/action/actiondo.php';
		data="ajcode="+ajcode;
		data+="&delline2="+sid;
		data+="&option="+option;
		sendHttpPost(url,data);
	}
}

function showOrHide(sid,path,key,db='',aid=''){//显示和隐藏
	var ajcode=document.getElementById("ajcode").value;
	url = path + 'include/action/actiondo.php';
	data="ajcode="+ajcode;
	data+="&showhide="+sid;
	data+="&key="+key;
	data+="&db="+db;
	data+="&aid="+aid;
	sendHttpPost(url,data);
}

function showOrHide2(sid,path,key,option=''){//显示和隐藏2
	var ajcode=document.getElementById("ajcode").value;
	url = path + 'include/action/actiondo.php';
	data="ajcode="+ajcode;
	data+="&showhide2="+sid;
	data+="&key="+key;
	data+="&option="+option;
	sendHttpPost(url,data);
}

function autoSave(path,pathkey='0'){//自动保存
	var tp=document.getElementById("arttype").value;
	if(tp=='a'){
		var ajcode=document.getElementById("ajcode").value;
		url = path + 'include/action/actiondo.php';
		var artarr='';
		artarr="id="+add_art.id.value;
		artarr+="&type="+add_art.arttype.value;
		artarr+="&template=";
		artarr+="&title="+add_art.title.value;
		artarr+="&content="+add_art.content.value;
		artarr+="&getsite="+add_art.getsite.value;
		artarr+="&geturl="+add_art.geturl.value;
		var copyr=add_art.copyrights.checked==false?'1':'0';
		artarr+="&copyrights="+copyr;
		artarr+="&pic="+add_art.pic.value;
		artarr+="&excerpt="+add_art.excerpt.value;
		artarr+="&saynum="+add_art.saynum.value;
		artarr+="&filenum="+add_art.filenum.value;
		
		artarr+="&s_id="+add_art.sort.value;
		artarr+="&tags="+add_art.tags.value;
		artarr+="&date="+add_art.date.value;
		artarr+="&alias="+add_art.alias.value;
		artarr+="&key="+add_art.key.value;
		artarr+="&password="+add_art.password.value;
		artarr+="&eyes="+add_art.eyes.value;
		artarr+="&goodnum="+add_art.goodnum.value;
		artarr+="&badnum="+add_art.badnum.value;
		sayoks = add_art.sayok.checked==false?'0':'1';
		artarr+="&sayok="+sayoks;

		marktop = add_art.marktop.checked==false?'0':'1';
		marksorttop = add_art.marksorttop.checked==false?'0':'1';
		var mark="";
		if(marktop=='1'){
			mark+='T';
			if(marksorttop=='1'){mark+=',ST';}
		}else{
			if(marksorttop=='1'){mark+='ST';}
		}
		artarr+="&mark="+mark;
		artarr+="&addart=1";
		artarr+="&pathkey="+pathkey;
		//console.log(artarr);
		sendHttpPost(url,artarr);
	}else{
		autoSave2(path,pathkey);
	}
}

function autoSave2(path,pathkey='0'){//自动保存page
	var ajcode=document.getElementById("ajcode").value;
	url = path + 'include/action/actiondo.php';
	var artarr='';
	artarr="id="+add_page.id.value;
	artarr+="&type="+add_page.arttype.value;
	artarr+="&template="+add_page.template.value;
	artarr+="&title="+add_page.title.value;
	artarr+="&content="+add_page.content.value;
	artarr+="&getsite=";
	artarr+="&geturl=";
	artarr+="&copyrights=0";
	artarr+="&pic=";
	artarr+="&excerpt=";
	artarr+="&saynum="+add_page.saynum.value;
	artarr+="&filenum="+add_page.filenum.value;
	
	artarr+="&s_id=0";
	artarr+="&tags=";
	artarr+="&date=";
	artarr+="&alias="+add_page.alias.value;
	artarr+="&key="+add_page.key.value;
	artarr+="&password=";
	artarr+="&eyes=0";
	artarr+="&goodnum=0";
	artarr+="&badnum=0";
	sayoks = add_page.sayok.checked==false?'0':'1';
	artarr+="&sayok="+sayoks;

	artarr+="&mark=";
	artarr+="&addart=1";
	artarr+="&pathkey="+pathkey;
	//console.log(artarr);
	sendHttpPost(url,artarr);

}

function showFile(path){//显示文章的图片附件
	aid=document.getElementById("aid").value;
	var ajcode=document.getElementById("ajcode").value;
	url = path + 'include/action/actiondo.php';
	data="ajcode="+ajcode;
	data+="&showfile="+aid;
	data+="&db=file";
	sendHttpPost(url,data);
}

function upFileFc2(path,zdy){//上传文件
	var ajcode=document.getElementById("ajcode").value;
	var aid=document.getElementById("aid").value;
	url = path+'include/action/actiondo.php';
	fileObj=document.getElementById(zdy).files;
	var data=new FormData();
	if(fileObj.length > 0){
		for(i=0;i<fileObj.length;i++){
			data.append("file["+i+"]",fileObj[i]);
		}
	}
	data.append("ajcode",ajcode);
	data.append("upaid",aid);
	data.append("type",'image');
	sendHttpUp2(url,data);
}

function delList(path,db=''){//删除批量数据
	var artcks = document.getElementsByName("artck[]");
	var ajcode=document.getElementById("ajcode").value;
	var arr=new Array();
	for(i=0;i<artcks.length;i++){
		if(artcks[i]['checked']==true){
			arr.push(artcks[i]['value']);
		}
	}
	if(arr.length<1){
		alert('没有选择任何可操作的对象');return;
	}
	if(confirm('确定删除?')){
		url = path + 'include/action/actiondo.php';
		data = "list="+arr;
		data += "&ajcode="+ajcode;
		data += "&db="+db;
		data += "&dellist=1";
		//console.log(data);
		sendHttpPost(url,data);
	}
}

function setDraft(path,db=''){//放入草稿箱
	var artcks = document.getElementsByName("artck[]");
	var ajcode=document.getElementById("ajcode").value;
	var arr=new Array();
	for(i=0;i<artcks.length;i++){
		if(artcks[i]['checked']==true){
			arr.push(artcks[i]['value']);
		}
	}
	if(arr.length<1){
		alert('没有选择任何可操作的对象');return;
	}
	url = path + 'include/action/actiondo.php';
	data = "list="+arr;
	data+="&ajcode="+ajcode;
	data+="&draft=0";
	data+="&db="+db;
	sendHttpPost(url,data);
}

function release(path,db=''){//笔记发布
	var artcks = document.getElementsByName("artck[]");
	var ajcode=document.getElementById("ajcode").value;
	var arr=new Array();
	for(i=0;i<artcks.length;i++){
		if(artcks[i]['checked']==true){
			arr.push(artcks[i]['value']);
		}
	}
	if(arr.length<1){
		alert('没有选择任何可操作的对象');return;
	}
	url = path + 'include/action/actiondo.php';
	data = "list="+arr;
	data+="&ajcode="+ajcode;
	data+="&release=1";
	data+="&db="+db;
	sendHttpPost(url,data);
}

function examine(path,db=''){//审核
	var artcks = document.getElementsByName("artck[]");
	var ajcode=document.getElementById("ajcode").value;
	var arr=new Array();
	for(i=0;i<artcks.length;i++){
		if(artcks[i]['checked']==true){
			arr.push(artcks[i]['value']);
		}
	}
	if(arr.length<1){
		alert('没有选择任何可操作的对象');return;
	}
	url = path + 'include/action/actiondo.php';
	data = "list="+arr;
	data+="&ajcode="+ajcode;
	data+="&check=1";
	data+="&db="+db;
	sendHttpPost(url,data);
}


function moveSort(el,path){//更改分类
	var artcks = document.getElementsByName("artck[]");
	var ajcode=document.getElementById("ajcode").value;
	var arr=new Array();
	for(i=0;i<artcks.length;i++){
		if(artcks[i]['checked']==true){
			arr.push(artcks[i]['value']);
		}
	}
	if(arr.length<1){
		alert('没有选择任何可操作的对象');location.reload();return;
	}
	if(el.options[el.selectedIndex].value==''){return;}
	if(confirm('确定操作?')){
		url = path + 'include/action/actiondo.php';
		data = "list="+arr;
		data+="&ajcode="+ajcode;
		data+="&move="+el.options[el.selectedIndex].value;
		sendHttpPost(url,data);
	}
}

function setTop(el,path){//设置置顶
	var artcks = document.getElementsByName("artck[]");
	var ajcode=document.getElementById("ajcode").value;
	var arr=new Array();
	for(i=0;i<artcks.length;i++){
		if(artcks[i]['checked']==true){
			arr.push(artcks[i]['value']);
		}
	}
	if(arr.length<1){
		alert('没有选择任何可操作的对象');location.reload();
        return;
	}
	if(el.options[el.selectedIndex].value==''){return;}
	url = path + 'include/action/actiondo.php';
	data = "list="+arr;
	data+="&ajcode="+ajcode;
	data+="&top="+el.options[el.selectedIndex].value;
	sendHttpPost(url,data);
}

/**


function delSay(path){//删除评论
	var artcks = document.getElementsByName("artck[]");
	var ajcode=document.getElementById("ajcode").value;
	var arr=new Array();
	for(i=0;i<artcks.length;i++){
		if(artcks[i]['checked']==true){
			arr.push(artcks[i]['value']);
		}
	}
	if(arr.length<1){
		alert('请选择要操作的评论');
		return;
	}
	if(confirm('确定删除?')){
		url = path + 'include/action/actiondo.php';
		data = "list="+arr;
		data+="&ajcode="+ajcode;
		data+="&delsay=del";
		data+="&path="+path+"include/action/";
		//console.log(data);
		sendHttpPost(url,data);
	}
}

function setSayCheck(path){//评论审核
	var artcks = document.getElementsByName("artck[]");
	var ajcode=document.getElementById("ajcode").value;
	var arr=new Array();
	for(i=0;i<artcks.length;i++){
		if(artcks[i]['checked']==true){
			arr.push(artcks[i]['value']);
		}
	}
	if(arr.length<1){
		alert('请选择要操作的评论');
		return;
	}
	if(confirm('确定选中项通过审核?')){
		url = path + 'include/action/actiondo.php';
		data = "list="+arr;
		data+="&ajcode="+ajcode;
		data+="&checksay=1";
		data+="&path="+path+"include/action/";
		//console.log(data);
		sendHttpPost(url,data);
	}
}

//template
function usertem(tem,path){//更换模板
	var ajcode=document.getElementById("ajcode").value;
	url = path + 'include/action/action.php';
	data="ajcode="+ajcode;
	data+="&usertem="+tem;
	data+="&db=template";
	sendHttpPost(url,data);
}

//template
function deltem(tem,path){//删除模板
	if(confirm('你确定要删除该模板吗?')){
		var ajcode=document.getElementById("ajcode").value;
		url = path + 'include/action/action.php';
		data="ajcode="+ajcode;
		data+="&deltem="+tem;
		data+="&db=template";
		sendHttpPost(url,data);
	}
}

function setSayGood(path,good){//加精和神评
	var artcks = document.getElementsByName("artck[]");
	var ajcode=document.getElementById("ajcode").value;
	var arr=new Array();
	for(i=0;i<artcks.length;i++){
		if(artcks[i]['checked']==true){
			arr.push(artcks[i]['value']);
		}
	}
	if(arr.length<1){
		alert('请选择要操作的评论');
		return;
	}
	if(confirm('确定当前操作?')){
		url = path + 'include/action/actiondo.php';
		data = "list="+arr;
		data+="&ajcode="+ajcode;
		data+="&goodsay="+good;
		data+="&path="+path+"include/action/";
		sendHttpPost(url,data);
	}
}

function delphoto(path,uid){//删除头像
	var ajcode=document.getElementById("ajcode").value;
	var userpic=document.getElementById("userpic").value;
	
	if(confirm('确定删除?')){
		url = path+'include/action/actiondo.php';
		data="ajcode="+ajcode;
		data+="&userpic="+userpic;
		data+="&uid="+uid;
		sendHttpPost(url,data);
	}
}

function upfile(path,avatar){//上传文件
	url = path+'include/action/actiondo.php';
	ajcode=document.getElementById("ajcode").value;
	fileObj=document.getElementById("myfile").files;
	var data=new FormData();
	if(fileObj.length > 0){
		for(i=0;i<fileObj.length;i++){
			data.append("file["+i+"]",fileObj[i]);
		}
	}
	data.append("upfile",avatar);
	data.append("ajcode",ajcode);
	sendHttpUp2(url,data);
}










**/