<?php

declare(strict_types=1);

namespace Masteritua\Verification;

use JsonException;
use Masteritua\Verification\Email\VerificationEmail;

class Verification
{
    private array $fields;

    private array $checkedFields = [];

    public function __construct()
    {
        $this->fields = $_REQUEST['fields'] ?? [];
    }

    /**
     * @throws JsonException
     */
    public function check(): string
    {
        $email = $this->fields['email'] ?? '';
        $verificationEmail = new VerificationEmail($email);
        $this->checkedFields['email'] = $verificationEmail->check();

        return $this->encodeToJson($this->checkedFields);
    }

    /**
     * @throws JsonException
     */
    private function encodeToJson(array $array) : string
    {
        return json_encode($array, JSON_THROW_ON_ERROR);
    }
}