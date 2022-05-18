<?php

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use PHPUnit\Framework\TestCase;

use Core\Domain\Validation\DomainValidation;
use Throwable;

class DomainValidationUnitTest extends TestCase
{
    public function testNotNull()
    {
        try {
            $value = '';
            DomainValidation::notNull($value);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }   
    
    public function testNotNullCustomMessageException()
    {
        try {
            $value = '';
            DomainValidation::notNull($value, 'custom message error');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'custom message error');
        }
    } 
    
    public function testStrMaxLength()
    {
        try {
            $value = 'Teste';
            DomainValidation::strMaxLength($value, 5, 'Custom message');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message');
        }
    }   

    public function testStrMinLength()
    {
        try {
            $value = 'Test';
            DomainValidation::strMinLength($value, 8, 'Custom message');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message');
        }
    }  
    
    public function testStrCanNullAndMaxLength()
    {
        try {
            $value = 'teste';
            DomainValidation::strCanNullAndMaxLength($value, 3, 'Custom message');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message');
        }
    }  
}