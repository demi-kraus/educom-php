  
$(document).ready( function() {

    $(".star").click( function() {
    const value = $(this).attr('data-value')
    const item_id = $("#item_id").attr('data-value')
    const user_id = $("#user_id").attr('data-value')

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
        url : 'http://localhost/educom-php/php_ajax/index.php?',
        data: {action: "ajaxcall",
                func: "setRating",
                rating: value,
                item_id: item_id,
                user_id: user_id},
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
