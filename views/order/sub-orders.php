 <?php if($sub_orders) { ?>
        <tr class="sub-tr">
            <th colspan="2">id</th>
            <th colspan="2">provider</th>
            <th colspan="1">Description</th>
            <th colspan="1">Quantity</th>
            <th colspan="2">Service</th>
            <th colspan="2">Status</th>
        </tr>
    <?php
        $i = 1;
        foreach ($sub_orders as $index => $sub_order) { ?>
        <tr data-suborder="<?= $sub_order->order_id ?>">
            <td colspan="2"><?= $sub_order->id ?></td>
<!--            <td colspan="2">--><?php //= date("Y-m-d", strtotime($sub_order->created_at)) ?><!--</td>-->
            <td colspan="2"><?= @$sub_order->getProvider() ?></td>
            <td colspan="1"><?= @$sub_order->description ?></td>
            <td colspan="1"><?= @$sub_order->quantity ?></td>
            <td colspan="2"><?= @$sub_order->getService(); ?></td>
            <td colspan="2"><?= @$sub_order->status ?></td>
            <td colspan="2"><a href="#" class="update-sub-order-modal" data-sub="<?= $sub_order->id; ?>"><i class="fas fa-pencil-alt"></i></a></td>
        </tr>
    <?php  }  ?>
 <?php } ?>

