<?php

/* Validate a color
 *
 * @param String color
 * @return boolean
 */

function validColor($color)
{
    global $f3;
    return in_array($color, $f3->get('colors'));
}

function validString($string)
{
    return ctype_alpha($string);
}

function validQty($qty)
{
    return !empty($qty) && ctype_digit($qty) && $qty >= 1;
}

function validToys($toys)
{
    global $f3;
    //Condiments are optional
    if (empty($toys)) {
        return true;
    }
    //But if there are condiments, we need to make sure they're valid
    foreach ($toys as $toy) {
        if (!in_array($toy, $f3->get('toys1'))) {
            return false;
        }
    }
    //If we're still here, then we have valid condiments
    return true;
}