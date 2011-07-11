<?php

class Vectors_Cipher_Block_Mode_ECBTest extends PHPUnit_Framework_TestCase {


    public static function provideTestEncryptVectors() {
        $file = \CryptLibTest\getTestDataFile('Vectors/aes-ecb.test-vectors');
        $nessie = new CryptLibTest\lib\VectorParser\NESSIE($file);
        $data = $nessie->getVectors();
        foreach ($data as $vector) {
            $results[] = array(
                $vector['mode'],
                $vector['key'],
                $vector['iv'],
                strtoupper($vector['plain']),
                strtoupper($vector['cipher']),
            );
        }
        return $results;
    }
    
    /**
     * @dataProvider provideTestEncryptVectors
     */
    public function testEncrypt($cipher, $key, $iv, $data, $expected) {
        $cipher = new \CryptLib\Cipher\Block\Cipher\AES($cipher);
        $cipher->setKey(pack('H*', $key));
        $mode = new \CryptLib\Cipher\Block\Mode\ECB($cipher, pack('H*', $iv), '');
        $enc = $mode->encrypt(pack('H*', $data));
        $enc .= $mode->finish();
        $this->assertEquals($expected, strtoupper(bin2hex($enc)));
    }
    
    /**
     * @dataProvider provideTestEncryptVectors
     */
    public function testDecrypt($cipher, $key, $iv, $expected, $data) {
        $cipher = new \CryptLib\Cipher\Block\Cipher\AES($cipher);
        $cipher->setKey(pack('H*', $key));
        $mode = new \CryptLib\Cipher\Block\Mode\ECB($cipher, pack('H*', $iv), '');
        $dec = $mode->decrypt(pack('H*', $data));
        $dec .= $mode->finish();
        $this->assertEquals($expected, strtoupper(bin2hex($dec)));
    }
    

}
