<?php
declare(strict_types=1);

namespace App\Database\Entities\MailChimp;

use Tests\App\TestCases\MailChimp\MemberTestCase;

/**
 * Tests for creation and validation of the MailChimp Member Entities.
 */
class MailChimpMembersTest extends MemberTestCase
{
    /**
     * Test that a MailChimpMember returns the same data as it's source.
     */
    public function testToMailChimpArray()
    {
        $expected = static::$memberData;

        $list = new MailChimpMember(static::$memberData);
        $actual = $list->toArray();

        $this->assertEquals($expected, $actual);
    }

    /**
     * Test happy path for validation.
     */
    public function testValidationRulesCleanlyPass()
    {
        $source_data = static::$listData;

        $member = new MailChimpMember($source_data);
        $validator = app('validator')->make($member->toMailChimpArray(), $member->getValidationRules());

        $this->assertFalse($validator->fails());
    }

    /**
     * Test Members returns appropriate number of errors.
     */
    public function testValidationRulesFailWithEmpty()
    {
        $expected_error_keys = [
            'email_address',
            'email_type',
            'status',
        ];
        $source_data = [
            'email_address' => 'invalid_email_address',
            'email_type' => 'not_a_valid_type',
            'status' => 'not_a_valid_status',
        ];

        $list = new MailChimpMember($source_data);
        $validator = app('validator')->make($list->toMailChimpArray(), $list->getValidationRules());

        $this->assertTrue($validator->fails());
        $this->assertEquals($expected_error_keys, array_keys($validator->errors()->toArray()));
    }
}
