<?php include 'database.php'; ?>
<?php 
	session_start();
//value taking............................................................	
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
        header("Location: login_&_Signup.php");

//selected question set..............................................................................
    $sql1 = "SELECT * from ".$t_name." where subject='".$t_sub."'";
	$result = mysqli_query($connection, $sql1); 
	if(isset($_POST["set"])){
		while ($row = mysqli_fetch_assoc($result)){
			if(isset($_POST["a".$row['id'].""])){
				$sql2 = "INSERT INTO ".$e_code."(id,question,o1,o2,o3,o4,answer) VALUES('','".$row["question"]."','".$row["o1"]."','".$row["o2"]."','".$row["o3"]."','".$row["o4"]."','".$row["answer"]."')";
				mysqli_query($connection, $sql2);
			}
		}
    }

//logout............................................................................................    
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
	<title>Seleting question for exam from question bank</title>
	<style type="text/css">
		div#full{position: absolute; height: 100%; width: 100%; z-index: -1}
		div#page_name{position: fixed; float: left; left: 0%; width: 100%; height: 9%; background-color: yellow;  }
		.a{text-transform: uppercase; padding-left: 35%; color: blue; }
		div#up_right{position: relative; float: right; margin-right: 10%; width: 20%; margin-top: 0.8%; }
		ul{padding: 0; margin: 0; list-style: none;}
		li.nav{float: left; }
		a#link{display: block; text-decoration: none; padding: 8px 17px; color:white; font-size: 1em; border:2px solid #cd853f; background-color: green;  }
		a#link:hover{background-color:#800000 }
		.logout{height: 2.4em; width: 6em; padding: 6px;  background-color: green;  border:2px solid #cd853f;  font-size: 1em; color:white; text-transform: uppercase; }
        .logout:hover{background-color: #800000;  cursor: pointer; }
        div#left{position: absolute; height: 84%; width: 48%; top: 15%; float: left; overflow: scroll; z-index: -1 }
        div#middle{position: fixed; height: 85%; width: 1%; top: 15%; margin-left: 48.5%; background-color: green; border-radius: 0 20px}
        div#right{position: absolute; height: 84%; width: 48%; top: 15%; margin-left: 51%; overflow: scroll; z-index: -1}
        .set{position: fixed; background-color: sienna; width: 8%; padding: 0.7%; margin-left: 37%; margin-top: 40%; border-radius: 10px; border:2px solid sienna; color:white; font-size: 1em;box-shadow: 3px 3px 3px 3px rgba(0, 0, 0, 0.7)}
        .set:hover{background-color: #4A3AAD ; border: 2px solid  #4A3AAD;  }
	</style>
</head>
<body>
	<div id="full">
		<div id="page_name">
			<font size="10px" class="a"> Selection </font>
		</div>
		<div id="up_right">
			<ul>
				<li class="nav"><a id="link" href="teacher.php">MYPAGE</a></li>
			</ul>
			<form action="" method="post"> 
                <input type="submit" class="logout" name="Logout" value="log out" >
            </form>
		</div>
		<div id="" style="position: fixed; text-align: center; background-color: blue; font-size: 1.7em; color: white; top: 10%; width: 48%; ">Related questions</div>
		<form action="" method="post">
			<div id="left">
				
				<?php 
					$sql = "SELECT * from ".$t_name." where subject='".$t_sub."'";
					$result = mysqli_query($connection, $sql); $i=1;
					while ($row = mysqli_fetch_assoc($result)) {
						echo "<input type='checkbox' value='checkbox' name='a".$row['id']."'>";
						echo $i;?> .&nbsp;&nbsp;&nbsp; <?php
	                    echo "".$row['question'].""; ?> <br><br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
	                    echo "a. ".$row['o1']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
	                    echo "b. ".$row['o2']."";?> <br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
	                    echo "c. ".$row['o3']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
	                    echo "d. ".$row['o4']."";?> <br><br> <?php
	                    $i=$i+1;
	                }
				?>
			</div>
			<input class="set" type="submit" name="set" value="SET"><br><br>
		</form>
		<div id="middle">
			
		</div>
		<div id="" style="position: fixed; text-align: center; background-color: blue; font-size: 1.7em; color: white; top: 10%; width: 49%; margin-left: 50%; ">Selected questions</div>
		<div id="right">
			
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
</body>
</html>