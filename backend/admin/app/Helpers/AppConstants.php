<?php

// Path: app\Helpers\Constants.php
// Contains the constants used in the application

namespace App\Helpers;

class AppConstants
{
    public const API_VERSION = 'v1';
    public const API_PREFIX = 'api';
    public const API_MIDDLEWARE = 'auth:sanctum';

    public const ROLE_ADMIN = 'admin';

    // Socialite Providers
    public const SOCIAL_PROVIDERS = ['google'];
    public const PROVIDER_GOOGLE = 'google';
    public const PROVIDER_FACEBOOK = 'facebook';
    public const PROVIDER_TWITTER = 'twitter';
    public const PROVIDER_GITHUB = 'github';
}
