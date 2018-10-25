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

    /**
     * Test that creating a MailChimpList entity that has an entity_id in it's
     *  JSON sets list_id value as the ID.
     */
    public function testGetId()
    {
        $expected = 'aabb1133cc22';

        $source_data = static::$listData;
        $source_data['list_id'] = 'aabb1133cc22';

        $list = new MailChimpList($source_data);
        $actual = $list->getId();

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test happy path for validation.
     */
    public function testValidationRulesCleanlyPass()
    {
        $source_data = static::$listData;

        $list = new MailChimpList($source_data);
        $validator = app('validator')->make($list->toMailChimpArray(), $list->getValidationRules());

        $this->assertFalse($validator->fails());
    }

    /**
     * Test that an empty list fails validation.
     */
    public function testValidationRulesFailWithEmpty()
    {
        $source_data = [];

        $list = new MailChimpList($source_data);
        $validator = app('validator')->make($list->toMailChimpArray(), $list->getValidationRules());

        $this->assertTrue($validator->fails());
        $this->assertCount(14, $validator->errors()->toArray());
    }
}
