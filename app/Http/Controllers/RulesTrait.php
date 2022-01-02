<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedUserException;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\RequestRulesException;
use App\Http\Controllers\Process\SynchronizationController;
use App\Http\Controllers\Task\TaskManagementController;
use App\Http\Controllers\Task\CommentController;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

trait RulesTrait
{


    public static function rules()
    {
        return [
            NotificationController::class => [
                'createItem' => [
                    "date" => "required|string",
                    "type" => "nullable|string",
                    "job_id" => "integer|required",
                    "metadata" => "array|required",
                    "topic" => "required|string"
                ],
                'show' => [
                    'id' => 'integer'
                ],
                'index' => [
                    '$top' => 'numeric',
                    '$skip' => 'numeric'
                ],
                'updateItem' => [
                    'id' => 'integer',
                    "date" => "string",
                    "type" => "nullable|string",
                    "job_id" => "integer",
                    "metadata" => "array",
                    "topic" => "string"
                ],
                'removeItem' => [
                    'id' => 'integer',
                ]


            ]
        ];
    }

    public static function checkRules($data, $function, $code)
    {
        $controller = __CLASS__;
        if (is_object($data)) {
            $validation = Validator::make(
                $data->all(),
                self::rules()[$controller][$function]
            );
        } else {
            $validation = Validator::make(
                $data,
                self::rules()[$controller][$function]
            );
        }

        if ($validation->fails()) {
//            dd($validation->errors()->getMessages());
            throw new RequestRulesException($validation->errors()->getMessages(), $code);
        }


        return $validation->validated();
    }
}
