<!DOCTYPE html>
<html>
<head>
	  <title>This_is_homepage</title>
	  <style type="text/css">
        body{padding: 0; margin: 0; background-color: #FF7357;}
      	div#full{position: absolute; height: 150%;  width: 100%;  z-index: -1; padding: 0; margin: 0}
        div#up{position: relative; float: left;  width: 100%; }
        div#down{position: relative; width: 100%; height: 90%;  z-index: -1}
      	div#website_name{position: relative;  float: left; width: 35%;  background-color: #FF7357; color: yellow;  padding: .5% 0%; padding-left: 15%;  font-size: 3vw; animation-name: l; animation-duration: 2s}
      	@keyframes l{from{top: -200%} to {top: 0%}}
      	div#up_right_side{position: relative; float: left; width: 50%;  background-color: #FF7357 ;  animation-name: k; animation-duration: 2s}
      	@keyframes k{from{top: 200%} to {top: 0%}}
      	div#navbar{position: relative; float: left; width: 100%;  background-color: black; overflow: auto; }
      	ul{padding: 0; margin: 0; list-style: none;}
      	li.nav{float: left; }
      	a#link{display: block; text-decoration: none; padding: 5px 20px;  font-size: 1.25em; color: white;}
      	a#link:hover{background-color: #2FD067}
      	img#name{ 
      		  width: 10%;
            height: 100%;
            border-radius: 50%;
            left: 14%;
            top: 1%;
            overflow: hidden;
            position: absolute;
        }
        img#up_right_sie_image{
            margin-top: 0%;
            margin-left: 5%;
        	  width: 10%;
            height: 130%;
            top: 0%;
            overflow: hidden;
            position: absolute;
        }
        .a{position: relative; color: white; padding-left: 18%; font-size: 1.5vw }
        div#slider{ position: relative; float: left; height: 40%; width: 50%; background-color: black; z-index: -1 }
        .slide{height: 100%; width: 100%; animation-name: fade; animation-duration: 1.5s;  }
        @keyframes fade{from{opacity: 0.4} to {opacity: 1}}
        div#description{position: relative; background-color: #4475CD; float: left; height: 40%; width: 50%; z-index: -1; text-align: center; overflow:auto; }
        .signup{height: 13%; width: 24% ;  background-color: #4475CD; border:2px solid white; color:white; font-size: 1.5vw; }
        .signup:hover{background-color: #2FD067; border: 2px solid  #2FD067; cursor: pointer; border: 2px solid white }
        div#left_down{position: relative; height: 47%;   float: left; margin-top: 5%; margin-left: 5%;  width: 40%; z-index: -1; overflow: auto; }
      	div#middle{position: relative; height: 47%;  float: left; margin-top: 2%; left: 7%; width: 40%; z-index: -1 ; overflow: auto;}
      	.link{text-decoration: none}
      	div#footer{position: relative; float: left; width: 100%; bottom: 0; background-color: #2D2D2D; color: white}
      	div#term{float: left; height: 30%; width:50%; margin-top: 1% }
      	div#photo{ float: right; width: 10%; margin-top: 2%  }
        a{cursor: pointer;}
    
    </style>
</head>
<body>
  	<div id="full">
        <div id="up">
      	  	<div id="website_name">
        	    	<img id="name" src="small_image/nameicon.jpeg">
          			<font>GaMe_oF_QuIz</font> 
      	  	</div>
      	  	
            <div id="up_right_side">
                <img id="up_right_sie_image" src="small_image/sideicon.png">
                <font class="a" style="">Online quiz exam<br></font>
                <font class="a">check up your knowledge.</font> 
            </div>
      	  	<div id="navbar">
        	  		<ul>
          		  		<li class="nav"><a id="link" href="#term">Term & conditions</a></li>
          		  	  <li class="nav"><a id="link" href="signup_teacher.php">Signup-Teacher</a></li>
                    <li class="nav"><a id="link" href="signup_student.php">Signup-Student</a></li>
                    <li class="nav" style="float: right; margin-right: 5%;"><a id="link" href="login_&_Signup.php">Login</a></li>
        	  		</ul>
      	  	</div>
        </div>
      	<div id="down">  	
            <div id="slider">
        		  	<img class="slide" src="page_image/1.jpeg">
        		  	<img class="slide" src="page_image/2.jpeg">
        		  	<img class="slide" src="page_image/3.jpeg">
        		  	<img class="slide" src="page_image/4.jpeg">
      	  	</div>
      	  	<div id="description"><br><br><br>
      	  		  <font size="10px" color="white" style="">Create new account </font><br><br>
                <input type="button" class="signup" name="signup" value="As a Teacher" onclick="location.href='signup_teacher.php';"><br><br>
                <input type="button" class="signup" name="signup" value="As a Student" onclick="location.href='signup_student.php';"><br><br>
                <font size="5px" color="white " style=""> Please read the description.</font>
      	  	</div>
      	  	<div id="left_down">
                <font size="4px">Wellcome to</font><br>
                <font size="5px" color="black" style="font-weight: bold;"> GaMe_oF_QuIz.</font><br>
                This is a quiz exam web application. Here user can create account as a teacher or as a student. A user will enjoy different type of quiz/mcq related facilities here. Facilities of teacher/student is given beside differently. Hope users will enjoy this application.
            </div>
            <div id="middle">
            		<font size="5px" style="font-weight: bold;">Facilities</font><br><br>
                <font size="4px" style="font-weight: bold;">For Teacher :</font><br>
                <ul style="list-style-type: disc;">
                    <li>Can add subject in own page by own choice. </li>
                    <li>Createing own question bank of many different subjects.</li>
                    <li>Create exam for students</li>
                    <li>Teachers will able to prepare question for exam in 3 ways</li>
                        <ol>
                            <li>Create new questions for exam.</li>
                            <li>Random question selection from own question bank</li>
                            <li>Select question from own question bank.</li>
                        </ol>
                    <li>Exam taking is secure because no student will able to give a particular exam twice.</li>    
                    <li>Selected exams marks of all students whose are participate in that exam will see in here.</li>
                    <li>Teachers can see their running exam in own page.</li>    
                </ul><br>
                <font size="4px" style="font-weight: bold;">For Student :</font><br>
                <ul style="list-style-type: disc;">
                    <li>Can add subject in own page by own choice.</li>
                    <li>Give exam which are arranged by teachers.</li>
                    <li>Selected exams mark can see from own page.</li>
                    <li>Create own exam to test knowledge.</li>
                    <li>Can read many question of different subject</li>
                </ul>
            </div> 
            
        </div> 
        <div id="footer">
                <div id="term">
                    <font size="4em"; style=" margin-left: 5%;  "><a name="term"> Terms & Conditions </a></font><br>
                    <ul style="margin-left: 7%;list-style:disc;" >
                        <li> Your personal data must be correct. </li>
                        <li>As a teacher if you share question for all, that must be valid.</li>
                    </ul>
                </div>
                <div id="photo">
                    Developed by<br>Arun kundu<br>CSE,RUET
                </div>    
            </div>
  	</div>



    <script type="text/javascript">
      var myindex = 0;
      carousel();

      function carousel(){
          var i;
          var x = document.getElementsByClassName("slide");
          for(i=0; i<x.length; i++){
              x[i].style.display = "none";
          }
          myindex++;
          if(myindex>x.length){myindex=1}
              x[myindex-1].style.display = "block";
          setTimeout(carousel, 2000);
      }
    </script>
</body>
</html>