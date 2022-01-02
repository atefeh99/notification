<?php

namespace App\Http\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Log;


class NotificationService
{
    public static function createItem($data)
    {
        return Notification::createItem($data);

    }

    public static function show($id)
    {
        return Notification::show($id);
    }

    public static function index($take, $skip)
    {
        $data = Notification::index($take, $skip);
        $count = count($data);
        if ($count > 0) return $data;
        return [];


    }

    public static function updateItem($data,$id)
    {
        return Notification::updateItem($data,$id);
    }

    public static function removeItem($id)
    {
        return Notification::removeItem($id);
    }


}
