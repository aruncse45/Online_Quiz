<?php include 'database.php' ; ?>

<?php 
	session_start();
//taking value from input form.........................................................	
	$name = $_SESSION['Username'];
	$pass = $_SESSION['Password'];
	if (!isset($name) || !isset($pass)) {
		header("location:login_&_Signup.php");}
	$sql = "SELECT * FROM teacher where username = '".$name."' AND password ='".$pass."' ";
	$result = mysqli_query($connection, $sql);
	if (mysqli_num_rows($result) == 0) {
		header("location:login_&_Signup.php");
	}
	
?>
<?php
	//add subject......................................................................
	$subject = isset($_POST['sub']) ? $_POST["sub"] : "";

    if(isset($_POST["add"])){
    
	    $query = "SELECT subject FROM " . $name . "_subject Where subject = '" . $subject ."' ";
	    $result = mysqli_query($connection, $query);
	    if(mysqli_num_rows($result) == 1){
	      $value = 1;
	    }
	    else{  $value = 0; }
	    
	    if($value == 0){
	        $query1 = "INSERT INTO " . $name . "_subject(subject) VALUES ('$subject')";
	        mysqli_query($connection , $query1);
		}
   	}
//add subject into all subjects list....................................................................
    if(isset($_POST["add"])){
   
	    $query = "SELECT subject FROM all_subject Where subject = '" . $subject ."' ";
	    $result = mysqli_query($connection, $query);
	    if(mysqli_num_rows($result) == 1){
	      $value = 1;
	    }
	    else{  $value = 0; }
	    
	    if($value == 0){
	        $query1 = "INSERT INTO all_subject(subject) VALUES ('$subject')";
	        mysqli_query($connection , $query1);
	        
		}
   	}

//unique exam name, exam code checking...........................................................
    $value = 0;
    $value1 = 0;
    $value2 = 0;
	$subject1 = isset($_POST['sub1']) ? $_POST["sub1"] : "";
	$exam_n = isset($_POST['exam_name']) ? $_POST["exam_name"] : "";
	$exam_c = isset($_POST['exam_code']) ? $_POST["exam_code"] : "";
	//$s = $exam_n+$exam_c;
	$date = isset($_POST['date']) ? $_POST["date"] : "";
	$duration = isset($_POST['duration']) ? $_POST["duration"] : "";
	$qus_sys = isset($_POST['qus_system']) ? $_POST["qus_system"] : "";
	$_SESSION['sub1'] = $subject1;
	$_SESSION['exam_code'] = $exam_c;

	if(isset($_POST["next"])){
		$query = "SELECT exam_code FROM " . $name . "_exam Where exam_code = '" . $exam_c ."' ";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1){
          $value1 = 1;
		}
        else{  $value1 = 2; }

        $query = "SELECT code FROM exams WHERE code = '" . $exam_c ."' ";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1){
          $value2 = 1;
		}
        else{  $value2 = 2; }

	}
//create exam......................................................................................    
    if(isset($_POST["next"]) && $value1 == 2 && $value2 == 2){
    	if(!empty($subject1) && !empty($exam_n) && !empty($exam_c) && !empty($date) && !empty($duration) && !empty($qus_sys) ){
        	$query = "INSERT INTO " . $name . "_exam(subject, exam_name, exam_code, date, duration, qus_system) VALUES ('$subject1','$exam_n','$exam_c', '$date', '$duration', '$qus_sys') ";
        	mysqli_query($connection, $query);
        	$sql = "INSERT INTO exams(id,name,code,duration) VALUES('','$exam_n','$exam_c','$duration')";
        	mysqli_query($connection, $sql);
        	
        	$query1 = "CREATE TABLE ".$exam_c."( id int(10) not null AUTO_INCREMENT, question varchar(200), o1 varchar(20), o2 varchar(20), o3 varchar(20), o4 varchar(20), answer varchar(20), PRIMARY key (id)) ";
        	mysqli_query($connection, $query1);

        	$query2 = "CREATE TABLE ".$exam_c."_result(id int(10) not null AUTO_INCREMENT, password varchar(20), roll_no varchar(20), marks varchar(20), PRIMARY key (id) ) ";
        	mysqli_query($connection, $query2);

        	$query3 = "CREATE TABLE ".$exam_c."_given(id int(10) not null AUTO_INCREMENT, password varchar(20), roll_no varchar(20), PRIMARY key (id) ) ";
        	mysqli_query($connection, $query3);
        	if ($qus_sys == "Create new Question") {
        		header("location:create_exam_questions.php");
        	}
        	elseif ($qus_sys == "Randomly from Question bank") {
        		header("location:random_question_set.php");
        	}
        	elseif ($qus_sys == "Selecting from Question bank") {
        		header("location:selection.php");
        	}
		}
		else{ $value = 0;}
	}
	//auto delete finished(time) exam tables........................................................................
  	$sql = "SELECT * FROM ".$name."_exam";
	$result = mysqli_query($connection, $sql);
	if (isset($_POST["delete"])) {
		$current_date = strtotime('now');
		while ($row = mysqli_fetch_assoc($result)){
            $finish_date = strtotime($row['date']);
            if ($finish_date < $current_date) {
            	$s = "DELETE FROM ".$name."_exam where id = '".$row['id']."' ";
                mysqli_query($connection, $s);
                $s1 = "DELETE FROM exams where code = '".$row['exam_code']."' ";
                mysqli_query($connection, $s1);
                $sql = "DROP TABLE ".$row['exam_code']." ";
                mysqli_query($connection, $sql);
                $sql1 = "DROP TABLE ".$row['exam_code']."_result ";
                mysqli_query($connection, $sql1);
                $sql2 = "DROP TABLE ".$row['exam_code']."_given ";
                mysqli_query($connection, $sql2);
            }
		}
	}

