<?php
$register_info = [];

$register_fields['name'] = ['label' => 'Naam' , 'type' => 'text', 'value'=>''];
$register_fields['email'] = ['label' => 'E-mail' , 'type' => 'text', 'value'=>''];
$register_fields['password'] = ['label' => 'Wachtwoord' , 'type' => 'text', 'value'=>''];
$register_fields['repeat_password'] = ['label' => 'Herhaal Wachtwoord' , 'type' => 'text', 'value'=>''];

$register_info['page'] = 'register';
$register_info['fields'] = $register_fields;
// $login_info['page'] = $page;


showForm($register_info);
?>