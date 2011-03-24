<?php

use CryptLib\Random\Source\UniqID;
use CryptLib\Core\Strength\Low as LowStrength;



class Unit_Random_Source_UniqIDTest extends PHPUnit_Framework_TestCase {

    public static function provideGenerate() {
        $data = array();
        for ($i = 0; $i < 100; $i += 5) {
            $not = $i > 0 ? str_repeat(chr(0), $i) : chr(0);
            $data[] = array($i, $not);
        }
        return $data;
    }

    /**
     * @covers CryptLib\Random\Source\UniqID::getStrength
     */
    public function testGetStrength() {
        $strength = new LowStrength;
        $actual = UniqID::getStrength();
        $this->assertEquals($actual, $strength);
    }

    /**
     * @covers CryptLib\Random\Source\UniqID::generate
     * @dataProvider provideGenerate
     */
    public function testGenerate($length, $not) {
        $rand = new UniqID;
        $stub = $rand->generate($length);
        $this->assertEquals($length, strlen($stub));
        $this->assertNotEquals($not, $stub);
    }

}
