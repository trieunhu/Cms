<?php

namespace common\func;

class FunctionCommon
{
    public static function _substr($str, $length, $minword = 3)
    {
        $sub = '';
        $len = 0;
        foreach (explode(' ', $str) as $word) {
            $part = (($sub != '') ? ' ' : '') . $word;
            $sub .= $part;
            $len += strlen($part);
            if (strlen($word) > $minword && strlen($sub) >= $length) {
                break;
            }
        }
        return $sub . (($len < strlen($str)) ? '...' : '');
    }

    public static function createFolder($path)
    {
        $pathYear = $path . '/' . date('Y');
        if (!file_exists($pathYear)) {
            mkdir($pathYear, 0777, TRUE);
        }
        $pathYear .= '/' . date('m');
        if (!file_exists($pathYear)) {
            mkdir($pathYear, 0777, TRUE);
        }
        return $pathYear . '/';
    }

    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
     public static function random_code($length = 10)
    {

        $string = '';
        // You can define your own characters here.
        $characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }

    public static function getURLImage()
    {
        $title = date('Y') . '/' . date("m") . '/';
        return 'uploads/images/' . $title;
    }

    public static function getStatusUser()
    {
        return [
            0 => "Chưa xác minh",
            1 => "Đã xác minh",
        ];
    }

    public static function getRoleUser()
    {
        return [
            0 => "Người dùng bình người",
            1 => "Người dùng quản trị",
        ];
    }

    public static function stripVietnamese($str)
    {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ứ|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return $str;
    }

    public static function toSlug($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    function time_hours($times)
    {
        $time = getdate(strtotime($times));
        if ($time["hours"] < 10) {
            $hour = "0" . $time["hours"];
        } else {
            $hour = $time["hours"];
        }
        return $hour;
    }

    function time_minutes($times)
    {
        $time = getdate(strtotime($times));
        if ($time["minutes"] < 10)
            $minute = "0" . $time["minutes"];
        else
            $minute = $time["minutes"];
        return $minute;
    }

    function time_seconds($times)
    {
        $time = getdate(strtotime($times));
        if ($time["seconds"] < 10)
            $seconds = "0" . $time["seconds"];
        else
            $seconds = $time["seconds"];
        return $seconds;
    }

    function time_hms($time)
    {
        return time_hours($time) . ":" . time_minutes($time) . ":" . time_seconds($time);
    }

    function time_date($times)
    {
        $time = getdate(strtotime($times));
        if ($time["mday"] < 10)
            $date = "0" . $time["mday"];
        else
            $date = $time["mday"];
        return $date;
    }

    function time_month($times)
    {
        $time = getdate(strtotime($times));
        if ($time["mon"] < 10)
            $month = "0" . $time["mon"];
        else
            $month = $time["mon"];
        return $month;
    }

    function time_year($times)
    {
        $time = getdate(strtotime($times));
        if ($time["year"] < 10)
            $year = "0" . $time["year"];
        else
            $year = $time["year"];
        return $year;
    }

    function time_dmy($time)
    {
        return time_date($time) . " tháng " . time_month($time) . " năm " . time_year($time);
    }

    public static function time_fomat($time, $format = 'd/m/Y')
    {
        return date($format, strtotime($time));
    }

}
