<?php
/**
 * Created by PhpStorm.
 * User: mains2114
 * Date: 15-1-3
 * Time: 下午6:29
 */

session_start();
session_destroy();

header("Location: login.php", TRUE, 302);
exit();