<?php

namespace Database\Seeders;

use App\Enums\Sms\SmsTemplateEnum;
use App\Models\SmsTemplate;
use Illuminate\Database\Seeder;

class SmsTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (SmsTemplateEnum::cases() as $template) {
            SmsTemplate::query()
                ->updateOrCreate(
                    ['key' => $template->value],
                    [
                        'keys' => $template->keys(),
                        'label' => $template->label(),
                        'message' => $template->message(),
                        'description' => $template->description(),
                    ]
                );
        }
    }
}
