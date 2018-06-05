<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
    //return view('dashboard'); //temp
});

//** routes that need authentification */
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('logout',[ 
    'uses'=>'\App\Http\Controllers\Auth\LoginController@logout',
    'as'=>'logout'
]);

//**users routes */
Route::get('register/showRegister',[
    'uses'=>'Auth\RegisterController@showRegister',
    'as'=>'showRegister'
]);

Route::post('register/createAdmin',[
    'uses'=>'Auth\RegisterController@createAdmin',
    'as'=>'createAdmin'
]);

Route::get('user/userslist',[
    'uses'=>'UsersController@index',
    'as'=>'userslist'
])->middleware('auth');

Route::get('user/showcreate',[
    'uses'=>'UsersController@showCreate',
    'as'=>'showCreateUser'
    ])->middleware('auth');

Route::post('user/create',[
    'uses'=>'UsersController@create',
    'as'=>'createUser'
    ])->middleware('auth');

Route::get('user/showupdate/{id}',[
    'uses'=>'UsersController@showUpdate',
    'as'=>'showUpdateUser'
    ])->middleware('auth');

Route::post('user/update/{id}',[
    'uses'=>'UsersController@update',
    'as'=>'updateUser'
    ])->middleware('auth');

Route::get('user/delete/{id}',[
    'uses'=>'UsersController@delete',
    'as'=>'deleteUser'
])->middleware('auth');

