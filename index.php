<?php

function dd($res)
{
    echo '<pre>';
    print_r($res);
    echo '</pre>';
}


require_once 'functions.php';
require_once(__DIR__ . '/telnet/TelnetClient.php');

use TelnetClient\TelnetClient;

$telnet = new TelnetClient('****', 23);
$telnet->connect();
$telnet->setPrompt('$'); //setRegexPrompt() to use a regex
$telnet->login('****', '****');
$command = 'iwinfo wlan0 assoclist';
$cmdResult = $telnet->exec($command);

$cmdResults = linesRemove($cmdResult);

$associatedLines = getAssociatedStations($cmdResults);
$associatedLines = isset($associatedLines) && !empty($associatedLines) ? $associatedLines : [];

$command = 'iwinfo';
$iwinfoResult = $telnet->exec($command);
//$iwinfoResults = linesRemove($iwinfoResult);

$wireless = getWireless($iwinfoResult);
dd($wireless);die;
$wireless = isset($wireless) && !empty($wireless) ? $wireless : [];
$wirelesArr = [];
$wirelesArr = [
    'wireless'=> $wireless
];


$command = 'cat /tmp/dhcp.leases';
$dhcpResult = $telnet->exec($command);


$dhcpResults = linesRemove($dhcpResult);

$dhcpResultArr = getDhcpLeases($dhcpResults);
$dhcpResultArr = isset($dhcpResultArr) && !empty($dhcpResultArr) ?  $dhcpResultArr : [];
dd($wireless);die;


$telnet->disconnect();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }


        .associated_stations table th, .associated_stations table td   {
            text-align: left;
        }
    </style>
</head>
<body>
<?php if(isset($dhcpResultArr) && !empty($dhcpResultArr)) : ?>
    <table><h2> DHCP Leases </h2>
        <tr>
            <th><b>Hostname</b></th>
            <th><b>IPv4-Address</b></th>
            <th><b>MAC-Address</b></th>
            <th><b>Leasetime remaining</b></th>

        </tr>
        <?php foreach ($dhcpResultArr as $res) : ?>

            <tr>
                <td><?php echo $res[1]; ?></td>
                <td><?php echo $res[2]; ?></td>
                <td><?php echo $res[3]; ?></td>
                <td><?php echo $res[4]; ?></td>
            </tr>

        <?php endforeach; ?>
    </table>
<?php endif; ?>



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


<?php if(!empty($associatedLines)) : ?>
    <div class="associated_stations">
        <table>
            <h2>Associated Stations</h2>
            <tr>
                <th style="border-right: 1px solid transparent;"></th>
                <th><b>MAC-Address</b></th>
                <th><b>RX Rate</b></th>
                <th><b>TX Rate</b></th>
            </tr>
            <?php foreach ($associatedLines as $res) : ?>

                <tr >
                    <td style="border-right: 1px solid transparent;">
                        <img width=30 src='<?php echo __DIR__ ;?>\img\<?= 'expert'; ?>.png'>
                    </td>
                    <td>
                        <?php echo $res['mac']; ?>
                    </td>
                    <td><?php echo $res['rx']; ?></td>
                    <td><?php echo $res['tx']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

<?php endif; ?>



</body>
</html>

