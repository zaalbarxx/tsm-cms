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
  font-family: Arial;
}
fieldset{
	margin-bottom: 30px;
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
#adminLoginForm{
  width: 330px;
  margin: auto;
  margin-bottom: 100px;
  margin-top: 30px;
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
h1{
  color: #454545;
  margin: 5px 5px 15px 5px;
  padding: 0px;
}
h2{
	color: #454545;
	
	 margin: 5px 5px 15px 0px;
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
#sideBar ul ul{
  margin: 0px;
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
#sideBar ul ul li a{
  padding-left: 50px;
  padding-right: 30px;
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
  display: inline-block;
}
label{
  width: 150px;
  display: inline-block;
  font-weight: bold;;
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
.bigItem{
  position: relative;
  display: block;
  width: 650px;
  padding: 20px;
  margin-left: 10px;
  background: #efefef; 
	background: linear-gradient(top, #efefef 0%, #bbbbbb 100%);  
	background: -moz-linear-gradient(top, #efefef 0%, #bbbbbb 100%); 
	background: -webkit-linear-gradient(top, #efefef 0%,#bbbbbb 100%);
  box-shadow: 0px 0px 4px rgba(0,0,0,0.8);
  border-radius: 5px;
  margin-bottom: 30px;
}
.bigItem .title{
  margin-left: 30px;
  width: 500px;
  display: inline-block;
  font-size: 18px;
  cursor: pointer;
  font-weight: bold;
}
.bigItem .buttons{
  float: right;
}
.bigItem .buttons a{
  position: relative;
  display: inline-block;
  width: 24px;
  height: 24px;
  margin-left: 10px;
 	background-repeat: no-repeat !important;
}
.bigItem .buttons a:hover{
  top: -2px;
}
.bigItem .buttons a:active{
  top: 0px;
}
.bigItem .buttons .reviewButton{
  background: url(../images/icons/linedpaper24.png);
}
.bigItem .buttons .editButton{
  background: url(../images/icons/pencil24.png);
}
.bigItem .buttons .deleteButton{
  background: url(../images/icons/stop24.png);
}
.button{
  position: relative;
  display: inline-block;
  width: 24px;
  height: 24px;
  background-repeat: no-repeat !important;
}
.deleteButton{
background: url(../images/icons/stop24.png);
}

.bigItem .itemDetails{
  padding: 30px;
  display: none;
  	overflow: auto;
  	width: 97%;
}
.divider{
	width: 100%; clear: both; border: 0px; border-bottom: 2px solid #777; padding-top: 20px; margin-bottom: 10px;
}
.itemDetails h3{
	text-align: center;
	color: #444;
  
}
.dataTable{
	width: 100%;
	border-spacing:0;
  border-collapse:collapse;
}
.dataTable tr td{
	padding: 7px;
	border-bottom: 1px solid #999;
}
.dataTable tr.header{
	font-weight: bold;
  font-size: 15px;
}
.dataTable td{
  font-size: 13px;
}
.dataTable tr td{
  font-size: 15px;
}
.med_button{
	display: inline-block;
	color: white;
	font-weight: 600;
	text-transform: uppercase;
	font-size: 13px;
	border-radius: 25px;
	text-decoration: none;
	padding: 8px 16px;
	text-shadow: -1px 1px 0px rgba(0, 0, 0, 0.6);
	background: #09F;
	background: -moz-linear-gradient(top, #8A6655 1%, #47352C 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,#09F), color-stop(100%,#47352C));
	background: -webkit-linear-gradient(top, #8A6655 1%,#47352C 100%);
	background: -o-linear-gradient(top, #8A6655 1%,#47352C 100%);
	background: -ms-linear-gradient(top, #8A6655 1%,#47352C 100%);
	background: linear-gradient(top, #8A6655 1%,#47352C 100%);
	-moz-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.4);
	-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.4);
	box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.4);
}
.right{
	float: right;
}
.small_button{
	display: inline-block;
	color: white;
	font-weight: 600;
	text-transform: uppercase;
	font-size: 12px;
	border-radius: 13px;
	text-decoration: none;
	padding: 5px 10px;
	text-shadow: -1px 1px 0px rgba(0, 0, 0, 0.6);
	background: #09F;
	background: -moz-linear-gradient(top, #8A6655 1%, #47352C 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,#09F), color-stop(100%,#47352C));
	background: -webkit-linear-gradient(top, #8A6655 1%,#47352C 100%);
	background: -o-linear-gradient(top, #8A6655 1%,#47352C 100%);
	background: -ms-linear-gradient(top, #8A6655 1%,#47352C 100%);
	background: linear-gradient(top, #8A6655 1%,#47352C 100%);
	-moz-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.4);
	-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.4);
	box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.4);
}
.med_button:hover, .small_button:hover {
	background: linear-gradient(top, #946D5A 1%,#785A4C 100%);
	background: -webkit-linear-gradient(top, #946D5A 1%,#785A4C 100%);
	background: -ms-linear-gradient(top, #946D5A 1%,#785A4C 100%);
	text-decoration: none;
}
.center{
	display: block;
	text-align: center;
}
.smallItem{
  position: relative;
  display: block;
  width: 650px;
  padding: 10px 20px;
  margin-left: 10px;
  background: #efefef; 
	background: linear-gradient(top, #efefef 0%, #bbbbbb 100%);  
	background: -moz-linear-gradient(top, #efefef 0%, #bbbbbb 100%); 
	background: -webkit-linear-gradient(top, #efefef 0%,#bbbbbb 100%);
  box-shadow: 0px 0px 4px rgba(0,0,0,0.8);
  border-radius: 5px;
  margin-bottom: 15px;
}
.smallItem .title{
  margin-left: 30px;
  width: 500px;
  display: inline-block;
  font-size: 18px;
  font-weight: bold;
}
.smallItem .buttons{
  margin-top: -2px;
  float: right;
}
.smallItem .buttons a{
  position: relative;
  display: inline-block;
  width: 24px;
  height: 24px;
  margin-left: 10px;
 	background-repeat: no-repeat !important;
}
.smallItem .buttons a:hover{
  top: -2px;
}
.smallItem .buttons a:active{
  top: 0px;
}
.smallItem .buttons .reviewButton{
  background: url(../images/icons/linedpaper24.png);
}
.smallItem .buttons .editButton{
  background: url(../images/icons/pencil24.png);
}
.smallItem .buttons .deleteButton{
  background: url(../images/icons/stop24.png);
}

.smallItem .itemDetails{
  padding: 30px;
  display: none;
}

.editButton{
  position: relative;
  display: inline-block;
  width: 32px;
  height: 32px;
  background: url(../images/icons/pencil32.png) no-repeat;
}
.addButton{
  position: relative;
  display: inline-block;
  margin-bottom:-3px;
  width: 32px;
  height: 32px;
  background: url(../images/icons/plus32.png) no-repeat;
}
.addButton24{
  position: relative;
  display: inline-block;
  margin-bottom:-3px;
  width: 24px;
  height: 24px;
  background: url(../images/icons/plus24.png) no-repeat;
}
.addButton:hover, .addButton24:hover{
  top: 3px;
}
.addButton:active, .addButton24:active{
  top: 5px;
}
.tooltip{
	cursor: pointer;
}
.infoSection{
	padding: 20px;
	border: 1px solid #777;
	-webkit-box-shadow: 0px 1px 8px rgba(0, 0, 0, 0.6);
	box-shadow: 0px 1px 8px rgba(0, 0, 0, 0.6);
	background: #eee;
	line-height: 1.3em;
	overflow: auto;
	margin-bottom: 30px;
}
.infoSection .title{
	font-weight: bold;
	color: #222;
	padding-right: 15px;
	width: 475px;
}
.label{
	font-weight: bold;
	margin-right: 10px;
	width: 140px;
	text-align: right;
	display: inline-block;
}
.one-third .label{
	width: 50px;
}
.infoSection .smallItem, .infoSection .bigItem{
	width: 90%;
}
.infoSection .itemDetails{
	padding: 10px;
}
.half{
	width: 46%;
	padding: 2%;
	float: left;
}
.two-thirds{
	width: 65%;
	padding: 1%;
	float: left;
}
.one-third{
	width: 31%;
	padding: 1%;
	float: left;
}
.three-fourths{
	width: 73%;
	padding: 2%;
	float: left;
}
.one-fourth{
	width: 18%;
	padding: 2%;
	float: left;
}
.periods{
	border: 1px solid #000;
	position: absolute;
	top: 100px;
	display: block;
	padding: 0px 20px 20px 20px;
	margin-left: auto;
	margin-right: auto;
	background: #EFEFEF;
	background: linear-gradient(top, #EFEFEF 0%, #BBB 100%);
	background: -moz-linear-gradient(top, #EFEFEF 0%, #BBB 100%);
	background: -webkit-linear-gradient(top, #EFEFEF 0%,#BBB 100%);
	box-shadow: 0px 0px 4px rgba(0, 0, 0, 0.8);
	border-radius: 5px;
	margin-bottom: 15px;
	z-index: 10;
}
#overlay{
	opacity : 0.4;
	position: absolute;
	top: 0;
	left: 0;
	background-color: black;
	width: 100%;
	z-index: 9;
}
<?php if($_GET['fb'] == "1"){ ?>
#topMenuWrapper{
  display:none;
}
#sideBar{
  display: none;
}
.contentWithSideBar{
  margin-left: 120px;
  width: 700px;
}
<?php } ?>