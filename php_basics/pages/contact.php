<?php
// form info contact
$form_info = [];

$fields['name'] = ['label' => 'Name' , 'type' => 'text', 'value'=>''];
$fields['email'] = ['label' => 'E-mail' , 'type' => 'text', 'value'=>''];
$fields['message'] = ['label' => 'Bericht' , 'type' => 'textarea', 'value'=>''];
$form_info['fields'] = $fields;
$form_info['page'] = 'form_results';


//show form
showForm($form_info);
?>