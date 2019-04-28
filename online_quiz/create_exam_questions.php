<?php include 'database.php' ; ?>
<?php 
    session_start();
    $t_name = $_SESSION['Username'];
    $pass = $_SESSION['Password'];
    $t_sub = $_SESSION['sub1'];
    $e_code = $_SESSION['exam_code'];

    if (!isset($t_name) || !isset($pass))
        header("Location: login_&_Signup.php");

    $sql = "SELECT * FROM teacher where username = '".$t_name."' AND password ='".$pass."' ";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) == 0) {
        header("location:login_&_Signup.php");
    }

    if (!isset($e_code))
        header("Location: teacher.php");
    
    //question set...............................................
    $value1 = 0;
    /*$question = isset($_POST['qus']) ? $_POST["qus"] :"";
    $level = isset($_POST['level']) ? $_POST["level"] :"";
    $o1 = isset($_POST['o1']) ? $_POST["o1"] :"";
    $o2 = isset($_POST['o2']) ? $_POST["o2"] :"";
    $o3 = isset($_POST['o3']) ? $_POST["o3"] :"";
    $o4 = isset($_POST['o4']) ? $_POST["o4"] :"";
    $answer = isset($_POST['answer']) ? $_POST["answer"] :"";

    if (isset($_POST["upload"])) {
        if(!empty($question) && !empty($o1) && !empty($o2) && !empty($o3) && !empty($o4) && !empty($answer)){
            $sql = "SELECT question from ".$e_code." where question = '".$question."' ";
            $result = mysqli_query($connection, $sql);
            if(mysqli_num_rows($result)==1){
                $value1 = 1;
            }
            else{
                $value1 = 2;
            }
        }
        if ($value1 == 2) {
            $sql1 = "INSERT INTO ".$e_code."(id,question,o1,o2,o3,o4,answer) VALUES('','".$question."','".$o1."','".$o2."','".$o3."','".$o4."','".$answer."')";
            mysqli_query($connection, $sql1);
        }
    }

    if(isset($_POST['checkbox'])){
        $sql = "SELECT question from ".$t_name." where question = '".$question."' ";
            $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) == 1){
           $value1=3;
          
        }
        else{ $value1=4;}

        if($value1==4){
            if(!empty($question) && !empty($o1) && !empty($o2) && !empty($o3) && !empty($o4) && !empty($answer)) {
                $sql1 = "INSERT INTO ".$t_name."(id,subject,level,question,o1,o2,o3,o4,answer) VALUES('','".$t_sub."','".$level."','".$question."','".$o1."','".$o2."','".$o3."','".$o4."','".$answer."')";
                mysqli_query($connection, $sql1);  
            }  
        }
    }*/

