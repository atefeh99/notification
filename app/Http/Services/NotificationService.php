<?php

namespace App\Http\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use MqttNotification\Publisher;


class NotificationService
{
    public static function publish($metadata, $user_id)
    {
        $host = env('MQTT_HOST');
        $port = env('MQTT_PORT');
        $username = env('MQTT_USERNAME');
        $password = env('MQTT_PASSWORD');
        $mqtt = new Publisher($metadata, null, null, $user_id, 'notification', null/*msg_type*/, $host, $username, $password, $port);
        return $mqtt->send();


    }

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
        $query = Notification::index($take, $skip);
        $data = $query['data'];
        if (count($data) > 0) return $query;
        return [];


    }

    public static function updateItem($data, $id)
    {
        return Notification::updateItem($data, $id);
    }

    public static function removeItem($id)
    {
        return Notification::removeItem($id);
    }


}
