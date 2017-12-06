<?php

/*
 * MaliciousScan.php is part of Malicious-Code-Scanner.
 *
 * (c) Allemand Sébastien <sebastien.a.consulting@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require __DIR__.'/vendor/autoload.php';
use MaliciousScanner\Console\Console;

$console = new Console("Malicious Code", 1.0);
$console->run();