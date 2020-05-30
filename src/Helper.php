<?php

namespace Hector\V2bAdapter;

class Helper
{
    protected static function getKey()
    {
        return 'RocketMaker';
    }

    public static function rc4($pt, $key = null)
    {
        if (!$key) {
            $key = self::getKey();
        }
        $s = array();
        for ($i = 0; $i < 256; $i++) {
            $s[$i] = $i;
        }

        $j = 0;
        $key_len = strlen($key);
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $s[$i] + ord($key[$i % $key_len])) % 256;
            //swap
            $x = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $x;
        }
        $i = 0;
        $j = 0;
        $ct = '';
        $data_len = strlen($pt);
        for ($y = 0; $y < $data_len; $y++) {
            $i = ($i + 1) % 256;
            $j = ($j + $s[$i]) % 256;
            //swap
            $x = $s[$i];
            $s[$i] = $s[$j];
            $s[$j] = $x;
            $temp = $pt[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
            $ct .= $temp;
        }
        return $ct;
    }

    public static function normalResp($info, $data = null)
    {
        return base64_encode(static::rc4(json_encode(
            [
                'code' => 200,
                'info' => $info,
                'data' => $data,
            ]
        )));
    }

    public static function errorResp($code, $info)
    {
        return base64_encode(Helper::rc4(json_encode(
            [
                'code' => $code,
                'info' => $info,
            ]
        )));
    }

    public static function unAuth()
    {
        return static::errorResp(401, '请先登录');
    }

    public static function forbid()
    {
        return static::errorResp(403, '您的账户已被禁用');
    }

    public static function badResp($msg)
    {
        return static::errorResp(400, $msg);
    }
}
