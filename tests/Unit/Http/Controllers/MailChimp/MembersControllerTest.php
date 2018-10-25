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
            'data' => static::$memberData,
            'request_exception' => 'post',
            'expected_code' => 400,
            'expected_content' => '{"message": "MailChimpList[x] not found"}',
        ];
        yield [
            'method' => 'remove',
            'list_id' => 'x',
            'data' => [],
            'request_exception' => 'delete',
            'expected_code' => 400,
            'expected_content' => '{"message": "MailChimpList[x] not found"}',
        ];
        yield [
            'method' => 'update',
            'list_id' => 'x',
            'data' => static::$memberData,
            'request_exception' => 'put',
            'expected_code' => 400,
            'expected_content' => '{"message": "MailChimpList[x] not found"}',
        ];
        yield [
            'method' => 'show',
            'list_id' => 'x',
            'data' => [],
            'request_exception' => 'get',
            'expected_code' => 400,
            'expected_content' => '{"message": "MailChimpList[x] not found"}',
        ];
    }

    /**
     * @param $method
     * @param $list_id
     * @param $data
     * @param $request_exception
     * @param $expected_code
     * @param $expected_content
     *
     * @dataProvider dataProviderForExceptions
     */
    public function testErrors($method, $list_id, $data, $request_exception, $expected_code, $expected_content)
    {
        $controller = new MembersController($this->entityManager, $this->mockMailChimpForException($request_exception));
        $request = new Request($data);

        $response = $controller->$method($request, $list_id);
        $actual_code = $response->getStatusCode();
        $actual_content = $response->content();

        self::assertEquals($expected_code, $actual_code);
        self::assertJsonStringEqualsJsonString($expected_content, $actual_content);
    }
}
