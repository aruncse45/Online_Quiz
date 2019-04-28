<?php include 'database.php'; ?>
<?php
	session_start();
//taking value from form input.............................................................	
    $t_name = $_SESSION['Username'];
    $pass = $_SESSION['Password'];
    $subject = $_GET['subject'];

    if (!isset($t_name) || !isset($pass)) {
		header("location:login_&_Signup.php");
	}

	$sql = "SELECT * FROM student where username = '".$t_name."' AND password ='".$pass."' ";
	$result = mysqli_query($connection, $sql);
	if (mysqli_num_rows($result) == 0) {
		header("location:login_&_Signup.php");
	}

//delete selected question from database...................................................
    $sql1 = "SELECT * from ".$t_name." where subject='".$subject."'";
	$result = mysqli_query($connection, $sql1); 
	if(isset($_POST["delete"])){
		while ($row = mysqli_fetch_assoc($result)){
			if(isset($_POST["a".$row['id'].""])){
				$sql2 = "DELETE FROM ".$t_name." WHERE id='".$row['id']."'";
				mysqli_query($connection, $sql2);
			}
		}
    }

//logout..................................................................................    
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
	<title>Different subjects page of student</title>
	<style type="text/css">
		div#full{ position: absolute; height: 100%; width: 100%; z-index: -1}
		div#page_name{position: fixed; float: left; left: 0%; width: 100%; height: 9%; background-color: blue;  }
		.a{text-transform: uppercase; padding-left: 35%; color:yellow; font-size: 3.5vw; }
		div#up_right{position: relative; float: right;  margin-right: 10%; width: 15%; margin-top: 0.8%; }
		ul{padding: 0; margin: 0; list-style: none; }
		li.nav{float: left; }
		.logout{width: 50%; padding: 2%; float: left; background-color: green;  border:2px solid #cd853f;  font-size: 1.2vw; color:white; text-transform: uppercase; }
        .logout:hover{background-color: #800000;  cursor: pointer; }
       
        div#down_up{position: absolute; top: 11%;  width: 70%; margin-left: 15%;  z-index: -1}
	</style>
</head>
<body>
	<div id="full">
		<div id="page_name">
			<font  class="a"><?php echo " ".$_GET['subject']." " ?></font>
			<div id="up_right">
				<input id="butt" class="logout"  type="button"  value="My page" onclick="location.href='student.php';" >
				<form action="teacher.php" method="post"> 
	                <input type="submit" class="logout" name="Logout" value="log out" >
	            </form>
			</div>
		</div>
		
		<div id="down_up" >
			<?php 
				$sql = "SELECT * from all_questions where subject = '".$subject."' ";
				$result = mysqli_query($connection, $sql); $i=1;
				while ($row = mysqli_fetch_assoc($result)) {
					echo $i;?> .&nbsp; <?php
                    echo "".$row['question'].""; ?> <br><br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
                    echo "a. ".$row['o1']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
                    echo "b. ".$row['o2']."";?> <br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
                    echo "c. ".$row['o3']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
                    echo "d. ".$row['o4']."";?> <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
                    echo "Correct answer: ".$row['answer']."";?> <br><br> <?php 
                    $i=$i+1;
                }
			?>
		</div>
	</div>
</body>
</html>