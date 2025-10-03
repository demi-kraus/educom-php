  
$(document).ready( function() {

    $(".star").click( function() {
    const value = $(this).attr('data-value')
    const item_id = 1
    const user_id = 1

    // clear all red stars
    $(".star").removeClass('red')
    // paint stars red
    $('.star').each((index,elem) => {
        const itemValue = $(elem).attr('data-value')
        if(itemValue <= value){
            $(elem).addClass('red')
        }
    })
    //

    // send ajax request
    $.ajax({
        type : 'GET',
        url : 'test_ajax.php?action=ajaxcall&func=setRating',
        data: {rating:value, user_id:user_id, item_id:item_id},
        dataType : 'json',
        success: function(data){
            $(data.target).html(data.content);
            console.log(data);
        },
        error: function(xhr, status, error){
            console.error("AJAX Error:", status, error);
            console.error("Response:", xhr.responseText);
        }
    })

    })
})    
