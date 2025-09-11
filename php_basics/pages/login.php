<?php
$login_info = [];


$login_fields['email'] = ['label' => 'E-mail' , 'type' => 'text', 'value'=>''];
$login_fields['password'] = ['label' => 'Wachtwoord' , 'type' => 'text', 'value'=>''];

$login_info['page'] = 'login';
$login_info['fields'] = $login_fields;
// $login_info['page'] = $page;


showForm($login_info);
?>