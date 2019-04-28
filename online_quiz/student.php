<?php include 'database.php' ; ?>

<?php 
	session_start();
//taking value from input form......................................................	
	$name = $_SESSION['Username'];
	$pass = $_SESSION['Password'];

	if (!isset($name) || !isset($pass)) {
		header("location:login_&_Signup.php");
	}

	$sql = "SELECT * FROM student where username = '".$name."' AND password ='".$pass."' ";
	$result = mysqli_query($connection, $sql);
	if (mysqli_num_rows($result) == 0) {
		header("location:login_&_Signup.php");
	}
?>
<?php
//add subject to student page......................................................
	$value6 = 0;
	$subject = isset($_POST['sub']) ? $_POST["sub"] : "";

    if(isset($_POST["add"])){
   
	    $query = "SELECT subject FROM student_".$name."_subject Where subject = '" . $subject ."' ";
	    $result = mysqli_query($connection, $query);
	    if(mysqli_num_rows($result) == 1){
	      $value6 = 3;
	    }
	    else{  $value6 = 2; }
	    
	    if($value6 == 2){
	        $query1 = "INSERT INTO student_".$name."_subject(subject) VALUES ('$subject')";
	        mysqli_query($connection , $query1);
	    }


	}

//Go to exam....................................................................
    $value = 0;
    $value1 = 0;
	$exam_n = isset($_POST['exam_name']) ? $_POST["exam_name"] : "";
	$exam_c = isset($_POST['exam_code']) ? $_POST["exam_code"] : "";
	
	$_SESSION['exam_code'] = $exam_c;

	if(isset($_POST["next"])){
		$sql = "SELECT code from exams where code = '".$exam_c."' ";
		$result1 = mysqli_query($connection, $sql);
		if (mysqli_num_rows($result1) == 1 ) {
			$value1 = 1;
		}
		else{$value1 = 2;}
	}
	if ($value1 == 1) {
		$query = "SELECT password FROM ".$exam_c."_given Where password = '" . $pass ."' ";
		$result = mysqli_query($connection, $query);
		if (mysqli_num_rows($result) == 1 ) {
			$value = 1;
		}
		else{$value = 2;}
	}
//taking information of student who participate in the exam............................................	
	$sql = "SELECT roll_no from student where username = '".$name."'";
	$result = mysqli_query($connection, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
		$roll = $row['roll_no'];
	}
	if ($value == 2 && $value1 == 1) {
		$sql = "INSERT INTO ".$exam_c."_given(id,password,roll_no) VALUES ('', '".$pass."', '".$roll."') ";
		mysqli_query($connection, $sql);
		$sql1 = "DROP TABLE student_".$pass."_time ";
        mysqli_query($connection, $sql1);
		$query2 = "CREATE TABLE student_".$pass."_time( id int(2) not null AUTO_INCREMENT,time varchar(2),PRIMARY key (id)) ";
        mysqli_query($connection , $query2);
        header("location:student_exam.php");
	}
// Student own exam....................................................................................	
	$e = 0;
	$exam_subject = isset($_POST['exam_subject']) ? $_POST["exam_subject"] : "";
	$_SESSION["exam_subject"] = $exam_subject;
	$number = isset($_POST['number']) ? $_POST["number"] : "";
	$_SESSION["number"] = $number;
	$duration = isset($_POST['duration']) ? $_POST["duration"] : "";
	$_SESSION["duration"] = $duration;

	if (isset($_POST["exam"])) {
		if(!empty($exam_subject) && !empty($number) && !empty($duration)){
			
			header("location:student_own_exam.php");
		}
		else {
			$e = 1;
		}
	}
