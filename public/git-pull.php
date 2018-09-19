<?php
ini_set("display_errors", 1);

if (isset($_GET['v'])) {
    echo shell_exec("git checkout {$_GET['v']}");
} else {
    echo shell_exec("git pull");
}