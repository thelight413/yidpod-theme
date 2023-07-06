<?php 
// time duration

function timeDurationFormat($duration){

	$myArray = explode(":",$duration);
	$length = count($myArray);

    if($length == 1){
       $duration1 = ((int)($duration/60));
       $duration2  = ($duration%60);
       return $duration1.":".$duration2;
    }
    
     if($length == 3 && strpos($duration, '::') !== true)
     {
       $time1 = $myArray[0];
       $time2 = $myArray[1];
       $time3 = $time1 * 60;
       $time4 = $time3 + $time2;

       $duration = $time4.":".$myArray[2];
       $duration = str_replace(":0",":",$duration);
     }


     if($length == 2 && ($myArray[1] == "" || $myArray[1] == "00")){
       $time1 = $myArray[0];      
       $duration = $time1.":0";
     }elseif($length == 2 && ($myArray[1] != "" || $myArray[1] != "00"))
     {
     
		$time1 = $myArray[0];
		$time2 = $myArray[1];

		$duration = $time1.":".$time2;

		if($time2.length > 1)
		$duration = str_replace(":0",":",$duration);
       
     }
     
     return $duration;
     
   }

// day and time difference common function

function dayDifference($date2){

    $date1 = date("m/d/Y");
    $date1 = date_create($date1);
    $date2 = date_create($date2);
    $diff1 = date_diff($date1,$date2);
    $daysdiff = $diff1->format("%R%a");
    $diffDays = abs($daysdiff);
    
    $dmy_text = "";
    if($diffDays > 0 && $diffDays < 31){
            $dmy_text = $diffDays." days ago";
          }
     else if($diffDays > 0 && $diffDays < 365 && $diffDays > 31){
    
           $divide = $diffDays/30; 
            $dmy_text = round($divide)." month ago";
    
          }
      else if($diffDays > 0 &&  $diffDays > 365){
            $divide = $diffDays/365; 
            $dmy_text = round($divide)." year ago";
          }
      else{
    
              $interval = $date1->diff($date2);
            $hrs = $interval->format('%h');
            $mnt = $interval->format('%i');
            $dmy_text_new  = "";
             if($hrs > 0){
              $dmy_text_new = $hrs." hours";
              }
              else if($mnt > 0 && $hrs == 0){
                 $dmy_text_new = $mnt." minutes";
              }else{
                  $dmy_text_new = $interval->format('%s')." seconds";
              }
            $dmy_text = $dmy_text_new." ago";
          }
    
    return $dmy_text;
    
    }


    function RemoveSpecialChar($str)
    {
        $res = preg_replace('/[\@\.\;\""()]+/', '', $str);
        $res = str_replace("'","",$res);
        return $res;
    }
    function setTimeDuration($duration){

		$check = strpos($duration, ':');

			if($check){
			$strlength = strlen($duration);
			if($strlength < 5)
			$time = substr($value->duration, 0, 2).":".substr($duration, 2, 3);	     
			else
			$time = $duration;
			}
			else
			{
			$time1 = $duration/60;
			$time1 = (int)$time1;
			$time2 = $duration%60;
			$time = $time1.":".$time2;

			}

		return $time;      

}