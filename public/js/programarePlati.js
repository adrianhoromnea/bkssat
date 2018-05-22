$(document).ready(function(){
    //**define global variables */
    var ppStatus = $('#ppStatus').text();

    //**csrf for AJAX */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //**functions */
    function getExtrase(){
        //**gets extras deppending on cont on changing Cont*/
        var idcont = $("#contBancar :selected").val();
        var date = $("#data").val();
        var baseUrl = $('#baseUrl').val();
        $.ajax({
            type:'GET',
            url: baseUrl + '/financiar/programareplati/getExtraseCont' + '/' + idcont + '/data/' + date,
            data:'_token = <?php echo csrf_token() ?>',
            dataType: 'json',
            success: function(data){
                var extrasT = $('#extrasBanca');
                extrasT.empty();
                if(data.extrase.length > 0){
                    data.extrase.forEach(
                        extras => extrasT.append("<option value='"+ extras.idExtrasBanca +"'>" 
                            + "Extras numarul ["    
                            + extras.Numar + "] "
                            + " de la "
                            + extras.DeLa.substring(0,10)
                            + " pana la "
                            + extras.PanaLa.substring(0,10)
                            + "</option>")
                    )
                }
                else{
                    extrasT.append("<option value=''>NU sunt extrase de banca</option>")
                }
            },
            error:function(){alert('EROARE! Contactati administratorul de sistem');}
        });   

        //**show btnAddExtras button */
        var contBancar = $('#contBancar').val();
        if(contBancar){
            $('#divAddExtras').removeAttr('hidden');
            
        }
        else{
            $('#divAddExtras').attr('hidden');
        }
    };

    function btnAddRemoveExtras(){
        var contBancar = $('#contBancar').val();
        if(contBancar){
            $('#divAddExtras').removeAttr('hidden');  
        }
        else{
            $('#divAddExtras').attr('hidden');
        }
    };

    function addNewExtras(){
        var baseUrl = $('#baseUrl').val();
        $.ajax({
          type: 'POST',
          url: baseUrl + '/financiar/extrasecont/create',
          data:{
            'numar':$('#numarExtras').val(),
            'data': $('#dataExtras').val(),
            'deLa': $('#deLaExtras').val(),
            'panaLa': $('#panaLaExtras').val(),
            'observatie': $('#observatieExtras').val(),
            'idContBanca':$('#contBancar').val(),
          },
          success: function(data){
            if((data.errors)){
                //**error numar 
                if(data.errors.numar){
                    setTimeout(function(){
                        $('#createExtrasModal').modal('show');
                        toastr.error('Eroare la validaree datelor!', 'Erroare', {timeOut: 2000});
                    },100);
                    $('#errorNumar').text(data.errors.numar);
                }

                //**error data 
                if(data.errors.data){
                    setTimeout(function(){
                        $('#createExtrasModal').modal('show');
                        toastr.error('Eroare la validaree datelor!', 'Erroare', {timeOut: 2000});
                    },100);
                    $('#errorData').text(data.errors.data);
                }

                //**error deLa 
                if(data.errors.deLa){
                    setTimeout(function(){
                        $('#createExtrasModal').modal('show');
                        toastr.error('Eroare la validaree datelor!', 'Erroare', {timeOut: 2000});
                    },100);
                    $('#errorDeLa').text(data.errors.deLa);
                }

                //**error deLa 
                if(data.errors.panaLa){
                    setTimeout(function(){
                        $('#createExtrasModal').modal('show');
                        toastr.error('Eroare la validaree datelor!', 'Erroare', {timeOut: 2000});
                    },100);
                    $('#errorPanaLa').text(data.errors.panaLa);
                }
            }
            else{
                //**remove previous fields 
                $('#numarExtras').val('');
                $('#observatieExtras').val('');

                //** update extras cont
                var idcont = $("#contBancar :selected").val();
                var date = $("#data").val();
                var baseUrl = $('#baseUrl').val();
                $.ajax({
                    type:'GET',
                    url: baseUrl + '/financiar/programareplati/getExtraseCont' + '/' + idcont + '/data/' + date,
                    data:'_token = <?php echo csrf_token() ?>',
                    dataType: 'json',
                    success: function(data){
                        var extrasT = $('#extrasBanca');
                        extrasT.empty();
                        if(data.extrase.length > 0){
                            data.extrase.forEach(
                                extras => extrasT.append("<option value='"+ extras.idExtrasBanca +"'>" 
                                    + "Extras numarul ["    
                                    + extras.Numar + "] "
                                    + " de la "
                                    + extras.DeLa.substring(0,10)
                                    + " pana la "
                                    + extras.PanaLa.substring(0,10)
                                    + "</option>")
                            )
                        }
                        else{
                            extrasT.append("<option value=''>NU sunt extrase de banca</option>")
                        }
                    },
                    error:function(){alert('EROARE! Contactati administratorul de sistem');}
                });       
            }
          },
          error: function(data){
              alert('Eroare! Contactati administratorul de sistem.');
          }
        })
    };

    function dataTableMethods(){
        $('#dataTable1 tbody tr').each(function(){
            //**get path */
            var baseUrl = $('#baseUrl').val();

            //**get columns values*/
            var c_id = $(this).find('td:eq(0)');
            var idRow = c_id.attr('id');
            var c_platabaza = $(this).find('td:eq(15)');

            var c_cont = $(this).find('td:eq(2)');
            var c_partener = $(this).find('td:eq(3)');
            var c_cui = $(this).find('td:eq(4)');
            var c_cont_baza = $(this).find('td:eq(5)');
            var c_cont_tva = $(this).find('td:eq(6)');
            var c_tip = $(this).find('td:eq(7)');
            var c_numar = $(this).find('td:eq(8)');
            var c_data = $(this).find('td:eq(9)');
            var c_scadenta = $(this).find('td:eq(10)');
            var c_zile = $(this).find('td:eq(11)');
            var c_sold = $(this).find('td:eq(12)');
            //var c_platabaza = $(this).find('td:eq(13)');
            var c_platatotal = $(this).find('td:eq(14)');
            var c_platatva = $(this).find('td:eq(16)');
            var c_numarop= $(this).find('td:eq(1)');
            var btn_deleteTableRow = $(this).find('#btnDeleteRow');

            //** save row data to dadabase - onclick event */
            c_platabaza.on('click',function(event){
                event.preventDefault();
                 //get values
                $.ajax({
                    type: 'GET',
                    url: baseUrl + '/financiar/programareplati/getDetaliuListaProgramari/' + idRow,
                    success: function(data){
                        //**set variables */
                        var pBaza           = data.detaliu[0].plataBaza;
                        var pTotal          = data.detaliu[0].plataTotal;
                        var pTVa            = data.detaliu[0].PlataTVA;
                        var sold            = data.detaliu[0].sold;
                        var partener        = data.detaliu[0].denumirePartener;
                        var contContabil    = data.detaliu[0].simbolCont;
                        var dataDoc         = data.detaliu[0].dataDocument;
                        var numar           = data.detaliu[0].numarDocument;
                        var scadenata       = data.detaliu[0].dataScadenta;
                        var zile            = data.detaliu[0].zileDepasite;
                        var tip             = data.detaliu[0].tipDocument;
                        var idContContabil  = data.detaliu[0].idBancaBaza;
                        var idPartener      = data.detaliu[0].idPartener;
                        var idContBaza      = data.detaliu[0].idBancaBaza;
                        var idContTva       = data.detaliu[0].idContTVA;
                        var numarOp         = data.detaliu[0].numarOp;
                        var splitTVA        = data.detaliu[0].splitTVA;
                        var idNomDocument   = data.detaliu[0].idDocument;
                    

                        if(idContBaza == 0){
                            alert('Operatiune esuata! Verifica conturile bancare partener.');
                            return;
                        }else{
                            //**update plata */
                            if(splitTVA != 'da'){
                                if(Number($(c_platabaza).text()) == 0){
                                    $(c_platabaza).text(sold);
                                    $(c_platatotal).text(
                                        Number($(c_platabaza).text()) + Number($(c_platatva).text())
                                    )
                                    $(c_platatva).text('.00');

                                    pBaza = Number(c_platabaza.text());
                                    pTotal = Number(c_platatotal.text());
                                    pTVa = Number(c_platatva.text());
                                }
                                else{
                                    $(c_platabaza).text('.00');
                                    $(c_platatotal).text('.00');
                                    $(c_platatva).text('.00');

                                    pBaza = Number(c_platabaza.text());
                                    pTotal = Number(c_platatotal.text());
                                    pTVa = Number(c_platatva.text());
                                }

                                //**update data into database */
                                $.ajax({
                                    type: 'POST',
                                    url: baseUrl + '/financiar/programareplati/updateDetaliu/' + idRow,
                                    data:{
                                        'cont_baza_id':idContBaza,
                                        'cont_tva_id':idContTva,
                                        'plataTotal':pTotal,
                                        'plataBaza':pBaza,
                                        'plataTva':pTVa,
                                        'numarOp':numarOp,
                                        'splitTva':splitTVA
                                    },
                                    success: function(data){
                                        //**sum columns */
                                        $(c_numarop).text(data.numarop);
                                        sumColumns();
                                    },
                                    error: function(){
                                        alert('Eroare - [salvare date la click]! Contactati administratorul de sistem.');
                                    }
                                }); 

                            }else{
                                if(idContTva == 0){
                                    alert('Operatiune esuata! Verifica contul TVA partener.');
                                    return;
                                }else{
                                    if(Number($(c_platabaza).text()) == 0 && Number($(c_platatva ).text()) == 0){
                                        /*
                                        $(c_platabaza).text(sold);
                                        $(c_platatotal).text(
                                            Number($(c_platabaza).text()) + Number($(c_platatva).text())
                                        )
                                        pBaza = Number(c_platabaza.text());
                                        pTotal = Number(c_platatotal.text());
                                        pTVa = Number(c_platatva.text());
                                        */
                                       $.ajax({
                                            type: 'GET',
                                            url: baseUrl + '/financiar/programareplati/getBazaTvaData',
                                            data:{
                                                'idPartener':idPartener,
                                                'idNomDocument':idNomDocument,
                                                'numarDocument':numar,
                                                'dataDocument':dataDoc
                                            },
                                            success:function(data){
                                                //alert('a mers!');
                                                var baza   = data.bazatva.baza;
                                                var tva    = data.bazatva.tva;
                                                var total  = Number(baza)+Number(tva);

                                                $(c_platabaza).text(baza);
                                                $(c_platatva).text(tva);
                                                $(c_platatotal).text(total);

                                                pBaza   = Number(c_platabaza.text());
                                                pTotal  = Number(c_platatotal.text());
                                                pTVa    = Number(c_platatva.text());

                                                //**update data into database */
                                                $.ajax({
                                                    type: 'POST',
                                                    url: baseUrl + '/financiar/programareplati/updateDetaliu/' + idRow,
                                                    data:{
                                                        'cont_baza_id':idContBaza,
                                                        'cont_tva_id':idContTva,
                                                        'plataTotal':pTotal,
                                                        'plataBaza':pBaza,
                                                        'plataTva':pTVa,
                                                        'numarOp':numarOp,
                                                        'splitTva':splitTVA
                                                    },
                                                    success: function(data){
                                                        //**sum columns */
                                                        $(c_numarop).text(data.numarop);
                                                        sumColumns();
                                                    },
                                                    error: function(){
                                                        alert('Eroare - [salvare date la click - splitTVA]! Contactati administratorul de sistem.');
                                                    }
                                                }); 
                                            },
                                            error:function(){
                                                alert('Eroare - [preluare date splitTVA]! Contactati administratorul de sistem.');
                                                return;
                                            }
                                       });
                                    }else{
                                        $(c_platabaza).text('.00');
                                        $(c_platatotal).text('.00');
                                        $(c_platatva).text('.00');

                                        pBaza = Number(c_platabaza.text());
                                        pTotal = Number(c_platatotal.text());
                                        pTVa = Number(c_platatva.text());

                                        //**update data into database */
                                        $.ajax({
                                            type: 'POST',
                                            url: baseUrl + '/financiar/programareplati/updateDetaliu/' + idRow,
                                            data:{
                                                'cont_baza_id':idContBaza,
                                                'cont_tva_id':idContTva,
                                                'plataTotal':pTotal,
                                                'plataBaza':pBaza,
                                                'plataTva':pTVa,
                                                'numarOp':numarOp,
                                                'splitTva':splitTVA
                                            },
                                            success: function(data){
                                                //**sum columns */
                                                $(c_numarop).text(data.numarop);
                                                sumColumns();
                                            },
                                            error: function(){
                                                alert('Eroare - [salvare date la click - splitTVA]! Contactati administratorul de sistem.');
                                            }
                                        }); 
                                    }
                                } //ends idContTVA != 0
                            } // ends splitTVa == da
                        }
                        
                    },
                    error: function(){
                        alert('Eroare - [aduc info linie]! Contactati administratorul de sistem. ' + idRow);
                    }
                });
            });

            //** confirmation on deleting row*/
            var cText = $(c_tip).text() + ' numarul ' + $(c_numar).text();
            var rPath =  baseUrl + '/financiar/programareplati/deleteDetaliu/' + idRow;
            btn_deleteTableRow.on('click',function(){
                deleteWarning(
                    rowId = idRow,
                    routePath = rPath,
                    frontElement = $('#dataTable1').find('[rowId=' + idRow +']').closest('tr'),
                    customText = cText);
                sumColumns();
            });

            //**change OP number */
            c_numarop.on('click',function(event){
                //**get opnUmber from database */
                $.ajax({
                    type: 'GET',
                    url: baseUrl + '/financiar/programareplati/getDetaliuListaProgramari/' + idRow,
                    success: function(data){
                        //**set variables */
                        var numarOp         = data.detaliu[0].numarOp;
                        cValue = numarOp;
                        if(cValue && cValue != '' && cValue != 0){
                            cText = 'Numar OP = ';
                            rPath =  baseUrl + '/financiar/detaliuProgramarePlati/updateNumarOpSpot/' + idRow;
                            numarNew = modifyOneValue(
                                rowId = idRow,
                                routePath = rPath,
                                frontElement = $('#dataTable1').find('[rowId=' + idRow +']').closest('tr'),
                                customText = cText,
                                dataType = 'number',
                                valueToBeChanged = cValue,
                            );
                        }

                    },
                    error:function(){
                        alert('Eroare - [aduc numar OP]! Contactati administratorul de sistem.');
                    }
                });


            });

            //**show update modal on dblclick */
            $(this).dblclick(function(){
                    //hide errors
                    $('#m_errorContBaza').text('');
                
                    //**update idModalRow */
                    $('#idModalRow').val(idRow);
                    $('#detaliuprogramareplataUpdateModal').modal('show');

                    $.ajax({
                        type: 'GET',
                        url: baseUrl + '/financiar/programareplati/getDetaliuListaProgramari/' + idRow,
                        success:function(data){
                            //**get data for modal */
                            var contContabil1 = data.detaliu[0].simbolCont;
                            var partener1 = data.detaliu[0].denumirePartener;
                            var tip1 = data.detaliu[0].tipDocument;
                            var numar1 = data.detaliu[0].numarDocument;
                            var data1 = data.detaliu[0].dataDocument;
                            var scadenta1 = data.detaliu[0].dataScadenta;
                            var zile1 = data.detaliu[0].zileDepasite;
                            var sold1 = data.detaliu[0].sold
                            var pTotal1 = data.detaliu[0].plataTotal;
                            var pBaza1= data.detaliu[0].plataBaza;
                            var pTva1 = data.detaliu[0].plataTVA;
                            var idPreluatCb = data.detaliu[0].idBancaBaza;
                            var idPreluatCTVA = data.detaliu[0].idContTVA;
                            var idPartener = data.detaliu[0].idPartener;
                            var contBazaImplicit = data.detaliu[0].Implicita;
                            var numarOp = data.detaliu[0].numarOp;
                            var splitTVA1 = data.detaliu[0].splitTVA;

                            //**initialise modal values */
                            //**static */
                            $('#m_parCont').empty();
                            $('#m_parCont').append(contContabil1);

                            $('#m_parPartener').empty();
                            $('#m_parPartener').append(partener1);

                            $('#m_parTip').empty();
                            $('#m_parTip').append('Tip: ' + tip1);

                            $('#m_parNumar').empty();
                            $('#m_parNumar').append('Numar: ' + numar1);

                            $('#m_parData').empty();
                            $('#m_parData').append('Data: ' + data1);

                            $('#m_parScadenta').empty();
                            $('#m_parScadenta').append('Scadenta: ' + scadenta1);

                            $('#m_parZile').empty();
                            $('#m_parZile').append('Zile depasire: ' + zile1);

                            $('#m_sold').empty();
                            $('#m_sold').val(Number(sold1));

                            $('#m_plataTotal').empty();
                            $('#m_plataTotal').val(Number(pTotal1));

                            $('#m_plataBaza').empty();
                            $('#m_plataBaza').val(Number(pBaza1));

                            $('#m_plataTva').empty();
                            $('#m_plataTva').val(Number(pTva1));

                            $('#m_idPartener').empty();
                            $('#m_idPartener').val(idPartener);

                            $('#m_op').empty();
                            $('#m_op').append(null == numarOp ? 'OP: ' : 'OP: ' + numarOp);
                            $('#m_op').attr('valoare',numarOp);

                            $('#m_splitTva').empty();
                            $('#m_splitTva').text(splitTVA1);

                            //**enable / disable split TVA  */
                            if(splitTVA1 == 'da'){
                                $('#m_plataTva').prop('disabled',false);
                            }else{
                                $('#m_plataTva').prop('disabled',true);
                            }

                            //**banci */
                            $.ajax({
                                type: 'GET',
                                url: baseUrl + '/financiar/programareplati/getConturiBancare/' + idPartener,
                                success:function(data){
                                    //**define needed variables */
                                    var sel='';
                                    var selTva='';
                                    var selDefaultB = '';
                                    var selDefaultTva = '';
                                    var ckB = 0;
                                    var ckTva = 0;

                                    //**add bank accounts to select inputs */
                                    //**empty select inputs */
                                    $('#m_contBaza').empty();
                                    $('#m_contTva').empty();

                                    //**add values to select inputs */
                                    data.banci.forEach(function(banca){ 
                                        if (idPreluatCb == banca.idContBanca){
                                            sel='selected'; 
                                        // selDefaultB = '';
                                            ckB = Number(ckB) + 1;
                                        }else{
                                            sel=''; 
                                        // selDefaultB='selected';
                                        }
                                        if (idPreluatCTVA == banca.idContBanca){
                                            selTva='selected'; 
                                        // selDefaultTva = '';
                                            ckTva = Number(ckTva) + 1;
                                        }else{
                                            selTva=''; 
                                        // selDefaultTva='selected';
                                        }

                                        $('#m_contBaza').append(
                                            '<option value = "' + banca.idContBanca +  '" '+ sel +'   implicita="' + banca.Implicita + '">' + banca.contBanca +  '</option>'
                                        );

                                        $('#m_contTva').append(
                                            '<option value = "' + banca.idContBanca +  '" '+ selTva +'>' + banca.contBanca +  '</option>'
                                        );  
                                    })

                                    if(ckB == 0){
                                        selDefaultB='selected';
                                        $('#m_contBaza').append('<option value="" disabled '+ selDefaultB +' >Selecteaza contul bancar - baza</option>');
                                    }

                                    if(ckTva == 0){
                                        selDefaultTva='selected';
                                        $('#m_contTva').append('<option value="" disabled ' + selDefaultTva + ' >Selecteaza contul bancar - TVA</option>');   
                                    }
                                },
                                error:function(){
                                    alert('Eroare - [aducere info conturi]! Contactati administratorul de sistem.');
                                }
                            });

                            if(contBazaImplicit == 1){
                                $('#m_ckImplicit').prop('checked',true);
                            }
                            else{
                                $('#m_ckImplicit').prop('checked',false);
                            }

                            $('#m_contBaza').on('change',function(){
                                    if($('#m_contBaza option:selected').attr('implicita') == 1){
                                        $('#m_ckImplicit').prop('checked',true)
                                    }
                                    else{
                                        $('#m_ckImplicit').prop('checked',false)
                                    }
                            
                            });

                        },
                        error: function(){
                            alert('Eroare - [aduc info modal]! Contactati administratorul de sistem.');
                        }
                    });
            });
        });
    };

    function saveModalData(){
        //**get path */
        var baseUrl = $('#baseUrl').val();
        var setContImplicit = 0;
        $('#m_ckImplicit').prop('checked') ? setContImplicit = 1 : setContImplicit = 0;
        var idNomPartener = $('#m_idPartener').val();

        //**init idRow */
        idModalRow = $('#idModalRow').val();
        $.ajax({
            type: 'POST',
            url: baseUrl + '/financiar/programareplati/updateDetaliu/' + idModalRow,
            data:{
                'cont_baza_id':$('#m_contBaza').val(),
                'cont_tva_id':$('#m_contTva').val(),
                'plataTotal':$('#m_plataTotal').val(),
                'plataBaza':$('#m_plataBaza').val(),
                'plataTva':$('#m_plataTva').val(),
                //'plataTva':0,
                'setContImplicit':setContImplicit,
                'idNomPartener':idNomPartener,
                'numarOp':$('#m_op').attr('valoare'),
                'splitTva':$('#m_splitTva').text()
            },
            success: function(data){
                if((data.errors)){
                   // alert('erori');
                    //**errorcont baza id
                    if(data.errors.cont_baza_id){
                        setTimeout(function(){
                            $('#detaliuprogramareplataUpdateModal').modal('show');
                            toastr.error('Eroare la validaree datelor!', 'Erroare', {timeOut: 2000});
                        },100);
                        $('#m_errorContBaza').text(data.errors.cont_baza_id);
                    }
                    if(data.errors.cont_tva_id){
                        setTimeout(function(){
                            $('#detaliuprogramareplataUpdateModal').modal('show');
                            toastr.error('Eroare la validaree datelor!', 'Erroare', {timeOut: 2000});
                        },100);
                        $('#m_errorContTva').text(data.errors.cont_tva_id);
                    }
                }
                else{
                    var currentRow = $('#dataTable1 tbody td').filter(function(){
                        return $(this).attr('rowId') == idModalRow;
                    }).closest('tr');

                    var cont_baza = currentRow.find('td:eq(5)');
                    var cont_tva = currentRow.find('td:eq(6)');
                    var platabaza = currentRow.find('td:eq(15)');
                    var platatotal = currentRow.find('td:eq(14)');
                    var platatva = currentRow.find('td:eq(16)');
                    var numarOp = currentRow.find('td:eq(1)');

                    cont_baza.attr('id',$('#m_contBaza :selected').val());
                    cont_baza.text($('#m_contBaza :selected').text());
                    cont_tva.attr('id',$('#m_contTva :selected').val());
                    if( cont_tva.attr('id') == 0){
                        cont_tva.text('');
                    }else{
                        cont_tva.text($('#m_contTva :selected').text());
                    }
                    platabaza.text($('#m_plataBaza').val());
                    platatotal.text($('#m_plataTotal').val());
                    platatva.text($('#m_plataTva').val());
                    numarOp.text(data.numarop);

                    //**sum columns */
                    sumColumns();
                }
                
            },
            error: function(){
               alert('Eroare - [salvare date modal]! Contactati administratorul de sistem.');
            }
        });
    };

    function sumColumns(){
        var sSold = 0;
        var sTotal = 0;
        var sBaza = 0;
        var sTva = 0;

        $('td.sSold').each(function(){
            if($(this).closest('tr').is(':visible')){
                sSold = sSold + Number($(this).text());
            }
        });

        $('td.sTotal').each(function(){
            if($(this).closest('tr').is(':visible')){
                sTotal = sTotal + Number($(this).text());
            }
        });

        $('td.sBaza').each(function(){
            if($(this).closest('tr').is(':visible')){
                sBaza = sBaza + Number($(this).text());
            }
        });

        $('td.sTva').each(function(){
            if($(this).closest('tr').is(':visible')){
                sTva = sTva + Number($(this).text());
            }
        });

        $('#stSold').val($.number(sSold,2,',',' '));
        $('#stPlataTotal').val($.number(sTotal,2,',',' '));
        $('#stPlataBaza').val($.number(sBaza,2,',',' '));
        $('#stPlataTva').val($.number(sTva,2,',',' '));
    };

   

    function checkErrors(){
        //**pp numar op - numeric */
        if(!$.isNumeric($("#startNumar").val()) && $("#startNumar").length >= 1){
            $('#ppErrorNumarOp').text('Campul trebuie sa fie numeric');
            $("#startNumar").val('');
        }else{
            $('#ppErrorNumarOp').text('');
        }
    };

    function listaProgramariMethods(){
        $('#listaProgramariTable tr').each(
            function(){
                var baseUrl = $('#baseUrl').val();
                $(this).click(function(){
                    var $id = $(this).find('td:eq(0)').attr('id');
                    document.location.href = baseUrl + '/financiar/programareplati/showUpdate/' + $id;
                });
            }
        )
    }

    function getrights(type){
            var ckInitiaza = 0;
            var ckAproba = 0;
            var arInitiaza = Array('Financiar');
            var arAproba = Array('Aprobator plati');

            for(var i = 0, len = user_roles.length;i<len;i++){
                if($.inArray(user_roles[i].name,arInitiaza) > -1){
                    ckInitiaza = ckInitiaza + 1;
                }
                if($.inArray(user_roles[i].name,arAproba) > -1){
                    ckAproba = ckAproba + 1;
                }
            }

            ckInitiaza > 0 ? ckInitiaza = 1 : ckInitiaza = 0;
            ckAproba > 0 ? ckAproba = 1 : ckAproba = 0;

            return type == 'aproba' ? ckAproba : ckInitiaza;
    }

    $("#startNumar").keyup(function(){
        checkErrors();
    });
    
    //** initializations*/
    btnAddRemoveExtras();
    listaProgramariMethods();

    //**get status */
    if(typeof user_roles != 'undefined' && typeof status_pp != 'undefined'){
        if(getrights('initiaza') == 1 && status_pp == 0){
            dataTableMethods();
        }
    }
    sumColumns();

    //**event: change cont bancar */
    $('#contBancar').on('change', function(){
        getExtrase();
    });

    //**event: change data */
    $('#data').on('change',function(){
        if($('#contBancar option:selected').val() != '' ){
            getExtrase();
        }
    });

    //**event: add new extras btn */
    $("#btnAddExtras").on("click",function(){
        addNewExtras(); 
    });

    //**event on click partener */
    $('#hPartener').on('click',function(){
        //**get idProgramarePlata */
    });

    //**search on input */
    $("#goSubtotal").on("click", function() {
        sumColumns();
    });

    $("#inputSearch").on("keyup", function() {
         var value = $(this).val().toLowerCase();

         $("#dataTable1").show();

         $("#dataTable1 tbody tr").filter(function() {
           $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
           //sumColumns();    
         });

         var x = $('#dataTable1 tr:visible').length;
         if(x <= 1){
            $("#dataTable1").hide();
         }
     });

    //**show & init create extras modal */
    $("#addExtrasCont").on("click",function(){
        $('#createExtrasModal').modal('show');
    });
    
     //**table detalliListaProgramarePlati */

    //**modal detaliuprogramareplata - misc */
        //**select all on focus/
        $('.allFocus').focus(function(){
            $(this).select();
        });

        //**sum plata total + restriction p*/
        $('#m_plataBaza').keyup(function(){
            $('#m_plataTotal').val(
                Number($(this).val()) + Number($('#m_plataTva').val()));
            
            if(Number($('#m_plataTotal').val()) > Number($('#m_sold').val())){
                alert('Suma platita nu poate depasi soldul documentului');
                $(this).val(0);
                $('#m_plataTotal').val(
                    Number($(this).val()) + Number($('#m_plataTva').val()));
            }
        });

        $('#m_plataTva').keyup(function(){
             $('#m_plataTotal').val(
                 Number($(this).val()) + Number($('#m_plataBaza').val()));

            if(Number($('#m_plataTotal').val()) > Number($('#m_sold').val())){
            alert('Suma platita nu poate depasi soldul documentului');
            $(this).val(0);
            $('#m_plataTotal').val(
                Number($(this).val()) + Number($('#m_plataBaza').val()));
            }
         });

         //**save modal data to database*/
         $('#m_btnSalveaza').click(function(){
            saveModalData();
         });
     
         //**show/hide header */
         $('#btnArataAntetLista').click(function(){
            $('#updateAntet').toggle();
         });





    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    });

