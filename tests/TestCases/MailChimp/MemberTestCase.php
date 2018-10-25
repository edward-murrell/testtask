<?php
declare(strict_types=1);

namespace Tests\App\TestCases\MailChimp;

use App\Database\Entities\MailChimp\MailChimpMember;
use Mailchimp\Mailchimp;

abstract class MemberTestCase extends ListTestCase
{
    /**
     * @var array
     */
    protected $createdMembers = [];

    /**
     * @var array
     */
    protected static $memberData = [
            'id'               => '5bf9d88a5ebb8e535975735cdd6eac1e',
            'email_address'    => 'testname@example.com',
            'unique_email_id'  => 'fab20fa03d',
            'email_type'       => 'html',
            'status'           => 'subscribed',
            'status_if_new'    => '',
            'merge_fields'     =>
                [
                    'FNAME' => 'Robert',
                    'LNAME' => 'Smith',
                ],
            'interests'        =>
                [
                    '9143cf3bd1' => false,
                ],
            'stats'            =>
                [
                    'avg_open_rate'  => 0,
                    'avg_click_rate' => 0,
                ],
            'ip_signup'        => '',
            'timestamp_signup' => '',
            'ip_opt'           => '198.2.191.34',
            'timestamp_opt'    => '2015-09-16 19:24:29',
            'member_rating'    => 2,
            'last_changed'     => '2015-09-16 19:24:29',
            'language'         => '',
            'vip'              => false,
            'email_client'     => '',
            'location'         =>
                [
                    'latitude'     => 0,
                    'longitude'    => 0,
                    'gmtoff'       => 0,
                    'dstoff'       => 0,
                    'country_code' => '',
                    'timezone'     => '',
                ],
            'list_id'          => '57afe96172',
        ];

    /**
     * Call MailChimp to delete lists created during test.
     *
     * @return void
     */
    public function tearDown(): void
    {
        /** @var Mailchimp $mailChimp */
        $mailChimp = $this->app->make(Mailchimp::class);

        parent::tearDown();
    }

    /**
     * Create MailChimp list into database.
     *
     * @param array $data
     *
     * @return \App\Database\Entities\MailChimp\MailChimpList
     */
    protected function createMember(array $data): MailChimpMember
    {
        $list = new MailChimpMember($data);

        $this->entityManager->persist($list);
        $this->entityManager->flush();

        return $list;
    }
}
