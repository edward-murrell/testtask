<?php
declare(strict_types=1);

namespace Tests\App\Unit\Http\Controllers\MailChimp;

use App\Http\Controllers\MailChimp\MembersController;
use Illuminate\Http\Request;
use Tests\App\TestCases\MailChimp\MemberTestCase;

/**
 * @covers \App\Http\Controllers\MailChimp\MembersController
 */
class MembersControllerTest extends MemberTestCase
{
    public function dataProviderForExceptions()
    {
        yield [
            'method' => 'create',
            'list_id' => 'x',
            'member_id' => null,
            'data' => static::$memberData,
            'request_exception' => 'post',
            'expected_code' => 404,
            'expected_content' => '{"message": "MailChimpList[x] not found"}',
        ];
        yield [
            'method' => 'remove',
            'list_id' => 'x',
            'member_id' => 'abc123',
            'data' => [],
            'request_exception' => 'delete',
            'expected_code' => 404,
            'expected_content' => '{"message": "MailChimpList[x] not found"}',
        ];
        yield [
            'method' => 'update',
            'list_id' => 'x',
            'member_id' => 'abc123',
            'data' => static::$memberData,
            'request_exception' => 'patch',
            'expected_code' => 404,
            'expected_content' => '{"message": "MailChimpList[x] not found"}',
        ];
        yield [
            'method' => 'show',
            'list_id' => 'x',
            'member_id' => 'abc123',
            'data' => [],
            'request_exception' => 'get',
            'expected_code' => 404,
            'expected_content' => '{"message": "MailChimpList[abc123] not found"}',
        ];
    }

    /**
     * @param $method
     * @param $list_id
     * @param $member_id
     * @param $data
     * @param $request_exception
     * @param $expected_code
     * @param $expected_content
     *
     * @dataProvider dataProviderForExceptions
     */
    public function testErrors($method, $list_id, $member_id, $data, $request_exception, $expected_code, $expected_content)
    {
        $controller = new MembersController($this->entityManager, $this->mockMailChimpForException($request_exception));
        $request = new Request($data);

        if ($member_id === null) {
            $response = $controller->$method($request, $list_id);
        }
        else {
            $response = $controller->$method($request, $list_id, $member_id);
        }
        $actual_code = $response->getStatusCode();
        $actual_content = $response->content();

        self::assertEquals($expected_code, $actual_code);
        self::assertJsonStringEqualsJsonString($expected_content, $actual_content);
    }
}
