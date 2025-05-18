<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class TestDb extends Controller
{
    public function index()
    {
        $db = Database::connect();
        $query = $db->query("SELECT * FROM categories");
        $results = $query->getResult();

        echo "<h3>Data from 'categories' table:</h3><pre>";
        print_r($results);
        echo "</pre>";
    }
}
