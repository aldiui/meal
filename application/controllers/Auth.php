<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index(){
        if($this->session->userdata("nickname") && $this->session->userdata("role") == "Admin"){
			redirect("admin/dashboard");
		} else if ($this->session->userdata("nickname") && $this->session->userdata("role") == "Sales") {
			redirect("sales/dashboard");
		}
		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->db->get_where('master_user', ['username' => $username])->row_array();
            if($user > 0){
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'nickname' => $user["username"],
						'role' => $user["role"],
					];
                    $this->session->set_userdata($data);
                    if ($user['role'] == 'Admin') {
                        $this->session->set_flashdata('pesan', '
						<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
							<div class="text-white">Berhasil Login Sebagai Admin </div>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>');
                        redirect('admin/dashboard');
                    } elseif($user['role'] == 'Sales') {
                        $this->session->set_flashdata('pesan', '
						<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
							<div class="text-white">Berhasil Login Sebagai Sales </div>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>');
                        redirect('sales/dashboard');
                    } elseif($user['role'] == 'Dapur') {
                        $this->session->set_flashdata('pesan', '
						<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
							<div class="text-white">Berhasil Login Sebagai Dapur </div>
							<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>');
                        redirect('dapur/dashboard');
                    }
                } else {
                    $this->session->set_flashdata('pesan', '
					<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
						<div class="text-white">Password salah!</div>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('pesan', '
				<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
					<div class="text-white">Username tidak terdaftar!</div>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>');
				redirect('auth');
            }
        }
	}

    public function logout(){        
        $this->session->unset_userdata("nickname");
        $this->session->unset_userdata("role");
        $this->session->set_flashdata('pesan', '
        <div class="alert alert-success border-0 bg-success alert-dismissible fade show">
        <div class="text-white">Berhasil logout!</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        redirect('auth');
    }
}