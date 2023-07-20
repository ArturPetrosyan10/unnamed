function deleteUser(user_id) {
    if(confirm('Ջնջել ՞')){
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
        $($('#updateModal')).remove();
    }
    user_id = $(this).data('id');
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
            console.log(data);
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