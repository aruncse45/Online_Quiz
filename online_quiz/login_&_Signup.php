<?php include 'database.php' ; ?>
  
<?php
    session_start();
//taking value from input form......................................................
    $username = isset($_POST["Username"]) ? $_POST["Username"] : "";
    $password = isset($_POST["Password"]) ? $_POST["Password"] : "";
    $radio = isset($_POST["Radio"]) ? $_POST["Radio"] : ""; 
    $_SESSION['Username']= $username;
    $_SESSION['Password']= $password;
    $value=0;
    $v=0;
     
//login as a teacher......................................................................     
    if($radio == "teacher"){
        //$query = 'SELECT * FROM teacher Where username = \'' . $username .'\' AND password = \'' . $password . '\'';
        $query = "SELECT * FROM teacher Where username = '" . $username ."' AND password = '" . $password . "'";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1){
            header("location:teacher.php");
        }
        else{ $value=1;}
    }
//login as a student......................................................................    
    else if($radio == "student"){
        $query = "SELECT * from student where username = '" . $username ."' AND password = '" . $password ."' ";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1){
            header("location:student.php");
        }
        else{  $value=1;}
    }
      
    
   
  ?>



<!DOCTYPE html>
<html>
<head>
	<title>Login & Signup</title>
	<style type="text/css">
      body{}
      div#full{position: absolute; height: 100%; width: 100%;background-image: url(page_image/autumn.jpg); background-repeat: no-repeat; background-size: cover; font-family: arial rounded mt bold;}
  		div#login_form{ position: relative; background-color:#D2B48C ; background-color: rgba(0,0,0,0.4);  margin:auto; margin-top: 7%; width: 30%; border-radius: 10px; }
  		.a{margin-left: 35%; padding-top: 10%; text-align: center; overflow: auto; font-size: 2vw}
  		.login_attribute{font-family: vrinda; color:white; font-size: 1.5vw; margin-left: 20%; line-height: 1.5em}
  		.blank_space{margin-left: 20%; height: 10%; width: 60%; border:none; border-bottom: 1px solid #fff; background: transparent;outline: none; font-size: 1em}
      .blank_space:hover{padding:3px;} 
      .radio{color:white; font-size: 1.5vw; padding-left: 20%; margin-top: 13%}
      .radioo{color:white; font-size: 1.5vw; margin-left: 15%; margin-top: 13%}
      .radion{font-size: 1vw; margin-top: 13%}
  		.login_attribute_button{position: relative; margin-left:25%;height: 35px; width:48%; border-radius: 10px; background-color: #5cdb95; border:#5cdb95; font-size: 1.5vw; color:#ff1493; font-weight: bold;}
  		.login_attribute_button:hover{background-color: #ffe400; color:red;}
  		.login_attribute_button:active{background-color: #FFA500}
      .teacher{
        position: relative;
        width: 20%;
        height: 20%;
        border-radius: 50%;
        overflow: hidden;
        position: absolute;
        top: -10%;
        margin-left: 40%; 
      }
      .error{ margin-left: 100px; color:#00ff7f; font-family: vrinda }
	</style>
</head>
<body>
    <div id="full">
        <div id="login_form">
            <img class="teacher" src="small_image/id.png">
            <form action="login_&_Signup.php" method="post">
                <br><br><br>
                <font class="a"  color="yellow" >
                    <b>Log in here</b>
                </font><br><br><br>
                <div class="error" > 
                    <?php  if(isset($_POST["login"])){
                        if(!isset($_POST["Username"]) || empty($_POST["Username"])){echo "* Username cant be blank"; $v=2;}
                    } 
                     ?> 
                </div>
                <font class="login_attribute" > Username:&nbsp;&nbsp;&nbsp;</font><br>
              	<input class="blank_space" type="text" placeholder="Your name" name="Username" value="<?php echo $username ?>" size="30%"><br><br>
                <div class="error"><?php if(isset($_POST["login"])){
                    if(!isset($_POST["Password"]) || empty($_POST["Password"])){
                      echo "* Password cant be blank"; $v=2;} } ?></div>
              	<font class="login_attribute"  > Password:&nbsp;&nbsp;&nbsp;&nbsp;</font><br>
              	<input class="blank_space" type="password" placeholder="........." name="Password" size="30" minlength="8"><br><br>
                <div class="error" style=" ">
                    <?php if(isset($_POST["login"])){
                        if($v==2){}
                        elseif ($value==1) {
                            echo"Username or Password is incorrect";
                        }
                    } 
                    ?>
                </div>
                  
                <font class="radio">Teacher</font>
                <input class="radion" type="radio" name="Radio" value="teacher">
                <font   class="radioo">Student</font>
                <input  class="radion" type="radio" name="Radio" value="student"><br><br><br>
                <input class="login_attribute_button" type="submit" name="login" value="Login" onclick=""><br><br>
                
                <br><br><br>
            </form>
        </div> 
    </div>    
</body>
</html>