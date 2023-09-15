<?php

function formatDate($date, $format='pt_BR')
{
    // Create a new DateTime object in the UTC format
    $utc_timezone = new DateTimeZone("America/Araguaina");

    $datetime = new DateTime($date, $utc_timezone);
    // Convert the DateTime object to the timezone of Tallinn

    // $datetime->setTimezone($utc_timezone);
    // Display the result in the YYYY-MM-DD HH:MM:SS format
    if ($format == 'pt_BR') {
        return $datetime->format('d-m-Y');
    }
    return $datetime->format('Y-m-d');
}