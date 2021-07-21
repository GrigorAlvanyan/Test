<?php

function isValidMacAddress($mac)
{
    return filter_var($mac, FILTER_VALIDATE_MAC);
}


 function getAssociatedStations($associatedStationLines) {



     $associatedStations = [];

     $mac = '';
     foreach ($associatedStationLines as $key => $line) {

         $macAddress = explode('  ', $line);

         if (isset($macAddress[0]) && isValidMacAddress($macAddress[0])) {
             $mac = $macAddress[0];
//         dd($mac);die;
             $associatedStations[$mac]['mac'] = $mac;

         } elseif (strpos($line, 'RX:')) {
             $rxLine = trim($line);
             $rxLine = substr($rxLine, 0, strpos($rxLine, '  '));
             $associatedStations[$mac]['rx'] = $rxLine;
         } elseif(strpos($line, 'TX:')) {
             $txLine = trim($line);
             $txLine = substr($txLine, 0, strpos($txLine, '  '));
             $associatedStations[$mac]['tx'] = $txLine;
         }



     }
     return $associatedStations;
 }









?>
<!---->
<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta name="viewport"-->
<!--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">-->
<!--    <meta http-equiv="X-UA-Compatible" content="ie=edge">-->
<!--    <title>Document</title>-->
<!--    <style>-->
<!--        table {-->
<!--            font-family: arial, sans-serif;-->
<!--            border-collapse: collapse;-->
<!--            width: 100%;-->
<!--            }-->
<!---->
<!--        td, th {-->
<!--            border: 1px solid #dddddd;-->
<!--            text-align: center;-->
<!--            padding: 8px;-->
<!--            }-->
<!---->
<!--        tr:nth-child(even) {-->
<!--            background-color: #dddddd;-->
<!--            }-->
<!---->
<!---->
<!--        .associated_stations table th, .associated_stations table td   {-->
<!--            text-align: left;-->
<!--        }-->
<!--    </style>-->
<!--</head>-->
<!--<body>-->
<?php //if(!empty($associatedLines)) : ?>
<!--<div class="associated_stations">-->
<!--    <table>-->
<!--        <h2>Associated Stations</h2>-->
<!--        <tr>-->
<!--            <th style="border-right: 1px solid transparent;"></th>-->
<!--            <th><b>MAC-Address</b></th>-->
<!--            <th><b>RX Rate</b></th>-->
<!--            <th><b>TX Rate</b></th>-->
<!--        </tr>-->
<!--        --><?php //foreach ($associatedLines as $res) : ?>
<!---->
<!--            <tr >-->
<!--                <td style="border-right: 1px solid transparent;">-->
<!--                    <img width=30 src='--><?php //echo __DIR__ ;?><!--\img\--><?//= 'expert'; ?><!--.png'>-->
<!--                </td>-->
<!--                <td>-->
<!--                    --><?php //echo $res['mac']; ?>
<!--                </td>-->
<!--                <td>--><?php //echo $res['rx']; ?><!--</td>-->
<!--                <td>--><?php //echo $res['tx']; ?><!--</td>-->
<!--            </tr>-->
<!--        --><?php //endforeach; ?>
<!--    </table>-->
<!--</div>-->
<!---->
<?php //endif; ?>
<!---->
<!--</body>-->
<!--</html>-->
<!---->
<!---->




