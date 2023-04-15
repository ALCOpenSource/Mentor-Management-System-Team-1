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

    return $str->$methodname($args);
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
