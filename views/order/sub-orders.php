<?php
    $i = 1;
    foreach ($sub_orders as $index => $sub_order) { ?>
    <tr data-suborder="<?= $sub_order->order_id ?>">
        <td><?= $sub_order->order_id.'.'.$i++ ?></td>
        <td><?= $sub_order->id ?></td>
        <td><?= $sub_order->created_at ?></td>
        <td><?= $sub_order->payload_link ?></td>
        <td><?= $sub_order->charge ?></td>
        <td><?= $sub_order->start_count?></td>
        <td><?= $sub_order->quantity ?></td>
        <td><?= $sub_order->service ?></td>
        <td><?= $sub_order->status ?></td>
        <td><?= $sub_order->remains ?></td>
        <td><?= $sub_order->remains ?></td>
        <td><a href="#"><i class="fas fa-pencil-alt"></i></a></td>
    </tr>
<?php  }  ?>

