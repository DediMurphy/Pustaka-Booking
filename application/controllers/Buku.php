<?php 

class Buku extends CI_Controller
{

    public function __construct() 
    { 
        parent::__construct(); 
        cek_login(); 

    } 
    // Manajemen Buku
    public function index() {
        $data['judul'] = 'Kategori Buku'; 
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array(); 
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array(); 

                $this->form_validation->set_rules('judul_buku', 'Judul Buku', 'required|min_length[3]', [ 
                    'required' => 'Judul Buku harus diisi', 
                    'min_length' => 'Judul buku terlalu pendek' 
                ]); 
                $this->form_validation->set_rules('id_kategori', 'Kategori', 'required', [ 
                    'required' => 'Nama pengarang harus diisi', 
                ]); 
                $this->form_validation->set_rules('pengarang', 'Nama Pengarang', 'required|min_length[3]', [ 
                    'required' => 'Nama pengarang harus diisi', 
                    'min_length' => 'Nama pengarang terlalu pendek' 
                ]); 
                $this->form_validation->set_rules('penerbit', 'Nama Penerbit', 'required|min_length[3]', [ 
                    'required' => 'Nama penerbit harus diisi', 
                    'min_length' => 'Nama penerbit terlalu pendek' 
                ]); 
                $this->form_validation->set_rules('tahun', 'Tahun Terbit', 'required|min_length[3]|max_length[4]|numeric', [ 
                    'required' => 'Tahun terbit harus diisi', 
                    'min_length' => 'Tahun terbit terlalu pendek', 
                    'max_length' => 'Tahun terbit terlalu panjang', 
                    'numeric' => 'Hanya boleh diisi angka' 
                ]); 
                $this->form_validation->set_rules('isbn', 'Nomor ISBN', 'required|min_length[3]|numeric', [ 
                    'required' => 'Nama ISBN harus diisi', 
                    'min_length' => 'Nama ISBN terlalu pendek', 
                    'numeric' => 'Yang anda masukan bukan angka' 
                ]); 
                $this->form_validation->set_rules('stok', 'Stok', 'required|numeric', [ 
                    'required' => 'Stok harus diisi', 
                    'numeric' => 'Yang anda masukan bukan angka' 
                ]); 
                 //konfigurasi sebelum gambar diupload 
        $config['upload_path'] = './assets/img/upload/'; 
        $config['allowed_types'] = 'jpg|png|jpeg'; 
        // $config['max_size'] = '3000'; 
        // $config['max_width'] = '1024'; 
        // $config['max_height'] = '1000'; 
        $config['file_name'] = 'img' . time(); 
 
        $this->load->library('upload', $config); 
 
        if ($this->form_validation->run() == false) { 
            $this->load->view('templates/header', $data); 
            $this->load->view('templates/sidebar', $data); 
            $this->load->view('templates/topbar', $data); 
            $this->load->view('buku/index', $data); 
            $this->load->view('templates/footer'); 
        } else { 
            if ($this->upload->do_upload('image')) { 
                $image = $this->upload->data(); 
                $gambar = $image['file_name']; 
            } else { 
                $gambar = ''; 
            } 
 
            $data = [ 
                'judul_buku' => $this->input->post('judul_buku', true), 
                'id_kategori' => $this->input->post('id_kategori', true), 
                'pengarang' => $this->input->post('pengarang', true), 
                'penerbit' => $this->input->post('penerbit', true), 
                'tahun_terbit' => $this->input->post('tahun', true), 
                'isbn' => $this->input->post('isbn', true), 
                'stok' => $this->input->post('stok', true), 
                'dipinjam' => 0, 
                'dibooking' => 0, 
                'image' => $gambar 
            ]; 
 
            $this->ModelBuku->simpanBuku($data); 
            redirect('buku'); 
        }

    }
    // KATEGORI
    public function kategori() 
    { 
        $data['judul'] = 'Kategori Buku'; 
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array(); 
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array(); 
 
        $this->form_validation->set_rules('nama_kategori', 'nama kategori', 'required', [ 
            'required' => 'Judul Buku harus diisi' 
        ]); 
 
        if ($this->form_validation->run() == false) { 
            $this->load->view('templates/header', $data); 
            $this->load->view('templates/sidebar', $data); 
            $this->load->view('templates/topbar', $data); 
            $this->load->view('buku/kategori', $data); 
            $this->load->view('templates/footer'); 
        } else { 
            $data = [
                'nama_kategori' => $this->input->post('nama_kategori', true)
            ];
 
            $this->ModelBuku->simpanKategori($data); 
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Kategori berhasil ditambahkan!</div>');
            redirect('buku/kategori'); 
        } 
    } 

