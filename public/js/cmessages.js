function deleteWarning(rowId,routePath,frontElement,customText){
    var mHtml = '<br /><br />'
                + '&nbsp; &nbsp; &nbsp; <button type="button" id="deleteWbtnIdYes" class="btn clear">Da</button> &nbsp &nbsp &nbsp <button type="button" id="deleteWbtnIdNo" class="btn clear">Nu</button>';

    var msgBody = 'Esti sigur ca vrei sa stergi inregistrarea? <br>'
                 +  customText;
        toastr.warning(mHtml,msgBody,
            {closeButton: false,
             allowHtml: true,
             showDuration:100,
             hideDuration:100,
             timeOut: 5000,
             onShown: function (toast) {
                $("#deleteWbtnIdYes").on('click',function(){
                    $.ajax({
                        type: 'GET',
                        url: routePath,
                        success:function(){
                            frontElement.remove();
                        },
                        error:function(){
                            alert('Eroare [stergere linie]. Contactati administratorul de sistem.');
                        }

                    });
                });
            }
        });
}

