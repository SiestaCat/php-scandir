<?php

namespace Siestacat\PhpScandir;

function scanrdir(string $dir, callable $callback)
{
    foreach(scandir($dir) as $filename)
    {

        if(in_array($filename, ['.', '..'])) continue;

        $file_path = joinpath($dir, $filename);

        $realpath = realpath($file_path);

        if($realpath === false) continue;

        if(is_dir($realpath)) scanrdir($realpath, $callback);

        if(is_file($realpath))
        {
            if($callback($realpath) === false) break;
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