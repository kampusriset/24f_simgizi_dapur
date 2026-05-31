<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../auth/login.php");
    exit;
}

require_once '../config/database.php';
require_once '../models/dapur.php';

$db = (new Database())->connect();
$dapur = new Dapur($db);

$id = $_GET['id'] ?? null;

if ($id) {
    $dapur->delete($id);
    header("Location: read.php?status=success_deleted");
} else {
    header("Location: read.php");
}
exit;
?>