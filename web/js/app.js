function deleteUser(user_id) {
    if(confirm('delete ?')){
        $.ajax({
            url: '/user/delete',
            method: 'get',
            dataType: 'html',
            data: { user_id: user_id,  },
            success: function (data) {
                $('table tbody tr ').each(function(){
                    if($(this).html().includes('deleteUser('+user_id+')')){
                        $(this).remove();
                        return false;
                    };
                })
            }
        });
    } else {
        return false;
    }
}
$('body').on('click','.modal_update_user', function (el) {
    if($('#updateModal')){
        $('#updateModal').remove();
    }
    var user_id = $(this).data('id');
    $.ajax({
        url: '/user/update',
        method: 'get',
        dataType: 'html',
        data: { user_id: user_id,  },
        success: function (data) {
            $('body').append(data);
            $('body').find('#modal-update').trigger('click');
            $('body').find('#modal-update').remove();
        }
    });
})
$('body').on('click','.update-order-modal', function (el) {
    if($('#updateModal')){
        $('#updateModal').remove();
    }
    var order_id = $(this).data('id');
    $.ajax({
        url: '/order/update',
        method: 'post',
        dataType: 'html',
        data: { order_id: order_id, },
        success: function (data) {
            $('body').append(data);
            $('body').find('#modal-update-order').trigger('click');
            $('body').find('#modal-update-order').remove();
        }
    });
})

$('body').on('click','.update-service-modal', function (el) {
    if($('#updateModal')){
        $('#updateModal').remove();
    }
    var service_id = $(this).data('id');
    $.ajax({
        url: '/services/update',
        method: 'post',
        dataType: 'html',
        data: { service_id: service_id, },
        success: function (data) {
            $('body').append(data);
            $('body').find('#modal-update-services').trigger('click');
            $('body').find('#modal-update-services').remove();
        }
    });
})
//after task
$('body').on('click','.update-sub-order-modal', function (el) {
    if($('#updateModal')){
        $('#updateModal').remove();
    }
    var sub_order_id = $(this).data('sub') ?? 0; // update sub order
    var order_id = $(this).data('id') ?? 0; // create sub order

    $.ajax({
        url: '/order/sub-order',
        method: 'post',
        dataType: 'html',
        data: {
            sub_order_id: sub_order_id,
            order_id: order_id,
        },
        success: function (data) {
            $('body').append(data);
            $('body').find('#modal-update-sub-order').trigger('click');
            $('body').find('#modal-update-sub-order').remove();
        }
    });
})
$('body').on('click','.view-order-modal', function (el) {
    if($('#updateModal')){
        $('#updateModal').remove();
    }
    var view_id = $(this).data('id');
    $.ajax({
        url: '/order/view',
        method: 'post',
        dataType: 'html',
        data: { view_id: view_id, },
        success: function (data) {
            $('body').append(data);
            $('body').find('#modal-view-order').trigger('click');
            $('body').find('#modal-view-order').remove();
        }
    });
})
$('body').on('click','.view-service-modal', function (el) {
    if($('#updateModal')){
        $('#updateModal').remove();
    }
    var view_id = $(this).data('id');
    $.ajax({
        url: '/services/view',
        method: 'post',
        dataType: 'html',
        data: { view_id: view_id, },
        success: function (data) {
            $('body').append(data);
            $('body').find('#modal-view-service').trigger('click');
            $('body').find('#modal-view-service').remove();
        }
    });
})

$('body').on('input','#user-username', function () {
    let username = $(this).val();
    let id = $(this).closest('div').find('#id').val();
    $.ajax({
        url: '/user/check-username',
        method: 'get',
        dataType: 'html',
        data: {
            username: username,
            id: id,
        },
        success: function (data) {
            if (!$('.field-user-username').find('span').html()) {
                $('.field-user-username').append(data);
                $('[type="submit"]').attr('disabled', true);
            }
            if (!data) {
                $('.field-user-username').find('span').remove();
                $('[type="submit"]').attr('disabled', false);
            }
        }
    });
})
$('body').on('input','#user-password , #user-password_repeat', function () {
    let pass = $(this).closest('form').find('#user-password').val();
    let rep = $(this).closest('form').find('#user-password_repeat').val();
    if(pass != rep){
        // border-color: #dc3545;
        $(this).closest('form').find('#user-password_repeat').css('border-color','#dc3545');
        $('[type="submit"]').attr('disabled', true);
    }else {
        $(this).closest('form').find('#user-password_repeat').css('border-color','#28a745');
        $('[type="submit"]').attr('disabled', false);
    }
})
var def_prov = 0;
$('body').on('change','.def-provider',function () {
    let el = $(this);
    def_prov = $(this).val();
    el.closest('form').find('.soctial_types_group').css('display','block');
})
$('body').on('change','.social_types',function () {
    let el = $(this);
    let id = def_prov;
    let name = $(this).val();
    $.ajax({
        url: 'def-services',
        method: 'post',
        dataType: 'json',
        data: { id: id,name: name,  },
        success: function (data) {
            if ($(".def-service").length > 0) {
                $(".def-providers").html('');
            }
            var labelElement = $('<label>', {
                text: 'Select Default Service:'
            });
            let selectElement = $('<select>', {
                class: 'def-service select2-select w-100', // Add your class or attributes here
                name: 'Services[def_service]'    // Add your name attribute here if needed
            });

            data.forEach(function(item) {
                var option = $('<option>', {
                    value: item.id,
                    text: item.service_id+' '+item.name
                });
                selectElement.append(option);
            });
            // el.closest('div').after(labelElement, selectElement);
            el.closest('form').find('.def-providers').append(labelElement, selectElement);
            $('.select2-select').select2();
        }
    });
})
function copy_text(el,text_of_copy) {
    var textarea = document.createElement("textarea");
    textarea.value = text_of_copy;
    document.body.appendChild(textarea);

    // Select the text in the textarea
    textarea.select();
    textarea.setSelectionRange(0, 99999); // For mobile devices

    // Copy the selected text to the clipboard
    document.execCommand("copy");

    // Remove the temporary textarea
    document.body.removeChild(textarea);

}

