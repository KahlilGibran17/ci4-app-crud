<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use CodeIgniter\Controller;

class Product extends Controller
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll(); // kirim data kategori ke view
        return view('products/index', $data);
    }

    public function getAll()
    {
        $model = new ProductModel();
        $data['products'] = $model->getProductsWithCategory();

        return $this->response->setJSON($data);
    }

    public function create()
    {
        $model = new ProductModel();
        $model->insert([
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'category_id' => $this->request->getPost('category_id'),
        ]);

        return $this->response->setJSON(['status' => 'success']);
    }

    public function delete($id)
    {
        $model = new ProductModel();
        $model->delete($id);

        return $this->response->setJSON(['status' => 'deleted']);
    }
    public function update($id)
{
    $model = new ProductModel();
    $model->update($id, [
        'name' => $this->request->getPost('name'),
        'price' => $this->request->getPost('price'),
        'category_id' => $this->request->getPost('category_id'),
    ]);

    return $this->response->setJSON(['status' => 'updated']);
}

}
