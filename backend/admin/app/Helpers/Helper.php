<?php

// Helper functions will be written here
// Path: app\Helpers\Helper.php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Exception\NotSupportedException;
use Intervention\Image\Exception\NotWritableException;
use Intervention\Image\Facades\Image;

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
            'last_activity' => now()->format('Y-m-d H:i:s'),
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
 * Linkify urls.
 */
function linkifyUrl(string $text): string
{
    // URLs starting with http://, https://, or ftp://
    $matches = [];

    $pattern = '/(https?:\/\/[^\s]+)/';
    preg_match_all($pattern, $text, $matches);

    foreach ($matches[0] as $match) {
        $text = str_replace($match, '<a href="'.$match.'" target="_blank">'.$match.'</a>', $text);
    }

    return $text;
}

/**
 * Linkify emails.
 */
function linkifyEmail(string $text): string
{
    // Change email addresses to mailto:: links
    $matches = [];

    $pattern = '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/';
    preg_match_all($pattern, $text, $matches);

    foreach ($matches[0] as $match) {
        $text = str_replace($match, '<a href="mailto:'.$match.'" target="_blank">'.$match.'</a>', $text);
    }

    return $text;
}

/**
 * URLs starting with "www." (without // before it, or it'd re-link the ones done above).
 */
function linkifyWww(string $text): string
{
    $matches = [];

    $pattern = '/(^|[^\/])(www\.[\S]+(\b|$))/';
    preg_match_all($pattern, $text, $matches);

    foreach ($matches[0] as $match) {
        $text = str_replace($match, '<a href="http://'.$match.'" target="_blank">'.$match.'</a>', $text);
    }

    return $text;
}

/**
 * Remove all html tags from a string.
 */
function stripHtml(string $text): string
{
    return strip_tags($text);
}

/**
 * Remove all html tags and links from a string.
 */
function stripHtmlAndLinks(string $text): string
{
    $text = stripHtml($text);

    // Remove all links i.e. http://, https://, ftp://, mailto:, www.
    $text = preg_replace('/(https?:\/\/[^\s]+)/', '', $text);
    $text = preg_replace('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/', '', $text);
    $text = preg_replace('/(^|[^\/])(www\.[\S]+(\b|$))/', '', $text);

    return $text;
}

/**
 * Find links and replace them with anchor tags.
 */
function linkify(string $text): string
{
    $text = stripHtml($text);
    $text = linkifyUrl($text);
    $text = linkifyEmail($text);
    $text = linkifyWww($text);

    return $text;
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

/**
 * Get file type given mime type.
 * Either image, video, audio, or file, or doc, or unknown.
 */
function getFileType(string $mimeType): string
{
    // Pregematch for image, video, audio, or file
    preg_match('/(image|video|audio|file|doc)/', strtolower($mimeType), $matches);

    if (count($matches) > 0) {
        return $matches[0];
    }

    return 'unknown';
}

function runMySqlQueryInNonStrictMode(callable $callable)
{
    $strictMode = config('database.connections.mysql.strict');

    config(['database.connections.mysql.strict' => false]);
    callStatic(DB::class, 'reconnect');

    // Run the query
    $result = $callable();

    config(['database.connections.mysql.strict' => $strictMode]);
    callStatic(DB::class, 'reconnect');

    return $result;
}

/**
 * Get room id given user ids.
 *
 * @param mixed $user_id1
 * @param mixed $user_id2
 */
function getRoomIdFromUserIds($user_id1, $user_id2): string
{
    // If two ids are same, return empty string
    if ($user_id1 == $user_id2) {
        return '';
    }

    return md5(
        sprintf(
            '%s-%s',
            min([$user_id1, $user_id2]),
            max([$user_id1, $user_id2])
        )
    );
}

/**
 * Check if a string contains @ mentions.
 */
function containsMentions(string $str, User $user): bool
{
    $str = strtolower($str);
    $user_email = strtolower($user->email);
    $user_name = strtolower($user->name);

    // Can be @here, @everyone, or @name, or @email
    $pattern = '/(^|\s)(@here|@everyone|@'.$user_name.'|@'.$user_email.')(\s|$)/';

    return preg_match($pattern, $str);
}

/**
 * Generate certificates.
 */
function generateCertificate(string $name)
{
    try {
        $sampleCertPath = public_path('certs/cert.jpg');

        if (! File::exists($sampleCertPath)) {
            // Sample certificate image does not exist.
            return false;
        }

        $image = Image::make($sampleCertPath);

        $imageName = $name.'-cert';
        $destinationPath = public_path('certs/');

        if (! File::isDirectory($destinationPath)) {
            // Create the destination directory if it doesn't exist.
            File::makeDirectory($destinationPath, 0o755, true);
        }

        $fontPath = public_path('fonts/2.ttf');
        if (! File::exists($fontPath)) {
            // Font file does not exist.
            return false;
        }

        $image->text($name, 500, 320, function ($font) use ($fontPath) {
            $font->file($fontPath);
            $font->size(40);
            $font->color('#001a1a');
            $font->align('center');
            $font->valign('bottom');
        });

        $imagePath = $destinationPath.$imageName.'.png';
        $image->save($imagePath);

        return $imagePath;
    } catch (NotSupportedException|NotWritableException $e) {
        // Unable to generate or save the certificate.
        return false;
    }
}
