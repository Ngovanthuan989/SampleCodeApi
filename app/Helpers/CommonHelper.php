<?php


namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Integer;

class CommonHelper
{

    public static function checkSpecialCharacter($text, $excepts = [])
    {
        $pattern = '/[-_<>+=~!@#$%^&*().,?":{}|\[\]<>\`"\'\/]/';
        if (!empty($excepts) && is_array($excepts)) {
            foreach ($excepts as $key => $except) {
                if ($except == '[') {
                    $except = "\[";
                } else if ($except == ']') {
                    $except = "\]";
                } else if ($except == '`') {
                    $except = "\`";
                } else if ($except == '/') {
                    $except = "\/";
                }
                $pattern = str_replace($except, '', $pattern);
            }
        }
        return preg_match($pattern, $text);
    }


    public static function checkLength($text, $length)
    {
        return (strlen($text) <= $length);
    }


    public static function checkIsDigit($text)
    {
        return preg_match('/^\d+$/', $text);
    }

    /* Generate unique string */
    public static function gennerateUniqueString($prefix = 'BK', $length = 2)
    {
        $string = strtoupper(uniqid($prefix));

        return $string . CommonHelper::generateRandomString($length);
    }

    /* Random character */
    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    /*Convert VI to EN*/
    public static function utf8Convert($str)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", "a", $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", "e", $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", "i", $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", "o", $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", "u", $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", "y", $str);
        $str = preg_replace("/(đ)/", "d", $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", "A", $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", "E", $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", "I", $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", "O", $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", "U", $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", "Y", $str);
        $str = preg_replace("/(Đ)/", "D", $str);
        //$str = str_replace(" ", "-", str_replace("&*#39;","",$str));
        $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        return $str;
    }


    public static function reMoveSpecialChars($string, $excepts = [])
    {
        $pattern = '/[-_<>+=~!@#$%^&*().,?":{}|\[\]<>\`"\'\/]/';
        if (!empty($excepts) && is_array($excepts)) {
            foreach ($excepts as $key => $except) {
                if ($except == '[') {
                    $except = "\[";
                } else if ($except == ']') {
                    $except = "\]";
                } else if ($except == '`') {
                    $except = "\`";
                }
                $pattern = str_replace($except, '', $pattern);
            }
        }
        return preg_replace($pattern, '', $string);
    }


    public static function hasDigit($str)
    {
        return preg_match('/[0-9]/', $str);
    }

    public static function hasSpace($string)
    {
        if (strpos($string, ' ') !== false) {
            return true;
        }
        return false;
    }


    public static function hasVietnamese($string)
    {
        if (preg_match("/[ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]/u", $string)) {
            return true;
        } else {
            return false;
        }
    }


    public static function generateNumber($length = 12) {
        $run = true;
        $min = intval(str_pad('10', $length - 1, '0', STR_PAD_RIGHT));
        $max = intval(str_pad('9', $length, '9', STR_PAD_RIGHT));
        $number = rand($min, $max);
        $number = str_pad($number, 6, 0, STR_PAD_LEFT);
        return $number;
    }
}
