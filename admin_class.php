<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;
	public 
	function __construct() {
		ob_start();
		include 'include/db_connect.php';
		$this->db = $conn;
	}
	function __destruct() {
		$this->db->close();
		ob_end_flush();
	}
	function login(){
		extract($_POST);
		$qry = $this->db->query("SELECT * FROM user_account where username = '".$username."' and password = '".$password."' ");
		if($qry->num_rows > 0){
			foreach ($qry->fetch_array() as $key => $value) {
				if($key != 'passwors' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			// if($_SESSION['login_access'] != 1){
			// 	foreach ($_SESSION as $key => $value) {
			// 		unset($_SESSION[$key]);
			// 	}
			// 	return 2 ;
			// 	exit;
			// }
			return 1;
		}else{
			return 3;
		}
	}
	function logout(){
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:login.php");
	}
	function save_genre(){
		if ($_SESSION['login_access'] != 1) {
			return 14;
		}else{
			extract($_POST);
			$data = " genreType = '$genre' ";
			if(empty($id)){
				$save = $this->db->query("INSERT INTO tbl_movie_genre set $data");
				return 1;
			}else{
				$save = $this->db->query("UPDATE tbl_movie_genre set $data where id = $id");
				return 2;
			}
		}
	}
	function delete_genre(){
		if ($_SESSION['login_access'] != 1) {
			return 14;
		}else{
			extract($_POST);
			$delete = $this->db->query("DELETE FROM tbl_movie_genre where id = ".$id);
			if($delete){
				return 1;
			}
		}
	}
	function save_customer(){
		extract($_POST);
		$data = " email = '$email' ";
		$data .= ", fName = '$fName' ";
		$data .= ", mName = '$mName' ";
		$data .= ", lName = '$lName' ";
		$data .= ", address = '$address' ";
		$data .= ", contactNo = '$contactNo' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO tbl_customer_info set $data");
			return 1;
		}else{
			$save = $this->db->query("UPDATE tbl_customer_info set $data where id = $id");
			return 2;
		}
	}
	function delete_customer(){
		if ($_SESSION['login_access'] != 1) {
			return 14;
		}else{
			extract($_POST);
			$delete = $this->db->query("DELETE FROM tbl_customer_info where id = ".$id);
			if($delete){
				return 1;
			}
		}
	}
	function save_movie(){
		if ($_SESSION['login_access'] != 1) {
			return 14;
		}else{
			$wala = 0;
			extract($_POST);
			$data = " title = '$title' ";
			$data .= ", cast = '$cast' ";
			$data .= ", director = '$director' ";
			$selectedGenres = $_POST['genre'];
			$selectedGenresString = implode(',', $selectedGenres);
			if (isset($_FILES['img_path']) && $_FILES['img_path']['error'] === UPLOAD_ERR_OK) {
				$tempFile = $_FILES['img_path']['tmp_name'];
				$fileName = $_FILES['img_path']['name'];
				$targetPath = 'Storage/';
				$targetFile = $targetPath . $fileName;
				if (move_uploaded_file($tempFile, $targetFile)) {
					$img_path = $targetFile;
					$data .= ", img = '$img_path' ";
				}
			}
			if (empty($id)) {
				$this->db->begin_transaction();
				$save = $this->db->query("INSERT INTO tbl_movie_info SET $data");
				$lastInsertedId = $this->db->insert_id;
				if ($save) {
					$save1 = $this->db->query("INSERT INTO `tbl_movie_about`(`tbl_movie_info_id`, `tbl_movie_genre_id`, `description`, `duration`, `year_release`) VALUES ('$lastInsertedId', '$selectedGenresString', '$description', '$duration', '$release_year')");
					$save2 = $this->db->query("INSERT INTO `tbl_movie_inventory_info`(`tbl_movie_info_id`, `price`, `qty`, `available`, `borrowed`) VALUES ('$lastInsertedId', '$price', '$quantity', '$quantity', '$wala')");
					if ($save1 && $save2) {
						$this->db->commit();
						return 1;
					} else {
						$this->db->rollback();
						return 0;
					}
				} else {
					$this->db->rollback();
					return 0;
				}
			} else {
				$this->db->begin_transaction();
				$save = $this->db->query("UPDATE tbl_movie_info SET $data WHERE id = $id");
				if ($save) {
					$save1 = $this->db->query("UPDATE `tbl_movie_about` SET `tbl_movie_genre_id`='$selectedGenresString', `description`='$description', `duration`='$duration', `year_release`='$release_year' WHERE `tbl_movie_info_id`='$id'");
					if ($save1) {
						$this->db->commit();
						return 2;
					} else {
						$this->db->rollback();
						return 0;
					}
				} else {
					$this->db->rollback();
					return 0;
				}
			}
		}
	}
	function delete_movie(){
		if ($_SESSION['login_access'] != 1) {
			return 14;
		}else{
			$id = $this->db->real_escape_string($_POST['id']);
			$result = 0;
			$this->db->begin_transaction();
			$delete = $this->db->query("DELETE FROM tbl_movie_info WHERE id = '$id'");
			if ($delete) {
				$delete1 = $this->db->query("DELETE FROM tbl_movie_about WHERE tbl_movie_info_id = '$id'");
				if ($delete1) {
					$delete2 = $this->db->query("DELETE FROM tbl_movie_inventory_info WHERE tbl_movie_info_id = '$id'");
					if ($delete2) {
						$this->db->commit();
						$result = 1;
					} else {
						$this->db->rollback();
					}
				} else {
					$this->db->rollback();
				}
			}
			if ($result === 0) {
			}
			return $result;
		}
	}
	function save_inventory(){
		if ($_SESSION['login_access'] != 1) {
			return 14;
		}else{
			extract($_POST);
			$data = "price = '$price' ";
			$data .= ", qty = '$quantity' ";
			$data .= ", penalty = '$penalty' ";
			$data .= ", available = '$quantity' ";
			if(empty($id)){
			// $save = $this->db->query("INSERT INTO tbl_movie_inventory_info set $data");
			}else{
				$save = $this->db->query("UPDATE tbl_movie_inventory_info set $data where id = $id");
				return 1;
			}
		}
	}
	function save_trans(){
		$jsonData = file_get_contents('php://input');
		$item = json_decode($_POST['cart'], true);
		$current_date = date("Y-m-d");
		$genrecipt = substr(md5(uniqid(rand(), true)), 0, 13);
		$success = true;
		
		foreach ($item as $cartItem) {
			$price = intval($cartItem['price']);
			$quantity = intval($cartItem['quantity']);
			$requestedAmount = $price * $quantity;
        // Build the data string for the database query
			$data = "tbl_user_information_id = " . $_POST['seller'];
			$data .= ", tbl_customer_info_id = " . $_POST['customer'];
			$data .= ", tbl_movie_info_id = '" . $cartItem['id'] . "'";
			$data .= ", genereratedCode = '$genrecipt'";
			$data .= ", requestedDate = '$current_date'";
			$data .= ", returnDate = '" . $_POST['requestedDate'] . "'";
			$data .= ", requestedQty = '$quantity'";
			$data .= ", requestedAmount = '$requestedAmount'";
			$data .= ", status = 'RENTED'";
			$save = $this->db->query("INSERT INTO tbl_rents_info SET $data");
			if (!$save) {
				$success = false;
				echo "Failed to save item with ID " . $cartItem['id'] . ".";
            break; // Stop the loop if there is a failure
        }
    }
    if ($success) {
    	return 1;
    } else {
    	return 0;
    }
}
public function save_user()
{
	if ($_SESSION['login_access'] != 1) {
		return 14;
	}else{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$f_name = $_POST['fName'];
		$m_name = $_POST['mName'];
		$l_name = $_POST['lName'];
		$address = $_POST['address'];
		$contact = $_POST['contactNo'];
		
		if (isset($_POST['access'])) {
    $access = $_POST['access'];
}


		$id = $_POST['id'];



		$this->db->begin_transaction();
		try {
			if (empty($id)) {
            // Insert a new record in user_account table
				$insertUserAccount = $this->db->query("INSERT INTO `user_account`(`username`, `password`, `access`, `active`) VALUES ('$username','$password','0','1')");
				$lastInsertedId = $this->db->insert_id;
				$insertUserInfo = $this->db->query("INSERT INTO `tbl_user_information`(`user_account_id`, `email`, `fName`, `mName`, `lName`, `address`, `contactNo`) VALUES ('$lastInsertedId','$email','$f_name','$m_name','$l_name','$address','$contact')");
				$this->db->commit();
				return 1;
			} else {
				$updateUserAccount = $this->db->query("UPDATE `user_account` SET `username`='$username', `password`='$password' WHERE `id`='$id'");
				$updateUserInfo = $this->db->query("UPDATE `tbl_user_information` SET `email`='$email', `fName`='$f_name', `mName`='$m_name', `lName`='$l_name', `address`='$address', `contactNo`='$contact' WHERE `user_account_id`='$id'");
				$this->db->commit();
				return 2;
			}
		} catch (Exception $e) {
			$this->db->rollback();
			echo "Error: " . $e->getMessage();
        return 0; // Failure
    }
}
}
function delete_user(){
	if ($_SESSION['login_access'] != 1) {
		return 14;
	}else{
		extract($_POST);
		$this->db->begin_transaction();
		$delete = $this->db->query("DELETE FROM tbl_user_information where user_account_id = ".$id);
		if($delete){
			$delete2 = $this->db->query("DELETE FROM user_account where id = ".$id);
		}
		if ($delete2) {
			$this->db->commit();
			return 1;
		}
	}
}
public function update_role()
{
	if ($_SESSION['login_access'] != 1) {
		return 14;
	}else{
		$jsonData = file_get_contents('php://input');
		$data = json_decode($jsonData, true);
		$access = $data['access'];
		$id = $data['id'];
		$this->db->begin_transaction();
		try {
			$updateUserAccount = $this->db->query("UPDATE `user_account` SET `access`='$access' WHERE `id`='$id'");
			$this->db->commit();
			echo json_encode(2);
		} catch (Exception $e) {
			$this->db->rollback();
        echo json_encode(0); // Failure
    }
}
}


