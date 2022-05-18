<?php

namespace Tests\Unit;

use Core\Test;
use PHPUnit\Framework\TestCase;

class TestUnitTest extends TestCase
{
    public function testCallMethodFoo()
    {
        $teste = new Test();
        $response = $teste->foo();

        $this->assertEquals('123', $response);
    }
}