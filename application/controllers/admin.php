<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index() {
        $data['kasir'] = $this->session->userdata('kasir') ?? [];
        $this->load->view('header');
        $this->load->view('kasir', $data);
        $this->load->view('footer');
    }

    public function tambah_pesanan() {
        $jenis_makanan = $this->input->post('jenis_makanan');
        $jumlah = $this->input->post('jumlah');

        // Validasi input
        if (empty($jenis_makanan) || !is_numeric($jumlah) || $jumlah <= 0) {
            $this->session->set_flashdata('error', 'Input tidak valid. Pastikan Anda mengisi jenis makanan dan jumlah dengan benar.');
        } else {
            // Mendefinisikan harga sesuai jenis makanan
            $harga_per_makanan = $this->get_harga_makanan($jenis_makanan);
    
            if ($harga_per_makanan === false) {
                $this->session->set_flashdata('error', 'Jenis makanan tidak valid.');
            } else {
                $kasir = array(
                    'jenis_makanan' => $jenis_makanan,
                    'jumlah' => $jumlah,
                    'harga' => $harga_per_makanan * $jumlah
                );
    
                $kasir_array = $this->session->userdata('kasir') ?? [];
                $kasir_array[] = $kasir;
    
                $this->session->set_userdata('kasir', $kasir_array);
    
                $this->session->set_flashdata('success', 'Pesanan berhasil ditambahkan.');
            }
        }
    
        redirect('admin');
    }
    
    private function get_harga_makanan($jenis_makanan) {
        // Definisikan harga untuk setiap jenis makanan
        $harga_makanan = array(
            'nasi_goreng' => 15000,
            'pecel_lele' => 20000,
            'tumis_kangkung' => 10000,
            'nasi' => 5000
            // Tambahkan jenis makanan lain sesuai kebutuhan
        );
    
        // Periksa apakah jenis makanan valid
        if (array_key_exists($jenis_makanan, $harga_makanan)) {
            return $harga_makanan[$jenis_makanan];
        } else {
            return false; // Jenis makanan tidak valid
        }
    }
        
    public function hapus_pesanan($index) {
        $kasir_array = $this->session->userdata('kasir') ?? [];
        
        if (isset($kasir_array[$index])) {
            unset($kasir_array[$index]);
            $this->session->set_userdata('kasir', array_values($kasir_array));
            $this->session->set_flashdata('success', 'Pesanan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Index pesanan tidak valid.');
        }

        redirect('admin');
    }

    public function hapus_semua_pesanan() {
        $this->session->unset_userdata('kasir');
        $this->session->set_flashdata('success', 'Semua pesanan berhasil dihapus.');
        redirect('admin');
    }
}
