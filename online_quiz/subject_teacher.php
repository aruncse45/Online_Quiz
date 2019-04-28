<?php include 'database.php'; ?>
<?php
	session_start();

//taking value from form input.............................................................	
    $t_name = $_SESSION['Username'];
    $pass = $_SESSION['Password'];
    $subject = $_GET['subject'];

    if (!isset($t_name) || !isset($pass))
        header("Location: login_&_Signup.php");

    $sql = "SELECT * FROM teacher where username = '".$t_name."' AND password ='".$pass."' ";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) == 0) {
        header("location:login_&_Signup.php");
    }
    
    if (!isset($subject))
        header("Location: teacher.php");

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
	<title>Different subjects page for teacher</title>
	<style type="text/css">
		div#full{position: absolute; height: 100%; width: 100%; z-index: -1}
		div#page_name{position: fixed; float: left; left: 0%; width: 100%; height: 9%; background-color: blue;  }
		.a{text-transform: uppercase; padding-left: 35%; color:yellow; font-size: 3.5vw; }
		div#up_right{position: relative; float: right;  margin-right: 10%; width: 15%; margin-top: 0.8%; }
		ul{padding: 0; margin: 0; list-style: none;}
		li.nav{float: left; }
		.logout{width: 50%; padding: 2%; float: left; background-color: green;  border:2px solid #cd853f;  font-size: 1.2vw; color:white; text-transform: uppercase; }
        .logout:hover{background-color: #800000;  cursor: pointer; }
        form#down{position: absolute; width: 95%; height: 88%; top: 5%; left: 2%; z-index: -1; }
        div#down_up{position: relative; border: 2px solid red; margin-top: 2%; height: 90%; width: 100%; overflow: auto; z-index: -1}
        div#down_down{position: relative; margin-left: 40%}
        .delete{background-color: sienna; float: left;  width: 13%; margin-left: 5%; padding: 1%; border-radius: 10px; border:2px solid sienna; color:white; font-size: 1.2vw;box-shadow: 3px 3px 3px 3px rgba(0, 0, 0, 0.7)}
        .delete:hover{background-color: #4A3AAD ; border: 2px solid  #4A3AAD; padding: 10px }
	</style>
</head>
<body>
	<div id="full">
		<div id="page_name">
			<font  class="a"><?php echo " ".$_GET['subject']." " ?></font>
			<div id="up_right">
				<input id="butt" class="logout"  type="button"  value="My page" onclick="location.href='teacher.php';" >
				<form action="teacher.php" method="post"> 
	                <input type="submit" class="logout" name="Logout" value="log out" >
	            </form>
			</div>
		</div>
		<form id="down" action="" method="post">
			<div id="down_up" >
				<?php 
					$sql = "SELECT * from ".$t_name." where subject='".$subject."'";
					$result = mysqli_query($connection, $sql); $i=1;
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<input type='checkbox' value='checkbox' name='a".$row['id']."'>";
						echo $i;?> .&nbsp; <?php
	                    echo "".$row['question'].""; ?> <br><br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
	                    echo "a. ".$row['o1']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
	                    echo "b. ".$row['o2']."";?> <br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
	                    echo "c. ".$row['o3']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
	                    echo "d. ".$row['o4']."";?> <br><br> <?php
	                    $i=$i+1;
	                }
				?>
			</div><br>
			<div id="down_down">
				<input type="button" class="delete" name="insert" value="INSERT" onclick="location.href='upload_question.php';">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="submit" class="delete" name="delete" value="DELETE">
			</div>
		</form>
	</div>
</body>
</html>