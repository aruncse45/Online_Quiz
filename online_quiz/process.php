<?php include 'database.php' ; ?>
<?php 
    session_start();
    $t_name = $_SESSION['Username'];
    $pass = $_SESSION['Password'];
?>    

<?php 
	$subselect = $_POST['subselect'];
	$leveltype = $_POST['leveltype'];
	$questionselect = $_POST['questionselect'];
	$i1 = $_POST['i1'];
	$i2 = $_POST['i2'];
	$i3 = $_POST['i3'];
	$i4 = $_POST['i4'];
	$i5 = $_POST['i5'];
	$checkbox = $_POST['checkbox'];

	if(!empty($questionselect) && !empty($i1) && !empty($i2) && !empty($i3) && !empty($i4) && !empty($i5)){
            $sql = "SELECT question from ".$t_name." where question = '".$questionselect."' ";
            $result = mysqli_query($connection, $sql);
            if(mysqli_num_rows($result)==1){
                $value1 = 1;
            }
            else{
                $value1 = 2;
            }
        }
    if ($value1 == 2) {
   
		$sql1 = "INSERT INTO ".$t_name." values('','$subselect','$leveltype','$questionselect','$i1','$i2','$i3','$i4','$i5')";
	    $res = mysqli_query($connection, $sql1);
	    if ($res) {
	    	echo "successfull";
	    }
	    else
	    {
	    	echo 'failed';
	    }
	    $sql2 = "INSERT INTO ".$t_name."_recent(id,question,o1,o2,o3,o4) VALUES('','".$questionselect."','".$i1."','".$i2."','".$i3."','".$i4."') ";
	    $res1 = mysqli_query($connection, $sql2);
        
	}
    if (!empty($checkbox)) {
    	$query = "SELECT question FROM all_questions Where question = '" . $questionselect ."' ";
        $result = mysqli_query($connection, $query);
        if(mysqli_num_rows($result) == 1){
           $value1=3;
          
        }
        else{ $value1=4;}

        if($value1==4){
        $sql1 = "INSERT INTO all_questions(id,subject,level,question,o1,o2,o3,o4,answer) VALUES('','".$subselect."','".$leveltype."','".$questionselect."','".$i1."','".$i2."','".$i3."','".$i4."','".$i5."')";
        $res = mysqli_query($connection, $sql1);    
        }
    }
?>