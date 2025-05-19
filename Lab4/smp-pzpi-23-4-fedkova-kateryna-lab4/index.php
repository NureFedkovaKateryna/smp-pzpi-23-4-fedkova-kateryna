<?php 

session_start();
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$page = $request ?: '/';

$allowedWithoutAuth = ['/login', '/'];

require_once("includes/header.php");

if (!isset($_SESSION['username']) && !in_array($page, $allowedWithoutAuth)) {
    require_once("pages/page404.php");
    exit;
}

switch ($page) {
    case "/":
        require_once("pages/main.php"); 
        break;
    case "/basket":
        require_once("pages/basket.php");
        break;
    case "/products":
        require_once("pages/products.php");
        break;
    case "/login":
        require_once("pages/login.php");
        break;
    case "/profile":
        require_once("pages/user_profile.php");
        break;
    default:
        require_once("pages/page404.php");
        break;
}

require_once("includes/footer.php");

?>