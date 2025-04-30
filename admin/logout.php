<?php

session_start();
session_destroy();
echo "<script>window.location.href='sign_in.php'</script>";

?>