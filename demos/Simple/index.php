<?php
namespace Simple;

require '../../Bootstrap.php';

$form = new FormPessoa();
$form->setAction('index.php')
		->setMethod('post')
		->setView(\Zend_Registry::get('view'));



if ($form->isValid($_POST)) {
	var_dump($form->getEntity());
}

echo $form->render();