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
            $associatedStations[$mac]['mac'] = $mac;

        } elseif (strpos($line, 'RX:')) {
            $rxLine = trim($line);
            $rxLine = substr($rxLine, 0, strpos($rxLine, '  '));

            $rxLine = explode(', ', $rxLine);

            unset($rxLine[count($rxLine)]);
            $rxLine = implode(', ',$rxLine);
            $associatedStations[$mac]['rx'] = $rxLine;
        } elseif (strpos($line, 'TX:')) {
            $txLine = trim($line);
            $txLine = substr($txLine, 0, strpos($txLine, '  '));
            $txLine = explode(', ', $txLine);
            unset($txLine[count($txLine)-1]);
            $txLine = implode(', ',$txLine);
            $associatedStations[$mac]['tx'] = $txLine;
        }

    }
    return $associatedStations;
}


function getWireless($wirelessLines)
{

    $strLines = [];
    foreach ($wirelessLines as $lines) {
        $lines =
        $strLines[] = explode('  ', ltrim($lines));
    }

    $strLine = [];
    foreach ($strLines as $line) {
        if (count($line) == 2) {

            $strLine[] = $line[0];
            $strLine[] = $line[1];
            unset($line[1]);

        } else {
            $strLine[] = $line[0];
        }

    }


    $wireless = [];
    foreach ($strLine as $key => $str) {
        $keys = '';
        $str = explode(': ', $str);
        $keys = $str[0];
        if ($keys == 'ESSID') {
            $wireless[] = 'SSID' . ':' . $str[1];
        } elseif ($keys == 'Channel') {
            $wireless[] = $keys . ':' . $str[1];
        } elseif ($keys == 'Bit Rate') {
            $wireless[] = 'Bitrate' . ':' . $str[1];
        } elseif ($keys == 'Access Point') {
            $wireless[] = 'BSSID' . ':' . $str[1];
        } elseif ($keys == 'Encryption') {
            $wireless[] = $keys . ':' . $str[1];
        }
    }

    return $wireless;
}


function linesRemove($arr){
    unset($arr[0]);
    $resArrayCount = count($arr);
    unset($arr[$resArrayCount]);
    return $arr;
}


function isValidTimeStamp($timestamp)
{
    return ((string) (int) $timestamp === $timestamp)
        && ($timestamp <= PHP_INT_MAX)
        && ($timestamp >= ~PHP_INT_MAX);
}

function getDhcpLeases($dhcpLeasesFileLines) {

    $dhcpLeases = [];
    foreach($dhcpLeasesFileLines as $key => $line) {
        $line = array_reverse(explode(' ', $line));
        unset($line[0]);
        foreach ($line as $item) {

            if (isValidTimeStamp($item)) {
                $dhcpLeases[$key][] = date('d-m-Y H:i:s',$item);
            } else {
                $dhcpLeases[$key][] = $item;
            }
        }
    }

    return $dhcpLeases;
}