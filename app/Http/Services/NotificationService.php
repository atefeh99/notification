<?php

namespace App\Http\Services;

use App\Models\Notification;
use Carbon\Carbon;
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
        $success_time = Carbon::now();
        $mqtt = new Publisher($metadata, null, $success_time, $user_id, 'notification', null, $host, $username, $password, $port);
        return $mqtt->send();


    }

    public static function createItem($data)
    {
        $topic = explode('/', $data['topic']);
        $data['user_id'] = $topic[0];
        try {
            return Notification::createItem($data);
        } catch (\Exception $e) {
           Log::error($e->getMessage());
        }

    }

    public static function show($id)
    {
        return Notification::show($id);
    }

    public static function index($take, $skip, $user_id)
    {
        $query = Notification::index($take, $skip, $user_id);
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
