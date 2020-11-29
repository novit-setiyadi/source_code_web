<?php 
	include "db_config.php";

	class User{
		protected $db;
		public function __construct(){
			$this->db = new DB_con();
			$this->db = $this->db->ret_obj();
		}

		public function edit($id){

			$data = null;

			$query = "SELECT * FROM tb_penyewa WHERE no_custumer = '$id'";
			if ($sql = $this->db->query($query)) {
				while($row = $sql->fetch_assoc()){
					$data = $row;
				}
			}
			return $data;
		}
		public function update($data){

			$query = "UPDATE tb_penyewa SET nama_lengkap='$data[name]', email='$data[email]', handphone='$data[mobile]', alamat='$data[address]' WHERE no_custumer='$data[id] '";

			if ($sql = $this->db->query($query)) {
				return true;
			}else{
				return false;
			}
		}
		public function insert(){

			if (isset($_POST['submit'])) {
				if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['address'])) {
					if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['mobile']) && !empty($_POST['address']) ) {
						
						$name = $_POST['name'];
						$mobile = $_POST['mobile'];
						$email = $_POST['email'];
						$address = $_POST['address'];

						$query = "INSERT INTO tb_penyewa (nama_lengkap,email,handphone,alamat) VALUES ('$name','$email','$mobile','$address')";
						if ($sql = $this->db->query($query)) {
							echo "<script>alert('records added successfully');</script>";
							echo "<script>window.location.href = 'data_penyewa.php';</script>";
						}else{
							echo "<script>alert('failed');</script>";
							echo "<script>window.location.href = 'create_penyewa.php';</script>";
						}

					}else{
						echo "<script>alert('empty');</script>";
						echo "<script>window.location.href = 'create_penyewa.php';</script>";
					}
				}
			}
		}
		public function tampil_data(){
			$data = null;
	
				$query = "SELECT * FROM tb_penyewa";
				if ($sql = $this->db->query($query)) {
					while ($row = mysqli_fetch_assoc($sql)) {
						$data[] = $row;
					}
				}
				return $data;
		}
		public function delete($id){

			$query = "DELETE FROM tb_penyewa where no_custumer = '$id'";
			if ($sql = $this->db->query($query)) {
				return true;
			}else{
				return false;
			}
		}

		public function check_login($username, $password){
        $password = md5($password);
		
		$query = "SELECT id_user from tb_user WHERE username='$username' and password='$password'";
		
		$result = $this->db->query($query) or die($this->db->error);

		
		$user_data = $result->fetch_array(MYSQLI_ASSOC);
		$count_row = $result->num_rows;
		
		if ($count_row == 1) {
	            $_SESSION['login'] = true; // this login var will use for the session thing
	            $_SESSION['id'] = $user_data['id_user'];
	            return true;
	        }else{
				return false;
			}
	}
	
	public function get_fullname($id){
		$query = "SELECT username FROM tb_user WHERE id_user = $id";
		
		$result = $this->db->query($query) or die($this->db->error);
		
		$user_data = $result->fetch_array(MYSQLI_ASSOC);
		echo ucfirst($user_data['username']) ;
		
	}
	/*** starting the session ***/
	public function get_session(){
	    return $_SESSION['login'];
	}

	public function user_logout() {
	    $_SESSION['login'] = FALSE;
		unset($_SESSION);
	    session_destroy();
	    }
	}
