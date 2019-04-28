<?php include 'database.php' ; ?>
<?php 
    session_start();
    $t_name = $_SESSION['Username'];
    $pass = $_SESSION['Password'];

    if (!isset($t_name) || !isset($pass))
        header("Location: login_&_Signup.php");

    $sql = "SELECT * FROM teacher where username = '".$t_name."' AND password ='".$pass."' ";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) == 0) {
        header("location:login_&_Signup.php");
    }

    $subject=isset($_POST['sub']) ? $_POST["sub"] : "";
    $value=0;
    $value1=0;

    //add subject.....................
    if(isset($_POST["add"])){
       
        $query = "SELECT subject FROM " . $t_name . "_subject Where subject = '" . $subject ."' ";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1){
          $value = 1;
        }
        else{  $value = 0; }
        
        if($value == 0){
            $query1 = "INSERT INTO " . $t_name . "_subject(subject) VALUES ('$subject')";
            mysqli_query($connection , $query1);
       }
       
    }
//add subject to all subject...............................................
    if(isset($_POST["add"])){

    $query = "SELECT subject FROM all_subject Where subject = '" . $subject ."' ";
    $result = mysqli_query($connection, $query);
    if(mysqli_num_rows($result) == 1){
      $value = 1;
    }
    else{  $value = 0; }
    
    if($value == 0){
        $query1 = "INSERT INTO all_subject(subject) VALUES ('$subject')";
        mysqli_query($connection , $query1);
        
    }
    }
    //question bank.......................................................
    // $sub1 = isset($_POST['sub1']) ? $_POST["sub1"] :"";
    // $level = isset($_POST['level']) ? $_POST["level"] :"";
    // $question = isset($_POST['qus']) ? $_POST["qus"] :"";
    // $o1 = isset($_POST['o1']) ? $_POST["o1"] :"";
    // $o2 = isset($_POST['o2']) ? $_POST["o2"] :"";
    // $o3 = isset($_POST['o3']) ? $_POST["o3"] :"";
    // $o4 = isset($_POST['o4']) ? $_POST["o4"] :"";
    // $answer = isset($_POST['ans']) ? $_POST["ans"] :"";

    /*if (isset($_POST["upload"])) {
        if(!empty($question) && !empty($o1) && !empty($o2) && !empty($o3) && !empty($o4) && !empty($answer)){
            $sql = "SELECT question from ".$t_name." where question = '".$question."' ";
            $result = mysqli_query($connection, $sql);
            if(mysqli_num_rows($result)==1){
                $value1 = 1;
            }
            else{
                $value1 = 2;
            }
        }
        if ($value1 == 2) {
            $sql1 = "INSERT INTO ".$t_name."(id,subject,level,question,o1,o2,o3,o4,answer) VALUES('','".$sub1."','".$level."','".$question."','".$o1."','".$o2."','".$o3."','".$o4."','".$answer."')";
            mysqli_query($connection, $sql1);
            
           $sql2 = "INSERT INTO ".$t_name."_recent(id,question,o1,o2,o3,o4) VALUES('','".$question."','".$o1."','".$o2."','".$o3."','".$o4."') ";
           mysqli_query($connection, $sql2);
        }
    }
//share with all............................................................................
    if(isset($_POST['checkbox'])){
        $query = "SELECT question FROM all_questions Where question = '" . $question ."' ";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1){
           $value1=3;
          
        }
        else{ $value1=4;}

        if($value1==4){
        $sql1 = "INSERT INTO all_questions(id,subject,level,question,o1,o2,o3,o4,answer) VALUES('','".$sub1."','".$level."','".$question."','".$o1."','".$o2."','".$o3."','".$o4."','".$answer."')";
        mysqli_query($connection, $sql1);    
        }
    }*/

    if(isset($_POST["Logout"])){
        
        $sql4=" DELETE  FROM  " . $t_name . "_recent" ;
        mysqli_query($connection, $sql4);
        echo "<script type=''text/javascript>
                window.location.href='login_&_Signup.php';
        </script>";
        session_destroy();
    }

