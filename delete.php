<?php
session_start();
include_once 'dbh.php';
$id = $_GET['id'];
$qDelete = $conn->prepare('DELETE FROM recept where id = ?;');
$qDelete->execute([$id]);
$_SESSION['add']='<div class="alert alert-success" role="alert">
  Korisnik uspješno obrisan 🤴
 </div>';
 header("Location: ../index.php");
 exit();