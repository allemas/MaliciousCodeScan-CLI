<?php

/*
 * Console.php is part of Malicious-Code-Scanner.
 *
 * (c) Allemand Sébastien <sebastien.a.consulting@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace MaliciousScanner\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use MaliciousScanner\Scanner\MaliciousCode;

class Console extends Application
{
    public function __construct($name, $version)
    {
        parent::__construct($name, $version);

        $this->initCommands();
    }

    public function initCommands()
    {
        $this->add(new MaliciousCode());
    }

    public function getDefaultInputDefinition()
    {
        return new InputDefinition(array(
            new InputArgument('command', InputArgument::REQUIRED, 'The command to execute'),
        ));
    }
}