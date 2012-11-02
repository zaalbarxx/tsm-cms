<?php
header("Content-Type: text/css");
?>
@media screen and (max-device-width: 1200px){
  /*--- iPhone only CSS here ---*/
  body{
    width: 1220px;
  }
}
body{
  background: #ccc;
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
  margin-left: auto;
  margin-right: auto;
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
  box-shadow: 0px 0px 9px rgba(0,0,0,0.15);
}
#topMenu{
  width: 1000px;
  margin-left: auto;
  margin-right: auto;
  height: 50px;

}

#topMenu ul ul {
	display: none;
	width: 210px;
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
	color: #757575; text-decoration: none;
}		
		
#topMenu ul ul {
	background: #5f6975; border-radius: 0px; padding: 0;
	position: absolute; top: 100%;
}
#topMenu ul ul li {
	float: none; 
	border-top: 1px solid #6b727c;
	border-bottom: 1px solid #575f6a; position: relative;
}
#topMenu ul ul li a {
	padding: 15px 40px;
	color: #fff;
}	
#topMenu ul ul li a:hover {
	background: #4b545f;
}
		
#topMenu ul ul ul {
	position: absolute; left: 100%; top:0;
}