//logout.............................................................
    if(isset($_POST["Logout"])){
        $sql4=" DELETE  FROM  " . $name . "_recent" ;
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
	<title>Create exam questions</title>
	<style type="text/css">
        body{
            padding: 0; margin: 0;
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
            width: 34%;
            height: 100%;
            float: left;
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
            margin: 6% auto 9%;
            width: 80%;
            text-align: center;
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
        .form{margin-top: 30px;  color:#EEE2DC;}
        
        .f_attri{font-weight: ; font-family: comic sans ms} 
        .a{width: 50%; border-radius: 10px; border: 1px solid white; transition-duration: 0.3s; font-size: 1em}
        .a:hover{padding: 3px}
        .f{ font-family: comic sans ms; } 
        .qus{border-radius: 10px; width: 50%; height: 15%; transition-duration: 0.3s}
        .qus:hover{padding: 3px}
        .b{background-color: sienna; margin-top: 8%;  width: 30%; padding: 3%; border-radius: 10px; border:2px solid sienna; color:white; font-size: 1vw;box-shadow: 3px 3px 3px 3px rgba(0, 0, 0, 0.7)}
        .b:hover{background-color: #4A3AAD ; border: 2px solid  #4A3AAD;  }
        div#butt:hover{background-color: yellow}
        .qus{margin-top: 0%; font-size: 1em;}
        div#form{position: relative; float: left; top: 17%; height: 80%; width: 90%; margin-left: 5%; overflow: auto; }
        .text{ width:50%; border-radius: 1em; transition-duration: 0.3s; font-size: 1em}
        .text:hover{padding: 3px}
	</style>
</head>
<body>
    <div id="full">
        <div id="left">
            <div id="navbar">
                <ul>
                    <input id="butt" class="logout"  type="button"  value="My page" onclick="location.href='teacher.php';" >
                    <input id="butt" class="logout"  type="button"  value="Upload question" onclick="location.href='upload_question.php';" >

                    <form action="" method="post"> 
                        <input type="submit" class="logout" name="Logout" value="log out" >
                    </form>
                </ul>
            </div>
            <div id="upload_form">
              
                <form class="form" action="" method="post">
                    <font class="f_attri" style=" font-size: 1.5em; color:#ffff00; text-shadow: 5px 5px 5px rgba(0,0,0,0.7)">Set your question</font><br><br><br>
                    <div style="position: absolute; height: 3%; width: 100%; top: 15%; color:#ffc346; text-align: center;"><?php if(isset($_POST["upload"])){$value1 = "<script>document.write(msg)</script>"; if($value1!= "successfull"){echo "Already exists.please choose another.";} } ?></div>
                    <div id="form">
                        
                            <font style=" ">Question :</font>
                        
                        <textarea id="question" class="qus" name="qus"></textarea><br><br>
                        <font>level :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                        <select id="leveltype" class="a" name="level">
                            <option>Easy</option>
                            <option>Medium</option>
                            <option>Hard</option>
                        </select><br><br>
                        <font>option 1 :&nbsp;&nbsp;</font>
                        <input id="i1" class="text" type="text" name="o1" ><br><br>
                        <font>option 2 :&nbsp;&nbsp;</font>
                        <input id="i2" class="text" type="text" name="o2" ><br><br>
                        <font>option 3 :&nbsp;&nbsp;</font>
                        <input id="i3" class="text" type="text" name="o3" ><br><br>
                        <font>option 4 :&nbsp;&nbsp;</font>
                        <input id="i4" class="text" type="text" name="o4" ><br><br>
                        <font>Answer :&nbsp;&nbsp;</font>
                        <input id="i5" class="text" type="text" name="answer" ><br><br>
                        <div class="error" > 
                            <?php  if(isset($_POST["checkbox"])){
                            if($value1==3){ echo "*This is already saved.";}
                            } ?> </div>
                        <input id="checkbox" type="checkbox" value="checkbox1" name="checkbox">
                        <font size="3" color="#EEE2DC">Save to question bank</font><br>
                        
                        <input onclick="ajaxinput()" class="b" style="  " type="submit" name="upload" value="SET"><br><br><br>
                    </div>
                
                </form>
            </div>
        </div>   
        
        <div id="header">
            <font style="  font-size: 1.7em; color:#00ffff; font-family: comic sans ms;text-shadow: 5px 5px 5px rgba(0,0,0,0.7)">Your recent exam questions</font>
        </div>  
        
        <div id="photo">
            <?php
                $sql = "SELECT * FROM ".$e_code." ";
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
        
    </div>
    
    <script type="text/javascript">
        function ajaxinput(){
            var question = document.getElementById('question').value;
            var leveltype = document.getElementById('leveltype').value;
            var i1 = document.getElementById('i1').value;
            var i2 = document.getElementById('i2').value;
            var i3 = document.getElementById('i3').value;
            var i4 = document.getElementById('i4').value;
            var i5 = document.getElementById('i5').value;
            var checkbox = document.getElementById('checkbox').value;

            var datastring = 'question='+question+'&leveltype='+leveltype+'&i1='+i1+'&i2='+i2+'&i3='+i3+'&i4='+i4+'&i5='+i5+'&checkbox='+checkbox;
            $.ajax({
                type : "POST",
                url : "process1.php",
                data : datastring,
                success:function(html){
                    var msg = html;
                }
            }) 
        }
    </script>

</body>
</html>