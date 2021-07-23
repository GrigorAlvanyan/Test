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
            if (count($rxLine) > 3) {
                unset($rxLine[count($rxLine) - 1]);
            }
            unset($rxLine[count($rxLine)]);
            $rxLine = implode(', ',$rxLine);
            $associatedStations[$mac]['rx'] = $rxLine;
        } elseif (strpos($line, 'TX:')) {
            $txLine = trim($line);
            $txLine = substr($txLine, 0, strpos($txLine, '  '));
            $txLine = explode(', ', $txLine);
            if (count($txLine) > 3) {
                unset($txLine[count($txLine) - 1]);
            }
            $txLine = implode(', ',$txLine);
            $associatedStations[$mac]['tx'] = $txLine;
        }

    }
    return $associatedStations;
}

function getWireless($iwinfoResults)
{
    $parsedIwinfo = [];
    foreach ($iwinfoResults as $iwinfoLine) {
        if (strpos($iwinfoLine, 'ESSID:')) {
            $iwinfoLine = substr($iwinfoLine,  strpos($iwinfoLine, '  '));
        }

        $parsedIwinfoLine = explode('  ', ltrim($iwinfoLine));

        if (count($parsedIwinfoLine) == 2) {

            $parsedIwinfo[] = $parsedIwinfoLine[0];
            $parsedIwinfo[] = $parsedIwinfoLine[1];
            unset($parsedIwinfoLine[1]);

        } else {
            $parsedIwinfo[] = $parsedIwinfoLine[0];
        }
    }

    $wireless = [];
    foreach ($parsedIwinfo as  $str) {
        $keys = '';
        $str = explode(': ', $str);
        $keys = $str[0];
        if ($keys == 'ESSID') {
            $str[1] = str_replace('"', '', $str[1]);
            $wireless['SSID'] = $str[1];
        } elseif ($keys == 'Channel') {
            $wireless['Channel'] = $str[1];
        } elseif ($keys == 'Bit Rate') {
            $wireless['Bitrate'] = $str[1];
        } elseif ($keys == 'Access Point') {
            $wireless['BSSID'] = $str[1];
        } elseif ($keys == 'Encryption') {
            $wireless['Encryption'] = $str[1];
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

                $presentTime = time();
                $presentDate =  date('Y-m-d H:i:s', $presentTime);
                $timeDifference = $item - $presentTime;
                $timeDifference = $presentTime - $timeDifference;

                $oldDate=  date('Y-m-d H:i:s', $timeDifference);

                $assigned_time = "{$oldDate}";
                $completed_time= "{$presentDate}";

                $d1 = new DateTime($assigned_time);
                $d2 = new DateTime($completed_time);
                $interval = $d2->diff($d1);

                $dhcpLeases[$key][] = $interval->format(' %hh %im %ss');

            } else {
                $dhcpLeases[$key][] = $item;
            }
        }
    }

    return $dhcpLeases;
}