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
     * @ORM\Column(name="timestamp_signup", type="string", nullable=true)
     *
     * @var string IP Address of client.
     */
    private $timestampSignup;

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
    private $timestampOpt;

    /**
     * @ORM\Column(name="member_rating", type="integer", nullable=true)
     *
     * @var int Star rating for this member, between 1 and 5.
     *
     * This field is set by MailChimp.
     */
    private $memberRating;

    /**
     * @ORM\Column(name="last_changed", type="string", nullable=true)
     *
     * @var string Star rating for this member, between 1 and 5.
     *
     * This field is set by MailChimp.
     */
    private $lastChanged;


    /**
     * @ORM\Column(name="language", type="string", nullable=true)
     *
     * @var string If set/detected, the subscriber’s language.
     */
    private $language;

    /**
     * @ORM\Column(name="vip", type="boolean", nullable=true)
     *
     * @var boolean If set/detected, the subscriber’s language.
     */
    private $vip;

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

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return MailChimpMember
     */
    protected function setId(string $id): MailChimpMember
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * @param mixed $listId
     *
     * @return MailChimpMember
     */
    public function setListId($listId)
    {
        $this->listId = $listId;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     *
     * @return MailChimpMember
     */
    public function setEmailAddress(string $emailAddress): MailChimpMember
    {
        $this->emailAddress = $emailAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getUniqueEmailId(): string
    {
        return $this->uniqueEmailId;
    }

    /**
     * @param string $uniqueEmailId
     *
     * @return MailChimpMember
     */
    protected function setUniqueEmailId(string $uniqueEmailId): MailChimpMember
    {
        $this->uniqueEmailId = $uniqueEmailId;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailType(): string
    {
        return $this->emailType;
    }

    /**
     * @param string $emailType
     *
     * @return MailChimpMember
     */
    public function setEmailType(string $emailType): MailChimpMember
    {
        $this->emailType = $emailType;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     *
     * @return MailChimpMember
     */
    protected function setStatus(string $status): MailChimpMember
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatusIfNew(): string
    {
        return $this->statusIfNew;
    }

    /**
     * @param string $statusIfNew
     *
     * @return MailChimpMember
     */
    public function setStatusIfNew(string $statusIfNew): MailChimpMember
    {
        $this->statusIfNew = $statusIfNew;
        return $this;
    }

    /**
     * @return array
     */
    public function getMergeFields(): array
    {
        return $this->mergeFields;
    }

    /**
     * @param array $mergeFields
     *
     * @return MailChimpMember
     */
    public function setMergeFields(array $mergeFields): MailChimpMember
    {
        $this->mergeFields = $mergeFields;
        return $this;
    }

    /**
     * @return array
     */
    public function getInterests(): array
    {
        return $this->interests;
    }

    /**
     * @param array $interests
     *
     * @return MailChimpMember
     */
    public function setInterests(array $interests): MailChimpMember
    {
        $this->interests = $interests;
        return $this;
    }

    /**
     * @return array
     */
    public function getStats(): array
    {
        return $this->stats;
    }

    /**
     * @param array $stats
     *
     * @return MailChimpMember
     */
    public function setStats(array $stats): MailChimpMember
    {
        $this->stats = $stats;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpSignup(): string
    {
        return $this->ipSignup;
    }

    /**
     * @param string $ipSignup
     *
     * @return MailChimpMember
     */
    protected function setIpSignup(string $ipSignup): MailChimpMember
    {
        $this->ipSignup = $ipSignup;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimestampSignup(): string
    {
        return $this->timestampSignup;
    }

    /**
     * @param string $timestampSignup
     *
     * @return MailChimpMember
     */
    public function setTimestampSignup(string $timestampSignup): MailChimpMember
    {
        $this->timestampSignup = $timestampSignup;
        return $this;
    }

    /**
     * @return string
     */
    public function getIpOpt(): string
    {
        return $this->ipOpt;
    }

    /**
     * @param string $ipOpt
     *
     * @return MailChimpMember
     */
    protected function setIpOpt(string $ipOpt): MailChimpMember
    {
        $this->ipOpt = $ipOpt;
        return $this;
    }

    /**
     * @return string
     */
    public function getTimestampOpt(): string
    {
        return $this->timestampOpt;
    }

    /**
     * @param string $timestampOpt
     *
     * @return MailChimpMember
     */
    protected function setTimestampOpt(string $timestampOpt): MailChimpMember
    {
        $this->timestampOpt = $timestampOpt;
        return $this;
    }

    /**
     * @return int
     */
    public function getMemberRating(): int
    {
        return $this->memberRating;
    }

    /**
     * @param stintring $memberRating
     *
     * @return MailChimpMember
     */
    protected function setMemberRating(int $memberRating): MailChimpMember
    {
        $this->memberRating = $memberRating;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastChanged(): string
    {
        return $this->lastChanged;
    }

    /**
     * @param string $lastChanged
     *
     * @return MailChimpMember
     */
    protected function setLastChanged(string $lastChanged): MailChimpMember
    {
        $this->lastChanged = $lastChanged;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return MailChimpMember
     */
    public function setLanguage(string $language): MailChimpMember
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return bool
     */
    public function getVip():? bool
    {
        return $this->vip;
    }

    /**
     * @param bool $vip
     *
     * @return MailChimpMember
     */
    public function setVip(bool $vip = null): MailChimpMember
    {
        $this->vip = $vip;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailClient(): string
    {
        return $this->emailClient;
    }

    /**
     * @param string $emailClient
     *
     * @return MailChimpMember
     */
    protected function setEmailClient(string $emailClient): MailChimpMember
    {
        $this->emailClient = $emailClient;
        return $this;
    }

    /**
     * @return array
     */
    public function getLocation(): array
    {
        return $this->location;
    }

    /**
     * @param array $location
     *
     * @return MailChimpMember
     */
    public function setLocation(array $location): MailChimpMember
    {
        $this->location = $location;
        return $this;
    }

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
