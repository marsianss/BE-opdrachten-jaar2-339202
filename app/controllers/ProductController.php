<?php

class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        // Load the Product model
        $this->productModel = $this->model('ProductModel');
    }

    public function index()
    {
        error_log("ProductController index method called"); // Debugging

        $data = [
            'title' => 'Overzicht producten uit het assortiment',
            'products' => NULL,
            'startDate' => '',
            'endDate' => '',
            'message' => NULL
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data['startDate'] = trim($_POST['startDate']);
            $data['endDate'] = trim($_POST['endDate']);

            try {
                $products = $this->productModel->getProductsByDateRange($data['startDate'], $data['endDate']);
                $data['products'] = $products;
            } catch (Exception $e) {
                error_log($e->getMessage());
                $data['message'] = "Er is een fout opgetreden in de database: " . $e->getMessage();
            }
        }

        $this->view('product/index', $data);
    }

    public function delete($id)
    {
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            $this->redirect('product');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $today = date('Y-m-d');
            if ($today < $product->EinddatumLevering) {
                $this->setFlash('product_message', 'Product kan niet worden verwijderd, datum van vandaag ligt voor einddatum levering');
                $this->redirect('product');
            }

            if ($this->productModel->deleteProduct($id)) {
                $this->setFlash('product_message', 'Product is succesvol verwijderd');
                $this->redirect('product');
            } else {
                $this->setFlash('product_message', 'Er is iets misgegaan bij het verwijderen van het product');
                $this->redirect('product');
            }
        }

        $data = [
            'product' => $product
        ];

        $this->view('product/delete', $data);
    }

    private function setFlash($name, $message)
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION[$name] = $message;
    }

    private function redirect($url)
    {
        header('Location: ' . URLROOT . '/' . $url);
        exit();
    }
}
