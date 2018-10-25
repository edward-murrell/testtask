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
}
