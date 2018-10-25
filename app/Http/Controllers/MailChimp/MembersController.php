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
        if (($error = $this->validateMember($member)) instanceof JsonResponse) {
            return $error;
        }

        try {
            $this->mailChimp->post("/lists/{$list_id}/members",
                $member->toMailChimpArray());
        }
        catch (\Exception $e) {
            return $this->errorResponse(['message' => "MailChimpList[{$list_id}] not found"]);
        }
        return $this->successfulResponse($member->toArray());
    }

    public function remove(Request $request, $list_id, $member_id): JsonResponse
    {
        try {
            $this->mailChimp->delete("/lists/{$list_id}/members/{$member_id}");
        }
        catch (\Exception $e) {
            return $this->errorResponse(['message' => "MailChimpList[{$list_id}] not found"]);
        }
        return $this->successfulResponse([]);
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

    public function show(Request $request, $listId, $memberId): JsonResponse
    {
        $list = $this->entityManager->getRepository(MailChimpMember::class)->find($listId);

        if ($list === null) {
            $response = $this->getMemberFromMailChimp($listId, $memberId);
            if ($response instanceof JsonResponse)
            {
                return $response;
            }
            else {
                $list = $response;
                $this->saveEntity($list);
            }
        }

        return $this->successfulResponse($list->toArray());
    }

    /**
     * Retrieve a list from MailChimp and validate it.
     *
     * @param string $memberId
     *   MailChimp list_id property.
     *
     * @return MailChimpList|JsonResponse
     *  ]
     */
    private function getMemberFromMailChimp(string $listId, string $memberId)
    {
        try {
            $results = $this->mailChimp->get("/lists/{$listId}/members/{$memberId}");
        }
        catch (\Exception $e) {
            return $this->getNotFoundError($memberId);
        }

        $data = $results->toArray();
        $data['merge_fields'] = (array) $data['merge_fields'];
        $data['stats'] = (array) $data['stats'];
        $data['location'] = (array) $data['location'];
        $member = new MailChimpMember($data);

        if (($error = $this->validateMember($member)) instanceof JsonResponse) {
            return $error;
        }

        return $member;
    }

    /**
     * Validate the list, returns JSON message error if invalid.
     *
     * @param $member
     *
     * @return \Illuminate\Http\JsonResponse|null
     */
    private function validateMember(MailChimpMember $member)
    {
        $validator = $this->getValidationFactory()
            ->make($member->toMailChimpArray(), $member->getValidationRules());
        if ($validator->fails()) {
            // Return error response if validation failed
            return $this->errorResponse(
                [
                    'message' => 'Invalid data given',
                    'errors'  => $validator->errors()->toArray()
                ]);
        } else {
            return null;
        }
    }
}
