<?php include 'database.php'; ?>
<?php 
//session.........................
	session_start();
    $name = $_SESSION['Username'];
    $password = $_SESSION['Password'];
    $subject = $_SESSION['exam_subject'];
    $number = $_SESSION['number'];
    $duration = $_SESSION['duration'];

    if (!isset($name) || !isset($password))
        header("Location: login_&_Signup.php");
    if (!isset($subject)) {
    	header("location: student.php");
    }
	
//submit answer.....................
    
    if(isset($_POST["Logout"])){
        echo "<script type=''text/javascript>
				window.location.href='login_&_Signup.php';
        	</script>";
        session_destroy();
	}
?>
<!DOCTYPE html>
<html>
<head>

	<title>Student own exam</title>
	<style type="text/css">
		div#full{position: absolute; height: 100%; width: 100%; z-index: -1}
		div#page_name{position: relative; float: left; left: 0%; width: 100%; height: 9%; background-color: blue;  }
		.a{text-transform: uppercase; padding-left: 40%; color: yellow; font-size: 3.5vw }
		div#up_right{position: fixed; float: left; margin-left: 67%; width: 7%; margin-top: 0.8% }
		div#up_right_2{position: fixed; float: left; width: 20%; height: 4%; font-size: 1em; margin-left: 77%; margin-top:0.8%   }
		.start{ width: 100%; padding: 3%;  background-color: green;  border:2px solid #cd853f;  font-size: 1.4vw; color:white; text-transform: uppercase; }
        .start:hover{background-color: #800000;  cursor: pointer; }
        div#left{position: relative; margin-top: 10%; margin-left: 1%; float: left; height: 60%;  color: white;  box-shadow: 5px 5px 5px rgba(0,0,0,0.7) ;  width: 17%; background-color: rgba(0,0,0,0.6); animation-name: m; animation-duration: 3s; overflow: auto; }
        div#right{position: absolute; height: 88%; width: 60%; top: 10%;  left: 20%; z-index: -1; border: 2px solid red; overflow: auto; }
        .done{position: relative; margin-top: 38%;  margin-left: 50%; padding: 0.5%; background-color: sienna; width: 10%;  border-radius: 10px; border:2px solid sienna; color:white; font-size: 1.5vw;box-shadow: 3px 3px 3px 3px rgba(0, 0, 0, 0.7)}
        .done:hover{background-color: #4A3AAD ; border: 2px solid  #4A3AAD; padding: 10px }

        div#up_left{position: fixed; width: 15%; margin-left: 10%;  float: left; top: 3%;  }
		ul{padding: 0; margin: 0; list-style: none;}
		li.nav{float: left; }
		.logout{width: 50%; padding: 2%; float: left;  background-color: green;  border:2px solid #cd853f;  font-size: 1.3vw; color:white; text-transform: uppercase; }
        .logout:hover{background-color: #800000;  cursor: pointer; }
	</style>
</head>
<body>
    <form id="aa" action="" method="post">
		<div id="full">
			<div id="page_name">
				<font class="a"> Questions </font>
			</div>
			<div id="up_left">
				<input id="butt" class="logout"  type="button"  value="My page" onclick="location.href='student.php';" >
				<form action="teacher.php" method="post"> 
	                <input type="submit" class="logout" name="Logout" value="log out" >
	            </form>
			</div>
			<div id="up_right">
				<input class="start" id="start" type="submit" name="start" value="START"  onclick="">
				
			</div>
			<div id="up_right_2">
				<script type="text/javascript">
				var n;
				var countdown;
				var countdownnumber;
				var x = 1;
				function disable1(){
			    		document.getElementById('r').setAttribute("disabled", "disabled");
			    	}
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
			    	else if(n == -1)
			    		 disable1();
			    	}
			    	function disable(){
			    		document.getElementById('start').setAttribute("disabled", "disabled");
			    	}
				</script>
			</div>
			<div id="left">
  		    	<br>
		        <font size="5px" color="#ff4500">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Description </font><br><br>
		        1. Please click the start button to start the exam.<br> 
		        2. When you will click the start button, exam and exam time counting will start.<br>
		        3. You have to submit your answer before the time limit otherwise you will unable to submit answer.<br>
		        4. If you reload the page, then current exam will disappear. Then you have to click the start button to start a new exam.<br>
		        5. After finishing a exam, you will able to start a same exam but different question set by clicking the start button. <br>
		        
      		</div>
			<div id="right">
				<br>
				<?php 
					$n=0;
					if (isset($_POST['start'])) { 
						/*$sql1 = "DROP TABLE ".$password."_questions ";
            			mysqli_query($connection, $sql1);
            			$query1 = "CREATE TABLE ".$password."_questions( id int(10) not null AUTO_INCREMENT, question varchar(200), o1 varchar(20), o2 varchar(20), o3 varchar(20), o4 varchar(20), answer varchar(20), PRIMARY key (id)) ";
        				mysqli_query($connection, $query1);*/
        				$sql = "DELETE from ".$password."_questions";
        				mysqli_query($connection, $sql);
						
						$sql = "SELECT * from all_questions where subject = '".$subject."' ORDER BY RAND() limit ".$number." ";
					    $result = mysqli_query($connection, $sql);
						
						$i=1; $n=2;
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
		                    $e = "INSERT INTO ".$password."_questions(id,question,o1,o2,o3,o4,answer) VALUES('','".$row["question"]."','".$row["o1"]."','".$row["o2"]."','".$row["o3"]."','".$row["o4"]."','".$row["answer"]."')";
	           				mysqli_query($connection, $e);
		                }
		                 
		                echo '<script> countdowninit(); </script>' ;
		                
		                echo '<script> disable(); </script>' ;
					}
					if (isset($_POST['done'])) {
						$sql = "SELECT * from ".$password."_questions ";
					    $result = mysqli_query($connection, $sql);
						
						$i=1; $n=2;
						while ($row = mysqli_fetch_assoc($result)) {
							echo $i;?> .&nbsp;&nbsp;&nbsp; <?php
		                    echo "".$row['question'].""; ?> <br><br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
		                    
		                    echo "a. ".$row['o1']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
		                    
		                    echo "b. ".$row['o2']."";?> <br>&nbsp;&nbsp;&nbsp;&nbsp; <?php
		                    
		                    echo "c. ".$row['o3']."";?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php
		                    
		                    echo "d. ".$row['o4']."";?> <br><br>&nbsp;&nbsp;&nbsp; <?php
		                    echo "Aanswer: ".$row['answer']."";?> <br><br> <?php 
		                    $i=$i+1; 
		                    
		                }
					}
						
				?>
			</div>
			<input class="done" id="r" type="submit" name="done" value="SUBMIT" ><br><br>
		
		</div>
	</form>
	<div style="position: fixed; height: 10%; width: 12%; border:2px solid blue; right: 3%; top: 12%; text-align: center; padding-top:1% ">
		.......MARKS.......
		<?php
		
		$ans = array();
		$e = 0;
		$j = 1; 
		$i=0;
		$count = 0;
		
		for($j=1; $j<=$number; $j++){
			$ans[$j] = isset($_POST['radio'.$j.'']) ? $_POST['radio'.$j.''] : "";
		}
		
		$sql = "SELECT * from ".$password."_questions ";
		$result = mysqli_query($connection, $sql);
		while($row = mysqli_fetch_assoc($result)){
			$e = 1;
		}
		
		if (isset($_POST['done'])) {
	    	
	    	if($e == 1){
		    	$sql = "SELECT * from ".$password."_questions  ";
				$result = mysqli_query($connection, $sql); $i=1;
				while ($row = mysqli_fetch_assoc($result)) {
					if ($ans[$i] == $row['answer']) {
						$count++;
					} 	$i = $i + 1 ;
				}
				echo "Obtained marks: "; echo $count ;
	        }
        }
	    
    ?>
	</div>
	
</body>
</html>