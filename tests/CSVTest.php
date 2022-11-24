<?php

use App\Services\DataSources\CSV;
use PHPUnit\Framework\TestCase;



class CSVTest extends TestCase
{

    public function test_empty_filepath()
    {
        $this->expectException('ErrorException');
        new CSV('', __DIR__);
    }

    public function test_empty_basedir()
    {
        $this->expectException('ErrorException');
        new CSV('file', '');
    }

}
