<?php
namespace App\Workarounds;

use Faker\Provider\DateTime;

//** */
class Utilities{
    private static $currentDate;
    public $selectedDate;


    public function __construct(){
       self::$currentDate = date_create();

    }

    //methods
    public static function getAnLunaC(){
        $year = self::$currentDate->format('Y');

        if(strlen(self::$currentDate->format('m')) == 1){
            $month = '0' . self::$currentDate->format('m');
        }
        else{
            $month = self::$currentDate->format('m');            
         }
         
         $yearMonth = $year . $month;
        

         //**return data*/
        return $yearMonth; 
    }

    public function getAnLuna(){
        $year = date('Y',strtotime($this->selectedDate));

        if(strlen(date('m',strtotime($this->selectedDate))) == 1){
            $month = '0' . date('m',strtotime($this->selectedDate));
        }
        else{
            $month = date('m',strtotime($this->selectedDate));            
         }
         
         $yearMonth = $year . $month;
         //**return data*/
        return $yearMonth; 
    }

    public function getDateInfo($date,$type){
        //**info */
            // y = year, m = month, d = day, ym = yearMonth
        

        switch($type){
            case 'y':
            $r = date('Y',strtotime($date));
            break;

            case 'm':
            $r = date('m',strtotime($date));
            break;

            case 'd':
            $r = date('d',strtotime($date));
            break;

            case 'ym':
            if(strlen(date('m',strtotime($date)) == 1)){
                $r = date('Y',strtotime($date)) . '0'. date('m',strtotime($date));
            }
            else{
                $r = date('Y',strtotime($date)) . date('m',strtotime($date));
            }
            break;

            case 'ymd':
            $r =  date('Y',strtotime($date)) .  date('m',strtotime($date)) .  date('d',strtotime($date));
            break;

            default:
            $r = 'error';
        }



        return $r;

    }








    
}
?>