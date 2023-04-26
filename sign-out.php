<?php

session_start();
// Finally, destroy the session.
session_destroy();
Header("Location: sign-in.php");

?>