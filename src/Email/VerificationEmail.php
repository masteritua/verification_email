<?php

declare(strict_types=1);

namespace Masteritua\Verification\Email;

class VerificationEmail
{

    private string $email;

    private const SUCCESS_ANSWER = 'Success';

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public function check(): string
    {
        try {

            if (empty($this->email)) {
                throw new \RuntimeException('Error: Email must not be empty');
            }

            if (!preg_match("/[0-9a-z]+@[a-z]/", $this->email)) {
                throw new \RuntimeException('Error: Invalid email format');
            }

            if (!$this->getMXRecord()) {
                throw new \RuntimeException('Error: Invalid MX record format');
            }

            return static::SUCCESS_ANSWER;
        } catch (\RuntimeException $e) {
            return $e->getMessage();
        }
    }

    private function getMXRecord()
    {
        dns_get_mx('otus.local', $mx_details);

        return $mx_details;
    }
}
