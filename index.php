<?php
require 'vendor/autoload.php';

use RDuuke\Request\Request;

$requests = Request::createFromGlobals();
$request = $requests->requets;
if (Request::METHOD_POST === $requests->getMethod()) {
    echo "is Method POST <br>";
    echo "Parameter ". $request->get('name');
}
?>

<form action="" method="post">
    <input type="text" name="name">
    <button>enviar</button>
</form>
