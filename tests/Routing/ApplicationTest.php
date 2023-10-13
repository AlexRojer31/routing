<?php

namespace Routing;

use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{

    /**
     * @covers ApplicationTest
     */
    public function testGetString() : void
    {
        $this->assertIsString('Ok');
    }
}

