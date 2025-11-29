<?php
declare(strict_types = 1);

function print_header() {
    /*
        <a href="../newlisting/newlisting.html" id="new-listing">Add New Listing</a>
        <a href="../login/index.php">Login</a>
        <a href="../registration/index.php">Sign Up</a>
    */

    if (isset($_SESSION["user_id"])) {
        echo '<a href="../newlisting/newlisting.html" id="new-listing2">+ Add New Listing</a>
            <a href="../myprofile/index.php">My Profile</a>
            <a href="#" id="logout">Log Out</a>';
    } else {
        echo '<a href="../login/index.php">Login</a>
            <a href="../registration/index.php">Sign Up</a>';
    }
}