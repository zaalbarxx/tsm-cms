<?php
header("Content-Type: text/css");
?>
body{
margin: 0px;
padding: 0px;
background: #FAFAFA;
font-family: Georgia;
}
header, nav, section, article, aside, footer {
display:block;
}
a{
text-decoration: none;
color: #000;
}
a img{
border: none;
}
a:hover{
text-decoration: underline;
}
p{
margin: 0 0 1em 0;
font: Georgia;
}
h2 {
text-align: center;
font-family: Arial;
font-size: 2em;
font-style: normal;
font-variant: normal;
font-weight: normal;
line-height: normal;
color: #333232;
text-transform: uppercase;
padding: 40px 0 50px;
margin-bottom: 25px;
margin: 0px;
background: url("../images/d-heading-strong.gif") center bottom no-repeat;
border-top: 1px solid #E5E5E5;
}
.insideContent .headerImage {
width: 880px;
padding: 5px;
border: 1px solid #CCC;
margin-bottom: 30px;
margin-top: 20px;
}
#mainWrapper{
display: block;
width: 1280px;
margin: auto;
box-shadow: 0px 0px 9px rgba(0,0,0,1);
}
#navWrapper{
position: relative;
top: 0px;
margin: 0px;
padding: 0px;
width: 1280px;
height: 116px;
background: url('../images/header-BG.jpg');
}
#navLogo{
display: block;
position: relative;
left: 10px;
height: 116px;
width: 350px;
background: url('../images/reachout_logo_nav.png') no-repeat;
}
#topNav{
height: 116px;
width: 200px;
display: block;
position: relative;
top: -116px;
background: url('../images/header-divider.gif') repeat-y;
left: 370px;
z-index: 20;
padding-left: 30px;
font-family: Verdana, Arial;
font-size: 14px;
}
#topNav ul{
position: relative;
top: 30px;
margin: 0px;
padding: 0px;
list-style: none;
width: 850px;
}
#topNav ul li{
float: left;
}
#topNav ul li ul{
background: url('../images/dropdown-BG.png');
display: none;
width: 248px;
border: 1px solid #000;
float: none;
position: absolute;
top: 70px;
margin-left: -90px;
border-radius: 5px;
box-shadow: inset 0 1px rgba(255, 255, 255, 0.1), 0 1px 10px rgba(0, 0, 0, 0.5);
}
#topNav ul li ul li{
border-radius: 5px;
border-bottom: 1px solid #444;
border-top: 1px solid #666;
}
#topNav ul li ul li a:hover{
background: #303030;
}
#topNav ul li ul li a{
width: 213px;
background: none;
padding: 12px 18px;
position: static;
display: block;
height: auto;
text-align: left;
text-shadow: rgba(0, 0, 0, 0.75) 0px 1px 1px;
line-height: 24px;
border: 0;
}
#topNav ul li:hover ul{
display: block;
}
#topNav ul li:hover ul li ul{
display: none;
}
#topNav ul li:hover ul li:hover ul{
display: block;
}
#topNav ul li ul li ul{
left: 225px;
}
#topNav a:hover{
color: white;
}
#topNav a{
color: #E4E2E3;
padding: 4px 12px 2px;
position: relative;
top: 0px;
display: inline-block;
zoom: 1;
border: 1px solid transparent;
text-decoration: none;
text-transform: uppercase;
font-size: 1em;
padding: 20px 20px;
}
.playButton{
width:100%;
height:100%;
float:left;
cursor: pointer;
position:absolute;
top: 0px;
left: 0px;
background: url(/files/2/images/ROWW-PlayBTN-Link.png) no-repeat;
background-position:center;

}
.playButton:hover{
background: url(/files/2/images/ROWW-PlayBTN-Hover.png) no-repeat;
background-position:center;
}
.arrow{
background: url("../images/arrow.png") center 0 no-repeat;
position: relative;
top: -13px;
margin-bottom: -20px;
height: 20px;
left: 0px;
width: 100%;
height: 20px;
z-index: 10;
}

