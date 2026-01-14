<?php

namespace App\Enums\Sms;

enum SmsTemplateEnum: string
{
    case NEW_QUOTE = 'new_quote';
    case NEW_MESSAGE = 'new_message';
    case PROFILE_PUBLISHED = 'profile_published';
    case PROFILE_INACTIVE = 'profile_inactive';
    case PROFILE_VIEWS_THRESHOLD = 'profile_views_threshold';
    case WEEKLY_SUMMARY = 'weekly_summary';

    public function message(): string
    {
        return match ($this) {
            self::NEW_QUOTE => 'You received a new quote',
            self::NEW_MESSAGE => 'You received a new message',
            self::PROFILE_PUBLISHED => 'Your profile was published',
            self::PROFILE_INACTIVE => 'Your contractor page is now inactive',
            self::PROFILE_VIEWS_THRESHOLD => 'Great! Your profile has been viewed {views_count} times this week!',
            self::WEEKLY_SUMMARY => 'Your weekly summary: search appearances: {search_appearances}, profile views: {profile_views}.',
        };
    }

    public function keys(): string
    {
        return match ($this) {
            self::NEW_QUOTE,
            self::NEW_MESSAGE,
            self::PROFILE_PUBLISHED,
            self::PROFILE_INACTIVE => '',
            self::PROFILE_VIEWS_THRESHOLD => 'views_count',
            self::WEEKLY_SUMMARY => 'search_appearances, profile_views',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::NEW_QUOTE => 'New Quote',
            self::NEW_MESSAGE => 'New Message',
            self::PROFILE_PUBLISHED => 'Profile Published',
            self::PROFILE_INACTIVE => 'Profile Inactive',
            self::PROFILE_VIEWS_THRESHOLD => 'High Profile Views',
            self::WEEKLY_SUMMARY => 'Weekly Summary',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::NEW_QUOTE => 'Contractor received a quote',
            self::NEW_MESSAGE => 'Contractor received a message',
            self::PROFILE_PUBLISHED => "Contractor's profile was published",
            self::PROFILE_INACTIVE => "Contractor's profile become inactive",
            self::PROFILE_VIEWS_THRESHOLD => 'Contractor profile has been viewed 5+ times in last 7 days',
            self::WEEKLY_SUMMARY => 'Weekly summary of search appearances and profile views',
        };
    }
}
