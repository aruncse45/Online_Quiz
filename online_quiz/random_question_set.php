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

    $easy = isset($_POST['Easy']) ? $_POST["Easy"] : "";
    $medium = isset($_POST['Medium']) ? $_POST["Medium"] : "";
    $hard = isset($_POST['Hard']) ? $_POST["Hard"] : "";

    //question selection...
    if(isset($_POST['set'])){
    //easy selection...
        if(!empty($easy)){
            $sql1 = "SELECT * FROM ".$t_name." WHERE subject='".$t_sub."' AND  level='easy' ORDER BY RAND() limit ".$easy." ";
            $result = mysqli_query($connection,$sql1);
            while ($row = mysqli_fetch_assoc($result)) {

            $e = "INSERT INTO ".$e_code."(id,question,o1,o2,o3,o4,answer) VALUES('','".$row["question"]."','".$row["o1"]."','".$row["o2"]."','".$row["o3"]."','".$row["o4"]."','".$row["answer"]."')";
            mysqli_query($connection, $e);}
        }
    //medium selection....
        if(!empty($medium)){
            $sql2 = "SELECT * FROM ".$t_name." WHERE subject='".$t_sub."' AND  level='medium' ORDER BY RAND() limit ".$medium." ";
            $result = mysqli_query($connection,$sql2);
            while ($row = mysqli_fetch_assoc($result)) {

            $m = "INSERT INTO ".$e_code."(id,question,o1,o2,o3,o4,answer) VALUES('','".$row["question"]."','".$row["o1"]."','".$row["o2"]."','".$row["o3"]."','".$row["o4"]."','".$row["answer"]."')";
            mysqli_query($connection, $m);}
        }
    //hard selection...
        if(!empty($hard)){
            $sql3 = "SELECT * FROM ".$t_name." WHERE subject='".$t_sub."' AND  level='hard' ORDER BY RAND() limit ".$hard." ";
            $result = mysqli_query($connection,$sql3);
            while ($row = mysqli_fetch_assoc($result)) {

            $h = "INSERT INTO ".$e_code."(id,question,o1,o2,o3,o4,answer) VALUES('','".$row["question"]."','".$row["o1"]."','".$row["o2"]."','".$row["o3"]."','".$row["o4"]."','".$row["answer"]."')";
            mysqli_query($connection, $h);}
        }
    }

//logout...............................................................
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
	<title>Randomly question selection</title>
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
            width: 30%;
            margin-left: 0px;
            overflow: auto;
            background-color: #5CDB95;
        }
        div#navbar{ position: relative; background-color: #708090; width: 100%; margin:auto; overflow: auto; border-radius: 10px}
        ul{padding: 0; margin: 0; list-style: none;}
        li{width:33.333%;background-color: #708090; float: left; overflow: auto;}
        a#link{display: block; text-decoration: none;text-align:center; font-size: 1.2vw; color:orange; text-transform: uppercase; font-weight: bold; padding:15.5px;}
        a#link:hover{background-color: #4169e1;  border-radius: 15px}
        div#upload_form{ 
            position: relative;
            top: 20%;
            width: 85%;
            padding-top: 3%;
            text-align: center;
            box-sizing: border-box;
            border-radius: 10px;
            background: rgba(0,0,0,0.3);
            margin: 20% 6% 40% 7%;
        }
        
        div#header{
            position:relative; 
            float: left;
            width: 69%;
            margin:auto;
            padding: 0.5% 0%;
            background-color: #9acd32;
            border-radius: 20px 0;
            text-align: center;
            border-bottom: 5px solid #a0522d;
        }
        div#photo{
            position: relative;
            float: left;
            height: 85%;
            width:63%;
            overflow: auto;
            padding-left: 5%;
            padding-top: 3%;
            border-radius: 0 20px 0 0;
        }
        .logout{height: 3.3em;width: 14em; padding: 5px; float:left; background-color: #708090; border:2px solid #708090; font-size: 0.9em; color:orange; text-transform: uppercase; font-weight: bold;}
        .logout:hover{background-color: #4169e1; border:2px solid #4169e1; border-radius: 15px;cursor: pointer;}
        .form{margin-top: 30px;  color:#EEE2DC;}
        
        .f_attri{font-weight: ; font-family: comic sans ms} 
        .a{height: 25px; width: 160px; border-radius: 10px; border: 1px solid white; transition-duration: 0.3s; line-height: 20px}
        .a:hover{padding: 3px}
        .f{ font-family: comic sans ms; } 
        .qus{border-radius: 10px; line-height: 30px; transition-duration: 0.3s}
        .qus:hover{padding: 3px}
        .b{background-color: sienna; margin-top: 8%; height: 20%; width: 30%; padding: 3%; border-radius: 10px; border:2px solid sienna; color:white; font-size: 1.2vw;box-shadow: 3px 3px 3px 3px rgba(0, 0, 0, 0.7)}
        .b:hover{background-color: #4A3AAD ; border: 2px solid  #4A3AAD;  }
        div#butt:hover{background-color: yellow}
        div#qus{position: absolute; float: left; top: 4%; margin-left:8% ;}
        .qus{margin-top: 0%; margin-left: 25%}
        div#form{position: absolute; top: 17%; height: 80%; width: 90%; margin-left: 5%; }
        .text{width: 40%; border-radius: 10px; transition-duration: 0.3s; font-size: 1em}
        .text:hover{padding: 3px}
	</style>
</head>
<body>
    <div id="full">
        <div id="left">
            <div id="navbar">
                
                    <input type="button" class="logout" name="Logout" value="MY PAGE" onclick="location.href='teacher.php';" >
                    <form action="" method="post"> 
                        <input type="submit" class="logout" name="Logout" value="log out" >
                    </form>
                
            </div>
            <div id="upload_form">
                <form class="form" action="random_question_set.php"  enctype="multipart/form-data"  method=   "post">
                    <font class="f_attri" style="line-height: 0px; font-size: 1.5em; color:#ffff00; text-shadow: 5px 5px 5px rgba(0,0,0,0.7)">Set your question</font><br><br><br>
                    <font class="f">question type:&nbsp;&nbsp;How many:</font><br><br>
                    <font class="f">Easy :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                    <input class="text" type="text" name="Easy"><br><br>
                    <font class="f">Medium :&nbsp;</font>
                    <input class="text" type="text" name="Medium"><br><br>
                    <font class="f">Hard :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
                    <input class="text" type="text" name="Hard"><br><br>
                    <input type="submit" class="b" name="set" value="SET">
                </form><br><br>
            </div>
        </div>   
        
        <div id="header">
            <font style="  font-size: 1.7em; color:#00ffff; font-family: comic sans ms;text-shadow: 5px 5px 5px rgba(0,0,0,0.7)">Your recent exam questions</font>
        </div>  
        <div id="photo">
            <?php
                $sql = "SELECT ".$t_name.".question,".$t_name.".o1,".$t_name.".o2,".$t_name.".o3,".$t_name.".o4 FROM ".$t_name.", ".$e_code." WHERE ".$t_name.".question=".$e_code.".question ";
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
    

</body>
</html>