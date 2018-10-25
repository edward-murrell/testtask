<?php
declare(strict_types=1);

namespace Tests\App\Functional\Http\Controllers\MailChimp;

use Mailchimp\Mailchimp;
use Tests\App\TestCases\MailChimp\MemberTestCase;

class MemberControllerTest extends MemberTestCase
{
    private function getDataToSend()
    {
        $data = static::$memberData;
        $data['email_address'] = 'edward@codefoundation.com.au';
        $data['unique_email_id'] = '';
        $data['merge_fields'] = ['FNAME' => 'Edward', 'LNAME' => 'Murrell'];

        unset($data['id']);
        unset($data['unique_email_id']);
        unset($data['stats']);
        unset($data['list_id']);
        unset($data['interests']);

        return $data;
    }

    /**
     * Test application returns empty successful response when removing existing list.
     *
     * @return void
     */
    public function testRemoveListSuccessfully(): void
    {
        $this->post('/mailchimp/lists', static::$listData);
        $list = \json_decode($this->response->content(), true);
        $listId = $list['mail_chimp_id'];
        $this->createdListIds[] = $listId; // Store MailChimp list id for cleaning purposes

        $memberData = $this->getDataToSend();
        $this->post("/mailchimp/lists/{$listId}/member", $memberData);
        $memberId = md5($memberData['email_address']);

        $this->delete("/mailchimp/lists/{$listId}/member/{$memberId}");

        $this->assertResponseOk();
        self::assertEmpty(\json_decode($this->response->content(), true));
    }

    /**
     * Test application returns successfully response when updating existing list with updated values.
     *
     * @return void
     */
    public function testUpdateListSuccessfully(): void
    {
        $this->post('/mailchimp/lists', static::$listData);
        $list = \json_decode($this->response->content(), true);
        $listId = $list['mail_chimp_id'];
        $this->createdListIds[] = $listId;

        $memberData = $this->getDataToSend();
        $this->post("/mailchimp/lists/{$listId}/member", $memberData);
        $memberId = md5($memberData['email_address']);

        $newData['merge_fields'] = ['FNAME' => 'Bob', 'LNAME' => 'Smith'];
        $this->put("/mailchimp/lists/{$listId}/member/{$memberId}", $newData);

        $this->assertResponseOk();
        $this->get("/mailchimp/lists/{$listId}/member/{$memberId}");
        $data = \json_decode($data = $this->response->content(), true);
        $this->assertEquals("Bob", $data['merge_fields']['FNAME']);
        $this->assertEquals("Smith", $data['merge_fields']['LNAME']);
    }

}
