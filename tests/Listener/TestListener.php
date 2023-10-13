<?php

namespace Listener;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;

/**
 *  Слушатель событий запущеного теста.
 */
class TestListener implements \PHPUnit\Framework\TestListener
{

    public function addError(Test $test, \Throwable $t, float $time): void
    {

    }

    public function addWarning(Test $test, Warning $e, float $time): void
    {

    }

    public function addFailure(Test $test, AssertionFailedError $e, float $time): void
    {
        printf("Test '%s' failed.\n", $test->getName());
    }

    public function addIncompleteTest(Test $test, \Throwable $t, float $time): void
    {

    }

    public function addRiskyTest(Test $test, \Throwable $t, float $time): void
    {

    }

    public function addSkippedTest(Test $test, \Throwable $t, float $time): void
    {

    }

    public function startTestSuite(TestSuite $suite): void
    {

        printf("TestSuite '%s' started.\n", $suite->getName());
    }

    public function endTestSuite(TestSuite $suite): void
    {

    }

    public function startTest(Test $test): void
    {

    }

    public function endTest(Test $test, float $time): void
    {

    }
}