//**programarePLati routes */

    //**listeProgramari */
    Route::get('financiar/programareplati/listaprogramari',[
        'uses'=>'ProgramarePlatiController@getListeProgramari',
        'as'=>'listaprogramariplati'
    ])->middleware('auth');

    Route::get('financiar/programareplati/showCreate',[
        'uses'=>'ProgramarePlatiController@showCreate',
        'as'=>'showCreateListaPp'
    ])->middleware('auth');

    Route::get('financiar/programareplati/showUpdate/{id}',[
        'uses'=>'ProgramarePlatiController@showUpdate',
        'as'=>'showUpdateListaPp'
    ])->middleware('auth');

    Route::post('financiar/programareplati/create',[
        'uses'=>'ProgramarePlatiController@create',
        'as'=>'createProgramarePlati'
    ])->middleware('auth');

    Route::post('financiar/programareplati/update/{id}',[
        'uses'=>'ProgramarePlatiController@update',
        'as'=>'updateProgramarePlati'
    ])->middleware('auth');

    Route::get('financiar/programareplati/getListeProgramari',[
        'uses'=>'ProgramarePlatiController@getListeProgramari',
        'as'=>'getListeProgramari'
    ])->middleware('auth');

    //**liste solduri*/
    Route::get('financiar/programareplati/getSolduriFacturi',[
        'uses'=>'ProgramarePlatiController@getSolduriFacturi',
        'as'=>'getSolduriFacturi'
    ])->middleware('auth');

    //**extraseCont & conturi*/
    Route::get('financiar/extrasecont/showCreate',[
        'uses'=>'ExtraseContController@showCreate',
        'as'=>'extrascont.showCreate'
    ])->middleware('auth');

    Route::get('financiar/programareplati/getExtraseCont/{id}/data/{date}',[
        'uses'=>'ProgramarePlatiController@getExtraseCont',
        'as'=>'getExtraseCont'
    ])->middleware('auth');

    Route::post('financiar/extrasecont/create',[
        'uses'=>'ExtraseContController@create',
        'as'=>'extrascont.create'
    ])->middleware('auth');

    Route::get('financiar/programareplati/getConturiBancare/{id}',[
        'uses'=>'ProgramarePlatiController@getConturiBancare',
        'as'=>'detaliilista.getconturibancare'
    ])->middleware('auth');

    //**detalii liste programari */
    Route::get('financiar/programareplati/getDetaliiListaProgramari/{id}',[
        'uses'=>'ProgramarePlatiController@getDetaliiListaProgramari',
        'as'=>'programareplati.getDetaliiListaProgramari'
    ])->middleware('auth');

    Route::get('financiar/programareplati/getDetaliuListaProgramari/{id}',[
        'uses'=>'ProgramarePlatiController@getDetaliuListaProgramari',
        'as'=>'programareplati.getDetaliuListaProgramari'
    ])->middleware('auth');

    Route::post('financiar/programareplati/updateDetaliu/{id}',[
        'uses'=>'ProgramarePlatiController@updateDetaliu',
        'as'=>'detaliilista.updatedetaliu'
    ])->middleware('auth');

    Route::get('financiar/programareplati/deleteDetaliu/{id}',[
        'uses'=>'ProgramarePlatiController@deleteDetaliu',
        'as'=>'detaliilista.deleteDetaliu'
    ])->middleware('auth');

    Route::post('financiar/detaliiProgramareplati/setNumarOp/{id}',[
        'uses'=>'ProgramarePlatiController@setNumarOp',
        'as'=>'detaliilista.setNumarOp'
    ])->middleware('auth');

    Route::post('financiar/detaliuProgramarePlati/updateNumarOpSpot/{id}',[
        'uses'=>'ProgramarePlatiController@updateNumarOpSpot',
        'as'=>'detaliilista.updateNumarOpSpot'
    ])->middleware('auth');

    Route::get('financiar/detaliuProgramarePlati/updateDetaliiProgramarePlata/{id}',[
        'uses'=>'ProgramarePlatiController@updateDetaliiProgramarePlata',
        'as'=>'detaliilista.updateDetaliiProgramarePlata'
    ])->middleware('auth');

    Route::get('financiar/programareplati/getBazaTvaData',[
        'uses'=>'ProgramarePlatiController@getBazaTvaData',
        'as'=>'programareplati.getBazaTvaData'
    ])->middleware('auth');

    //**approval flow */
    Route::get('financiar/programareplati/trimiteSpreAprobare/{id}',[
        'uses'=>'ProgramarePlatiController@trimiteSpreAprobare',
        'as'=>'programareplati.trimiteSpreAprobare'
    ])->middleware('auth');

    Route::get('financiar/programareplati/aproba/{id}',[
        'uses'=>'ProgramarePlatiController@aproba',
        'as'=>'programareplati.aproba'
    ])->middleware('auth');

    Route::get('financiar/programareplati/respinge/{id}',[
        'uses'=>'ProgramarePlatiController@respinge',
        'as'=>'programareplati.respinge'
    ])->middleware('auth');

    Route::get('financiar/programareplati/reanaliza/{id}',[
        'uses'=>'ProgramarePlatiController@reanaliza',
        'as'=>'programareplati.reanaliza'
    ])->middleware('auth');

    //**genereate ERP tranzactions */
    Route::get('financiar/programareplati/genereazaPlati/{id}',[
        'uses'=>'ProgramarePlatiController@genereazaPlati',
        'as'=>'programareplati.genereazaPlati'
    ])->middleware('auth');

    //**detalii programare plata manual */
    Route::post('financiar/detaliippmanual/create',[
        'uses'=>'DetaliuProgramarePlataController@create',
        'as'=>'detaliuppm.create'
    ])->middleware('auth');

    Route::get('financiar/detaliippmanual/delete/{id}',[
        'uses'=>'DetaliuProgramarePlataController@delete',
        'as'=>'detaliuppm.delete'
    ])->middleware('auth');

    //**export */
    Route::get('financiar/programareplati/export/{id}/{type}',[
        'uses'=>'ProgramarePlatiController@export',
        'as'=>'programareplata.export'
    ])->middleware('auth');


//info anaf routes


//**tests */
Route::get('test',[
    'uses'=>'test@getDataDocument',
    'as'=>'test'
])->middleware('auth');

Route::get('test/anaf/{idProgramarePlata}',[
    'uses'=>'DateFinanteController@insertAnafData',
    'as'=>'getAnafData'
]);











//**teste */
Route::get('ajax',function(){
    return view('message');
 });
 Route::get('teste',[
     'uses'=>'ProgramarePlatiController@export',
     'as'=>'getmsg'
     
     ]);