     // Method untuk mengubah kategori
     public function ubahKategori()
     {
         $data['judul'] = 'Ubah Kategori';
         $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
         $id = $this->uri->segment(3);
         $data['kategori'] = $this->ModelBuku->kategoriWhere(['id_kategori' => $id])->row_array();
 
         $this->form_validation->set_rules('kategori', 'nama_Kategori', 'required', [
             'required' => 'Kategori harus diisi'
         ]);
 
         if ($this->form_validation->run() == false) {
             $this->load->view('templates/header', $data);
             $this->load->view('templates/sidebar', $data);
             $this->load->view('templates/topbar', $data);
             $this->load->view('buku/ubah_kategori', $data);
             $this->load->view('templates/footer');
         } else {
             $data = [
                 'nama_kategori' => $this->input->post('kategori', true)
             ];
             $this->ModelBuku->updateKategori(['id_kategori' => $id], $data);
             redirect('buku/kategori');
         }
     }
 
 
    public function hapusKategori() 
    { 
        $where = ['id_kategori' => $this->uri->segment(3)]; 
        $this->ModelBuku->hapusKategori($where); 
        redirect('buku/kategori'); 
    } 

     // UPDATE BUKU
     public function ubahBuku() 
     { 
         $data['judul'] = 'Ubah Data Buku'; 
         $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array(); 
         $data['buku'] = $this->ModelBuku->bukuWhere(['id' => $this->uri->segment(3)])->row_array(); 
         $kategori = $this->ModelBuku->joinKategoriBuku(['buku.id' => $this->uri->segment(3)])->row_array(); 
         
         $data['id'] = $kategori['id_kategori']; 
         $data['k'] = $kategori['nama_kategori']; 
         $data['kategori'] = $this->ModelBuku->getKategori()->result_array(); 
         
         $this->form_validation->set_rules('judul_buku', 'Judul Buku', 'required|min_length[3]', [ 
             'required' => 'Judul Buku harus diisi', 
             'min_length' => 'Judul buku terlalu pendek' 
         ]); 
         $this->form_validation->set_rules('id_kategori', 'Kategori', 'required', [ 
             'required' => 'Kategori harus diisi', 
         ]); 
         $this->form_validation->set_rules('pengarang', 'Nama Pengarang', 'required|min_length[3]', [ 
             'required' => 'Nama pengarang harus diisi', 
             'min_length' => 'Nama pengarang terlalu pendek' 
         ]); 
         $this->form_validation->set_rules('penerbit', 'Nama Penerbit', 'required|min_length[3]', [ 
             'required' => 'Nama penerbit harus diisi', 
             'min_length' => 'Nama penerbit terlalu pendek' 
         ]); 
         $this->form_validation->set_rules('tahun_terbit', 'Tahun Terbit', 'required|min_length[3]|max_length[4]|numeric', [ 
             'required' => 'Tahun terbit harus diisi', 
             'min_length' => 'Tahun terbit terlalu pendek', 
             'max_length' => 'Tahun terbit terlalu panjang', 
             'numeric' => 'Hanya boleh diisi angka' 
         ]); 
         $this->form_validation->set_rules('isbn', 'Nomor ISBN', 'required|min_length[3]|numeric', [ 
             'required' => 'Nomor ISBN harus diisi', 
             'min_length' => 'Nomor ISBN terlalu pendek', 
             'numeric' => 'Yang anda masukan bukan angka' 
         ]); 
         $this->form_validation->set_rules('stok', 'Stok', 'required|numeric', [ 
             'required' => 'Stok harus diisi', 
             'numeric' => 'Yang anda masukan bukan angka' 
         ]); 
         
         $config['upload_path'] = './assets/img/upload/'; 
         $config['allowed_types'] = 'jpg|png|jpeg'; 
        //  $config['max_size'] = '3000'; 
        //  $config['max_width'] = '1024'; 
        //  $config['max_height'] = '1000'; 
         $config['file_name'] = 'img' . time(); 
         
         $this->load->library('upload', $config); 
         
         if ($this->form_validation->run() == false) { 
             $this->load->view('templates/header', $data); 
             $this->load->view('templates/sidebar', $data); 
             $this->load->view('templates/topbar', $data); 
             $this->load->view('buku/ubah_buku', $data); 
             $this->load->view('templates/footer'); 
         } else { 
             if ($this->upload->do_upload('image')) { 
                 $image = $this->upload->data(); 
                 if ($this->input->post('old_pict', true)) {
                     unlink('assets/img/upload/' . $this->input->post('old_pict', TRUE)); 
                 }
                 $gambar = $image['file_name']; 
             } else { 
                 $gambar = $this->input->post('old_pict', TRUE); 
             } 
             
             $data = [ 
                 'judul_buku' => $this->input->post('judul_buku', true), 
                 'id_kategori' => $this->input->post('id_kategori', true), 
                 'pengarang' => $this->input->post('pengarang', true), 
                 'penerbit' => $this->input->post('penerbit', true), 
                 'tahun_terbit' => $this->input->post('tahun_terbit', true),
                 'isbn' => $this->input->post('isbn', true), 
                 'stok' => $this->input->post('stok', true), 
                 'image' => $gambar 
             ]; 
     
             $this->ModelBuku->updateBuku($data, ['id' => $this->input->post('id')]); 
             redirect('buku'); 
         } 
     } 

