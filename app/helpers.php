<?php

function presentPrice($price): string
{
    return '$' . number_format((float) $price, 2, '.', ',');
}




