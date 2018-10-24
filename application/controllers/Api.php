<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('mod_monitoring');
		$this->load->model('mod_log');
		$this->load->model('mod_user');

		$this->str_normal = "Normal";
	}

	public function index(){
		$data["recent"] = $this->mod_monitoring->select();
		$data["notif"] = $this->mod_log->select();
		$this->load->view('monitoring',$data);
	}

	public function insert(){
		header('Content-type:JSON');
		if($this->uri->segment(3) != null && $this->uri->segment(4) != null && $this->uri->segment(5) != null && $this->uri->segment(6) != null){
			$val_suhu = $this->uri->segment(3);
			$val_asap = $this->uri->segment(4); // 1 - 0 
			$val_api = $this->uri->segment(5);  // 1 - 0
			$api_key = $this->uri->segment(6);

			$tanggal = date("Y-m-d H:i:s");

			if($val_suhu <= 35){
				$cat_suhu = "Normal";
			}else
			if($val_suhu > 35 && $val_suhu <= 55){
				$cat_suhu = "Suhu saat ini " . $val_suhu . " (di atas normal). ";
			}else
			if($val_suhu > 55){
				$cat_suhu = "Suhu saat ini " . $val_suhu . " (sangat berbahaya). ";
			}

			if($val_asap == 0){
				$cat_asap = "Normal";
			}else
			if($val_asap == 1){
				$cat_asap = "Bahaya";
			}
			
			if($val_api == 0){
				$cat_api = "Normal";
			}else
			if($val_api == 1){
				$cat_api = "Bahaya";
			}

			if($cat_suhu != $this->str_normal || $val_asap != 0 || $val_api != 0){

				$pesan_notifikasi = $cat_suhu;

				if($val_asap == 1 && $val_api == 0){
					$pesan_notifikasi .= "Terdeteksi asap, terindikasi kebakaran";
				}

				if($val_asap == 1 && $val_api == 1){
					$pesan_notifikasi .= "Terdeteksi asap dan api, terjadi kebakaran";
				}

				if($val_asap == 0 && $val_api == 1){
					$pesan_notifikasi .= "Terdeteksi api, terindikasi kebakaran";
				}
				
				$data_log = array(
					"api_key" => $api_key,
					"val_suhu" => $val_suhu,
					"val_asap" => $val_asap,
					"val_api" => $val_api,
					"cat_suhu" => $cat_suhu,
					"cat_asap" => $cat_asap,
					"cat_api" => $cat_api,
					"datetime" => $tanggal,
					"pesan_notifikasi" => $pesan_notifikasi
				);
				$this->mod_log->insert($data_log);
			}

			$data_monitoring = array(
				"api_key" => $api_key,
				"val_suhu" => $val_suhu,
				"val_asap" => $val_asap,
				"val_api" => $val_api,
				"cat_suhu" => $cat_suhu,
				"cat_asap" => $cat_asap,
				"cat_api" => $cat_api,
				"datetime" => $tanggal
			);

			$insert = $this->mod_monitoring->update( $api_key,$data_monitoring);

			if($insert > 0){
				$response = array(
					"severity" => "success",
					"message" => "Penyimpanan data berhasil"
				);
			}else{
				$response = array(
					"severity" => "warning",
					"message" => "Penyimpanan data gagal"
				);
			}

		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Parameter yang dikirim ke server tidak lengkap"
			);
		}
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function admin_login(){ 
		header('Content-type:JSON');
		if($this->input->post('username') == null && $this->input->post('password') == null){
			$login = file_get_contents('php://input');
			$json = json_decode($login);
			if($json == null){
				$severity = "warning";
				$message = "Tidak ada data dikirim ke server";
				$data_count = "0";
				$data = array();
				$username = null;
				$password = null;
			}else{
				$username = $json->username;
				$password = $json->password;
			}
		}else{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
		}
		if($username != null && $password != null ){
			$check = $this->mod_user->is_registered($username);
			if(sizeof($check) > 0){
				if($check[0]->password == md5($password)){
					if($check[0]->tipe == "0" ){
						$severity = "success";
						$message = "Login berhasil";
						$data_count = (string)sizeof($check);
						$data = $check;
						$data_session = array(
							"session_appssystem_code"=>"SeCuRe".date("YmdHis")."#".date("YHmids"),
							"session_appssystem_id"=>$check[0]->id,
							"session_appssystem_username"=>$check[0]->username,
							"session_appssystem_nama"=>$check[0]->nama,
						);
						$this->session->set_userdata($data_session);
					}else{
						$severity = "warning";
						$message = "Anda tidak terdaftar sebagai Admin";
						$data_count = "0";
						$data = array();
					}
				}else{
					$severity = "warning";
					$message = "Nama pengguna dan kata sandi tidak sesuai";
					$data_count = "0";
					$data = array();
				}
			}else{
				$severity = "danger";
				$message = "Nama pengguna tidak terdaftar";
				$data_count = "0";
				$data = $check;
			}
		}else{
			$severity = "warning";
			$message = "Tidak ada data dikirim ke server";
			$data_count = "0";
			$data = array();
		}
		$response = array(
			"severity" => $severity,
			"message" => $message,
			"data_count" => $data_count,
			"data" => $data
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	

	public function verifikasi(){ 
		header('Content-type:JSON');
		if($this->input->post('username') == null && $this->input->post('password') == null){
			$login = file_get_contents('php://input');
			$json = json_decode($login);
			if($json == null){
				$severity = "warning";
				$message = "Tidak ada data dikirim ke server";
				$data_count = "0";
				$data = array();
				$username = null;
				$password = null;
			}else{
				$username = $json->username;
				$password = $json->password;
			}
		}else{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
		}
		if($username != null && $password != null ){
			$check = $this->mod_user->is_registered($username);
			if(sizeof($check) > 0){
				if($check[0]->password == md5($password)){
					$severity = "success";
					$message = "Login berhasil";
					$data_count = (string)sizeof($check);
					$data = $check;
				}else{
					$severity = "warning";
					$message = "Nama pengguna dan kata sandi tidak sesuai";
					$data_count = "0";
					$data = array();
				}
			}else{
				$severity = "danger";
				$message = "Nama pengguna tidak terdaftar";
				$data_count = "0";
				$data = $check;
			}
		}else{
			$severity = "warning";
			$message = "Tidak ada data dikirim ke server";
			$data_count = "0";
			$data = array();
		}
		$response = array(
			"severity" => $severity,
			"message" => $message,
			"data_count" => $data_count,
			"data" => $data
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function android_user(){
		header('Content-type:JSON');
		if($this->uri->segment(3) != null){ //api_key
			$android = array(
				"recent" => $this->mod_monitoring->select($this->uri->segment(3)),
				"notif" => $this->mod_log->select($this->uri->segment(3))
			);
		}else{
			$android = array(
				"recent" => array(),
				"notif" =>  array()
			);
		}
		echo json_encode($android,JSON_PRETTY_PRINT);
	}

	public function admin_monitoring(){
		header('Content-type:JSON');
		$response = $this->mod_monitoring->admin_monitoring();
		echo json_encode(array("monitoring" => $response),JSON_PRETTY_PRINT);
	}

	public function admin_list_pengguna(){
		header('Content-type:JSON');
		$response = $this->mod_user->admin_list_pengguna();
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function pengguna_detail(){
		header('Content-type:JSON');
		$response = $this->mod_user->user_detail($this->uri->segment(3));
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function pengguna_delete(){
		header('Content-type:JSON');
		$delete = $this->mod_user->user_delete($this->uri->segment(3)); //api_key
		if($delete > 0){
			$this->mod_monitoring->delete($this->uri->segment(3)); //api_key
			$this->mod_log->delete($this->uri->segment(3)); //api_key
			$response = array(
				"severity" => "success",
				"message" => "Delete data berhasil",
				"data_count" => "0",
				"data" => array()
			);
		}else{
			$response = array(
				"severity" => "warning",
				"message" => "Simpan data gagal",
				"data_count" => "0",
				"data" => array()
			);
		}
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

	public function pengguna_simpan(){
		if($this->input->post('username') != null && 
		$this->input->post('password') != null && 
		$this->input->post('nama') != null && 
		$this->input->post('nama_toko') != null && 
		$this->input->post('alamat_toko') != null && 
		$this->input->post('api_key') != null){
			$check = $this->mod_user->is_registered($this->input->post('username') );
			if(sizeof($check) > 0){
				$response = array(
					"severity" => "warning",
					"message" => "Username sudah digunakan silakan gunakan username lainnya",
					"data_count" => "0",
					"data" => array()
				);
			}else{
				$username = $this->input->post('username'); 
				$password = $this->input->post('password'); 
				$nama = $this->input->post('nama'); 
				$nama_toko = $this->input->post('nama_toko'); 
				$alamat_toko = $this->input->post('alamat_toko');
				$api_key = $this->input->post('api_key');

				$is_reg = $this->mod_user->is_registered($username);

				if(sizeof($is_reg) > 0 ){
					$response = array(
						"severity" => "warning",
						"message" => "Username sudah digunakan. silakan cari username lainnya",
						"data_count" => "0",
						"data" => array()
					);
				}else{
					$ins = array(
						"username" => $username,
						"password" => md5($password),
						"nama" => $nama,
						"tipe" => "1",
						"api_key" => md5($api_key),
						"nama_toko" => $nama_toko,
						"alamat_toko" => $alamat_toko,
						"last_login" => date("Y-m-d H:i:s")
					);
					$res = $this->mod_user->insert($ins);
	
					$mon = array(
						"api_key" => md5($api_key),
						"val_suhu" => 0,
						"val_asap" => 0,
						"val_api" => 0,
						"cat_suhu" => "-",
						"cat_asap" => "-",
						"cat_api" => "-",
						"datetime" => date("Y-m-d H:i:s")
					);
	
					$this->mod_monitoring->insert($mon);
	
					if($res > 0){
						$response = array(
							"severity" => "success",
							"message" => "Simpan data berhasi;",
							"data_count" => "0",
							"data" => array()
						);
					}else{
						$response = array(
							"severity" => "warning",
							"message" => "Simpan data gagal",
							"data_count" => "0",
							"data" => array()
						);
					}
				}
			}
		}else{
			$response = array(
				"severity" => "danger",
				"message" => "Tidak ada data dikirim ke server",
				"data_count" => "0",
				"data" => array()
			);
		}
		header('Content-type:JSON');
		echo json_encode($response,JSON_PRETTY_PRINT);
	}


	public function pengguna_update(){
		if($this->uri->segment(3) != null){
			$detail = $this->mod_user->user_detail($this->uri->segment(3));
			if(sizeof($detail) > 0){
				//----------------
				if($this->input->post('password') == null && 
				$this->input->post('nama') == null && 
				$this->input->post('nama_toko') == null && 
				$this->input->post('alamat_toko') == null){
					$insert = file_get_contents('php://input');
					$json = json_decode($insert);
					if($json == null){
						$severity = "warning";
						$message = "Tidak ada data dikirim ke server";
						$data = array();
						$password = null;
						$nama = null;
						$nama_toko = null;
						$alamat_toko = null;
					}else{
						$password = $json->password;
						$nama = $json->nama;
						$nama_toko = $json->nama_toko;
						$alamat_toko = $json->alamat_toko;
					}
				}else{
					$password = $this->input->post('password');
					$nama = $this->input->post('nama');
					$nama_toko = $this->input->post('nama_toko');
					$alamat_toko = $this->input->post('alamat_toko');
				}
				if($password != null && $nama != null && 
				$nama_toko != null && $alamat_toko !=null){
					if($password != $detail[0]->password && md5($password) != $detail[0]->password){
						$password = md5($password);
					}
					$data_update = array(
						"password" => $password,
						"nama" => $nama,
						"nama_toko" => $nama_toko,
						"alamat_toko" => $alamat_toko,
					);
					$update_response = $this->mod_user->update_profil($this->uri->segment(3),$data_update);
					if($update_response > 0){
						$severity = "success";
						$message = "Update profil berhasil";
						$data = $this->mod_user->user_detail($this->uri->segment(3));
					}else{
						$severity = "warning";
						$message = "Update profil gagal, silakan coba lagi";
						$data = array();
					}
				}else{
					$severity = "warning";
					$message = "Tidak ada data dikirim ke server";
					$data = array();
				}
				//--------------------
			}else{
				$severity = "warning";
				$message = "User tidak ditemukan";
				$data = array();
			}
		}else{
			$severity = "warning";
			$message = "Tidak ada ID User dikirim ke server";
			$data = array();
		}
		$response = array(
			"severity" => $severity,
			"message" => $message,
			"data" => $data
		);
		echo json_encode($response,JSON_PRETTY_PRINT);
	}

}
