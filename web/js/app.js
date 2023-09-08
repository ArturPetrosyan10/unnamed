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
// $('body').on('click','.update-sub-order-modal', function (el) {
//     if($('#updateModal')){
//         $('#updateModal').remove();
//     }
//     var order_id = $(this).data('id');
//     $.ajax({
//         url: '/order/update',
//         method: 'post',
//         dataType: 'html',
//         data: { order_id: order_id, },
//         success: function (data) {
//             $('body').append(data);
//             $('body').find('#modal-update-order').trigger('click');
//             $('body').find('#modal-update-order').remove();
//         }
//     });
// })
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

