<?php


function getWireless($wirelessLines)
{

    $strLines = [];
    foreach ($wirelessLines as $lines){
        $lines =
        $strLines[] = explode('  ', ltrim($lines));
    }

    $strLine = [];
    foreach ($strLines as $line) {
        if(count($line) == 2) {

            $strLine[] = $line[0];
            $strLine[] = $line[1];
            unset($line[1]);

        }else{
            $strLine[] = $line[0];
        }

    }

    $wireless = [];

    foreach ($strLine as $key => $str) {
        $keys = '';
        $str = explode(': ', $str);
        $keys = $str[0];
        if($keys == 'ESSID'){
            $wireless[] = 'SSID' .':'. $str[1];
        } elseif($keys == 'Channel') {
            $wireless[] = $keys .':'. $str[1];
        } elseif($keys == 'Bit Rate') {
            $wireless[] = $keys .':'. $str[1];
        } elseif($keys == 'Access Point') {
            $wireless[] = 'BSSID' .':'. $str[1];
        } elseif ($keys == 'Encryption') {
            $wireless[] = $keys .':'. $str[1];
        }
    }

    return $wireless;
}

$wireless = getWireless();
$wireless = isset($wireless) && !empty($wireless) ? $wireless : [];
$wirelesArr = [];
$wirelesArr = [
    'wireless'=> $wireless
];


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table><h2>Wireless</h2>

<?php if(!empty($wirelesArr)) : ?>
    <?php foreach ($wirelesArr as $item) : ?>
        <tr>
            <td><?= $item[0]; ?></td>
        </tr>
        <tr>
            <td><?= $item[2]; ?></td>
        </tr>
    <tr>
            <td><?= $item[3]; ?></td>
    </tr>
        <tr>
            <td><?= $item[1]; ?></td>
        </tr>
    <tr>
            <td><?= $item[4]; ?></td>

        </tr>
<?php endforeach;?>
<?php endif; ?>

    </table>
</body>
</html>
