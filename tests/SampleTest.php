<?php
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
	public function testSampleFunction()
	{
		$sample = new \Dok123\Sample\Sample();
		$this->assertTrue( $sample->sample_function( 1));
	}
}