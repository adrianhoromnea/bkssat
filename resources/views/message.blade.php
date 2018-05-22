<html>
   <head>
      <title>Ajax Example</title>
      
      <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js">
      </script>
      
    
   </head>
   
   <body>
      <div id = 'msg'>This message will be replaced using Ajax. 
         Click the button to replace the message.</div>

         <input type="button" name="button" id="buton" value="nicusor">



      <script>

        $('#buton').on('click',function(){
           // alert("nnn");
            
            
        $.ajax({
            type:'GET',
            url: '{{route('getmsg')}}',
            data:'_token = <?php echo csrf_token() ?>',
            success:function(data){
                $("#msg").html(data.msg);
            }
        });
        



        }





        )


        </script>
   </body>

</html>