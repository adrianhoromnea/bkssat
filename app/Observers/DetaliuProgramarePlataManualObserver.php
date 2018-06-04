<?php

namespace App\Observers;

use App\DetaliuProgramarePlataManual;
use Auth;

class DetaliuProgramarePlataManualObserver {
    public function creating(DetaliuProgramarePlataManual $dppm){
        $dppm->created_by = Auth::user()->id;
        $dppm->updated_by = Auth::user()->id;
    }






}



