<?php
require 'vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

$data = $_POST['QRInput'];

$qrCode = Builder::create()
    ->writer(new PngWriter())
    ->data($data)
    ->build();

header('Content-Type: '.$qrCode->getMimeType());

echo $qrCode->getString();