#sliderWrapper{
position: relative;
width: 1280px;
height: 586px;

}
#sliderContent{
width: 1280px;
height: 405px;
background: #ccc;
}
#sliderThumbs{
width: 1280px;
height: 181px;
background: url('../images/slider-thumb-BG.gif');
border-top: 1px #aaa solid;
border-bottom: 1px #ccc solid;
}

#contentWrapper{
background: #FFF;
width: 1280px;
min-height: 400px;
}
.slide{
height: 405px;
width: 100%;
background-position: center center;
position: absolute;
top: 0;
left: 0;
}
.inside{
width: 980px;
margin: 0 auto;
}
.home-section{
border-top: 1px solid #E5E5E5;
}
.thirds{
text-align: center;
margin: 40px 0;
}
.thirds p{
font: 16px/26px Georgia, serif;
color: #333232;
padding: 0 20px;
margin-bottom: 30px;
}
.thirds h3{
color: #434343;
font-size: 26px;
margin: 15px 0;
font-family: Arial;
}
.third{
width: 31%;
padding: 0;
margin: 10px 2% 10px 0;
float: left;
}
.half{
width: 48%;
padding: 0;
margin: 10px 2% 10px 0;
float: left;
}
.footerList{
margin-top: 40px;
list-style: none;
}
.footerList li{
margin-top: 10px;
list-style: none !important;
margin-left: 0px;
}
.footerList ul{
margin-left: none;
padding: 0px;
}
.home-our-mission .inside{
width: 780px;
margin: 0 auto;
}
p.large{
font: 300 22px/32px Georgia, serif;
text-align: center;
margin-bottom: 37px;
}
.slide .framed.video-box b.play-button {
background: url("/september/12/images/play-button-main.png") center top no-repeat;
display: block;
width: 136px;
height: 60px;
z-index: 1;
position: absolute;
top: 38%;
width: 100%;
}
.slide .inside .rightContainer{
margin-top: 20px;
display: block;
width: 375px;
float: left;
color: #fff;
text-align: center;
}
.slide{
background: #000;
}
.slide p{
font-size: 16px;
line-height: 23px;
color: white;
margin-bottom: 32px;
text-align: center;
}
.slide .framed.video-box {
display: block;
float: left;
margin-right: 30px;
margin-top: 30px;
position: relative;
overflow: hidden;
width: 541px;
height: 304px;
}
.framed {
padding: 4px;
background: white;
border: 1px solid #A9B0BB;
}
.slide .framed.video-box img, .slide .framed.video-box iframe {
display: block;
width: 100%;
border: 0px;
height: 100%;
}
.d-button {
width: auto;
padding: .5em 1.4em;
font-size: 15px;
font-weight: 600;
font-family: "Proxima-Nova-n6", "Proxima-Nova-1", "Proxima-Nova-2", sans-serif;
text-transform: uppercase;
color: white;
border: 0;
text-shadow: none;
-webkit-box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.5), 0 1px rgba(0, 0, 0, 0.2);
-moz-box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.5), 0 1px rgba(0, 0, 0, 0.2);
box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.5), 0 1px rgba(0, 0, 0, 0.2);
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
-ms-border-radius: 4px;
-o-border-radius: 4px;
border-radius: 4px;
-webkit-transition: 0.1s all linear;
-moz-transition: 0.1s all linear;
-ms-transition: 0.1s all linear;
-o-transition: 0.1s all linear;
transition: 0.1s all linear;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
-ms-border-radius: 4px;
-o-border-radius: 4px;
border-radius: 4px;
}
.d-button.blue{
background: #2E9DF7;
border: 1px solid #2B79B8;
}
.d-button.blue:hover{
background: #47A9F8;
}
.d-button.red{
background: #D13B49;
border: 1px solid #D4364D;
}
.d-button.red:hover{
background: #C42E3C;
}
.home-section .d-button{
padding: 1em 2em;
}
a:link {
-webkit-tap-highlight-color: #DF451B;
}
.slide .d-button {
padding: 1.2em 2.9em;
background: #D13B49;
border: 1px solid #D4364d;
}
.slide .d-button:hover {
background: #C42E3C;
}
#thumbs-pointer {
background: url("../images/slideshow-pointer.png") center center no-repeat;
width: 36px;
height: 17px;
display: block;
position: absolute;
top: 389px;
margin-left: 150px;
left: 0;
}
#sliderThumbs ul{
position: relative;
top: 15px;
list-style: none;
margin: 0px;
padding: 0px;
}

