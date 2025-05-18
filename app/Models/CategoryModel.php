<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';  // Pastikan tabel ini ada di database kamu
    protected $primaryKey = 'id';      // Sesuaikan kalau beda
    protected $allowedFields = ['name']; // Sesuaikan field yang boleh diisi

    // Kalau mau tambah fungsi khusus, bisa ditambah di sini
}
