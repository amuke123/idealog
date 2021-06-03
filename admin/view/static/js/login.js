// JavaScript Document

function yzRegister(){
	if(register.password.value!=register.password2.value){
		alert('两次密码不一样');
		register.password2.focus();
		return false;
	}
}

function yzReset(){
	if(reset.password.value!=reset.password2.value){
		alert('两次密码不一样');
		reset.password2.focus();
		return false;
	}
}