<?php
header("Content-Type: text/css");
?>
@media screen and (max-device-width: 1200px){
  /*--- iPhone only CSS here ---*/
  body{
    width: 1220px;
  }
}
a{
  color: #000;
}
a:hover{
  text-decoration: none;
}
body{
  background: #694E41;
  padding: 0px;
  margin: 0px;
}
#headerWrapper{
  width: 1000px;
  margin-left: auto;
  margin-right: auto;
}
#contentWrapper{
  width: 100%;
  top: 50px;
  position: absolute;
  z-index: 2;
}
#contentArea{
  width: 960px;
  background: #ddd;
  padding: 20px;
  padding-bottom: 0px;
  margin-left: auto;
  margin-right: auto;
  box-shadow: 0px 0px 29px rgba(0,0,0,1);
}
#contentArea h1{
  color: #454545;
  margin: 5px 5px 15px 5px;
  padding: 0px;
}
#topMenuWrapper{ 
  position: absolute;
  top: 0px;
  height: 50px;
  width: 100%;
  z-index: 3;
  background: #efefef; 
	background: linear-gradient(top, #efefef 0%, #bbbbbb 100%);  
	background: -moz-linear-gradient(top, #efefef 0%, #bbbbbb 100%); 
	background: -webkit-linear-gradient(top, #efefef 0%,#bbbbbb 100%);
  box-shadow: 0px 0px 9px rgba(0,0,0,1);
}
#topMenu{
  width: 1000px;
  margin-left: auto;
  margin-right: auto;
  height: 50px;
}

#topMenu ul ul {
	display: none;
	width: 250px;
}

#topMenu ul li:hover > ul {
	display: block;
}

#topMenu ul { 
	padding: 0 20px;
	border-radius: 0;  
	list-style: none;
	position: relative;
	display: inline-table;  
  top: -16px; 
}
#topMenu ul:after {
	content: ""; clear: both; display: block;
}

#topMenu ul li {
	float: left;
}
#topMenu ul li:hover {
	background: #4b545f;
	background: linear-gradient(top, #4f5964 0%, #5f6975 40%);
	background: -moz-linear-gradient(top, #4f5964 0%, #5f6975 40%);
	background: -webkit-linear-gradient(top, #4f5964 0%,#5f6975 40%);
}

#topMenu ul li:hover a {
	color: #fff;
}

#topMenu ul li a {
	display: block; padding: 15px 40px;
	color: #575757; text-decoration: none;
	font-weight: bold;
}		
		
#topMenu ul ul {
	background: #5f6975; border-radius: 0px; padding: 0;
	position: absolute; top: 100%;
	box-shadow: 5px 5px 9px rgba(0,0,0,.25);
}
#topMenu ul ul li {
	float: none; 
	border-top: 1px solid #6b727c;
	border-bottom: 1px solid #575f6a; position: relative;
}
#topMenu ul ul li a {
	padding: 15px 40px;
	color: #fff;
	font-weight: normal;
}	
#topMenu ul ul li a:hover {
	background: #4b545f;
}
		
