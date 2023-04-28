<?php

// Helper functions will be written here
// Path: app\Helpers\Helper.php

use Illuminate\Support\Str;

/**
 * Call a string helper method.
 *
 * @param mixed ...$args
 *
 * @return mixed
 */
function strHelper(string $methodname, ...$args)
{
    $str = new Str();

    return $str->$methodname(...$args);
}

/**
 * Call a static method of a class.
 *
 * @param mixed $args
 *
 * @return mixed
 */
function callStatic(string $className, string $methodname, ...$args)
{
    $class = new $className();

    return $class->__callStatic($methodname, $args);
}

/**
 * Call a method of a class.
 *
 * @param mixed $args
 *
 * @return mixed
 */
function callStaticMethod(object $class, string $methodname, ...$args)
{
    return $class->__callStatic($methodname, $args);
}

/**
 * Add new user session.
 *
 * @param mixed $user
 * @param mixed $request
 */
function addUserSession($request)
{
    $user = $request->user();

    if (! $user->currentAccessToken() || ! $user->currentAccessToken()->token) {
        return;
    }

    $token = hash('md5', $user->currentAccessToken()->token);
    $session = $user->userSessions()->where('id', $token)->first();

    if (! $session) {
        $session = $user->userSessions()->create([
            'id' => $token,
            'last_activity' => now(),
        ]);
    }

    $session->update([
        'ip_address' => $request->ip(),
        'user_agent' => $request->userAgent(),
        'last_activity' => now(),
        'payload' => [
            'user_id' => $user->id,
            'scopes' => $user->currentAccessToken()->scopes,

            // Other tracking data
            'language' => $request->header('Accept-Language'),
            'country' => $request->header('CF-IPCountry'),
        ],
    ]);
}

/**
 * Find links and replace them with anchor tags.
 */
function linkify(string $text): string
{
    return preg_replace('/(https?:\/\/[^\s]+)/', '<a href="$1" target="_blank">$1</a>', $text);
}

/**
 * Get the user avatar.
 *
 * @param mixed $str
 */
function getUIAvatarBackgroundAndColor($str)
{
    $colors = [
        '#f44336',
        '#e91e63',
        '#9c27b0',
        '#673ab7',
        '#3f51b5',
        '#2196f3',
        '#03a9f4',
        '#00bcd4',
        '#009688',
        '#4caf50',
        '#8bc34a',
        '#cddc39',
        '#ffeb3b',
        '#ffc107',
        '#ff9800',
        '#ff5722',
        '#795548',
        '#9e9e9e',
        '#607d8b',
    ];

    $background = $colors[hexdec(substr(md5($str), 0, 1)) % count($colors)];
    $color = '#fff';

    return [
        'background' => $background,
        'color' => $color,
    ];
}

/**
 * Sluginize a string.
 */
function slugify(string $str): string
{
    return strHelper('slug', $str);
}
