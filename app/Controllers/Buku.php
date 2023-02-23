<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BukuModel;
use CodeIgniter\Validation\StrictRules\Rules;

class Buku extends BaseController
{
    protected $BukuModel;

    public function __construct()
    {
        $this->BukuModel = new BukuModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Buku',
            'buku' => $this->BukuModel->findAll()
        ];
        return view('buku/index',    $data);
    }

    public function detail($idbuku)
    {
        $data = [
            'title' => 'Detail Buku',
            'buku' => $this->BukuModel->getBuku($idbuku)
        ];
        return view('/buku/detail', $data);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Form Tambah Data Buku',
            'validation' => \config\Services::validation()
        ];
        return view('buku/tambah', $data);
    }

    public function simpan()
    {
        //validasi
        if (!$this->validate(
            [
                'judul' => [
                    'rules' => 'required',
                    'errors' => ['required' => '{field} harus diisi']
                ],
                'sampul' => [
                    'rules' => 'uploaded[sampul]|max_size[sampul,10000]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'uploaded' => 'Gambar wajib dipilih',
                        'max_size' => 'Ukuran gambar terlalu besar',
                        'is_image' => 'File wajib gambar',
                        'mime_in' => 'File gambar tidak sesuai'
                    ]
                ]
            ]
        )) {
            return redirect()->to('/buku/tambah');
        }

        //simpan
        $fileSampul = $this->request->getFile('sampul');
        $fileSampul->move('img');
        $namaSampul = $fileSampul->getName();

        $this->BukuModel->save(
            [
                'judul' => $this->request->getPost('judul'),
                'pengarang' => $this->request->getPost('pengarang'),
                'penerbit' => $this->request->getPost('penerbit'),
                'tahun_terbit' => $this->request->getPost('tahun_terbit'),
                'sampul' => $namaSampul
            ]
        );
        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');
        return redirect()->to('/buku');
    }

    public function hapus($idbuku)
    {
        $this->BukuModel->delete($idbuku);
        session()->setFlashdata('pesan', 'Data Berhasil Dihapus');
        return redirect()->to('/buku');
    }

    public function ubah($idbuku)
    {
        $data = [
            'title' => 'Form Ubah Data Buku',
            'validation' => \config\Services::validation(),
            'buku' => $this->BukuModel->getBuku($idbuku)
        ];
        return view('buku/ubah', $data);
    }

    public function update($idbuku)
    {
        //validasi
        if (!$this->validate(
            [
                'judul' => [
                    'rules' => 'required',
                    'errors' => ['required' => '{field} harus diisi']
                ],
                'sampul' => [
                    'rules' => 'uploaded[sampul]|max_size[sampul,10000]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'uploaded' => 'Gambar wajib dipilih',
                        'max_size' => 'Ukuran gambar terlalu besar',
                        'is_image' => 'File wajib gambar',
                        'mime_in' => 'File gambar tidak sesuai'
                    ]
                ]
            ]
        ))
            // {
            //     return redirect()->to('/buku/ubah/' . $idbuku)->withInput();
            // }
            //simpan
            $filesampul = $this->request->getFile('sampul');
        $filesampul->move('img');
        $nmsampul = $filesampul->getName();
        //die(var_dump($filesampul));
        //cek gambar kondisi sampul lama
        if ($filesampul->getError() == 4) {
            $nmsampul = $this->request->getPost('sampulLama');
        } else {
            $nmsampul = $filesampul->getName();
            $filesampul->move('img', $nmsampul);
        }
        $this->BukuModel->save(
            [
                'id_buku' => $idbuku,
                'judul' => $this->request->getPost('judul'),
                'pengarang' => $this->request->getPost('pengerang'),
                'penerbit' => $this->request->getPost('penerbit'),
                'tahun' => $this->request->getPost('tahun'),
                'sampul' => $nmsampul
            ]
        );
        session()->setFlashdata('pesan', 'Data berhasil diubah');
        return redirect()->to('/buku');
    }
}
