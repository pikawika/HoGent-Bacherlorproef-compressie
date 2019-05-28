<?php
/**
 * Created by Lennert Bontinck.
 * Date: 2019-05
 */

function rle_encode_all($input)
{
    $minimum_aantal_matches = 0;

    if (!$input) {
        return '';
    }

    $output = '';
    $vorige = $letter = null;
    $frequentie = 1;

    foreach (str_split($input) as $letter) {
        if ($letter === $vorige) {
            $frequentie++;
        } else {
            if ($frequentie > $minimum_aantal_matches && $vorige != null) {
                $output .= $frequentie;
            }
            $output .= $vorige;
            $frequentie = 1;
        }
        $vorige = $letter;
    }

    if ($frequentie > $minimum_aantal_matches) {
        $output .= $frequentie;
    }
    $output .= $letter;

    return $output;
}

function rle_encode($input)
{
    return preg_replace_callback('/(.)\1+/', function ($overeenkomst) {
        return strlen($overeenkomst[0]) . $overeenkomst[1];
    }, $input);
}

function rle_decode($input)
{
    return preg_replace_callback('/(\d+)(\D)/', function ($overeenkomst) {
        return str_repeat($overeenkomst[2], $overeenkomst[1]);
    }, $input);
}