//Result of exams..............................................................................	
	$v = 0; $w = 0;
	$exam_code = isset($_POST['e_code']) ? $_POST["e_code"] : "";
	$_SESSION['e_code']= $exam_code;

	if (isset($_POST['see_marks'])) {
		if (empty($exam_code)) {
			$w = 1;
		}
		else{
			$sql = "SELECT code from exams where code = '".$exam_code."' ";
			$result = mysqli_query($connection, $sql);
			if (mysqli_num_rows($result) == 1) {
			 	$v = 1;
			} 
			else{$v = 2;}

			$sql = "SELECT exam_code from ".$name."_exam where exam_code = '".$exam_code."' ";
			$result = mysqli_query($connection, $sql);
			if (mysqli_num_rows($result) == 1) {
			 	$w = 2;
			} 
			else{$w = 3;}
		}
	}
	if($v == 1 && $w == 2){
		header("location: exam_marks.php");
	}

////logout.........................................................................................
	if(isset($_POST["Logout"])){
    	$sql4=" DELETE  FROM  " . $name . "_recent" ;
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
	<title>Teachers page</title>
	<style type="text/css">
	    body{ background-size: cover; background-color: #6FD096; background-repeat: no-repeat; margin: 0; padding: 0;}
		div#full{position: absolute; height: 100%; width: 100%; z-index: -1}
		div#page_name{position: fixed; float: left; left: 0%; width: 100%; padding: .5% 0%; background-color: #515151; font-size:3vw;}
		.p_n{text-transform: uppercase; padding-left: 35%; color: yellow  }
		div#up_right{position: fixed; width: 25%; float: left; top: 2.5%; margin-left: 72%; }
		ul{padding: 0; margin: 0; list-style: none;}
		li.nav{float: left; }
		a#link{display: block; text-decoration: none; padding: 8px 17px; color:white; font-size: 17.35px; border:2px solid #cd853f; background-color: green;  }
		a#link:hover{background-color:#800000 }
		.logout{ width: 33.33%; padding: 1.5%; float: left; font-size: 1.1vw; background-color: green;  border:2px solid #cd853f;   color:white; text-transform: uppercase; }
        .logout:hover{background-color: #800000;  cursor: pointer; }
        div#right{position: absolute; height: 89%; width: 29%;  margin-left: 70%; top: 9%; z-index: -1 }
        div#right_up{position: relative;  float: left; height: 20%; width: 70%; margin: 5% 15%;  text-align: center;  font-family: comic sans ms;  }
        .exam_button{width: 100%; border-radius: 20px; padding: 1.5%; background-color: rgba(0,0,0,0); color:blue; border: 2px solid white; font-size: 1.2vw; font-family: comic sans ms; }
        .exam_button:hover{background-color: blue; color: yellow; cursor: pointer;}
        ul{padding: 0; margin: 0; list-style: none;}
        li.rnav{width: 100%}
        .rlink{display: block; text-decoration: none; padding: 1.5%; font-size: 1.2vw; background-color: rgba(0,0,0,0); color: blue; border:2px solid white; border-radius: 20px }
        .rlink:hover{background-color: blue; color: yellow}
        div#r1{position: relative; float: left; width: 100%; border: 2px solid blue; text-align: center;  background-color: rgba(0,0,0,0.4);  }
        form#running_exam{position: relative; float: left; height: 38%; width: 100%;}
        div#right_middle{position: relative; float: left; height: 80%; width: 100%; 	 overflow: auto; font-size: 1em}
        .rm{ font-size: 25px; font-weight: bold; color: white}
        div#r2{position: relative; float: left; width: 100%; text-align: center; border: 2px solid blue; background-color: rgba(0,0,0,0.4);  }
        div#right_down{position: relative; float: left; height: 29%; width: 100%; text-align: center; overflow: auto;}
        div#left{position: absolute; top: 9%; width: 69.7%; height: 90%;  overflow: auto; z-index: -1; border-right: 5px solid green; font-size: 2vw}
        .a:hover{}

        div#mymodal{
            display: none; 
        	position: fixed; 
        	z-index: 1;
            padding-top: 7%;     
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
	            padding: 40px 16px;
	        }
	        div#modal_footer{
	            text-align: center;
	            padding: 5px 16px;
	            background-color: #5d5c61; 
	            color: white; 
	        }
	        .exam_form_button{width:25%; padding:2%; font-size: 1.2vw border-radius:2px dotted white; border-radius:  10px; background-color: sienna;  color:white}
	        .exam_form_button:hover{background-color: #1e90ff}

	        .option{width: 45%; border-radius: 10px; font-size: 1em; border: 1px solid white; transition-duration: 0.3s; line-height: 20px}
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
	     	

	        .d_modal{width:25%; padding: 1.5%; font-size: 1.2vw; border-radius:2px dotted white; background-color: black; color:white}
	        .d_modal:hover{background-color: #1e90ff}
	        .clear{width:100%; padding: 1.5%; font-size: 1.2vw; margin-top: 1%;  background-color: white; color:blue}
	        .clear:hover{background-color: #1e90ff}
	        .a:hover{transform:scale(1.2);box-shadow:3px 3px 3px rgba(0,0,0,0.7);}

        
	        .modal_button{height: 40px; width:60%; border-radius:2px dotted white; border-radius:  10px; background-color: sienna; font-size: 15px; color:white}
	        .modal_button:hover{background-color: #1e90ff}
	</style>
</head>
<body>

	<div id="full">
		<div id="page_name">
			<font  class="p_n"> <?php echo "Sir "; echo $name; echo "'s home"; ?> </font>
		</div>
		<div id="up_right">
			<ul>
				<input type="button" id="button" class="logout" name="Logout" onclick="location.href='teacher.php';" value="MY PAGE" >
				<input type="button" id="button1" class="logout" name="Logout" value="ADD SUBJECT" >
			</ul>
			<form action="teacher.php" method="post"> 
                <input type="submit" class="logout" name="Logout" value="log out">
            </form>
		</div>
		<div id="left">
			<?php 

				$query = "SELECT subject from ".$name."_subject";
				$result = mysqli_query($connection, $query);

				while($option=mysqli_fetch_array($result)){
					echo "<a href='subject_teacher.php?subject={$option["subject"]}'> ";
					echo "<div class='a' style='height:12%; width:25%; float:left; margin-left: 6%; margin-top: 5%; transition: all 0.3 ease;
					transition-duration:0.3s;  padding-top:2%; border-radius: 5px 70px 5px 5px;
					 background-color:#515151; color: white; box-shadow: 5px 5px 5px rgba(0,0,0,0.7); text-align:center; '>";
					echo "		<font>".$option["subject"]."</font>";
					echo "	 </div>";
					echo	 "</a>";
				}
			?>
			
		</div>
		<div id="right">
			<div id="right_up">
				<div class="error"><?php if(isset($_POST["next"])){if($value1==1 || $value2 == 1) {echo "*Please chosse another Exam code.Try again...";} elseif($value == 0){ echo "*All fields are required.Try again..."; $value2=2;} } ?>
	                			
	            </div>
				<ul>
					<input type="button" id="butt" class="exam_button" name="" value="Create Exam" ><br><br>
					<li class="rnav"><a class="rlink" href="upload_question.php">Question bank</a></li><br>
				</ul>
			</div>
			<form action="" method="post" id="running_exam">
				<div id="r1">
					<font class="rm" style="padding-left: 22%" >EXAM'S</font>&nbsp;&nbsp;&nbsp;&nbsp;
					<div style=" width: 25%;   float: right; right: 2%"><input type="submit" class="clear" style="" name="delete" value="CLEAR"></div>
				</div>
				<div id="right_middle">
				
					<?php
						$sql = "SELECT * FROM ".$name."_exam";
						$result = mysqli_query($connection, $sql); $i = 1;
						while ($row = mysqli_fetch_assoc($result)) {
					 		echo $i;?>.&nbsp; <?php
					 		echo "Exam name : ".$row['exam_name']." ";?>&nbsp;&nbsp;<?php
					 		echo "Exam code: ".$row['exam_code']." ";?> &nbsp; &nbsp; <?php
					 		if (isset($_POST["delete"])) {
								$current_date = strtotime('now');
					 			$finish_date = strtotime($row['date']);
					 			if ($current_date < $finish_date) {
					 			    echo "Exam running...";
					 		    }
							} ?> <br> <?php
					 	} 
					?>
				</div>
			</form>
			<div id="r2">
				<font class="rm" >Result of exams</font>
			</div>
			<div id="right_down">
				<br>
				<form action="" method="post">
					<font size="5px">&nbsp;&nbsp;Exam code :  </font><br>
					<input type="text" style="width: 50%; font-size: 1em;" name="e_code"><br><br>
					<input type="submit" class="d_modal" name="see_marks" value="LETS SEE"><br><br>
					
				</form>
				<div class="error"><?php if(isset($_POST["see_marks"])){if($v == 2) {echo "*Exam code is wrong.Try again...";} elseif ($w == 1) {echo "*Please give a exam code.";} elseif ($w == 3) {echo "*This is not your any exam code.";}  } ?>
				</div>
			</div>
			<div  id="mymodal">
	            <div  id="modal_content">
	                <div id="modal_header">
	                    <span class="close">&times;</span>
	                    <h2> In which way you want to do..?</h2>
	                </div> 
	                <div id="modal_body">
	                	<form action="teacher.php" method="post">
	                		
	                        <font style="color:#000000; font-size: 20px">Subject :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
	                        <select class="option" name="sub1" style="" >
		                    <?php 
		                        $q = "Select subject from " . $name . "_subject";
		                        $r = mysqli_query($connection, $q);
		                    ?>
		                    <?php
		                        while($option = mysqli_fetch_assoc($r)) {
		                            echo "<option>" . $option["subject"] . "</option>";
		                        }
		                    ?>
		                    </select><br><br>
		                    <font style="color:#000000; font-size: 20px">Exam name :&nbsp;</font>
		                    <input type="text" name="exam_name" style="width: 45%; font-size: 1em; border-radius: 10px"><br><br>
		                    <font style="color:#000000; font-size: 20px">Exam code :&nbsp;&nbsp;</font>
		                    <input type="text" name="exam_code" style="width: 45%; font-size: 1em; border-radius: 10px"><br><br>
		                    <font style="color:#000000; font-size: 20px">finish :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
		                    <input type="datetime-local" name="date" style="width: 55%; font-size: 1em; border-radius: 10px"><br><br>
		                    <font style="color:#000000; font-size: 20px">Duration :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>
		                    <input type="text" name="duration" style="width: 45%; font-size: 1em; border-radius: 10px"><br><br>
		                    <font style="color:#000000; font-size: 20px">Choose a way for making question set :&nbsp;&nbsp;</font><br><br>
	                    	<select class="option" name="qus_system" style=" width: 60%">
	                    		<option>Create new Question</option>
	                    		<option>Randomly from Question bank</option>
	                    		<option>Selecting from Question bank</option>
	                    	</select><br><br><br>
	                    	<input type="submit" class="exam_form_button" name="next" value="NEXT-->">
	                    </form>
	                </div>  
	                <div id="modal_footer">
	                    <font>You can do this using these three ways. :-)</font>
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
		    	window.onclick = function(a){
		    		if(a.target == modal){
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
	                    <form action="teacher.php" method="post">
	                        <font style="color:#000000; font-size: 20px">Subject:&nbsp;&nbsp;&nbsp;</font>
	                        <input class="sub" style="width: 50%; font-size: 1em; border-radius: 5px" type="text" name="sub"><br><br>
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
		    	window.onclick = function(e){
		    		if(e.target == modala){
		    			modala.style.display = "none";
		    		}
		    	}
		    </script>
		</div>

</body>
</html>