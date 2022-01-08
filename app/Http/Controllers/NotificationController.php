<?php

namespace App\Http\Controllers;

use App\Exceptions\UnauthorizedUserException;
use App\Helpers\ScopeHelper;
use Illuminate\Http\Request;
use App\Http\Services\NotificationService;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class NotificationController extends ApiController
{
    use RulesTrait;
    public function publish(Request $request)
    {
        $user_id = $request->header('x-user-id');
        if (!isset($user_id)) {
            throw new UnauthorizedUserException(trans('messages.custom.unauthorized_user'), 1999);
        }
        $scopes = $request->header('x-scopes');
        if(!ScopeHelper::isAdmin($scopes)){
            throw new AccessDeniedHttpException();
        }
        $notification  = NotificationService::publish($request->all()['metadata'],$user_id);
        return $this->respondSuccessCreate($notification);


    }

    public function createItem(Request $request)
    {
        $user_id = $request->header('x-user-id');
        if (!isset($user_id)) {
            throw new UnauthorizedUserException(trans('messages.custom.unauthorized_user'), 2000);
        }
        $scopes = $request->header('x-scopes');
        if(!ScopeHelper::isAdmin($scopes)){
            throw new AccessDeniedHttpException();
        }
        $data = self::checkRules($request, __FUNCTION__, 1000);
        $notification = NotificationService::createItem($data);
        return $this->respondSuccessCreate($notification);
    }


    public function show(Request $request, $id)
    {
        $user_id = $request->header('x-user-id');
        if (!isset($user_id)) {
            throw new UnauthorizedUserException(trans('messages.custom.unauthorized_user'), 2001);
        }
        $id = self::checkRules(
            array_merge($request->all(), array('id' => $id)),
            __FUNCTION__,
            1001
        );
        $notification = NotificationService::show($id);
        return $this->respondItemResult($notification);

    }

    public function index(Request $request)
    {
        $user_id = $request->header('x-user-id');
        if (!isset($user_id)) {
            throw new UnauthorizedUserException(trans('messages.custom.unauthorized_user'), 2002);
        }
        $data = self::checkRules(
            array_merge($request->all()),
            __FUNCTION__,
            1002
        );
        $take = $data['$top'] ?? env('TAKE');
        $skip = $data['$skip'] ?? env('SKIP');

        $notifications = NotificationService::index($take, $skip);
        return $this->respondArrayResult($notifications);
    }

    public function updateItem(Request $request, $id)
    {
        $user_id = $request->header('x-user-id');
        if (!isset($user_id)) {
            throw new UnauthorizedUserException(trans('messages.custom.unauthorized_user'), 2003);
        }
        $data = self::checkRules(
            array_merge($request->all(), array('id' => $id)),
            __FUNCTION__,
            1003
        );
        $notification = NotificationService::updateItem($data, $id);
        return $this->respondItemResult($notification);
    }

    public function removeItem(Request $request, $id)
    {
        $user_id = $request->header('x-user-id');
        if (!isset($user_id)) {
            throw new UnauthorizedUserException(trans('messages.custom.unauthorized_user'), 2004);
        }
        $id = self::checkRules(
            array_merge($request->all(), array('id' => $id)),
            __FUNCTION__,
            1004
        );
        NotificationService::removeItem($id);
        return $this->respondSuccessDelete($id);
    }
}

