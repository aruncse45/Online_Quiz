<?php include 'database.php'; ?>

<?php 
    session_start();
    $t_name = $_SESSION['Username'];
    $pass = $_SESSION['Password'];
    $t_sub = $_SESSION['sub1'];
    $e_code = $_SESSION['exam_code'];
?> 

<?php
	
	$question = $_POST['question'];
	$leveltype = $_POST['leveltype'];
	$i1 = $_POST['i1'];
	$i2 = $_POST['i2'];
	$i3 = $_POST['i3'];
	$i4 = $_POST['i4'];
	$i5 = $_POST['i5'];
	$checkbox = $_POST['checkbox'];

	
    if(!empty($question) && !empty($i1) && !empty($i2) && !empty($i3) && !empty($i4) && !empty($i5)){
        $sql = "SELECT question from ".$e_code." where question = '".$question."' ";
        $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result)==1){
            $value1 = 1;
        }
        else{
            $value1 = 2;
        }
    }
    if ($value1 == 2) {
        $sql1 = "INSERT INTO ".$e_code."(id,question,o1,o2,o3,o4,answer) VALUES('','".$question."','".$i1."','".$i2."','".$i3."','".$i4."','".$i5."')";
        $res = mysqli_query($connection, $sql1);
        if ($res) {
        	echo "successfull";
        }
        else
        	echo "fail";
    }
    

    if(!empty($checkbox)){
        $sql = "SELECT question from ".$t_name." where question = '".$question."' ";
            $result = mysqli_query($connection, $sql);
        if(mysqli_num_rows($result) == 1){
           $value1=3;
          
        }
        else{ $value1=4;}

        if($value1==4){
            if(!empty($question) && !empty($i1) && !empty($i2) && !empty($i3) && !empty($i4) && !empty($i5)) {
                $sql1 = "INSERT INTO ".$t_name."(id,subject,level,question,o1,o2,o3,o4,answer) VALUES('','".$t_sub."','".$leveltype."','".$question."','".$i1."','".$i2."','".$i3."','".$i4."','".$i5."')";
            $res1 = mysqli_query($connection, $sql1);  
            }  
        }
    }

?>