?>
        
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="j.js"></script>
	<title>upload question for question bank</title>
	<style type="text/css">
        body{
            
        }
        div#full{
            position: absolute;
            padding: 0;
            margin: 0;
            background-size: cover;
            height: 100%;
            width: 100%;
        }
        div#left{
            position: relative;
            float: left;
            width: 34%;
            height: 100%;   
            border-radius: 10px;
            background-color: #5CDB95;
            overflow: auto;
        }
        div#navbar{ position: relative; background-color: #708090; width: 100%; margin:auto; overflow: auto; border-radius: 10px}
        ul{padding: 0; margin: 0; list-style: none;}
        li{width:33.333%;background-color: #708090; float: left; overflow: auto;}

        a#link{display: block; text-decoration: none;text-align:center; font-size: 1em; color:orange; text-transform: uppercase; font-weight: bold; padding:15.5px;}
        a#link:hover{background-color: #4169e1;  border-radius: 15px}
        div#upload_form{ 
            position: relative;
            width: 80%;
            text-align: center;
            margin: 5% auto 0;
            box-sizing: border-box;
            border-radius: 10px;
            background: rgba(0,0,0,0.3);
            padding-top: 1.5%;
            overflow: auto;
        }
        div#header{
            position:relative;
            float: left;
            width: 64%;
            margin:auto;
            padding: 0.5%;
            background-color: #9acd32;
            border-radius: 20px 0;
            text-align: center;
            border-bottom: 5px solid #a0522d;
        }
        div#photo{
            position: relative;
            background-size: cover;
            float: left;
            width:60%;
            height: 85%;
            overflow: auto;
            padding-top: 3%;
            padding-left: 5%;
            z-index: 0;
            border-radius: 0 20px 0 0;
        }
        .logout{height: 3.3em;width: 10.6em; padding: 5px; float:left; background-color: #708090; border:2px solid #708090; font-size: 0.9em; color:orange; text-transform: uppercase; font-weight: bold;}
        .logout:hover{background-color: #4169e1; border:2px solid #4169e1; border-radius: 15px;cursor: pointer;}
        .form{ margin-top: 30px;  color:#EEE2DC;}
        
        .f_attri{font-weight: ; font-family: comic sans ms} 
        .a{width: 50%; border-radius: 10px; border: 1px solid white; transition-duration: 0.3s; font-size: 1em}
        .a:hover{padding: 3px}
        .f{ font-family: comic sans ms; } 
        .qus{border-radius: 10px; height: 15%; width: 50%; font-size: 1em; transition-duration: 0.3s}
        .qus:hover{padding: 3px}
        .b{background-color: sienna; margin-top: 8%;  width: 30%; padding: 3%; border-radius: 10px; border:2px solid sienna; color:white; font-size: 1vw;box-shadow: 3px 3px 3px 3px rgba(0, 0, 0, 0.7)}
        .b:hover{background-color: #4A3AAD ; border: 2px solid  #4A3AAD;  }
        .d_modal{width: 20%; padding: 2%; font-size: 1.2vw; border-radius:2px dotted white; background-color: black; color:white}
        .d_modal:hover{background-color: #1e90ff}
        div#butt:hover{background-color: yellow}
        div#mymodal{
            display: none; 
        	position: fixed; 
        	z-index: 1;
            padding-top: 100px;     
        	left: 0; 
            top: 0; 
        	width:100%; 
        	height: 100%;
        	overflow: auto;
            background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);
            }
        div#modal_content{
        	position: relative; 
        	background-color: #c2b9b0;
        	margin: auto;
        	border: 1px solid #888; 
        	width: 40%; 
        	box-shadow: 0 4px 8px 0 rgba(0,0,0,0,2),0 6px 20px 0 rgba(0,0,0,0.9); 

            animation-duration:1.4s; 
            animation-name: animatetop;
            }
        @keyframes animatetop{ 
            from{top: -300px; opacity: 0}

                50%{top:-40px; opacity:0.5;
                    transform: rotate(360deg);
                }



             100%{top:0; opacity: 1;

             } 
         }
        .close{
            color:white; 
            float: right; 
            font-size: 28px; 
            font-weight: bold;
        }
        .close:hover,
        .close:focus{
            color:#000; 
            text-decoration: none;
            cursor: pointer;
         }
        div#modal_header{
            text-align: center;
            padding: 2px 16px; 
            background-color: #5d5c61;
            color: white;
         }
        div#modal_body{
            text-align: center;
            padding: 20px 16px;
        }
        div#modal_footer{
            text-align: center;
            padding: 5px 16px;
            background-color: #5d5c61; 
            color: white; 
        }
        div#qus{position: absolute; float: left; top: 4%; margin-left:25% ;}
        div#form{width: 100%;  }
        .text{width: 50%; font-size: 1em; border-radius: 10px; transition-duration: 0.3s}
        .text:hover{padding: 3px}
	</style>
