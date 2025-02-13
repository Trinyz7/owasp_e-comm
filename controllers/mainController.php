<?php

require_once 'models/userModel.php';
require_once 'models/productModel.php';

class MainController {
    private $userModel;
    private $productModel;

    public function __construct() {
        $this->userModel = new UserModel();
        $this->productModel = new ProductModel();
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        include 'view/index.php'; 
    }

    public function login() {
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $email && $password) {
            $user = $this->userModel->checkUser($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: index.php'); 
                exit;
            } else {
                $error = "Invalid credentials";
                include 'view/login.php'; 
            }
        } else {
            include 'view/login.php';
        }
    }

    public function register() {
        $username = $_POST['username'] ?? null;
        $email = $_POST['email'] ?? null;
        $password = $_POST['password'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $username && $email && $password) {
            $result = $this->userModel->addUser($username, $email, $password);
            if ($result) {
                header('Location: login.php'); 
                exit;
            } else {
                $error = "Error registering";
                include 'view/register.php'; 
            }
        } else {
            include 'view/register.php';
        }
    }

    public function contact() {
        include 'view/contact.php';
    }

}

$page = $_GET['page'] ?? 'index';

$controller = new MainController();

switch ($page) {
    case 'login':
        $controller->login();
        break;
    case 'register':
        $controller->register();
        break;
    case 'contact':
        $controller->contact();
        break;
    default:
        $controller->index();
        break;
}
