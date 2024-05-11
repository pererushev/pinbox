<?php
    /*
        Задача: необходимо написать скрипт преобразующий текстовое представление даты-время в ассоциативные массивы.

            Входные данные: текстовое представление даты времени работы компании. Для упрощения все вариации входных данных стандартизированы.

            Стандарт входных данных:
            деньнедели (-деньнедели) с времяначала до времязавершения, перерыв с времяначала до времязавершения
            деньнедели = пн,вт, ср, чт, пт, сб, вс
            перерыв,с,до - всегда есть эти слова

            Примеры входных данных:
            1) пн-ср с 9.00 до 20.00
            2) вт с 10:00 до 20:00
            3) пн-вс с 10.20 до 20.00, перерыв с 12:00 до 13.00

            Формат выходных данных:
            массив 1
            $wt["пн"]["begin"]="09:00"; //время обязательно 4 символа, всегда через :
            $wt["пн"]["end"]="20:00";
            массив 2
            $ww["пн"]["begin"]="12:00";
            $ww["пн"]["end"]="13:00";
    */

   function toArray(string $s){

    $wt = array(); //Work time
    $ww = array(); //Break time
    $dw = ["пн", "вт", "ср", "чт", "пт", "сб", "вс"]; //Days of week

    $sdata = explode(" ", $s);

    foreach($sdata as &$el){
            $el = str_replace('.', ':', $el);
    }

    if (!str_contains($sdata[0], '-')){
        $wt[$sdata[0]]["begin"] = $sdata[2];
        $wt[$sdata[0]]["end"] = $sdata[4];
        if (str_contains($sdata[4], ',')){
            $ww[$sdata[0]]["begin"] = $sdata[7];
            $ww[$sdata[0]]["end"] = $sdata[9];
            $wt[$sdata[0]]["end"] = rtrim($wt[$sdata[0]]["end"], ',');
        }
    } else {
        $begin = mb_substr($sdata[0], 0, 2);
        $end = mb_substr($sdata[0], -2);
        for ($i = array_flip($dw)[$begin]; $i <= array_flip($dw)[$end]; $i++){
            $wt[$dw[$i]]["begin"] = $sdata[2];
            $wt[$dw[$i]]["end"] = $sdata[4];
            if (str_contains($sdata[4], ',')){
                $ww[$dw[$i]]["begin"] = $sdata[7];
                $ww[$dw[$i]]["end"] = $sdata[9];
                $wt[$dw[$i]]["end"] = rtrim($wt[$dw[$i]]["end"], ',');
            }
        }
    }
    if(!empty($ww)){
        return array('wt' => $wt, 'ww' => $ww);
    } else {
        return $wt;
    }
    
   }

   var_dump(toArray($argv[1]));
   
   