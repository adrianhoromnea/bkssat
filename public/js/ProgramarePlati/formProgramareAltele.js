$(document).ready(function(){
    //declare constants
    const baseUrl = $('#baseUrl').val();
    
    //init form
    $('#pm_addNew_f').on('click',function(){

        $(this).prop('hidden',true);
        $('#pm_addNew').prop('hidden',true);
        $('#pm_form1').prop('hidden',false);
        initForm(baseUrl);
    });

    //add conturibancare
    $('#pm_partener1').on('change',function(){
        var id = $(this).val();
        if(id != '' && id != 0){
            getConturiBancare(baseUrl,id);
        }

    });


    //save
    $('#pm_salveaza1').on('click',function(){
        var errors = validation();
        if(errors == 0){
            save(baseUrl);
            defaultValues(baseUrl);
            getParteneri(baseUrl);
        }else{
            return;
        }
    });

   //functions
    function initForm(baseUrl){
        //default values
        defaultValues(baseUrl)

        //getparteneri
        getParteneri(baseUrl);
    };

    function defaultValues(baseUrl){
        //default values
        $('#pm_op1, #pm_explicatii1, #pm_valoare1').val('');
        $('#pm_partener1 option, #pm_contbancar option').remove();
        $('#pm_partener1').append(
            '<option value="" selected disabled>Selecteaza partenerul ...</option>'
        );
        $('#pm_contbancar').append(
            '<option value="" selected disabled>Selecteaza contul bancar ...</option>'
        );

        //remove invalid/valid classes
        $('#pm_op1, #pm_partener1, #pm_explicatii1, #pm_valoare1, #pm_contbancar').removeClass('is-invalid is-valid');

        //focus on op
        $('#pm_op1').focus();
    };

    function getParteneri(baseUrl){
        $.ajax({
            type:'get',
            url: baseUrl + '/financiar/programareplatimanual/getParteneri',
            dataType: 'json',
            success:function(data){
                data.parteneri.forEach(
                    partener=>
                        $('#pm_partener1').append('<option value="' + partener.idPartener + '">' + partener.denumire +'</option>')
                );
            },
            error:function(){
                alert('Eroare - [aduc parteneri]! Contactati administratorul de sistem.');
            }
        });
    };

    function getConturiBancare(baseUrl,id){
        $.ajax({
            type:'get',
            url: baseUrl + '/financiar/programareplatimanual/getConturiBancare/' + id,
            dataType:'json',
            success:function(data){
                $('#pm_contbancar option').remove();
                if(data.conturi.length > 0 ){
                    $.each(data.conturi,function(key,value){
                        var selected = value['implicit'] == 0 ? 'selected' : '';
                        $('#pm_contbancar').append('<option value="' + value['id'] + '" ' + selected + '>' + value['cont'] +'</option>');
                        //console.log($('#pm_contbancar option:selected').val());
                    });
                }else{
                    $('#pm_contbancar').append('<option value=""> Nu sunt conturi definite pentru acest partener</option>')
                }
            },
            error:function(){
                alert('Eroare - [aduc conturi bancare]! Contactati administratorul de sistem.');
            }

        });
    };

    function validation(){
        var errors = 0;
        //declare fields to be validated
        var op = $('#pm_op1');
        var partener = $('#pm_partener1');
        var cont = $('#pm_contbancar');
        var valoare = $('#pm_valoare1');

        //validations
        if(op.val() == '' || !$.isNumeric(op.val())){
            op.addClass('is-invalid');
            errors = Number(errors) + 1;
        }

        if(valoare.val() == '' || !$.isNumeric(valoare.val())){
            valoare.addClass('is-invalid');
            errors = Number(errors) + 1;
        }

        var partno = $('#pm_partener1 option:selected[value != ""]').length;
        if(partno == 0){
            partener.addClass('is-invalid');
            errors = Number(errors) + 1;
        }

        var contno = $('#pm_contbancar option:selected[value != ""]').length;
        if(contno == 0){
            cont.addClass('is-invalid');
            errors = Number(errors) + 1;
        }

        return errors;
    }

    function save(baseUrl){
        //get values
        var op = $('#pm_op1').val();
        var partener = $('#pm_partener1 option:selected').val();
        var cont = $('#pm_contbancar option:selected').val();
        var explicatii = $('#pm_explicatii1').val();
        var valoare = $('#pm_valoare1').val();

        //save
        $.ajax({
            type:'post',
            url:baseUrl + '/financiar/detaliippmanual/createf',
            data:{
                'programare_platas_id'  :programare_platas_id,
                'numarOp'               :op,
                'idPartener'            :partener,
                'idContBaza'            :cont,
                'descriere'             :explicatii,
                'valoare'               :valoare
            },
            success:function(data){
                var rowsno =  $('#dataTable2 tbody tr').length;
                if(rowsno>0){
                    $('#dataTable2 tbody tr:first').before(
                        '<tr><td hidden rowId="' + data.detaliualtele.id +'">' + data.detaliualtele.id +'</td>'
                        + '<td width:50px style="max-width: 100px">' + data.detaliualtele.numarOp +'</td>'
                        + '<td style="max-width: 150px">' + data.detaliualtele.partener +'</td>'
                        + '<td width:50px style="max-width: 100px" class="cont">' + data.cont +'</td>'
                        + '<td style="max-width: 300px">' + data.detaliualtele.descriere +'</td>'
                        + '<td style="max-width: 25px" class="pm_plata" valoare = "' + data.detaliualtele.valoare + '">' + data.detaliualtele.valoare +'</td>'
                        + '<td style="text-align: center" class="ck1"><div class="checkbox-inline justify-content-center align-items-center"><input type="checkbox" name="check" value="0" class="ckline1"></div></td>'
                        + '<td  style="min-width: 30px"><a href="#" style="color:red; text-decoration:none"><i class="fa fa-trash-o" title="Sterge linie" data-toogle="tooltip" id="btnDeleteRow2"></i></a></td></tr>'
                    );
                }else{
                    $('#dataTable2 tbody').append(
                        '<tr><td hidden rowId="' + data.detaliualtele.id +'">' + data.detaliualtele.id +'</td>'
                        + '<td width:50px style="max-width: 100px">' + data.detaliualtele.numarOp +'</td>'
                        + '<td style="max-width: 150px">' + data.detaliualtele.partener +'</td>'
                        + '<td width:50px style="max-width: 100px" class="cont">' + data.cont +'</td>'
                        + '<td style="max-width: 300px">' + data.detaliualtele.descriere +'</td>'
                        + '<td style="max-width: 25px" class="pm_plata" valoare = "' + data.detaliualtele.valoare + '">' + data.detaliualtele.valoare +'</td>'
                        + '<td style="text-align: center" class="ck1"><div class="checkbox-inline justify-content-center align-items-center"><input type="checkbox" name="check" value="0" class="ckline1"></div></td>'
                        + '<td  style="min-width: 30px"><a href="#" style="color:red; text-decoration:none"><i class="fa fa-trash-o" title="Sterge linie" data-toogle="tooltip" id="btnDeleteRow2"></i></a></td></tr>'
                    );
                }

                //sumCsv();
                sumColumnsItem('bazamanual',data.detaliualtele.valoare,0,'plus','1');
            },
            error:function(){
                alert('Eroare - [salvare plata manual]! Contactati administratorul de sistem.');
            }
        });

    }

    function sumCsv(){
        var sSis = 0;
        var sMan = 0;
        var sTotal = 0;

        $('#dataTable2 tr td.cont').each(function(){
            if($(this).text() != ''){
                sMan = sMan + Number($(this).closest('tr').find('td.pm_plata').text());
                //console.log('nnn');
            }
        });

        $('#dataTable1 tr td.sBaza').each(function(){
            sSis = sSis + Number($(this).text());
        });

        sTotal = sMan + sSis;

        $('#csv').text($.number(sTotal,2,',',' '));
    }

    function sumColumnsItem(type,value,valueOld,sign,csv1){
        /***types: */
        //**bazasistem,tvasistem,bazamanual,tvamanual*/
        //**csv: */
        //**0 = da, 1 = nu */
        //**sign: */
        //**plus/min */

        /*
        bazasistem;
        tvasistem;
        bazamanual;
        tvamanual;
        csvsistem;
        csvmanual;
        */

        value = sign == 'min' ? -Number(value) : Number(value);
        valueOld = sign == 'min' ? -Number(valueOld) : Number(valueOld);

        var csv = $('#csv');
        var totalsistem = $('#stPlataTotal');
        var totalmanual = $('#pm_plata_total');
        var gtotal = $('#grand_total');

        var bazasistem = $('#stPlataBaza');
        var bazamanual = $('#pm_plata_baza');
        var gbaza = $('#grand_total_baza');

        var tvasistem = $('#stPlataTva');
        var tvamanual = $('#pm_plata_tva');
        var gtva = $('#grand_total_tva');

        //console.log(tvasistem.attr('valoare') + '-' + value + '-' + valueOld);
        

        switch(type){
            case 'bazasistem':
                bazasistem.attr('valoare',Number(bazasistem.attr('valoare'))-valueOld+value);
            break;

            case 'tvasistem':
                tvasistem.attr('valoare',Number(tvasistem.attr('valoare'))-valueOld+value);
            break;

            case 'bazamanual':
                bazamanual.attr('valoare',Number(bazamanual.attr('valoare'))-valueOld+value);
            break;

            case 'tvamanual':
                tvamanual.attr('valoare',Number(tvamanual.attr('valoare'))-valueOld+value);
            break;

            default:
        };

        switch(csv1){
            case '0':

            break;

            case '1':
                var csvval = Number(csv.attr('valoare')) + value;
                csv.text($.number(csvval,2,',',' '));
            break;

            default:
        };

        gbaza.attr('valoare',Number(bazasistem.attr('valoare'))+Number(bazamanual.attr('valoare')));
        gtva.attr('valoare',Number(tvasistem.attr('valoare'))+Number(tvamanual.attr('valoare')));
        totalsistem.attr('valoare',Number(bazasistem.attr('valoare'))+Number(tvasistem.attr('valoare')));
        totalmanual.attr('valoare',Number(bazamanual.attr('valoare'))+Number(tvamanual.attr('valoare')));
        gtotal.attr('valoare',Number(totalsistem.attr('valoare'))+Number(totalmanual.attr('valoare')));

        totalsistem.val($.number(totalsistem.attr('valoare'),2,',',' '));
        totalmanual.val($.number(totalmanual.attr('valoare'),2,',',' '));
        gtotal.val($.number(gtotal.attr('valoare'),2,',',' '));
        bazasistem.val($.number(bazasistem.attr('valoare'),2,',',' '));
        bazamanual.val($.number(bazamanual.attr('valoare'),2,',',' '));
        gbaza.val($.number(gbaza.attr('valoare'),2,',',' '));
        tvasistem.val($.number(tvasistem.attr('valoare'),2,',',' '));
        tvamanual.val($.number(tvamanual.attr('valoare'),2,',',' '));
        gtva.val($.number(gtva.attr('valoare'),2,',',' '));


    };


});