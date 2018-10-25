<?php
declare(strict_types=1);

namespace App\Http\Controllers\MailChimp;

use App\Database\Entities\MailChimp\MailChimpList;
use App\Database\Entities\MailChimp\MailChimpMember;
use App\Http\Controllers\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Mailchimp\Mailchimp;

class MembersController extends Controller
{
    /**
     * @var \Mailchimp\Mailchimp
     */
    private $mailChimp;

    /**
     * ListsController constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \Mailchimp\Mailchimp $mailchimp
     */
    public function __construct(EntityManagerInterface $entityManager, Mailchimp $mailchimp)
    {
        parent::__construct($entityManager);

        $this->mailChimp = $mailchimp;
    }

    public function create(Request $request, $list_id): JsonResponse
    {
        $member = new MailChimpMember($request->all());
        try {
            $this->mailChimp->post("/lists/{$list_id}/members",
                $member->toMailChimpArray());
        }
        catch (\Exception $e) {
            return $this->errorResponse(['message' => "MailChimpList[{$list_id}] not found"]);
        }
    }

    public function remove(Request $request, $list_id, $member_id): JsonResponse
    {
        $member = new MailChimpMember($request->all());
        try {
            $this->mailChimp->delete("/lists/{$list_id}/members/{$member_id}");
        }
        catch (\Exception $e) {
            return $this->errorResponse(['message' => "MailChimpList[{$list_id}] not found"]);
        }
    }

    public function update(Request $request, $list_id, $member_id): JsonResponse
    {
        $member = new MailChimpMember($request->all());
        try {
            $this->mailChimp->patch("/lists/{$list_id}/members/{$member_id}");
        }
        catch (\Exception $e) {
            return $this->errorResponse(['message' => "MailChimpList[{$list_id}] not found"]);
        }
    }

    public function show(Request $request, $list_id, $member_id): JsonResponse
    {
        try {
            $this->mailChimp->get("/lists/{$list_id}/members/{$member_id}");
        }
        catch (\Exception $e) {
            return $this->errorResponse(['message' => "MailChimpList[{$list_id}] not found"]);
        }
    }
}
