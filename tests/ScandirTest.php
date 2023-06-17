<?php

namespace Siestacat\PhpScandir\Tests;

use PHPUnit\Framework\TestCase;
use Siestacat\PhpScandir\PhpScandir;

class ScandirTest extends TestCase
{
    public function testFunc()
    {

        $files_count = 0;

        PhpScandir::scan(__DIR__ . '/dirtest', function(string $filepath) use (&$files_count) {
            $files_count++;
        });

        $this->assertEquals(207, $files_count);

        
    }

    
}