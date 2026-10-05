<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class ProductsController extends Controller
{
    private function session()
    {
        $this->call->library('session');
        return lava_instance()->session;
    }

    public function __construct()
    {
        parent::__construct();
        $this->call->model('ProductModel');
    }

    public function index()
    {
        $allProducts = $this->ProductModel->all();
        $search = trim((string) $this->request->get('q', ''));
        $summary = [
            'products' => count($allProducts),
            'units' => 0,
            'value' => 0,
            'low_stock' => 0,
        ];

        foreach ($allProducts as $product) {
            $quantity = (int) $product['quantity'];
            $summary['units'] += $quantity;
            $summary['value'] += (float) $product['price'] * $quantity;
            if ($quantity <= 5) {
                $summary['low_stock']++;
            }
        }

        $products = array_values(array_filter($allProducts, function ($product) use ($search) {
            return $search === ''
                || stripos((string) $product['product_name'], $search) !== false;
        }));
        $session = $this->session();

        $this->call->view('products/index', [
            'products' => $products,
            'summary' => $summary,
            'search' => $search,
            'logged_in' => $session->userdata('logged_in') === true,
            'username' => $session->userdata('username')
        ]);
    }

    public function create()
    {
        $session = $this->session();

        $this->call->view('products/create', [
            'logged_in' => $session->userdata('logged_in') === true,
            'username' => $session->userdata('username')
        ]);
    }

    public function store()
    {
        $session = $this->session();

        if ($session->userdata('logged_in') !== true) {
            redirect('login');
            return;
        }

        $product_name = trim($this->request->post('product_name', ''));
        $description = trim($this->request->post('description', ''));
        $price = trim($this->request->post('price', ''));
        $quantity = trim($this->request->post('quantity', ''));

        if ($product_name === '' || $description === '' || $price === '' || $quantity === '') {
            $this->call->view('products/create', [
                'error' => 'All fields are required.',
                'logged_in' => true,
                'username' => $session->userdata('username')
            ]);
            return;
        }

        $this->ProductModel->insert([
            'product_name' => $product_name,
            'description' => $description,
            'price' => $price,
            'quantity' => (int)$quantity,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        redirect('products');
    }

    public function edit($id)
    {
        $session = $this->session();

        if ($session->userdata('logged_in') !== true) {
            redirect('login');
            return;
        }

        $product = $this->ProductModel->find($id);

        if (!$product) {
            redirect('products');
            return;
        }

        $this->call->view('products/edit', [
            'product' => $product,
            'logged_in' => true,
            'username' => $session->userdata('username')
        ]);
    }

    public function update($id)
    {
        $session = $this->session();

        if ($session->userdata('logged_in') !== true) {
            redirect('login');
            return;
        }

        $product_name = trim($this->request->post('product_name', ''));
        $description = trim($this->request->post('description', ''));
        $price = trim($this->request->post('price', ''));
        $quantity = trim($this->request->post('quantity', ''));

        if ($product_name === '' || $description === '' || $price === '' || $quantity === '') {
            $product = $this->ProductModel->find($id);
            $this->call->view('products/edit', [
                'product' => $product,
                'error' => 'All fields are required.',
                'logged_in' => true,
                'username' => $session->userdata('username')
            ]);
            return;
        }

        $this->ProductModel->update($id, [
            'product_name' => $product_name,
            'description' => $description,
            'price' => $price,
            'quantity' => (int)$quantity
        ]);

        redirect('products');
    }

    public function delete($id)
    {
        $session = $this->session();

        if ($session->userdata('logged_in') !== true) {
            redirect('login');
            return;
        }

        $this->ProductModel->delete($id);
        redirect('products');
    }
}