     public function tambahBuku()
     {
         $data['judul'] = 'Tambah Data Buku';
         $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
         $data['kategori'] = $this->ModelBuku->getKategori()->result_array();
 
         $this->form_validation->set_rules('judul_buku', 'Judul Buku', 'required|min_length[3]', [
             'required' => 'Judul Buku harus diisi',
             'min_length' => 'Judul buku terlalu pendek'
         ]);
         $this->form_validation->set_rules('id_kategori', 'Kategori', 'required', [
             'required' => 'Kategori harus diisi',
         ]);
         $this->form_validation->set_rules('pengarang', 'Nama Pengarang', 'required|min_length[3]', [
             'required' => 'Nama pengarang harus diisi',
             'min_length' => 'Nama pengarang terlalu pendek'
         ]);
         $this->form_validation->set_rules('penerbit', 'Nama Penerbit', 'required|min_length[3]', [
             'required' => 'Nama penerbit harus diisi',
             'min_length' => 'Nama penerbit terlalu pendek'
         ]);
         $this->form_validation->set_rules('tahun_terbit', 'Tahun Terbit', 'required|numeric', [
             'required' => 'Tahun terbit harus diisi',
             'numeric' => 'Hanya boleh diisi angka'
         ]);
         $this->form_validation->set_rules('isbn', 'Nomor ISBN', 'required|min_length[3]|numeric', [
             'required' => 'Nama ISBN harus diisi',
             'min_length' => 'Nama ISBN terlalu pendek',
             'numeric' => 'Yang anda masukan bukan angka'
         ]);
         $this->form_validation->set_rules('stok', 'Stok', 'required|numeric', [
             'required' => 'Stok harus diisi',
             'numeric' => 'Yang anda masukan bukan angka'
         ]);
 
         if ($this->form_validation->run() == false) {
             $this->session->set_flashdata('pesan', validation_errors());
             redirect('buku');
         } else {
             $config['upload_path'] = './assets/img/upload/';
             $config['allowed_types'] = 'jpg|png|jpeg';
             $config['max_size'] = '3000';
             $config['max_width'] = '1024';
             $config['max_height'] = '1000';
             $config['file_name'] = 'img' . time();
 
             $this->load->library('upload', $config);
 
             if ($this->upload->do_upload('image')) {
                 $image = $this->upload->data();
                 $gambar = $image['file_name'];
             } else {
                 $gambar = 'default.jpg';
             }
 
             $data = [
                 'judul_buku' => $this->input->post('judul_buku', true),
                 'id_kategori' => $this->input->post('id_kategori', true),
                 'pengarang' => $this->input->post('pengarang', true),
                 'penerbit' => $this->input->post('penerbit', true),
                 'tahun_terbit' => $this->input->post('tahun_terbit', true),
                 'isbn' => $this->input->post('isbn', true),
                 'stok' => $this->input->post('stok', true),
                 'image' => $gambar
             ];
 
             $this->ModelBuku->simpanBuku($data);
             redirect('buku');
         }
     }
 

    public function hapusBuku() 
    { 
        $where = ['id' => $this->uri->segment(3)]; 
        $this->ModelBuku->hapusBuku($where); 
        redirect('buku'); 
    }
}     