#sliderThumbs li{
background: #ccc;
display: inline-block;
list-style: none;
margin: 13px 5px 13px 10px;
text-align: center;
}

#sliderThumbs li a{
background: #ccc;
display: block;
list-style: none;
width: 175px;
height: 100px;
color: #747373;
text-decoration: none;
}

#sliderThumbs li a img{
display: block;
border: 4px solid white;
margin: 0 auto 10px;
-webkit-box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);
-moz-box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);
box-shadow: 0 0 1px rgba(0, 0, 0, 0.5);
}

#sliderThumbs li a:hover img{
border-color: #2E9DF7;
}
.footerTop{
background-color: #303030;
width: 100%;
/*height: 300px;*/
font-size: 14px;
line-height: 21px;
padding: 17px 0 14px 0;
text-transform: uppercase;
color: #929292;
}
.footerTop a{
color: #929292;
}
.footerTop li{
list-style: circle;
font-weight: bold;
}
.footerTop li ul li{
font-weight: normal;
}
.footerBottom{
background-color: #1A1A1A;
width: 1260px;
font-size: 13px;
padding: 9px 10px;
color: #636363;
}
#footer{
font-family: "Proxima-Nova-n6", "Proxima-Nova-1", "Proxima-Nova-2", sans-serif;
font-weight: 600;
position: relative;
}
br.clear {
clear: both;
display: block;
height: 1px;
margin: -1px 0 0 0;
}
.nos-container{
background: #F1F1F1 url("../images/nos-BG.gif");
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
-ms-border-radius: 4px;
-o-border-radius: 4px;
border-radius: 4px;
border: 1px solid #E9E9E9;
-webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
-moz-box-shadow: 0 1px 2px rgba(0,0,0,0.4);
box-shadow: 0 1px 2px rgba(0, 0, 0, 0.4);
margin-top: 45px;
}
.nos{
float: left;
text-align: center;
border-left: 1px solid white;
border-right: 1px solid #C1C1C1;
padding: 30px 0;
}
.nos.first{
border-left: none;
}
.nos.last{
border-right: none;
}
.no{
font: 70px/70px "League-Gothic-1","League-Gothic-2",sans-serif;
color: #303030;
}
.d-tooltip{
display: inline-block;
text-indent: -9999px;
width: 15px;
height: 15px;
background: url("../images/tooltip-question.png") center top no-repeat;
vertical-align: middle;
position: relative;
top: -1px;
margin-left: 2px;
}
#socialButtons a{
padding: 0px;
width: 30px;
height: 30px;
display: inline-block;
}
#socialButtons{
width: 180px;
height: 30px;
float: right;
margin-bottom: -50px;
position: absolute;
left: 710px;
padding: 10px;
z-index: 2;
}
.socialButton{
margin-left: 0px;
width: 30px;
height: 30px;
}
.socialButtons a{
padding: 0px;
width: 30px;
height: 30px;
display: inline-block;
}
#socialButtons .facebook, .socialButtons .facebook{
background: url("../images/facebook_icon.png");
}
#socialButtons .facebook:hover, .socialButtons .facebook:hover{
background: url("../images/facebook_icon_hover.png");
}
#socialButtons .twitter, .socialButtons .twitter{
background: url("../images/twitter_icon.png");
}
#socialButtons .twitter:hover, .socialButtons .twitter:hover{
background: url("../images/twitter_icon_hover.png");
}
#socialButtons .pinterest, .socialButtons .pinterest{
background: url("../images/pinterest_icon.png");
}
#socialButtons .pinterest:hover, .socialButtons .pinterest:hover{
background: url("../images/pinterest_icon_hover.png");
}
#socialButtons .youtube, .socialButtons .youtube{
background: url("../images/youtube_icon.png");
}
#socialButtons .youtube:hover, .socialButtons .youtube:hover{
background: url("../images/youtube_icon_hover.png");
}
#socialButtons .wordpress, .socialButtons .wordpress{
background: url("../images/wordpress_icon.png");
}
#socialButtons .wordpress:hover, .socialButtons .wordpress:hover{
background: url("../images/wordpress_icon_hover.png");
}




