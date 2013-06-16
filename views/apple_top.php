<table id="info" style='width: 600px;font-family: Helvetica;'>
    <tr style="border-bottom: solid 1px #000000;">
        <th>Product</th>
        <th>Average Days</th>
        <th>Past days</th>
        <th>Latest Release</th>
    </tr>
    <?php foreach ($infos as $tag => $info): ?>
        <tr>
            <td width="200"><?php echo $tag; ?></td>
            <td width="100"><?php echo $info['avg']; ?></td>
            <td width="100"><?php echo $info['latest']; ?></td>
            <td><?php echo $info['date']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>