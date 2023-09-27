<?php if(isset($query) &&  !empty($query)){ ?>
    <?php foreach ($query as $index => $item) {?>
        <div class=" m-1 p-3 parent border border-secondary rounded m-t-10">
            <div class="input-group-text d-flex justify-content-between m-t-10">
                <div class="d-flex">
                    <div class="border-right">
                        <img class="copy_data" data-data="<?= $item['customer_email'] ?>" title="<?= $item['customer_email'] ?>" src="<?= '/img/Email.png' ?>">
                    </div>
                    <div class="p-left-8"><span class="u_name"><?=  mb_substr($item['customer_name'], 0, 20)  ?></span></div>
                </div>
                <div>
                    <img src="<?= '/img/Phone.png' ?>" class="copy_data" data-data="<?= $item['customer_mobile'] ?>>" title="<?= $item['customer_mobile'] ?>">
                </div>
            </div>
            <div class="input-group-text d-flex justify-content-between m-t-10">
                <div class="d-flex">
                    <div class="border-right"><i class="fab fa-instagram"></i></div>
                    <div class="p-left-8"><span class="u_name">4000 followers</span></div>
                </div>
                <div></div>
            </div>

            <div class="input-group-text d-flex justify-content-between m-t-10 overflow-hidden">
                <div class="d-flex">
                    <div class="border-right">
                        <img class="comment-unread" data-id="<?= $item['id'] ?>" src="<?= '/img/Comment Unread.png' ?>">
                    </div>
                    <div class="p-left-8"><span class=""><?= mb_substr($item['customer_comment'], 0, 15).'...'; ?></span></div>
                </div>
                <div></div>
            </div>
            <div class="d-flex justify-content-between m-t-10 before_start">
                <div class="d-flex">
                    <div class="d-flex">
                        <div class="paperclip d-flex justify-content-center">
                            <img src="/img/Link.png" class="copy_data" data-data="<?= $item['link'] ?>" title="<?= $item['link'] ?>">
                        </div>
                    </div>
                    <div class="d-flex ml-1">
                        <div class="paperclip d-flex justify-content-center"><img src="/img/Chat.png"></div>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <span class="u_price pr-1">999.99 $ </span>
                    <div class=" <?= (!!$item['status_paid']) ? "confirmed" : 'unconfirmed'; ?>" data-id="<?= $item['id'] ?>" >
                        <img src="<?= (!!$item['status_paid']) ? "/img/Group 241.png" : '/img/Payment is not Confirmed.png'; ?>">
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between u_footer m-t-10">
                <button class="w-75 <?= (!!$item['status_paid']) ? 'choosen_btn start' : 'disabled'; ?>">Start</button>
                <button class="delete-provider-order"  style="padding:0px;"  data-id=<?= $item['id'] ?>><img src="<?= '/img/Group 225.png' ?>"></button>
            </div>

            <div class="d-flex justify-content-between m-t-10">
                <form  action=" " class="d-none form_<?= $item['id'] ?>" >
                    <div class="d-flex justify-content-between align-items-center multyple_forms">
                        <div class="w-45">
                            <label>Provider $ Service ID</label>
                            <select class="form-control">
                                <?php foreach ($services as $key => $value) { ?>
                                    <option><?= parse_url($value['name'])['host'].' '.$value['def_boost_service'].' '.$value['service_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="w-25">
                            <label>Overflow</label>
                            <select class="form-control">
                                <option>1</option>
                                <option>12</option>
                                <option>123</option>
                                <option>1234</option>
                            </select>
                        </div>
                        <div class="w-25">
                            <label>Quantity</label>
                            <input type="number" value="1000" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center m-t-10">
                        <span>Balance: $255.39</span>
                        <span>Charge: $999.99</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center m-t-30 multyple_forms">
                        <div class="w-60">
                            <label>The principle of distribution</label>
                            <select class="form-control">
                                <option>1</option>
                                <option>12</option>
                                <option>123</option>
                                <option>1234</option>
                            </select>
                        </div>
                        <div class="w-35">
                            <label>Quantity</label>
                            <input type="number" class="form-control" value="100" readonly>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center m-t-30 multyple_forms">
                        <div class="w-75">
                            <label class="d-block form-control long_text">http://instagram.com/p/Cu06hi/</label>
                        </div>
                        <div class="w-20">
                            <label  class="d-block form-control">10000</label>
                        </div>
                        <div class="d-flex align-items-center">
                            <span style="margin:0px 0 15px 5px ; font-size:20px;" class="remove-line">x</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center m-t-30 functional-buttons">
                        <div class="w-20">
                            <button class="add_link" data-id="<?= $item['id'] ?>" type="button">+</button>
                        </div>
                        <div class="w-20">
                            <button class="d-flex align-items-center justify-content-center"><img src="<?= '/img/list.png' ?>"></button>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between u_footer m-t-10">
                        <div class="d-flex">
                            <div class="paperclip d-flex justify-content-center" style="background:#4884f4;">
                                <img src="/img/link-01.png" class="copy_data" data-data="<?= $item['link'] ?>" title="<?= $item['link'] ?>" >
                            </div>
                        </div>
                        <div class="d-flex ml-1">
                            <div class="paperclip d-flex justify-content-center"><img src="/img/Chat.png"></div>
                        </div>
                        <div class="d-flex ml-1">
                            <div class="paperclip d-flex justify-content-center"><img src="/img/Divide.png"></div>
                        </div>
                        <button class="w-75 <?= (!!$item['status_paid']) ? 'choosen_btn' : 'disabled'; ?>">Execute</button>
                    </div>
                </form>

            </div>

        </div>
    <?php } ?>
<?php } ?>