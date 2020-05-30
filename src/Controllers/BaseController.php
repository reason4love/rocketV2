<?php

namespace Hector\V2bAdapter\Controllers;

use App\Models\Notice;
use App\Models\ServerGroup;
use App\Models\User;
use Carbon\Carbon;
use Hector\V2bAdapter\Helper;
use App\Utils\Helper as HHelper;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{

    public function login(Request $request)
    {
        $email = $request->input('username');
        $password = $request->input('password');
        $user = User::where('email', $email)->first();
        if (!$user) {
            return Helper::badResp('用户名或密码错误');
        }
        if (!HHelper::multiPasswordVerify(
            $user->password_algo,
            $password,
            $user->password)
        ) {
            return Helper::badResp('用户名或密码错误');
        }

        if ($user->banned) {
            return Helper::forbid();
        }
        $request->session()->put('email', $user->email);
        $request->session()->put('id', $user->id);
        return Helper::normalResp('登录成功', $this->getUserinfo($user));
    }

    protected function getUserinfo($user = null)
    {
        if (!$user) {
            $user = User::find(session('id'));
        }
        /**
         * @var $created_at Carbon
         */
        return [
            'username' => $user->email,
            'true_name' => $user->email,
            'traffic' => [
                'total' => $user->transfer_enable,
                'used' => $user->u + $user->d,
            ],
            'last_checkin' => '',
            'reg_date' => $user->created_at->format('Y-m-d H:i:s'),
            'balance' => $user->balance,
            'class' => $user->group_id,
            'class_expire' => date('Y-m-d H:i:s', $user->expired_at),
            'node_speedlimit' => '',
            'node_connector' => '',
            'pc_sub' => config('v2board.subscribe_url', config('v2board.app_url', env('APP_URL'))) . '/api/v1/client/subscribe?token=' . $user['token'],
            'android_sub' => '',
            'defaultProxy' => 'select'
        ];
    }

    public function userinfo()
    {
        return Helper::normalResp('获取成功', $this->getUserinfo());
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return Helper::normalResp('登出成功');
    }

    public function init()
    {
        return config('rocket.global.baseurl');
    }

    public function broadcast()
    {
        return Helper::normalResp('获取成功', [
            'title' => config('rocket.android.notice.title', ''),
            'content' => config('rocket.android.notice.content', ''),
            'broad_url' => config('rocket.android.notice.url', ''),
            'broad_show' => config('rocket.android.notice.show', false),

            'bootstrap_show' => config('rocket.android.bootstrap.show', false),
            'bootstrap_img' => config('rocket.android.bootstrap.image', ''),
            'bootstrap_url' => config('rocket.android.bootstrap.url', ''),

            'version_code' => config('rocket.android.update.version', 0),
            'description' => config('rocket.android.update.desc', ''),
            'download' => config('rocket.android.update.download', ''),
        ]);
    }

    public function pcAlert()
    {
        return Helper::normalResp('获取成功', config('rocket.common.notice'));
    }

    public function pcUpdate()
    {
        $latest = config('rocket.common.update.version', 0);
        $curVersion = \request('curVersion', 1);
        $data = [
            'update' => $latest > $curVersion,
        ];
        if ($data['update']) {
            $data = array_merge($data, config('rocket.common.update', []));
        }
        return Helper::normalResp('获取成功', $data);
    }

    public function config()
    {
        $data = [];
        ServerGroup::all()->map(function ($value)use (&$data) {
            $data['l' . $value->id] = $value->name;
        });
        return array_merge(config('rocket.common.preference'),['levelDesc'=>$data]);
    }

    public function anno()
    {
        $data = Notice::orderBy('created_at', 'DESC')->get()->map(function ($item) {
            return [
                'date' => $item->created_at->format('Y-m-d H:i:s'),
                'markdown' => $item->content,
            ];
        })->toArray();
        return Helper::normalResp('获取成功', $data);
    }
}
