<?php

namespace Tests\Unit\App\Models;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;
    abstract protected function traits(): array;
    abstract protected function fillables(): array;
    abstract protected function cats(): array;

    public function testIfUseTraits()
    {

        $traitsNeed = $this->traits();

        $traitsUsed = array_keys(class_uses($this->model()));
        
        $this->assertEquals($traitsNeed, $traitsUsed);
    }

    public function testFillables()
    {
        $expectedFillabales = $this->fillables();

        $fillables = $this->model()->getFillable();

        $this->assertEquals($expectedFillabales, $fillables);
    } 

    public function testIncrementIsFalse()
    {
        $model = $this->model();
        $this->assertFalse($model->incrementing);
    }

    public function testHasCasts()
    {
        $castsExpected = $this->cats();

        $casts = $this->model()->getCasts();

        $this->assertEquals($castsExpected, $casts);
    }
}