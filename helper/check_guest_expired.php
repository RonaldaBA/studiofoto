<?php

require_once "connection.php";

mysqli_query(
    $connection,
    "UPDATE guest_account
     SET status='inactive'
     WHERE expired_at < NOW()
     AND status='active'"
);