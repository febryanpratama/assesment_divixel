<?php

namespace App\Helpers;

class helper
{
    static function pregmatch($string)
    {
        $pattern = "/TR500/i";
        $match1 = '';
        if (preg_match_all($pattern, $string, $matches)) {
            $match1 = $matches[0][0];
        }
        $pattern2 = "/3/i";
        $match2 = '';
        if (preg_match_all($pattern2, $string, $matches2)) {
            $match2 = $matches2[0][0];
        }

        $pattern3 = "/WN/i";
        $match3 = '';
        if (preg_match_all($pattern3, $string, $matches3)) {
            $match3 = $matches3[0][0];
        }
        // dd($match1);

        if ($match1 != '' && $match2 != '' && $match3 != '') {
            return $match1 . $match2 . $match3;
        } else {
            // dd("false");
            return null;
        }
    }
}
