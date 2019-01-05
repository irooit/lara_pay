<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace Tests\Unit\Utils;

use App\Utils\ISO3166;
use Tests\TestCase;

class ISO3166Test extends TestCase
{

    public function testCountry()
    {
        $t = ISO3166::country('CN');
        $this->assertEquals($t, '中国');

        $t = ISO3166::country('CN', false);
        $this->assertEquals($t, 'China');
    }

    public function testIsValid()
    {
        $t = ISO3166::isValid('CN');
        $this->assertTrue($t);
    }

    public function testPhoneCode()
    {
        $t = ISO3166::phoneCode('CN');
        $this->assertEquals($t, '86');

        $t = ISO3166::phoneCode('CNN');
        $this->assertEquals($t, 'N/A');
    }
}
