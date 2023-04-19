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
