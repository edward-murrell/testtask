<?php
declare(strict_types=1);

namespace App\Database\Entities\MailChimp;

use Tests\App\TestCases\MailChimp\ListTestCase;

class MailChimpListTest extends ListTestCase
{
    /**
     * Test that a MailChimpList returns data that is the same as it's source
     *  array, with the null fields filled in.
     */
    public function testToMailChimpArray()
    {
        $expected = static::$listData;
        $expected['list_id'] = null;
        $expected['mail_chimp_id'] = null;

        $list = new MailChimpList(static::$listData);
        $actual = $list->toArray();

        $this->assertEquals($expected, $actual);
    }
}
