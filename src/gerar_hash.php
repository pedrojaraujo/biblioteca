<?php
$senha = 'S';
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo $hash;
