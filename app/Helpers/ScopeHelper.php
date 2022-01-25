<?php


namespace App\Helpers;


class ScopeHelper
{
    const DELIMITER = ' ';
    const ADMIN_KEY = 'admin';

    public static function isAdmin($scopes)
    {
        if (ScopeHelper::inScope($scopes, self::ADMIN_KEY)) {
            return true;
        }

        return false;
    }

    public static function inScope($scopes, $needle)
    {
        if (is_string($scopes)) {
            $scopes = explode(self::DELIMITER, $scopes);
            if (in_array($needle, $scopes)) {
                return true;
            }
        } elseif (is_array($scopes)) {
            if (in_array($needle, $scopes)) {
                return true;
            }
        }

        return false;
    }
}
