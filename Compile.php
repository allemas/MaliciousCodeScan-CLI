<?php

/*
 * Compile.php is part of Malicious-Code-Scanner.
 *
 * (c) Allemand Sébastien <sebastien.a.consulting@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

ini_set("phar.readonly", 0);

//Cleaning up any existing phar
if (file_exists('maliciousscan.phar')) {
    unlink('maliciousscan.phar');
}
//Where are my application sources
$dir = './';
$folder = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$items = array();

foreach ($folder as $item) {
    //Get the filename
    $filename = pathinfo($item->getPathName(), PATHINFO_BASENAME);
    //Filter Unix hidden files by their leading dot. Add more filters in this condition.
    if (substr($filename, 0, 1) != '.') {
        //Key is the relative path inside the Phar, value is the complete path of the file
        $items[substr($item->getPathName(), strlen($dir))] = $item->getPathName();
    }
}
print_r($items);

$phar = new Phar('maliciousscan.phar');
$phar->buildFromIterator(new ArrayIterator($items));
$phar->setStub($phar->createDefaultStub("MaliciousScan.php"));
echo PHP_EOL;