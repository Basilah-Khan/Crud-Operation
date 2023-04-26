<?php
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);

	include "config.php";

	#print_r($_REQUEST);
	$type = @$_REQUEST['type'];
	$datec = date('Y-m-d H:i:s');
	session_start();
	$userID = @$_SESSION['sess_id'];
	#echo $userID;exit;

	if ($type == 'register') {
		$postArr = $_POST;
		$postArr['datec'] = $datec; //Add
		#print_r($postArr);exit;

		$mobile = $_POST['mobile']; //Get
		$id = $err = 0; $msg = '';


		$stmt = $pdo->prepare("SELECT * FROM user_info WHERE mobile = :mobile");
		$stmt->bindParam(':mobile', $mobile);
		$stmt->execute();
		$row_count = $stmt->rowCount();
		//echo "$row_count"; exit;
		if($row_count > 0)
		{
			$err = 1;
			$msg = "User exist";
		}else{
			$stmt2 = $pdo->prepare("INSERT INTO user_info (datec, name, email, mobile, password) VALUES (:datec, :name, :email, :mobile, :password)");
			if($stmt2->execute($postArr)){
      			$id = $pdo->lastInsertId();
				$err = 0;
				$msg = "Registerd successfully!! <br>Please Login.";
			}
		}

		$status = ($err == 1)? 'failed': 'success';
		$data['status'] = $status;
		$data['message'] = $msg;
		$data['id'] = $id;
		print json_encode($data);
	}


	if ($type == 'login') {
		$postArr = $_POST;
		$postArr['datec'] = $datec; //Add
		#print_r($postArr);exit;

		$mobile = $_POST['mobile']; //Get
		$password = $_POST['password']; //Get
		$err = 0; $msg = '';


		$stmt = $pdo->prepare("SELECT * FROM user_info WHERE mobile = :mobile");
		$stmt->bindParam(':mobile', $mobile);
		$stmt->execute();
		$row_count = $stmt->rowCount();

		if($row_count == 0){
			$err = 1;
			$msg = "User not found";
		}


		$name = $uid = null;
		while($row = $stmt->fetch()) {
		    $uid = $row['uid'];
		    $name = $row['name'];
		    $in_passwd = $row['password'];
		    $active = $row['active'];

		    if($password != $in_passwd)
		    {
		    	$err = 1;
		    	$msg = "Password not matching ";
		    }

		    if($active != 'Y')
		    {
		    	$err = 1;
		    	$msg = "User Not Active";
		    }
		}

		if($err == 0)
		{
			$_SESSION["is_logged"] = "true";
			$_SESSION["sess_name"] = $name;
			$_SESSION["sess_id"] = $uid;
		    $msg = "Login Done!";
		}

		$status = ($err == 1)? 'failed': 'success';
		$data['status'] = $status;
		$data['message'] = $msg;
		print json_encode($data);
	}


	if ($type == 'addCustomer') {
		$postArr = $_POST;
		$postArr['datec'] = $datec; //Add
		$postArr['added_by'] = $userID; //Add
		#print_r($postArr);exit;

		$mobile = $_POST['mobile']; //Get
		$err = 0; $msg = '';


		$stmt = $pdo->prepare("SELECT * FROM customer_info WHERE mobile = :mobile");
		$stmt->bindParam(':mobile', $mobile);
		$stmt->execute();
		$row_count = $stmt->rowCount();
		//echo "$row_count"; exit;
		if($row_count > 0)
		{
			$err = 1;
			$msg = "Customer exist";
		}else{
			$stmt2 = $pdo->prepare("INSERT INTO customer_info (datec, added_by, name, email, mobile, address, isActive) VALUES (:datec, :added_by, :name, :email, :mobile, :address, :isActive)");
			if($stmt2->execute($postArr)){
				$err = 0;
				$msg = "Customer added successfully!!";
			}
		}

		$status = ($err == 1)? 'failed': 'success';
		$data['status'] = $status;
		$data['message'] = $msg;
		print json_encode($data);
	}


	if ($type == 'getCustomer') {

		$id = $_REQUEST['id']; //Get
		$datax = array(); $err = 0; $msg = '';


		$stmt = $pdo->prepare("SELECT * FROM customer_info WHERE cid = :id");
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$row_count = $stmt->rowCount();
		//echo "$row_count"; exit;
		if($row_count > 0){
			$dataz = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$datax = $dataz[0];
		}else{
			$err = 1;
			$msg = "Records not found.";
		}

		$status = ($err == 1)? 'failed': 'success';
		$data['status'] = $status;
		$data['message'] = $msg;
		$data['data'] = $datax;
		print json_encode($data);
	}


	if ($type == 'editCustomer') {
		$postArr = $_POST;
		#print_r($postArr);

		$stmt = $pdo->prepare("UPDATE customer_info SET name = :name, email = :email, mobile = :mobile, address = :address, isActive = :isActive WHERE cid = :cid");		
		if($stmt->execute($postArr)){
			$err = 0;
			$msg = "Customer updated successfully";
		}else{
			$err = 1;
			$msg = "Error occured.";
		}

		$status = ($err == 1)? 'failed': 'success';
		$data['status'] = $status;
		$data['message'] = $msg;
		print json_encode($data);
	}


	if ($type == 'deleteCustomer') {
		$id = $_REQUEST['id']; //Get
		$datax = array(); $err = 0; $msg = '';


		$stmt = $pdo->prepare("DELETE FROM customer_info WHERE cid = :id");
		$stmt->bindParam(':id', $id);
		if($stmt->execute()){
			$err = 0;
			$msg = "Deleted successfully";
		}else{
			$err = 1;
			$msg = "Error occured!";
		}

		$status = ($err == 1)? 'failed': 'success';
		$data['status'] = $status;
		$data['message'] = $msg;
		$data['data'] = $datax;
		print json_encode($data);
	}

?>