<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Page Not Found</title>
  <style type="text/css" media="screen">
    .owl {
  display: block;
  position: relative;
  width: 200px;
  height: 200px;
  margin: 100px auto 0;
  border-radius: 100px;
  -moz-border-radius: 100px;
  -webkit-border-radius: 100px;
  z-index: 10;
}

.ear {
  position: absolute;
  top: -21px;
  z-index: -1;
}

.ear.left {
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 0 0 50px 50px;
  border-color: transparent transparent #bbb6b0 transparent;
  left: 30px;
}

.ear.left:after {
  display: block;
  content: '';
  position: absolute;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 0 0 30px 30px;
  border-color: transparent transparent #655c5d transparent;
  left: -39px;
  top: 10px;
}

.ear.right {
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 50px 0 0 50px;
  border-color: transparent transparent transparent #bbb6b0;
  right: 30px;
}

.body {
  width: 200px;
  height: 200px;
  margin: 100px auto 0;
  border-radius: 100px;
  -moz-border-radius: 100px;
  -webkit-border-radius: 100px;
  background: #bbb6b0;
}

.beak {
  position: absolute;
  top: 100px;
  left: 40px;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 60px 60px 0 60px;
  border-color: #4d463e transparent transparent transparent;
}

.ear.right:after {
  display: block;
  content: '';
  position: absolute;
  width: 0;
  height: 0;
  border-style: solid;
  border-width: 30px 0 0 30px;
  border-color: transparent transparent transparent #655c5d;
  right: 11px;
  bottom: 10px;
}

.eye {
  position: absolute;
  width: 106px;
  height: 106px;
  background: #fff;
  biorder-radius: 53px;
  -moz-border-radius: 53px;
  -webkit-border-radius: 53px;
  top: 45px;
}

.eye:before {
  display: block;
  position: absolute;
  top: 0;
  left: 0;
  content: '';
  height:53px;
  width:106px;
  border-radius: 90px 90px 0 0;
  background:#655c5d;
  z-index: 10;
}

.eye:after {
  display: block;
  content: '';
  position: absolute;
  width: 40px;
  height: 40px;
  background: #4d463e;
  border-radius: 40px;
  -moz-border-radius: 40px;
  -webkit-border-radius: 40px;
  top: 46px;
  left: 43px;
  animation: eyeAni 1s ease-in-out infinite alternate;
}

.eye.left {
  left: -6px;
}

.eye.right {
  right: -6px;
}

.eyelash {
  position: absolute;
  height: 20px;
  width: 4px;
  background: #4d463e;
  z-index: 99;
  bottom: 53px;
  left: 10px;
}

.eyelash:before {
  display: block;
  position: absolute;
  content: '';
  height: 30px;
  width: 4px;
  background: #4d463e;
  z-index: 99;
  bottom: 0px;
  left: -10px;
}

.eyelash:after {
  display: block;
  position: absolute;
  content: '';
  height: 10px;
  width: 4px;
  background: #4d463e;
  z-index: 99;
  bottom: 0px;
  left: 10px;
}

.eye.right .eyelash {
  left: auto;
  right: 10px;
}
.eye.right .eyelash:before {
  height: 10px;
}
.eye.right .eyelash:after {
  height: 30px;
}

.claw {
  position: absolute;
  height: 30px;
  width: 4px;
  background: #4d463e;;
  bottom: -15px;
  z-index: -1;
}

.claw:before {
  display: block;
  position: absolute;
  left: 8px;
  content: '';
  height: 30px;
  width: 4px;
  background: #4d463e;
  transform:rotate(-25deg);
  -ms-transform:rotate(-25deg);
  -webkit-transform:rotate(-25deg);
}

.claw:after {
  display: block;
  position: absolute;
  left: -8px;
  content: '';
  height: 30px;
  width: 4px;
  background: #4d463e;
  transform:rotate(25deg);
  -ms-transform:rotate(25deg);
  -webkit-transform:rotate(25deg);
}

.claw.left {
  left: 65px;
}

.claw.right {
  right: 65px;
}
.owl {
  position: relative;
}
.lerge4 {
    font-size: 300px;
    display: inline-block;
    position: absolute;
    top: -89px;
    color: #bbb6b0;
}
.error-msg {
   font-size: 40px;
    text-align: center;
    margin-top: 70px;
}
.error-msg p{
  margin: 23px;
}
.error-msg a{
      font-size: 30px;
    color: #5D96EA;
    text-decoration: none;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
.error-msg a:hover {
  color: #3a77d0;
}

@keyframes eyeAni {
  0% {
    transform: none;
  }
  50% {
    transform: none;
  }
  75% {
    transform: translateX(-30px) rotate(-36deg);
  }
  100% {
    transform: translateX(-30px) rotate(-36deg);
  }
}
  </style>
</head>
<body>
  
  <div class='owl'>

    <div class="lerge4" style="left: -166px;">4</div>

  <div class='left ear'></div>
  <div class='right ear'></div>
  <div class='left claw'></div>
  <div class='right claw'></div>
  <div class='body'></div>
  <div class='beak'></div>
  <div class='left eye'>
    <div class='eyelash'></div>
  </div>
  <div class='right eye'>
    <div class='eyelash'></div>
  </div>

  <div class="lerge4" style="left: 226px;">4</div>

</div>
<div style="clear: both"></div>

<div class="error-msg">

 ARE YOU LOST?
<p>Do you want to go<a href="/"> Home page </a> ?</p>

</div>
</body>
</html>