select, input, textarea {
margin: 0;
font-size: 100%;
vertical-align: baseline;
display: inline-block;
}

.label-placeholder {
position: relative;
height: 55px;
float: left;
overflow: hidden;
}

.signup form .label-placeholder {
height: 60px;
}

.label-placeholder input[type="text"], .label-placeholder input[type="email"], .label-placeholder label {
padding: 15px;
height: auto;
z-index: 2;
position: absolute;
top: 0;
left: 0;
text-align: left;
background: transparent;
border: 0;
margin: 0;
box-shadow: none;
-webkit-border-radius: 6px 0px 0px 6px;
-moz-border-radius: 6px 0px 0px 6px;
-ms-border-radius: 6px 0px 0px 6px;
-o-border-radius: 6px 0px 0px 6px;
border-radius: 6px 0px 0px 6px;
font: 200 22px "Proxima-Nova-n3","Proxima-Nova-1","Proxima-Nova-2",sans-serif;
color: black;
-webkit-box-sizing: border-box;
-moz-box-sizing: border-box;
box-sizing: border-box;
}

.label-placeholder label {
z-index: 0;
color: #C9C7C7;
}

.label-placeholder.email, .label-placeholder.email label, .label-placeholder.email input {
width: 335px;
}

.first-name, .last-name {
width: 150px;
}

.label-placeholder.first-name label, .label-placeholder.last-name label, .label-placeholder.first-name input, .label-placeholder.last-name input {
width: 150px;
border-right: 2px solid #F2F2F2;
}

.signup form{
position: relative;
top: -20px;
}

.success{
margin-left: auto;
margin-right: auto;
width: 265px;
font-size: 26px;
}

input, textarea {
outline-width: 0;
}

.signup form .d-button {
position: absolute;
top: 10px;
right: 10px;
font-size: 16px;
padding: 10px 20px;
cursor: pointer;
}


.signup form fieldset {
background: #F4F6F9;
border: 1px solid #BCC5D3;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
-ms-border-radius: 4px;
-o-border-radius: 4px;
border-radius: 4px;
padding: 0;
}

.signup input {
border-color: #BCC5D3;
border-width: 1px;
padding: 17px 15px;
}

