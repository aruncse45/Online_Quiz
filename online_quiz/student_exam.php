<?php include 'database.php'; ?>
<?php 
//session.........................
	session_start();
    $name = $_SESSION['Username'];
    $password = $_SESSION['Password'];
    $e_code = $_SESSION['exam_code'];

    if (!isset($name) || !isset($password))
        header("Location: login_&_Signup.php");
    if (!isset($e_code)) {
    	header("location: student.php");
    }
	
//submit answer.....................
    
    $sql = "SELECT duration from exams where code = '".$e_code."'";
		$result = mysqli_query($connection, $sql);
		while ($row = mysqli_fetch_assoc($result)) {
			$duration = $row['duration'];
		}
    
    
?>
<!DOCTYPE html>
<html>
<head>

	<title>Students exam given by teacher</title>
	<style type="text/css">
		div#full{position: absolute; height: 100%; width: 100%; z-index: -1}
		div#page_name{position: relative; float: left; left: 0%; width: 100%; height: 9%; background-color: blue;  }
		.a{text-transform: uppercase; padding-left: 35%; color:yellow; font-size: 3.5vw; }
		div#up_right{position: relative; float: right; margin-right: 25%;  width: 7%; margin-top: 0.8% }
		div#up_right_2{position: relative;  float: left; width: 20%; height: 40%; font-size: 1em; margin-left: 77%; margin-top: -3%;  }
		.start{ width: 100%; padding: 3%;  background-color: green;  border:2px solid #cd853f;  font-size: 1.4vw; color:white; text-transform: uppercase; }
        .start:hover{background-color: #800000;  cursor: pointer; }
        div#left{ margin-top: 10%; margin-left: 1%; float: left; height: 50%; overflow: auto; color: white;  box-shadow: 5px 5px 5px rgba(0,0,0,0.7) ;  width: 17%; background-color: rgba(0,0,0,0.6); animation-name: m; animation-duration: 3s; 
        	}
        div#right{position: absolute; height: 88%; width: 60%; top: 10%;  left: 20%; z-index: -1; border: 2px solid red; overflow: auto; }
        .done{position: relative; margin-top: 38%;  margin-left: 50%; padding: 0.5%; background-color: sienna; width: 10%;  border-radius: 10px; border:2px solid sienna; color:white; font-size: 1.5vw;box-shadow: 3px 3px 3px 3px rgba(0, 0, 0, 0.7)}
        .done:hover{background-color: #4A3AAD ; border: 2px solid  #4A3AAD; padding: 10px }
	</style>
</head>
<body>
    <form id="aa" action="" method="post">
		<div id="full">
			<div id="page_name">
				<font size="10px" class="a"> Questions </font>
				<div id="up_right">
					<input class="start" id="start" type="submit" name="start" value="START"  onclick="">
				</div>
				<div id="up_right_2">
					<script type="text/javascript">
					var n;
					var countdown;
					var countdownnumber;
					var x = 1;
					var a = [];
					
					function countdowninit(){
						if(x == 1){	
						n =<?php echo $duration-1; ?> 
						
						countdownnumber = 61;
						countdowntrigger();
					    }
					}
					function countdowntrigger(){
						if(n>=0){
						if (countdownnumber>0) {
							countdownnumber--;
							document.getElementById('up_right_2').innerHTML ="Time remaining:"+n+":"+countdownnumber;

					    	if (countdownnumber>0) {
						    countdown = setTimeout("countdowntrigger()",1000);
					    	}
					    	if (countdownnumber==0) { n--; countdownnumber=60; countdowntrigger();}
				    		}
				    	}
				    	else if(n == -1){
				    		
				    		window.location.href='student.php';}
				    	}
				    	function disable(){
				    		document.getElementById('start').setAttribute("disabled", "disabled");
				    	}
					</script>
				</div>
			</div>
			
			<div id="left">
  		    	<br>
		        <font size="5px" color="#ff4500">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Description </font><br><br>
		        1. Please click the start button to start the exam.<br> 
		        2. When you will click the start button, exam and exam time counting will start.<br>
		        3. You have to submit your answer before the time limit otherwise you will unable to submit answer.<br>
		        4. If you reload the page, then current exam will disappear. You will be disqualify for this exam.<br>
		    </div>
			<div id="right">
				<br>
				<?php 
					$e = 0;
					if (isset($_POST['start'])) {
						$sql1 = "SELECT * from student_".$password."_time where time='1' ";
						$result = mysqli_query($connection, $sql1);
						if(mysqli_num_rows($result) == 1){
							$e=1;
						}
						else{$e=2;}
					}
						if($e==2){
						$sql = "SELECT * from ".$e_code." ";
						$result = mysqli_query($connection, $sql);
						$i=1;
						
						while ($row = mysqli_fetch_assoc($result)) {
							echo $i;?> .&nbsp;&nbsp;&nbsp; <?php
		                    echo "".$row['question'].""; ?> <br><br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
		                    echo "<input type='radio' value='".$row['o1']."' name='radio".$i."'>";
		                    echo "".$row['o1']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
		                    echo "<input type='radio' value='".$row['o2']."' name='radio".$i."'>";
		                    echo "".$row['o2']."";?> <br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
		                    echo "<input type='radio' value='".$row['o3']."' name='radio".$i."'>";
		                    echo "".$row['o3']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
		                    echo "<input type='radio' value='".$row['o4']."' name='radio".$i."'>";
		                    echo "".$row['o4']."";?> <br><br> <?php
		                    $i=$i+1;
		                } 
		                echo '<script> countdowninit(); </script>' ;
		                echo '<script> disable(); </script>' ;
		                $sql2 = "INSERT INTO student_".$password."_time(id,time) VALUES ('','1')";
		                mysqli_query($connection,$sql2);
					}
					if ($e == 1) {
						header("location:student.php");
					}
						
					?>
			</div>
			<input class="done" type="submit" name="done" value="SUBMIT" ><br><br>
		
		</div>
	</form>
	<?php
		$ans = array();
		$j = 1; 
		$i=0;
		$count = 0;
		$sql = "SELECT * from ".$e_code." ";
		$result = mysqli_query($connection, $sql);
		$i=1;
		while ($row = mysqli_fetch_assoc($result)) { $i +=1;}
		for($j=1; $j<=$i; $j++){
			$ans[$j] = isset($_POST['radio'.$j.'']) ? $_POST['radio'.$j.''] : "";
		}
	    if (isset($_POST['done'])) {
	    	$sql = "SELECT * from ".$e_code." ";
			$result = mysqli_query($connection, $sql); $i=1;
			while ($row = mysqli_fetch_assoc($result)) {
				if ($ans[$i] == $row['answer']) {
					$count++;
				} $i = $i + 1 ;
			}
			$sql = "SELECT roll_no from student where username = '".$name."'";
			$result = mysqli_query($connection, $sql);
			while ($row = mysqli_fetch_assoc($result)) {
				$roll = $row['roll_no'];
			}
			$sql1 = "INSERT INTO ".$e_code."_result(id,password,roll_no,marks) VALUES ('','".$password."', '".$roll."', '".$count."')";
			mysqli_query($connection, $sql1);
			$sql1 = "DROP TABLE student_".$password."_time ";
            mysqli_query($connection, $sql1);
			header("location: student.php");
	    }
    ?>
    
    
</body>
</html>