<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class TwilioService
{
    private Client $client;

    private string $fromPhone;

    public function __construct()
    {
        $accountSid = config('services.twilio.account_sid');
        $authToken = config('services.twilio.auth_token');
        $this->fromPhone = config('services.twilio.sms_from');

        if (! $accountSid || ! $authToken || ! $this->fromPhone) {
            throw new \InvalidArgumentException('Twilio credentials are not configured. Please check TWILIO_ACCOUNT_SID, TWILIO_AUTH_TOKEN, and TWILIO_SMS_FROM environment variables.');
        }

        $this->client = new Client($accountSid, $authToken);
    }

    /**
     * Send SMS message
     *
     * @param  string  $toPhone  Phone number to send to (must include country code, e.g., +1234567890)
     * @param  string  $message  Message text
     * @return \Twilio\Rest\Api\V2010\AccountContext\MessageInstance
     *
     * @throws TwilioException
     */
    public function send(string $toPhone, string $message)
    {
        try {
            $response = $this->client->messages->create(
                $toPhone,
                [
                    'from' => $this->fromPhone,
                    'body' => $message,
                ]
            );

            Log::info('SMS sent successfully', [
                'to' => $toPhone,
                'sid' => $response->sid,
                'status' => $response->status,
            ]);

            return $response;
        } catch (TwilioException $e) {
            Log::error('Failed to send SMS', [
                'to' => $toPhone,
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            throw $e;
        }
    }

    /**
     * Check message status by SID
     *
     * @return \Twilio\Rest\Api\V2010\AccountContext\MessageInstance
     */
    public function getMessageStatus(string $messageSid)
    {
        try {
            return $this->client->messages($messageSid)->fetch();
        } catch (TwilioException $e) {
            Log::error('Failed to fetch message status', [
                'sid' => $messageSid,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
