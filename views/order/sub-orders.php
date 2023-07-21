<?php
    $i = 1;
    foreach ($sub_orders as $index => $sub_order) { ?>
    <tr data-suborder="<?= $sub_order->order_id ?>">
        <td><?= $sub_order->order_id.'.'.$i++ ?></td>
        <td><?= $sub_order->id ?></td>
        <td><?= $sub_order->id ?></td>
        <td><?= $sub_order->name ?></td>
        <td><?= $sub_order->transaction_number ?? 1 ?></td>
        <td><?= $sub_order->email ?></td>
        <td><button>Edit</button></td>
    </tr>
<?php  }  ?>