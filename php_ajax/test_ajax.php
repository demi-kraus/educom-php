






 <!DOCTYPE html>
<html lang="en">
  <head>   
    <link rel="stylesheet" href="css/style.css"/>
    <script src="js/jquery.js"></script>
    <script>
      $(document).ready( function() {

          $(".star").click( function() {
            const value = $(this).attr('data-value')

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
          })
      })    
    </script>
  </head>

  <body>
     
     <span class="star" data-value="1">&#9733;</span>
     <span class="star" data-value="2">&#9733</span>
     <span class="star" data-value="3">&#9733</span>
     <span class="star" data-value="4">&#9733</span>
     <span class="star" data-value="5">&#9733</span>

  </body>
</html>      
       