.signup form .label-placeholder label, .signup form .label-placeholder input {
border-color: #BCC5D3;
border-width: 1px;
padding: 17px 15px;
}
#slide-1 .rightContainer{
padding-top: 40px;
}
#slide-1 h1{
top: 40px;
color: #222;
}
#slide-1 p{
color: #222;
}
.big_button {
color: white !important;
font-family: "Proxima-Nova-n6","Proxima-Nova-1","Proxima-Nova-2", sans-serif;
font-weight: 600;
text-transform: uppercase;
font-size: 14px;
border-radius: 25px;
text-decoration: none;
padding: 12px 24px;
display: block;
float: left;
clear: left;
text-shadow: -1px 1px 0px rgba(0, 0, 0, 0.6);
background: #E33242;
background: -moz-linear-gradient(top, #E33242 1%, #A82733 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(1%,#E33242), color-stop(100%,#A82733));
background: -webkit-linear-gradient(top, #E33242 1%,#A82733 100%);
background: -o-linear-gradient(top, #E33242 1%,#A82733 100%);
background: -ms-linear-gradient(top, #E33242 1%,#A82733 100%);
background: linear-gradient(top, #E33242 1%,#A82733 100%);
-moz-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.4);
-webkit-box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.4);
box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.4);
}
.big_button:hover {
background: linear-gradient(top, #D43140 1%,#A82531 100%);
background: -webkit-linear-gradient(top, #D43140 1%,#A82531 100%);
background: -ms-linear-gradient(top, #D43140 1%,#A82531 100%);
text-decoration: none;
}






/*FROM SECTIONPAGE.CSS */

body{
background: #2A2A2A
}
#insideBackground h2{
border: 0px;
margin-top: -30px;
}
.insideContent h2{
border: 0px;
margin-top: -30px;
}
.insideContent{
padding: 0 40px;
}
.subheader{
display: block;
height: 50px;
width: 1280px;
background: #000;
border-bottom: 1px solid #404F58;
position: absolute;
}
.subheader .nav{
width: 960px;
margin: 0 auto;
height: 20px;
text-align: center;
}
.subheader .nav ul{
padding: 15px;
margin: 0px;
}
.subheader .nav ul li {
display: inline-block;
text-transform: uppercase;
}
.subheader .nav li a {
color: #DBDBDB;
font: 13px/20px "Proxima-Nova-n6","Proxima-Nova-1","Proxima-Nova-2",sans-serif;
margin: 0;
padding: 0 15px;
}
.subheader .nav ul li::before {
content: '\2022';
color: #DBDBDB;
}
.subheader .nav ul li:first-child::before {
content: '';
}
.inner {
margin: 0px auto;
padding: 0px;
}
.inner .video{
margin-left: 70px;
float: left;
padding: 6px;
-moz-box-shadow: 0px 0px 3px #444;
-webkit-box-shadow: 0px 0px 3px #444;
box-shadow: 0px 0px 3px #444;
background: #FFF;
}
.inner img {
margin-left: 70px;
float: left;
padding: 6px;
-moz-box-shadow: 0px 0px 3px #444;
-webkit-box-shadow: 0px 0px 3px #444;
box-shadow: 0px 0px 3px #444;
background: #FFF;
}
.inner .right h3 {
width: 245px;
text-transform: uppercase;
font-size: 30px;
line-height: 30px;
margin: 45px auto 23px auto;
padding-bottom: 22px;
border-bottom: 1px solid rgba(0, 0, 0, 0.4);
}
.inner .right p {
width: 290px;
margin: 0px auto 28px auto;
font-size: 13px;
font-family: Arial, sans-serif;
color: #646464;
line-height: 18px;
}
.inner .right {
width: 410px;
float: left;
text-align: center;
background: url(../img/water_drop.png) no-repeat center top;
}
.inner .right .big_button {
margin-left: 135px;
}
.inner .right em {
clear: left;
float: left;
font-family: Georgia, serif;
font-style: italic;
color: #919191;
font-size: 12px;
margin-top: 20px;
margin-left: 108px;
width: 180px;
}
.white_box{
height: 502px;
}
.white_box .inner{
padding-top: 60px;
width: 971px;
height: 442px;
}
.grey_box{
height: 502px;
background: url(../images/grey-box.png) center top;
}
.grey_box .inner{
padding-top: 60px;
width: 971px;
height: 442px;
}
ul{
list-style: none;
}
li{
list-style: none;
}
#insideWrapper{
margin-top: 0px;
background: #000;
min-height: 200px;
padding-top: 30px;
padding-bottom: 30px;
}

#insideBackground{
background: #fff;
margin: auto;
width: 975px;
border-radius: 8px;
padding-top: 30px;
padding-bottom: 30px;
}