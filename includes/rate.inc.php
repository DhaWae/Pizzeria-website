<?php
session_start();
if(isset($_POST["submit"])) {
    $user_id = $_SESSION['user_id'];
    $pizza_id = $_POST['pizza_id'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    $date = date('Y-m-d H:i:s');

    echo "'userid' + $user_id + 'pizza_id' + $pizza_id + 'comment' + $comment + 'rating' + $rating + 'date' + $date";

    include_once 'dbh.inc.php';
    include_once 'rating.functions.inc.php';

    createRating($conn, $user_id, $pizza_id, $comment, $rating, $date);
    

} else {
    header("Location: ../php/index.php");
    exit();
}