public function update_rented()
{

		$jsonData = file_get_contents('php://input');
		$data = json_decode($jsonData, true);
	
		$id = $data['id'];
		$this->db->begin_transaction();
		try {
			$updateUserAccount = $this->db->query("UPDATE `tbl_rents_info` SET `status`='Return' WHERE `id`='$id'");
			$this->db->commit();
			echo json_encode(2);
		} catch (Exception $e) {
			$this->db->rollback();
        echo json_encode(0); // Failure
    }

}



public function add_penalty() {
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);

    if ($_SESSION['login_access'] != 1) {
        return 14;
    } else {
        $reN = $data['refno'];
        $dp = $data['days'];
        $pp = $data['pps'];
        $id = $data['id'];
       

        $this->db->begin_transaction();
        try {
            $insertPenalty = $this->db->query("INSERT INTO `penalty`(`receipt_no`, `days_penalty`, `penalty_price`) VALUES ('$reN','$dp','$pp')");
            $this->db->commit();

        
           
            $this->db->begin_transaction();
            try {
                $updateUserAccount = $this->db->query("UPDATE `tbl_rents_info` SET `status`='Return' WHERE `id`='$id'");
                $this->db->commit();
                
            } catch (Exception $e) {
                $this->db->rollback();
        
            }

            return 1;
        } catch (Exception $e) {
            $this->db->rollback();
            echo "Error: " . $e->getMessage();
            return 0; // Failure
        }
    }
}



}//end class