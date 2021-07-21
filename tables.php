<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        <?php
            require_once 'styles.css';
        ?>
    </style>
</head>
<body>
<?php if(!empty($dhcpResultArr)) : ?>
    <table><h2> DHCP Leases </h2>
        <tr>
            <th><b>Hostname</b></th>
            <th><b>IPv4-Address</b></th>
            <th><b>MAC-Address</b></th>
            <th><b>Leasetime remaining</b></th>
        </tr>
        <?php foreach ($dhcpResultArr as $dhcpResult) : ?>
            <tr>
                <?php foreach ($dhcpResult as $res) : ?>
                    <td><?php echo $res; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>



<table><h2>Wireless</h2>

    <?php if(!empty($wireless)) : ?>
        <?php foreach ($wireless as  $item) : ?>
            <tr>
                <td><?= $item; ?></td>
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

