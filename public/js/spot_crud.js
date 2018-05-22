function modifyOneValue(rowId,routePath,frontElement,customText,dataType,valueToBeChanged){
    var mHtml = '&nbsp;'
                + '<input type="'+dataType+'" id="crudInput" value = ' + valueToBeChanged + ' pattern="[0-9]" title="Numbers only"><br /><br />'
                + '&nbsp; &nbsp; &nbsp; <button type="button" id="yesCrudButton" class="btn clear">Da</button> &nbsp &nbsp &nbsp <button type="button" id="noCrudButton" class="btn clear">Nu</button>';

    var msgBody = 'Esti sigur ca vrei sa modifici inregistrarea? <br>'
                 +  customText;
        toastr.warning(mHtml,msgBody,
            {closeButton: false,
             allowHtml: true,
             showDuration:100,
             hideDuration:100,
             timeOut: 5000,
             positionClass:'toast-top-center',
             onShown: function (toast) {
                $('#crudInput').select();
                $('#crudInput').on('keyup',function(){
                    //**check data format */
                    if(dataType == 'number'){
                        if(!$.isNumeric($(this).val())){
                            alert ('Valoare trebuie sa fie de tip numeric!');
                            $(this).val('');
                        }else{
                            $(this).val(Math.floor($(this).val()));
                        }
                    } 
                })
                $("#yesCrudButton").on('click',function(){
                    $.ajax({
                        type: 'POST',
                        url: routePath,
                        data:{
                            'numarOp':$('#crudInput').val()
                        },
                        success:function(data){ 
                            frontElement.find('td:eq(1)').text(data.numarop);
                        },
                        error:function(){
                            alert('Eroare [actualizare numar]. Contactati administratorul de sistem.');
                        }

                    });

                });
            }
        });
}