<?php

namespace Siestacat\PhpScandir\Tests;

use PHPUnit\Framework\TestCase;
use function Siestacat\PhpScandir\scanrdir;

class ScandirTest extends TestCase
{
    public function testFunc()
    {

        $files_count = 0;

        scanrdir(__DIR__ . '/dirtest', function(string $filepath) use (&$files_count) {
            $files_count++;
        });

        $this->assertEquals(207, $files_count);

        
    }

    
}