//logout............................................................................................... 
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
	<title>student page</title>
	<style type="text/css">
	    body{background-color: #6FD096; background-size: cover; background-repeat: no-repeat; padding: 0; margin: 0;}
		div#full{position: absolute; height: 100%; width: 100%; z-index: -1}
		div#page_name{position: fixed; float: left; left: 0%; width: 100%; height: 9%; background-color: #515151;  }
		div#up_right{position: relative; float: right; margin-right: 10%; width: 20%; margin-top: 0.8%; }
		.p_n{text-transform: uppercase; padding-left: 35%; color: yellow; font-size: 3.5vw;  }
		ul{padding: 0; margin: 0; list-style: none;}
		li.nav{float: left; }
		a#link{display: block; text-decoration: none; padding: 8px 17px; color:white; font-size: 1em; border:2px solid #cd853f; background-color: green;  }
		a#link:hover{background-color:#800000 }
		.logout{height: 2.4em; width: 6em; padding: 6px; float: left;  background-color: green;  border:2px solid #cd853f;  font-size: 1.1vw; color:white; text-transform: uppercase; }
        .logout:hover{background-color: #800000;  cursor: pointer; }
        div#right{position: absolute; height: 89%; width: 30%;  margin-left: 69.5%; top: 9%; z-index: -1 }
        div#right_up{position: absolute; height: 20%; width: 70%; top: 6%; margin: 0% 15%;  text-align: center; font-family: comic sans ms;   }
        .exam_button{ width: 100%; border-radius: 20px; background-color: rgba(0,0,0,0); color:blue; border: 2px solid white; font-size: 1.4vw; font-family: comic sans ms; }
        .error{position: absolute; top: 4%; margin-left: 35% }
        .error1{position: absolute; top: 80%; margin-left: 30%;  }
        .exam_button:hover{background-color: blue; color: yellow; cursor: pointer;}
        ul{padding: 0; margin: 0; list-style: none;}
        li.rnav{width: 100%}
        .rm{ font-size: 1.5em; font-weight: bold; color: white;}
        div#middle{position: absolute; top: 31%; height: 33%; width: 97%; border-radius: 10px; border:3px solid white; text-align: center; overflow: auto; }
        div#right_down{position: absolute; top: 65.5%; height: 34.5%; width: 97%; overflow: auto; border-radius: 10px; border:3px solid white;  text-align: center; }
        div#left{position: absolute; top: 9%; width: 69%; height: 90%; overflow: scroll; z-index: -1; font-size: 2vw}
        .a:hover{}

        div#mymodal{
            display: none; 
        	position: fixed; 
        	z-index: 1;
            padding-top: 100px;     
        	left: 0; 
            top: 0; 
        	width:100%; 
        	height: 100%;
        	overflow: auto;
            background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);
            }
            
	        div#modal_content{
	        	position: relative; 
	        	background-color: #c2b9b0;
	        	margin: auto;
	        	border: 1px solid #888; 
	        	width: 30%; 
	        	box-shadow: 0 4px 8px 0 rgba(0,0,0,0,2),0 6px 20px 0 rgba(0,0,0,0.9); 

	            animation-duration:1.4s; 
	            animation-name: animate_examcreate;
	            }
	        @keyframes animate_examcreate{ 
	            from{top: -300px; opacity: 0}

	                100%{top:0px; opacity:1;
	                    transform: rotate(360deg);
	                }
				}

	        .close{
	            color:white; 
	            float: right; 
	            font-size: 28px; 
	            font-weight: bold;
	        }
	        .close:hover,
	        .close:focus{
	            color:#000; 
	            text-decoration: none;
	            cursor: pointer;
	         }
	        div#modal_header{
	            text-align: center;
	            padding: 2px 16px; 
	            background-color: #5d5c61;
	            color: white;
	         }
	        div#modal_body{
	            text-align: center;
	            padding: 20px 16px;
	        }
	        div#modal_footer{
	            text-align: center;
	            padding: 5px 16px;
	            background-color: #5d5c61; 
	            color: white; 
	        }
	        .option{height: 25px; width: 160px; border-radius: 10px; border: 1px solid white; transition-duration: 0.3s; line-height: 20px}
	        .option:hover{padding: 3px}

        div#mymodala{
            display: none; 
        	position: fixed; 
        	z-index: 1;
            padding-top: 100px;     
        	left: 0; 
            top: 0; 
        	width:100%; 
        	height: 100%;
        	overflow: auto;
            background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);
            }
            
	        div#modal_contenta{
	        	position: relative; 
	        	background-color: #c2b9b0;
	        	margin: auto;
	        	border: 1px solid #888; 
	        	width: 30%; 
	        	box-shadow: 0 4px 8px 0 rgba(0,0,0,0,2),0 6px 20px 0 rgba(0,0,0,0.9); 

	            animation-duration:1.4s; 
	            animation-name: animate_addsubject;
	            }
	        @keyframes animate_addsubject{ 
	            from{top: -300px; opacity: 0}

	                100%{top:0px; opacity:1;}
				}
	        .closea{
	            color:white; 
	            float: right; 
	            font-size: 28px; 
	            font-weight: bold;
	        }
	        .closea:hover,
	        .closea:focus{
	            color:#000; 
	            text-decoration: none;
	            cursor: pointer;
	         }
	        div#modal_headera{
	            text-align: center;
	            padding: 2px 16px; 
	            background-color: #5d5c61;
	            color: white;
	         }
	        div#modal_bodya{
	            text-align: center;
	            padding: 40px 16px;
	        }
	        div#modal_footera{
	            text-align: center;
	            padding: 5px 16px;
	            background-color: #5d5c61; 
	            color: white; 
	        }
	     	

	        .d_modal{ width:22%; font-size: 0.9vw; padding: 2%; border-radius:2px dotted white; background-color: black; color:white}
	        .d_modal:hover{background-color: #1e90ff}
	        .a:hover{transform:scale(1.2);box-shadow:3px 3px 3px rgba(0,0,0,0.7);}
	        .modal_button{height: 40px; width:60%; border-radius:2px dotted white; border-radius:  10px; background-color: sienna; font-size: 15px; color:white}
	        .modal_button:hover{background-color: #1e90ff}
	</style>
</head>
<body>

	<div id="full">
		<div id="page_name">
			<font size="" class="p_n">fgf <?php echo $name; echo "'s home"; ?> </font>
		</div>
		<div id="up_right">
			<input id="but" class="logout"  type="button"  value="My page" onclick="location.href='student.php';" >
			<form action="" method="post"> 
                <input type="submit" class="logout" name="Logout" value="log out">
            </form>
		</div>
		<div id="left">
			<?php 

				$query = "SELECT subject from student_".$name."_subject";
				$result = mysqli_query($connection, $query);

				while($option=mysqli_fetch_array($result)){
					echo "<a href='subject_student.php?subject={$option["subject"]}'> ";
					echo "<div class='a' style='height:12%; width:25%; float:left; margin-left: 6%; margin-top: 5%; transition: all 0.3 ease;
					transition-duration:0.3s;  padding-top:2%; border-radius:5px 70px 5px 5px; box-shadow: 5px 5px 5px rgba(0,0,0,0.7); color:white; background-color:#515151;
					  text-align:center; '>";
					echo "		<font>".$option["subject"]."</font>";
					echo "	 </div>";
					echo	 "</a>";
				}
			?>
		</div>
		<div id="right">
			<div class="error"><?php if(isset($_POST["add"])){if($value6 == 3) {echo "*already exists.";} } ?></div>
			<div id="right_up">
			
				<ul>
					<input type="button" id="button1" class="exam_button" name="Logout" value="ADD SUBJECT" ><br><br>
					<input type="button" id="butt" class="exam_button" name="" value="Exam" ><br>
					<div class="error1"><?php if(isset($_POST["next"])){if($value == 1) {echo "*already done.";} elseif ($value1 == 2) {
						echo "Exam code error.";
					} } ?></div>
				</ul>
			</div>
			
			<div id="middle">
				
				<div id="" style="width: 100%; background-color: rgba(0,0,0,0.4); ">
					<font class="rm" >Create own exam</font>
				</div>
				<?php if(isset($_POST["exam"])){if($e == 1) {echo "*all fields required.";} } ?>
			<br>
				<form action="" method="post">
					<font size="4em">Subject : </font>&nbsp;&nbsp;&nbsp;&nbsp;	
					<select class="option1"  name="exam_subject" style="outline: none; font-size: 1em; width: 50%; " >
	                    <?php 
	                        $q = "Select subject from all_subject";
	                        $r = mysqli_query($connection, $q);
	                    
	                        while($option = mysqli_fetch_assoc($r)) {
	                            echo "<option>" . $option["subject"] . "</option>";
	                        }
	                    ?>
	                </select><br>
	                <font size="4em">Number : </font>&nbsp;&nbsp;&nbsp;
	                <input type="text" style=" font-size: 1em; width: 50%" name="number" style="outline: none; " ><br>
	                <font size="4em">Duration : </font>&nbsp;
	                <input type="text" style=" font-size: 1em; width: 50%" name="duration"><br><br>
					<input type="submit" class="d_modal" name="exam" value="LET'S TEST"><br><br>
				</form>
			</div>
			
			<div id="right_down">
				<div id="" style="width: 100%; background-color: rgba(0,0,0,0.4); ">
					<font class="rm" >Result of exams</font>
				</div>
				<br>
				<form action="" method="post">
					<font size="4em">&nbsp;&nbsp;Exam code : </font><br>
					<input type="text" style=" font-size: 1em; width: 50%" name="e_code"><br><br>
					<input type="submit" class="d_modal" name="see_marks" value="LET'S SEE"><br><br>
					<?php 
//see result of a certain exam......................................................................									
					    $v = 0; $v1 = 0; $v2 = 0; $v3 = 0; $v0 = 0;
						$exam_code = isset($_POST['e_code']) ? $_POST["e_code"] : "";
						$sql = "SELECT * from exams where code = '".$exam_code."' ";
						$result = mysqli_query($connection, $sql);
						if(mysqli_num_rows($result) == 1){
							$v = 1;
						}
						else{ $v = 2;}
						if (isset($_POST['see_marks'])) {
							if(!empty($exam_code)){
								if($v == 1){
									$sql = "SELECT marks from ".$exam_code."_result where password = '".$pass."' ";
									$result = mysqli_query($connection, $sql);
									while($row = mysqli_fetch_assoc($result)){
										echo "Obtained marks :"; echo $row['marks'];
									}
									$sql1 = "SELECT password from ".$exam_code."_given where password = '".$pass."' ";
									$result = mysqli_query($connection, $sql1);
									if (mysqli_num_rows($result) == 1) {
									 	$v1 = 1;
									 } 
									else{$v1 = 2;}
									$sql2 = "SELECT password from ".$exam_code."_result where password = '".$pass."' ";
									$result = mysqli_query($connection, $sql2);
									if (mysqli_num_rows($result) == 1) {
									 	$v2 = 1;
									 } 
									else{$v2 = 2;}
								}
								else{ $v0 = 1;}
							}
							else{ $v3 = 1;}
					    }
						if($v0 == 1){
							echo "*invalid exam code.";
						}
						if ($v1==2 ) {
							echo "*You did not participate in this exam.";
						}
						if ($v1 == 1 && $v2 == 2) {
							echo "*Obtained marks: 0";
						}
						if($v3 == 1){
							echo "*Please give a exam code.";
						}
					?>
				</form>
			</div>
		</div>
		<div  id="mymodal">
            <div  id="modal_content">
                <div id="modal_header">
                    <span class="close">&times;</span>
                    <h2> Please give the following information..?</h2>
                </div> 
                <div id="modal_body">
                	<form action="" method="post">
	                    <font style="color:#000000; font-size: 2em">Exam name :&nbsp;</font><br>
	                    <input type="text" name="exam_name" style="width: 60%; font-size: 1em; border-radius: 10px"><br><br>
	                    <font style="color:#000000; font-size: 2em">Exam code :&nbsp;&nbsp;</font><br>
	                    <input type="text" name="exam_code" style="width: 60%; font-size: 1em;border-radius: 10px"><br><br>
                    	<input type="submit" class="d_modal" name="next" value="NEXT-->">
                    </form>
                </div>  
                <div id="modal_footer">
                    <font>Exam code have to be correct.</font>
                </div>
            </div>
        </div>
	    <script type="text/javascript">
	    	var modal = document.getElementById('mymodal');
	    	var btn = document.getElementById("butt");
	    	var span = document.getElementsByClassName("close")[0];
	    	btn.onclick = function(){
	    		modal.style.display = "block";
	    		if (isset($_POST["next"])){if($value2==2) {modal.style.display="block";}}
	    	}
	    	span.onclick = function(){
	    		modal.style.display = "none";
	    	}
	    	window.onclick = function(event){
	    		if(event.target == modal){
	    			modal.style.display = "none";
	    		}
	    	}
	    </script>

        <div id="mymodala">
            <div id="modal_contenta">
                <div id="modal_headera">
                    <span class="closea">&times;</span>
                    <h2>Add a subject</h2>
                </div> 
                <div id="modal_bodya">
                    <form action="" method="post">
                        <font style="color:#000000; font-size: 2em">Subject:&nbsp;&nbsp;&nbsp;</font>
                        <select class="option" name="sub" style=" width: 50%; font-size: 1em;" >
	                    <?php 
	                        $q = "Select subject from all_subject";
	                        $r = mysqli_query($connection, $q);
	                    
	                        while($option = mysqli_fetch_assoc($r)) {
	                            echo "<option>" . $option["subject"] . "</option>";
	                        }
	                    ?>
	                    </select><br><br><br>
                        <input class="d_modal" style=" "  type="submit" name="add" value="ADD">
                    </form>
                </div>  
                <div id="modal_footera">
                    <font>This subject will be add in your subject type</font>
                </div>
            </div>
        </div>
	    <script type="text/javascript">
	    	var modala = document.getElementById('mymodala');
	    	var btna = document.getElementById("button1");
	    	var spana = document.getElementsByClassName("closea")[0];
	    	btna.onclick = function(){
	    		modala.style.display = "block";
	    	}
	    	spana.onclick = function(){
	    		modala.style.display = "none";
	    	}
	    	window.onclick = function(event){
	    		if(event.target == modala){
	    			modala.style.display = "none";
	    		}
	    	}
	    </script>

	</div>

</body>
</html>