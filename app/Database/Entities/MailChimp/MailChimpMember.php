<?php
declare(strict_types=1);

namespace App\Database\Entities\MailChimp;

use Doctrine\ORM\Mapping as ORM;
use EoneoPay\Utils\Str;

/**
 * @ORM\Entity()
 */
class MailChimpMember extends MailChimpEntity
{
    /**
     * @ORM\Id()
     * @ORM\Column(name="id", type="guid")
     *
     * @var string
     *
     * This field is set by MailChimp.
     */
    private $id;

    /**
     * @var
     */
    private $listId; // connect to list

    /**
     * @ORM\Column(name="email_address", type="string", nullable=false)
     *
     * @var string Email address of member.
     */
    private $emailAddress;

    /**
     * @ORM\Column(name="unique_email_id", type="string", nullable=true)
     *
     * @var string MailChimp common email ID.
     *
     * This field is set by MailChimp.
     */
    private $uniqueEmailId;

    /**
     * @ORM\Column(name="email_type", type="string", nullable=false)
     *
     * @var string Email type. Must be one of:
     *  'html' or 'text'.
     */
    private $emailType;

    /**
     * @ORM\Column(name="status", type="string", nullable=false)
     *
     * @var string Status of this subscriber. Must be one of:
     * 'subscribed', 'unsubscribed', 'cleaned', 'pending', or 'transactional'.
     */
    private $status;

    /**
     * @ORM\Column(name="status_if_new", type="string", nullable=true)
     *
     * @var string
     */
    private $statusIfNew;

    /**
     * @ORM\Column(name="merge_fields", type="array")
     *
     * @var array
     */
    private $mergeFields;

    /**
     * @ORM\Column(name="interests", type="array")
     *
     * @var array Subscriber interests. Key is MailChimp ID.
     */
    private $interests;

    /**
     * @ORM\Column(name="stats", type="array")
     *
     * @var array Open and click rates for this subscriber.
     *
     * Should not be updated from client, only from MailChimp.
     */
    private $stats;

    /**
     * @ORM\Column(name="ip_signup", type="string", nullable=true)
     *
     * @var string IP Address of client.
     */
    private $ipSignup;

    /**
     * @ORM\Column(name="ip_opt", type="string", nullable=true)
     *
     * @var string The IP address the subscriber used to confirm their opt-in status.
     */
    private $ipOpt;

    /**
     * @ORM\Column(name="timestamp_opt", type="string", nullable=true)
     *
     * @var string The date and time the subscribe confirmed their opt-in status.
     *
     * Timestamp must be in ISO 8601 format. (YYYY-MM-DD hh:mm:ss)
     */
    private $timeStampOpt;

    /**
     * @ORM\Column(name="member_rating", type="integer", nullable=true)
     *
     * @var string Star rating for this member, between 1 and 5.
     *
     * This field is set by MailChimp.
     */
    private $memberRating;

    /**
     * @ORM\Column(name="language", type="string", nullable=true)
     *
     * @var string If set/detected, the subscriber’s language.
     */
    private $language; // str

    /**
     * @ORM\Column(name="vip", type="boolean", nullable=true)
     *
     * @var string If set/detected, the subscriber’s language.
     */
    private $vip; // bool

    /**
     * @ORM\Column(name="email_client", type="string", nullable=true)
     *
     * @var string The list member’s email client.
     *
     * This field is set by MailChimp.
     */
    private $emailClient;

    /**
     * @ORM\Column(name="location", type="array")
     *
     * @var array Subscriber location information.
     */
    private $location;

    public function getValidationRules(): array
    {
        // TODO: Implement getValidationRules() method.
    }

    /**
     * Get array representation of entity.
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = [];
        $str = new Str();

        foreach (\get_object_vars($this) as $property => $value) {
            $array[$str->snake($property)] = $value;
        }

        return $array;
    }
}