</head>
<body>
    <div id="full">
        <div id="left">
            <div id="navbar">
                <ul>
                    
                    <input id="but" class="logout"  type="button"  value="My page" onclick="location.href='teacher.php';">
                    <input id="butt" class="logout"  type="button"  value="Add Subject">

                    <form action="upload_question.php " method="post"> 
                        <input type="submit" class="logout" name="Logout" value="log out" >
                    </form>
                </ul>
            </div>
            <div id="upload_form">
              
                <form class="form" method="post">
                    <font class="f_attri" style="line-height: 0px; font-size: 20px; color:#ffff00; text-shadow: 5px 5px 5px rgba(0,0,0,0.7)">Upload your question</font><br><br>
                    
                    <div style="position: absolute; height: 3%; width: 100%; top: 11%; color:#ffc346; text-align: center;"></div><br>

                    <font class="f_attri" style="  ">Subject :&nbsp;</font>

                    <select id="subselect" class="a" name="sub1" style="" >
                    <?php 
                        $q = "Select subject from " . $t_name . "_subject";
                        $r = mysqli_query($connection, $q);
                    ?>
                    <?php
                        while($option = mysqli_fetch_assoc($r)) {
                            echo "<option>" . $option["subject"] . "</option>";
                        }
                    ?>
                    </select><br><br>
                    <font class="f_attri">Level :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                    <select id="leveltype" class="a" name="level">
                        <option>Easy</option>
                        <option>Medium</option>
                        <option>Hard</option>
                    </select><br><br>
                    <div class="error" > 
                    <?php  if(isset($_POST["upload"])){
                        if($value==8){ echo "this is already exist";}
                  } ?> 
                  </div>
                    <div id="form">
                        <font class="f" style=" ">Question :</font>
                        <textarea id="questionselect" class="qus" name="qus"></textarea><br><br>
                        <font>option 1 :&nbsp;&nbsp;</font>
                        <input id="i1" class="text" type="text" name="o1" ><br><br>
                        <font>option 2 :&nbsp;&nbsp;</font>
                        <input id="i2" class="text" type="text" name="o2" ><br><br>
                        <font>option 3 :&nbsp;&nbsp;</font>
                        <input id="i3" class="text" type="text" name="o3" ><br><br>
                        <font>option 4 :&nbsp;&nbsp;</font>
                        <input id="i4" class="text" type="text" name="o4" ><br><br>
                        <font>Answer :&nbsp;&nbsp;</font>
                        <input id="i5" class="text" type="text" name="ans" ><br><br><br>


                        <div class="error" > 
                            <?php  if(isset($_POST["checkbox"])){
                            if($value1==3){ echo "this is already shared";}
                            } ?> </div>
                        <input id="checkbox" type="checkbox" value="checkbox1" name="checkbox">
                        <font size="3" face="elephant" color="#EEE2DC">
                            Share to all</font><br>
                        <input onclick="ajaxinput()"  class="b" style="  " type="submit" name="upload" value="UPLOAD"><br><br>
                    </div>
                
                </form>
            </div>
        </div>   
        
        <div id="header">
            <font style="  font-size: 25px; color:#00ffff; font-family: comic sans ms;text-shadow: 5px 5px 5px rgba(0,0,0,0.7)">Your recent uploaded questions</font>
        </div>

        <div id="photo">
            <?php
                $sql = "SELECT * FROM ".$t_name."_recent ";
                $result = mysqli_query($connection, $sql); $i=1;
                while ($row = mysqli_fetch_assoc($result)) {
                    echo $i;?> .&nbsp; <?php
                    echo "".$row['question'].""; ?> <br><br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
                    echo "a. ".$row['o1']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
                    echo "b. ".$row['o2']."";?> <br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
                    echo "c. ".$row['o3']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
                    echo "d. ".$row['o4']."";?> <br><br> <?php
                    $i=$i+1;
                }
            ?>
        </div> 

        <script type="text/javascript">
            
                setInterval(function(){
                    $('#photo').load(' #photo');
                },2000);

        </script>

        
        <div id="mymodal">
            <div id="modal_content">
                <div id="modal_header">
                    <span class="close">&times;</span>
                    <h2>Add a subject</h2>
                </div> 
                <div id="modal_body">
                    <form action="upload_question.php" method="post">
                        <font style="color:#000000; font-size: 20px">Catagory:&nbsp;&nbsp;&nbsp;</font>
                        <input class="sub" style="width: 40%; font-size: 1em" type="text" name="sub"><br><br>
                        <input class="d_modal" style=" "  type="submit" name="add" value="ADD">
                    </form>
                </div>  
                <div id="modal_footer">
                    <font>This subject will be add in your subject type</font>
                </div>
            </div>
        </div>
    </div>    
   

    <script type="text/javascript">
    	var modal = document.getElementById('mymodal');
    	var btn = document.getElementById("butt");
    	var span = document.getElementsByClassName("close")[0];
    	btn.onclick = function(){
    		modal.style.display = "block";
    	}
    	span.onclick = function(){
    		modal.style.display = "none";
    	}
    	window.onclick = function(event){
    		if(event.target == modal){
    			modal.style.display = "none";
    		}
    	}
    </script>


    <script type="text/javascript">
        
        function ajaxinput()
        {
            var subselect=document.getElementById('subselect').value;
            var leveltype = document.getElementById('leveltype').value;
            var questionselect = document.getElementById('questionselect').value;
            var i1 = document.getElementById('i1').value;
            var i2 = document.getElementById('i2').value;
            var i3 = document.getElementById('i3').value;
            var i4 = document.getElementById('i4').value;
            var i5 = document.getElementById('i5').value;
            var checkbox = document.getElementById('checkbox').value;



            var datastring = 'subselect='+subselect+'&leveltype='+leveltype+'&questionselect='+questionselect+'&i1='+i1+'&i2='+i2+'&i3='+i3+'&i4='+i4+'&i5='+i5+'&checkbox='+checkbox;

            $.ajax({
                type:"POST",
                url:"process.php",
                data:datastring,
                success:function(html)
                {
                    //alert(html)
                    var msg = html;
                    //document.write(msg);
                }
            });
            
        }

    </script>

</body>
</html>