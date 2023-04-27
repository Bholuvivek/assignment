<?php
$name=$_POST['name'];
$gender= $_POST['gender'];
$email= $_POST['email'];
$phone= $_POST['phone'];
$dob= $_POST['dob'];
$password= $_POST['password'];

if(!empty($username) || !empty($password) || !empty($gender) || !empty($email) || !empty($phonecode) || !empty($phone)){
	$host="localhost";
	$dbUsername="root";
	$dbPassword="";
	$dbname="userdetails";

	//create connection
	$conn=new mysqli($host, $dbUsername, $dbPassword, $dbname);

	if(mysqli_connect_error()) {
		die('Connect Error('.mysqli_connect_error().')'.mysqli_connect_error());
	}
	else{
		$SELECT= "SELECT email From registerdata Where email = ? Limit 1";
		$INSERT= "INSERT Into registerdata (name, gender, email, phone, dob, password  ) values(?, ?, ?, ?, ?, ?)";

		//Prepare Statement
		$stmt= $conn->prepare($SELECT);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($email);
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		if($rnum==0)
		{
			$stmt->close();

			$stmt= $conn->prepare($INSERT);
			$stmt->bind_param("ssssii", $name, $gender, $email, $phone, $dob, $password,);
			$stmt->execute();
			echo "New Record inserted succesfully";
		}
		else{
			echo "someone already register using this email";
		}
		$stmt->close();
		$conn->close();
	}
}else
{
	echo "All field are required";
	die();
}
?>