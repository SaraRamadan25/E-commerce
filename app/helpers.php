<?php

function presentPrice($price): string
{ /*   return sprintf('$%.2f', $price / 100);*/

        $formattedPrice = floatval($price);
        return '$' . number_format($formattedPrice, 2);
    }

