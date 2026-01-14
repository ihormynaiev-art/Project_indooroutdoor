<?php

namespace App\Jobs;

use App\Models\SmsMessage;
use App\Models\SmsTemplate;
use App\Services\TwilioService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;
use Twilio\Exceptions\TwilioException;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Phone number to send to
     */
    private string $phone;

    /**
     * SMS template key (e.g., 'new_quote')
     */
    private string $templateKey;

    /**
     * Variables to substitute in template
     */
    private array $variables;

    /**
     * Source/provider of SMS request (e.g., 'order', 'provider', 'admin')
     */
    private string $source;

    /**
     * Provider ID to associate with SMS message
     */
    private ?int $providerId;

    /**
     * Create a new job instance.
     *
     * @param  string  $phone  Phone number with country code (e.g., +1234567890)
     * @param  string  $templateKey  Template key (e.g., 'new_quote')
     * @param  array  $variables  Variables to substitute in message
     * @param  string  $source  Source of SMS request
     * @param  int|null  $providerId  Provider ID to associate with SMS
     */
    public function __construct(
        string $phone,
        string $templateKey,
        array $variables = [],
        string $source = 'system',
        ?int $providerId = null
    ) {
        $this->phone = $this->formatPhone($phone);
        $this->templateKey = $templateKey;
        $this->variables = $variables;
        $this->source = $source;
        $this->providerId = $providerId;
    }

    /**
     * Execute the job.
     */
    public function handle(TwilioService $twilio): void
    {
        try {
            /** @var SmsTemplate $template */
            $template = SmsTemplate::query()
                ->where('key', $this->templateKey)
                ->first();

            if (! $template) {
                throw new Exception("SMS template not found: {$this->templateKey}");
            }

            if (! $template->is_enabled) {
                return;
            }

            // Prepare message text by substituting variables
            $message = $this->prepareMessage($template->message);

            // Send via Twilio
            $response = $twilio->send($this->phone, $message);

            // Log success
            SmsMessage::query()
                ->create([
                    'phone' => $this->phone,
                    'sms_template_id' => $template->id,
                    'provider_detail_id' => $this->providerId,
                    'message' => $message,
                    'status' => 'sent',
                    // 'external_message_id' => $response->sid,
                    'sent_at' => now(),
                ]);

            Log::channel('sms')->info('SMS sent successfully', [
                'phone' => $this->phone,
                'template_key' => $this->templateKey,
                'twilio_sid' => $response->sid,
                'source' => $this->source,
            ]);

        } catch (TwilioException $e) {
            $this->handleError($e->getMessage());
        } catch (Exception $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Handle failed job
     */
    public function failed(Throwable $exception): void
    {
        Log::channel('sms')->error('SendSmsJob failed', [
            'phone' => $this->phone,
            'template_key' => $this->templateKey,
            'source' => $this->source,
            'exception' => $exception->getMessage(),
        ]);
    }

    /**
     * Format phone number by adding + prefix if not present
     */
    private function formatPhone(string $phone): string
    {
        $phone = trim($phone);
        if (! str_starts_with($phone, '+')) {
            $phone = '+'.$phone;
        }

        return $phone;
    }

    /**
     * Prepare message by substituting variables
     * Variables format: {variable_name} in template
     */
    private function prepareMessage(string $template): string
    {
        $message = $template;

        foreach ($this->variables as $key => $value) {
            $message = str_replace("{{$key}}", (string) $value, $message);
        }

        return $message;
    }

    /**
     * Handle error and log it
     */
    private function handleError(string $errorMessage): void
    {
        try {
            $template = SmsTemplate::where('key', $this->templateKey)->first();
            $message = $this->prepareMessage($template?->message ?? '');

            SmsMessage::query()
                ->create([
                    'phone' => $this->phone,
                    'sms_template_id' => $template?->id,
                    'provider_detail_id' => $this->providerId,
                    'message' => $message,
                    'status' => 'failed',
                    'error_message' => $errorMessage,
                ]);

            Log::channel('sms')->error('SMS failed to send', [
                'phone' => $this->phone,
                'template_key' => $this->templateKey,
                'error' => $errorMessage,
                'source' => $this->source,
            ]);
        } catch (Exception $e) {
            Log::channel('sms')->error('Failed to log SMS error', [
                'phone' => $this->phone,
                'original_error' => $errorMessage,
                'logging_error' => $e->getMessage(),
            ]);
        }
    }
}