#topMenu ul ul ul {
	position: absolute; left: 100%; top:10px; right: 10px;
}
#topMenu .logoutButton{
  position: relative;
  padding: 15px;
  color: #575757;
  font-weight: bold;
  float: right;
  text-decoration: none;
}
#topMenu .logoutButton:hover{
	background: #4b545f;
	background: linear-gradient(top, #4f5964 0%, #5f6975 40%);
	background: -moz-linear-gradient(top, #4f5964 0%, #5f6975 40%);
	background: -webkit-linear-gradient(top, #4f5964 0%,#5f6975 40%);
	color: white;
}
#sideBar{
  width: 210px;
  float: left;
  margin-left: -20px;
  margin-top: -20px;
  margin-right: 40px;
  background: #DDD; 
	background: linear-gradient(right, #DDD 0%, #bbbbbb 100%);  
	background: -moz-linear-gradient(right, #DDD 0%, #bbbbbb 100%); 
	background: -webkit-linear-gradient(right, #DDD 0%,#bbbbbb 100%);
}
#sideBar .active{
	background: #4b545f;
	background: linear-gradient(top, #4f5964 0%, #5f6975 40%);
	background: -moz-linear-gradient(top, #4f5964 0%, #5f6975 40%);
	background: -webkit-linear-gradient(top, #4f5964 0%,#5f6975 40%);
	color: #fff;
	border: 1px #ccc solid;
	border-left: 3px #ccc solid;
  width: 156px;
  height: 18px;
}
#sideBar ul, #sideBar li{
  list-style: none;
  margin: 0px;
  padding: 0px;
}
#sideBar ul{
  margin-top: 30px;
  margin-bottom: 30px;
}
#sideBar ul li a{
  display: block;
  width: 160px;
  height: 20px;
  padding: 15px 40px;
  text-decoration: none;
  color: #353535;
  font-weight: bold; 
}

#sideBar ul li a:hover{
	background: #4b545f;
	background: linear-gradient(top, #4f5964 0%, #5f6975 40%);
	background: -moz-linear-gradient(top, #4f5964 0%, #5f6975 40%);
	background: -webkit-linear-gradient(top, #4f5964 0%,#5f6975 40%);
	color: #fff;
	border-right: 1px solid #ccc;
	border-left: 3px #ccc solid;
	border-top: 1px solid transparent;
	border-bottom: 1px solid transparent;
	width: 156px;
	height: 18px;
}

.submitButton{
  border: 0px;
  padding: 10px;
  cursor: pointer;
  background: #efefef; 
	background: linear-gradient(top, #efefef 0%, #bbbbbb 100%);  
	background: -moz-linear-gradient(top, #efefef 0%, #bbbbbb 100%); 
	background: -webkit-linear-gradient(top, #efefef 0%,#bbbbbb 100%);
  box-shadow: 0px 0px 9px rgba(0,0,0,0.5);
  border-radius: 5px;
}

input{
  border: 0px;
  padding: 5px;
  float: right;
}

label{
  float: left;
  font-weight: bold;
  margin: 5px;
}

.errorMessage{
  color: red;
  text-align: center;
  font-weight: bold;
}
#footerWrapper{
  width: 980px;
  margin: auto;
  padding: 10px;
}
#footerContents{
  text-align: right;
  font-size: 12px;
}
.contentWithSideBar{
  margin-left: 240px;
}
.program{
  position: relative;
  display: block;
  width: 650px;
  padding: 20px;
  margin-left: 10px;
  background: #efefef; 
	background: linear-gradient(top, #efefef 0%, #bbbbbb 100%);  
	background: -moz-linear-gradient(top, #efefef 0%, #bbbbbb 100%); 
	background: -webkit-linear-gradient(top, #efefef 0%,#bbbbbb 100%);
  box-shadow: 0px 0px 9px rgba(0,0,0,0.5);
  border-radius: 5px;
  margin-bottom: 30px;
}
.program .title{
  margin-left: 30px;
  width: 500px;
  display: inline-block;
  font-size: 18px;
  cursor: pointer;
  font-weight: bold;
}
.program .buttons{
  float: right;
}
.program .buttons a{
  position: relative;
  display: inline-block;
  width: 24px;
  height: 24px;
  margin-left: 10px;
}
.program .buttons a:hover{
  top: -2px;
}
.program .buttons a:active{
  top: 0px;
}
.program .buttons .editButton{
  background: url(../images/icons/pencil24.png);
}
.program .buttons .deleteButton{
  background: url(../images/icons/stop24.png);
}

.program .programDetails{
  padding: 30px;
  display: none;
}
.addButton{
  position: relative;
  display: inline-block;
  margin-bottom:-3px;
  width: 32px;
  height: 32px;
  background: url(../images/icons/plus32.png);
}
.addButton:hover{
  top: -2px;
}
.addButton:active{
  top: 0px;
}