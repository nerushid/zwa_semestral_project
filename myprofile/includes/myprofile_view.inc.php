<?php
declare(strict_types=1);

function print_user(): void {
    echo '<p>First Name: ' . $_SESSION["user_firstname"] . '</p>
          <p>Surname: ' . $_SESSION["user_surname"] . '</p>
          <p>Email: ' . $_SESSION["user_email"] . '</p>';
}