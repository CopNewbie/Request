<?php
require 'vendor/autoload.php';

use RDuuke\Request\Request;

$requests = Request::createFromGlobals();
/*$request = $requests->requets;
if (Request::METHOD_POST === $requests->getMethod()) {
    echo "is Method POST <br>";
    echo "Parameter ". $request->get('name');
}*/
$file = $requests->file->get('image_1');
echo '<pre>';
print_r($file->extension());
if($requests->getMethod() == Request::METHOD_POST)
{
    if ($file->isImage()) {
        echo 'Is image';
    }
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="image_1">
    <input type="file" name="image_2">
    <button>enviar</button>
</form>