$('body').on('click','.unconfirmed , .confirmed', function (el) {
    if($('#commentModal')){
        $('#commentModal').remove();
    }
    let to_confirm = 0;
    if($(this).hasClass('unconfirmed')){
        to_confirm = 1;
    }
    var id = $(this).data('id');
    $.ajax({
        url: '/provider-orders/payment',
        method: 'get',
        dataType: 'html',
        data: { id: id,to_confirm:to_confirm },
        success: function (data) {
            $('body').append(data);
            $('body').find('#modal-comment').trigger('click');
            $('body').find('#modal-comment').remove();
        }
    });
})
$('body').on('click','.delete-provider-order', function (el) {
    if($('#commentModal')){
        $('#commentModal').remove();
    }
    var id = $(this).data('id');
    $.ajax({
        url: '/provider-orders/delete-provider-order',
        method: 'post',
        dataType: 'html',
        data: { id: id },
        success: function (data) {
            $('body').append(data);
            $('body').find('#modal-comment').trigger('click');
            $('body').find('#modal-comment').remove();
        }
    });
})
$('body').on('click','.add_link', function (el) {
    if($('#commentModal')){
        $('#commentModal').remove();
    }
    var id = $(this).data('id');
    $.ajax({
        url: '/provider-orders/add-link',
        method: 'get',
        dataType: 'html',
        data: { id: id },
        success: function (data) {
            $('body').append(data);
            $('body').find('#modal-comment').trigger('click');
            $('body').find('#modal-comment').remove();
        }
    });
})
$('body').on('click','.start-add', function (el) {
    let parent = $(this).closest('div');
    $(this).closest('div').find('input').attr('disabled',false);
    $(this).closest('div').find('.d-none').removeClass('d-none');
    $(this).addClass('d-none');
})
$('body').on('click','.remove-line', function (el) {
    let form = $(this).closest('form').attr('class');
    $(this).closest('.multyple_forms').remove();
    calculing(form)
})
$('body').on('click','.add_new_link', function (el) {
    let form = 'form_'+$(this).closest('div').find('input').data('id');
    let new_link = $(this).closest('div').find('input').val();

    let div = '  <div class="d-flex justify-content-between align-items-center m-t-30 multyple_forms counts_views">' +
        '<div class="w-75">' +
        '<label class="d-block form-control long_text" title="'+new_link+'">'+new_link+'<input type="hidden" value="'+new_link+'" name="link[]" ></label>' +
        '</div>' +
        '    <div class="w-20">' +
        '        <label  class="d-block form-control count_xx">10000</label><input type="hidden" name="quantity[]" value="">    </div>    <div class="d-flex align-items-center">        <span style="margin:0px 0 15px 5px ; font-size:20px;" class="remove-line">x</span>    ' +
        '</div>' +
        '</div>';
    $("."+form).find('hr').after(div);

    calculing(form)
})

$('body').on('click','.start', function (el) {
    // if ((($(this).closest('.parent').find('.order_description').find('.u_name').html()).indexOf('FOLLOWERS')) >= 0 ){
    //     return 1;
    // }
    if($(this).data('checked')){
        $(this).closest('.parent').find('form').removeClass('d-none');
        $(this).closest('.u_footer').removeClass('d-flex');
        $(this).closest('.parent').find('.before_start').removeClass('d-flex');
        $(this).closest('.u_footer').addClass('d-none');
        $(this).closest('.parent').find('.before_start').addClass('d-none');
    }else{
        $.ajax({
            url: '/provider-orders/get-comment',
            method: 'get',
            dataType: 'html',
            data: { not_confirmed: true,  },
            success: function (data) {
                $('body').append(data);
                $('body').find('#modal-comment').trigger('click');
                $('body').find('#modal-comment').remove();
            }
        });
    }
    // calculing($(this).closest('.parent').find('.counts_views'));
})

