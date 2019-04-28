<?php include 'database.php'; ?>
<?php
	session_start();
    $t_name = $_SESSION['Username'];
    $pass = $_SESSION['Password'];
    $exam_code = $_SESSION['e_code'];
    

    if (!isset($t_name) || !isset($pass))
        header("Location: login_&_Signup.php");

    $sql = "SELECT * FROM teacher where username = '".$t_name."' AND password ='".$pass."' ";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) == 0) {
        header("location:login_&_Signup.php");
    }

    if (!isset($exam_code))
        header("Location: teacher.php");

//logout................................................................
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
	<title>Exam marks</title>
	<style type="text/css">
		div#full{position: absolute; height: 100%; width: 100%; z-index: -1}
		div#page_name{position: fixed; float: left; left: 0%; width: 100%; height: 9%; background-color: blue;  }
		.a{text-transform: uppercase; padding-left: 35%; color:yellow; font-size: 3.5vw; }
		div#up_right{position: relative; float: right; margin-right: 10%; width: 20%; margin-top: 0.8%; }
		ul{padding: 0; margin: 0; list-style: none;}
		li.nav{float: left; }
		a#link{display: block; text-decoration: none; padding: 8px 17px; color:white; font-size: 1vw; border:2px solid #cd853f; background-color: green;  }
		a#link:hover{background-color:#800000 }
		.logout{height: 2.4em; width: 6em; padding: 6px; float: left; background-color: green;  border:2px solid #cd853f;  font-size: 1.1vw; color:white; text-transform: uppercase; }
        .logout:hover{background-color: #800000;  cursor: pointer; }
        div#down_left{position: absolute; top: 17%; height: 81%; width: 40%; margin-left: 8%; border: 2px solid blue; text-align: center; overflow: auto; z-index: -1; font-size: 1em}
        div#down_right{position: absolute; top: 17%; height: 81%; width: 40%;margin-left: 50%;  border: 2px solid blue; text-align: center; overflow: auto; z-index: -1; font-size: 1em}
        
	</style>
</head>
<body>
	<div id="full">
		<div id="page_name">
			<font  class="a"><?php echo "RESULT OF ".$exam_code." " ?> </font>
			<div id="up_right">
				<input id="butt" class="logout"  type="button"  value="My page" onclick="location.href='teacher.php';" >
				<form action="teacher.php" method="post"> 
	                <input type="submit" class="logout" name="Logout" value="log out" >
	            </form>
			</div>
		</div>
		
		<div id="" style="position: fixed; width:40%; top: 10%; margin-left: 8%; border: 2px solid blue; background-color: yellow; text-align: center; font-size: 1.5em; color: blue;">Participated in exam<br>
		<font size="5px " style="font-weight: bold; text-decoration: underline;">Roll <br></font>
		</div>
		<div id="down_left" >
			<br>
			<?php 
				$sql = "SELECT * from ".$exam_code."_given ";
				$result = mysqli_query($connection, $sql); $i=1;
				while ($row = mysqli_fetch_assoc($result)) {
					echo $i;?> .&nbsp; <?php
                    echo "".$row['roll_no'].""; ?> &nbsp;&nbsp;&nbsp;&nbsp;<br><br> <?php
                    $i=$i+1;
                }
			?>
		</div>
		<div id="" style="position: fixed; width:40%; top: 10%; margin-left: 50%;border: 2px solid blue;  background-color: yellow; text-align: center; font-size: 1.5em; color: blue;">Got marks<br>
			<font size="5px" style="font-weight: bold; text-decoration: underline;">Roll</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
			<font size="5px" style="font-weight: bold; text-decoration: underline;">Marks</font><br>
		</div>
		<div id="down_right" >
			<br>
			<?php 
				$sql = "SELECT * from ".$exam_code."_result ";
				$result = mysqli_query($connection, $sql); $i=1;
				while ($row = mysqli_fetch_assoc($result)) {
					echo $i;?> .&nbsp; <?php
                    echo "".$row['roll_no'].""; ?> <-------------------------------> <?php
                    echo "".$row['marks']."";?><br><br> <?php
                    $i=$i+1;
                }
			?>
		</div>

			
		
	</div>
</body>
</html>