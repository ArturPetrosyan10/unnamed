function calculing(form) {
    // console.log(form);
    let main_quanttity = $("." + form).find('.main_quantity').val();
    let coun_links = $("." +form+ " .counts_views" ).length;
    $("." +form+ " .counts_views" ).each(function(){
        $(this).find('.count_xx').html( (main_quanttity/coun_links).toFixed(2));
        $(this).find('input[type=hidden]').val( (main_quanttity/coun_links).toFixed(2));
    });
}