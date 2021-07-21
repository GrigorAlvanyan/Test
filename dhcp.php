<?php



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

$dhcpResult = getDhcpLeases();
$dhcpResult = isset($dhcpResult) && !empty($dhcpResult) ?  $dhcpResult : [];

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
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>
</head>
<body>
<?php if(isset($dhcpResult) && !empty($dhcpResult)) : ?>
<table><h2> DHCP Leases </h2>
    <tr>
        <th><b>Hostname</b></th>
        <th><b>IPv4-Address</b></th>
        <th><b>MAC-Address</b></th>
        <th><b>Leasetime remaining</b></th>

    </tr>
    <?php foreach ($dhcpResult as $res) : ?>

    <tr>
        <td><?php echo $res[1]; ?></td>
        <td><?php echo $res[2]; ?></td>
        <td><?php echo $res[3]; ?></td>
        <td><?php echo $res[4]; ?></td>
    </tr>

    <?php endforeach; ?>
</table>
<?php endif; ?>
</body>
</html>
