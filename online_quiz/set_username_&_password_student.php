<?php include 'database.php' ; ?>

<?php
    session_start();
//taking value from input form......................................................
    $username=isset($_POST['Username']) ? $_POST["Username"] : "";
    $password=isset($_POST['Password']) ? $_POST["Password"] : "";
    $_SESSION['Username'] = $username;
    $_SESSION['Password'] = $password;
    $roll_no = $_SESSION['Roll_no'];
    $value1 = 0;
    $value2 = 0;
    $errors = array();

    $sql = "SELECT * FROM student where roll_no = '".$roll_no."' ";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) == 1) {
        header("location:login_&_Signup.php");
    }

    if (empty($roll_no)) {
        header("location: homepage++.php");
    }
//error checking....................................................................    
    if(isset($_POST["login"])){
        $field_required = array("Username","Password");
        foreach ($field_required as $field) {
            $value = $_POST[$field];      
            if(!isset($value) || empty($value)){
                $errors[$field] = $field;
            } 
            else {
                $errors[$field] = "";
            }
        }
    }
//given username, password check with database......................................   
    if(isset($_POST["login"])){
        if($_POST["Username"] != ""){
            $query1 = "SELECT username from username_password where username = '". $username ."' ";
            $result1 = mysqli_query($connection, $query1);
            if(mysqli_num_rows($result1) == 1){
                $value1=1;
            }
            else{$value1=2;}
            }
        if($_POST["Password"] != ""){
            $query2 = "SELECT password from username_password where password = '". $password ."' ";
            $result2 = mysqli_query($connection, $query2);
            if(mysqli_num_rows($result2) == 1){
                $value2=1;
            }
            else{$value2=2;}
        }
    }
//login and go to next page................................................................................
    if($value1 == 2 && $value2 == 2 ){
         
        $query = "INSERT INTO username_password(username, password) VALUES ('$username','$password')";
        mysqli_query($connection , $query);

        $query1 = "INSERT INTO student(username, password, roll_no ) VALUES ('$username','$password', '$roll_no')";
        mysqli_query($connection , $query1);

        $query2 = "CREATE TABLE student_".$username."_subject( id int(10) not null AUTO_INCREMENT,subject varchar(20),PRIMARY key (id)
          ) ";
        mysqli_query($connection , $query2);
        $query1 = "CREATE TABLE ".$password."_questions( id int(10) not null AUTO_INCREMENT, question varchar(200), o1 varchar(20), o2 varchar(20), o3 varchar(20), o4 varchar(20), answer varchar(20), PRIMARY key (id)) ";
        mysqli_query($connection, $query1);
        header("location: student.php");
    }   
    
   

  ?> 
  
<!DOCTYPE html>
<html>
  <head>
	  <title>Set username & password</title>
    	<style type="text/css">
            div#full{position: absolute; background-image: url(page_image/No_Clutter_by_Lars_Bjork_Larsonist.jpg); background-repeat: no-repeat; background-size: cover; height: 100%; width: 100%}
      		div#form{position: relative; padding-top: 2%;  margin:auto;  background-color: rgba(0,0,0,0.4); margin-top: 10%; width: 30%; height: 50%; border-radius: 10px;text-align: center  }
      		.a{font-family: vrinda; font-size: 2vw}
      		.login_attribute{color:white; font-size: 1.2em;  font-family: vrinda;}
      		.blank_space{width: 60%; font-size: 1em; background: transparent; border:none; outline: none; color: white; border-bottom: 1px solid #fff}
      		.login_attribute_button{padding: 2.5%; width: 25%;   background-color: #1818ff; border:#1818ff;  box-shadow: 3px 3px 3px 3px rgba(0, 0, 0, 0.7); font-family: ALGERIAN; color: white; font-size: 1vw; border-radius: 10px}
            .blank_space:hover{padding:3px;}
      		.login_attribute_button:hover{background-color: #a52a2a}
      		.login_attribute_button:active{background-color: #008F8F}
            .error{ color:#FFFF00;}
    	</style>
  </head>
<body>
    <div id="full">    
        <form action="" method="post">
            <div id="form">
                <font class="a" color="yellow" size="5px" >
            	      <b>Set username & password</b>
                </font><br><br><br>

                <div class="error"><?php if(isset($_POST["login"])){if($errors["Username"]=="Username"){ echo "*Username cant be blank.";} if($value1==1) {echo "*Please chosse another Username";}} ?>
                  
                </div>

                <font class="login_attribute"> Username</font><br>
          	    <input class="blank_space" type="text" placeholder="any name" name="Username" size="30"><br><br>

                <div class="error"><?php if(isset($_POST["login"])){if($errors["Password"]=="Password"){ echo "*Password cant be blank.";} if($value2==1) {echo "*Please chosse another Password";}} ?>
                  
                </div>

          	    <font class="login_attribute"> Password</font><br>
          	    <input class="blank_space" type="text" placeholder="........." name="Password" size="30" minlength="8"><br><br><br>
                <input class="login_attribute_button" type="submit" name="login" value="Login" onclick="">
                <br><br><br>
            </div>
        </form>
    </div>    
</body>
</html>