// JavaScript Document

function show(el){
	var pro=el.getElementsByTagName('i')[1];
	var par=el.parentNode;
	pro.className=par.className==''?'icon2 aicon-fold2':'icon2 aicon-fold';
	par.className=par.className==''?'active':'';
}

function hide(){
	var side=document.getElementById('side');
	var head=document.getElementById('head');
	var main=document.getElementById('main');
	side.className=side.className=='side'?'side sidehide':'side';
	head.className=side.className=='side'?'head':'head leftall';
	main.className=side.className=='side'?'main':'main leftall';
}

function autoShow(post,list=''){
	var nav = document.getElementById('nav_'+post);
	nav.parentElement.className = list==''?'action':'active';
	if(list!=''){
		var num = nav.childElementCount-1;
		nav.children[num].className = 'icon2 aicon-fold2';
		document.getElementById('nav_'+list).parentElement.className = 'action';
	}
}

function showurl(key){
	var ycxz = document.getElementById('ycxz');
	var geturl = document.getElementById('geturl');
	if(key==1){ycxz.style.display="inline-block";geturl.style.display="none";}
	if(key==2){ycxz.style.display="none";geturl.style.display="inline-block";}
}

function show_add(box){
	var add = document.getElementById(box);
	add.style.display = add.style.display != 'block' ? 'block' : 'none' ;
}

function checked(e){
	e.className = e.className!='ok'?'ok':'';
	e.getElementsByTagName('input')[0].checked = e.className!='ok'?false:true;
}

function all_checked(boxid){
	var box = document.getElementById(boxid);
	var plist=box.getElementsByTagName('p');
	for(i=0,len=plist.length;i<len;i++){
		checked(plist[i]);
	}
}


function tags_ck(boxid){
	var box = document.getElementById(boxid);
	var plist=box.getElementsByTagName('p');
	for(i=0,len=plist.length;i<len;i++){
		plist[i].getElementsByTagName('input')[0].checked = plist[i].className!='ok'?false:true;
	}
}

function sub(formid,boxid){
	if(confirm('确定删除?')){
		tags_ck(boxid);
		formid.submit();
	}
}

function showTags(box){
	var m_tags = document.getElementById(box);
	m_tags.style.display = m_tags.style.display!="block"?'block':'none';
}

function addTags(el){
	var tags = document.getElementById('tags');
	tags.value = tags.value!=""? tags.value+','+el : el;
}

function fb_art(formid){
	var fb=document.getElementById('fb');
	fb.value='';
	formid.submit();
}

function ycbox(){
	var imgbox=document.getElementById('imagebox');
	imgbox.style.display='none';
}

function setImages(path,pathsite){
	var m_pic = document.getElementById('m_pic');
	var pic = document.getElementById('pic');
	m_pic.innerHTML='<img src="'+path+'" /><a href="'+path+'" title="点击查看原图" target="_blank">查看原图</a><a href="javascript:autoSave(\''+pathsite+'\',\'1\');" title="点击更改图片">更改图片</a>';
	pic.value=path;
	ycbox();
}

function jumpMenu(targ,selObj,restore){ //v3.0
	eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	if (restore) selObj.selectedIndex=0;
}

function allSelect(el){
	var artcks = document.getElementsByName("artck[]");
	var allsele=document.getElementById(el);
	if(allsele.innerText=='全选'){
		for(i=0;i<artcks.length;i++){
			artcks[i]['checked']=true;
		}
		allsele.innerText='取消选择';
	}else{
		for(i=0;i<artcks.length;i++){
			artcks[i]['checked']=false;
		}
		allsele.innerText='全选';
	}
}


function navbh(el){
	var navlist = document.getElementById('addk').getElementsByTagName('li');
	for(i=0;i<navlist.length;i++){
		if(el==(i+1)){
			navlist[i].className='active2';
			document.getElementById('nav' + (i+1)).style.display = 'block';
		}else{
			navlist[i].className='';
			document.getElementById('nav' + (i+1)).style.display = 'none';
		}
	}
}

function anavshow(el){
	var addnav = document.getElementById('addnav');
	if(el=='0'){
		addnav.style.display="none";
	}else{
		addnav.style.display="block";
	}
}

function deluser(url){
	if(confirm('确定删除?')){
		location.href=url;
	}
}

function changeSet(num){//设置选项卡切换
	var idn="cont"+num;
	var evul=document.getElementById('navlist');
	var evli=evul.getElementsByTagName("li");
	log=evli.length;
	for(i=0;i<log;){
		evli[i].className="";i++;
		document.getElementById('cont'+i).style.display="none";
	}
	evli[num-1].className="active";
	document.getElementById(idn).style.display="block";
}

function yzNavAdd(){
	if(navadddiy.name.value==""){
		prompt1('导航名称不能为空');
		navadddiy.name.focus();
		return false;
	}
	if(navadddiy.url.value==""){
		prompt1('链接不能为空');
		navadddiy.url.focus();
		return false;
	}
}
function yzNavAdd2(){
	var sck = document.getElementsByName("sck[]");
	var arr1=new Array();
	for(i=0;i<sck.length;i++){
		if(sck[i]['checked']==true){
			arr1.push(sck[i]['value']);
		}
	}
	if(arr1.length<1){
		prompt1('请选择添加到导航的分类');
		return false;
	}
}
function yzNavAdd3(){
	var pck = document.getElementsByName("pck[]");
	var arr1=new Array();
	for(i=0;i<pck.length;i++){
		if(pck[i]['checked']==true){
			arr1.push(pck[i]['value']);
		}
	}
	if(arr1.length<1){
		prompt1('请选择添加到导航的单页');
		return false;
	}
}

function yzBannAdd2(){
	if(bannadd.pic2.value==""){
		if(bannadd.pic.value==""){
			prompt1('请选择图片');
			bannadd.pic.focus();
			return false;
		}
	}
}
function yzBannAdd(){
	if(bannadd.pic.value==""){
		prompt1('请选择图片');
		bannadd.pic.focus();
		return false;
	}
}

function yzUserAdd(){
	if(useradd.username.value==""){
		prompt1('请输入登录名');
		useradd.username.focus();
		return false;
	}
	if(useradd.password1.value!=""){
		if(useradd.password1.value!=useradd.password2.value){
			prompt1('确认密码与密码不一致');
			useradd.password2.focus();
			return false;
		}
	}
}

function prompt1(str){
	hint=document.getElementById('hint');
	hint.innerHTML=str;
	hint.style.display="block";
	setTimeout("prompt2(hint)",3000);
}
function prompt2(hint){
	hint.style.display="none";
}