$('body').on('click','.view-more-orders', function () {
    let el = $(this);
    let page = $(this).data('page');
    var queryString = window.location.search;
    $.ajax({
        url: '/provider-orders/view-more'+queryString,
        method: 'get',
        dataType: 'html',
        data: { swipe_page: page },
        success: function (data) {
            $('body').find('.orders_list').append(data);
            el.data('page',++page);
        }
    });
})
$('body').on('click','.calendar_content div', function (el) {
    let day = $(this).html();
    let inputDate =  $(this).closest('.calendar').find('.calendar_header').find('h2').html();
    var outputDate = day+' '+inputDate;

    let query = window.location.search;
    if(!query){
        query = '?';
    }
    window.location.replace("https://panel.instaboost.ge/order/test"+query+"&sorting[date]="+outputDate);
});
$('body').on('click','.paperclip_confirm', function (el) {
    let form = $(this).closest('form').attr('class');
    let divs = [];
    let i = 0;
    $("." +form+ " .counts_views" ).each(function(){
        divs[i++] = '<label class="w-250 text-break">'+$(this).find('.long_text').html()+'</label>' +
            '<input type="hidden" name="link[]" value="'+$(this).find('.long_text').html()+'"><br>';
    });
    $.ajax({
        url: '/provider-orders/confirm-all-views',
        method: 'get',
        dataType: 'html',
        data: {form :form },
        success: function (data) {
            $('body').append(data);
            $('body').find('#modal-comment').trigger('click');
            $('body').find('#modal-comment').remove();
            $('body').find('.modal-content').find('.modal-header .flex-column').prepend(divs);
        }
    });
});
//get balance
$('body').on('change','.autolikes_service', function (el) {
    // let form = $(this).closest('form').attr('class');
    el = $(this);
    let service_id  = $(this).val();
    $.ajax({
        url: '/provider-orders/get-balance',
        method: 'get',
        dataType: 'json',
        data: {service_id :service_id},
        success: function (data) {//0 - balance,1 - price
            let quantity = el.closest('.balance_counter').find('.main_quantity').val();
            if(!quantity){
                quantity = el.closest('.mini_order').find('input[name="like[min-max]"]').val();
                if (!quantity){
                    quantity = el.closest('.mini_order').find('input[name="view[min-max]"]').val();
                }
                console.log(quantity);
                quantity = quantity.split('-');
                quantity = (parseInt(quantity[0])+parseInt(quantity[1]))/2;
            }

            let charge = (parseFloat(quantity) * parseFloat(data[1]))/1000;
            let color = '';
            if(charge > data[0]){
                color = 'red';
            }else{
                color =  'rgba(101, 101, 101, 1)';
            }
            console.log(data);
            console.log(charge);
            //active flws
            el.closest('.mini_order').find('.service_balance').html('balance ' + data[0]+ ' $');
            el.closest('.mini_order').find('.service_price').html('charge ' + charge + ' $');
            //end
            el.closest('.balance_counter').find('.prov_price').html('charge ' + charge + ' $');
            el.closest('.balance_counter').find('.service_balance').html('balance ' + data[0]+ ' $');
            el.closest('.balance_counter').find('.prov_balance').html('balance ' + data[0]+ ' $');
            el.closest('.balance_counter').find('.prov_price').html('charge ' + charge + ' $');
            el.closest('.balance_counter').find('.prov_price').css('color',color);
            // el.closest('.balance_counter').find('.prov_price').html();


        }
    });
});
$('body').on('click','.confirm_modal_link', function (el) {
    let form = $(this).closest('div').find('.hidden_value').val();
    $('.modal-backdrop').remove();
    $('body .close').trigger('click');
    let balance;
    if($('.'+form).find('input[checked]').closest('.balance_counter').html()){
        balance = $('.'+form).find('input[checked]').closest('.balance_counter').find('.service_balance').html().match(/(\d+)/);
    }else{
        balance = (($('.'+form).find('.prov_balance').html()).match(/(\d+)/));
    }
    let price = (($('.'+form).find('.prov_price').html()).match(/(\d+)/));
    console.log(balance);
    console.log(balance[0]);
    console.log(price[0]);
    if(balance && (parseInt(balance[0]) >= parseInt(price[0]))){
        $('.'+form).find('button:submit').removeAttr('disabled');
        $('.'+form).find('button:submit').addClass('choosen_btn');
    }
 });
$('body').on('change', '.auto_checkbox', function () {
    // let el = $(this).closest('.mini_order');
    // let second = $(this).closest('form .mini_order').not(el);
    // el.toggleClass('opacity-05');
    // if (!el.hasClass('opacity-05')){
    //     second.addClass('opacity-05');
    // }
    var el = $(this).closest('.mini_order');
    var other_el = $(this).closest('form').find('.mini_order').not(el);

    el.toggleClass('opacity-05');
    // console.log(!other_el.hasClass('opacity-05') && other_el.find('input[type=checkbox]'));
    // if (!other_el.hasClass('opacity-05')){
    //     other_el.addClass('opacity-05');
    // }
});

$('body').on('hidden.bs.modal','#commentModal', function remove_modal(el) {
    $(this).remove();
});
