<?php

function presentPrice($price): string
{
        $formattedPrice = floatval($price);
        return '$' . number_format($formattedPrice, 2);
    }

