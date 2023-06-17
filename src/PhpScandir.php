<?php

namespace Siestacat\PhpScandir;

class PhpScandir
{

    const STOP_SIGNAL = 1;

    private static bool $stop = false;

    public static function scan(string $dir, callable $callback):void
    {

        if(self::$stop) return;

        foreach(scandir($dir) as $filename)
        {

            if(in_array($filename, ['.', '..'])) continue;

            $file_path = joinpath($dir, $filename);

            $realpath = realpath($file_path);

            if($realpath === false) continue;

            if(is_file($realpath) && $callback($realpath, $filename) === self::STOP_SIGNAL)
            {
                self::$stop = true;
                break;
            }

            if(is_dir($realpath)) self::scan($realpath, $callback);
        }
    }
}

/**
 * Usage: joinpath('/home/jhon', 'pictures', 'beatch.jpg');
 * Returns: /home/jhon/pictures/beatch.jpg
 * @return null|string 
 */
function joinpath() :?string
{
    $args = array_map('strval', func_get_args());
    
    return
    (count($args) > 0 && strlen(strval($args[0])) > 1 && in_array(substr(strval($args[0]),0,1), ['\\', '/']) ? substr($args[0], 0, 1) : null) . //if the first chr of first arg contains \ or /
    implode(DIRECTORY_SEPARATOR, array_map(function($v) {
        return trim($v, '/\\');
    }, $args));
}