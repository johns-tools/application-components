<?php

namespace JohnsTools\EventLogger\Services;

// Framework
use Exception;

class SystemCheckService
{
    public static function checkFileMeta(Array $fileMeta) : void
    {
        if(!isset($fileMeta['file_name']) or !isset($fileMeta['file_extension']))
        {
            throw new Exception("Missing required data from fileMeta.");
        }
    }

    public static function checkIdentifier(String $identifier) : void
    {
        if(!$identifier)
        {
            throw new Exception("Missing required parameter `identifier`.");
        }
    }
}
