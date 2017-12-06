<?php

/*
 * Malicious.php is part of Malicious-Code-Scanner.
 *
 * (c) Allemand Sébastien <sebastien.a.consulting@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MaliciousScanner\Scanner;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MaliciousCode extends Command
{
    public $infected_files = array();
    private $scanned_files = array();


    protected function configure()
    {
        $this->setName('malicious')
            ->setDescription("Search Malicious code in the directory");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pharFile = \Phar::running(false);
        $dir = ('' === $pharFile ? '' : dirname($pharFile) . DIRECTORY_SEPARATOR);

        $this->scan($dir);
    }

    private function scan($dir)
    {

        $this->scanned_files[] = $dir;
        $files = scandir($dir);

        if (!is_array($files)) {
            throw new Exception('Unable to scan directory ' . $dir . '.  Please make sure proper permissions have been set.');
        }

        foreach ($files as $file) {
            if (is_file($dir . '/' . $file) && !in_array($dir . '/' . $file, $this->scanned_files)) {
                $this->check(file_get_contents($dir . '/' . $file), $dir . '/' . $file);
            } elseif (is_dir($dir . '/' . $file) && substr($file, 0, 1) != '.') {
                $this->scan($dir . '/' . $file);
            }
        }
    }


    private function check($contents, $file)
    {
        $this->scanned_files[] = $file;
        if (preg_match('/(?<![a-z0-9_])eval\((base64|eval|\$_|\$\$|\$[A-Za-z_0-9\{]*(\(|\{|\[))/i', $contents)) {
            $this->infected_files[] = $file;
        }
    }
}