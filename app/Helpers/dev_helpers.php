<?php

if (!function_exists('print_pre')) {
    /**
     *
     *
     * @param  array $array
     * @param bool $exit
     * @param null $__FILE__
     * @param null $__LINE__
     * @param null $__METHOD__
     * @return void
     */
    function print_pre($array, $exit = false, $__FILE__ = NULL, $__LINE__ = NULL, $__METHOD__ = NULL)
    {
        echo "<pre>";
        echo $__FILE__ . '<br>';
        if (is_array($array)) {
            echo "<hr>";
            echo "Records \t:" . (count($array, 0));
            echo "<br>";
            echo "Data \t\t:" . (count($array, 1));

            echo "<hr>";
        } else {
            strlen($array);
        }
        print_r($array);
        echo $__FILE__ . '<br>';
        echo $__LINE__ . '<br>';
        echo $__METHOD__ . '<br>';


        if ($exit) {
            exit("</pre>");
        } else {
            echo "</pre>";
        }
    }
}

if (!function_exists('format_amount')) {
    function format_amount($amount)
    {
        return number_format((float)$amount, 2, '.', '');
    }
}

if (!function_exists('get_currency')) {
    function get_currency()
    {
        return 'KSH';
    }
}


if (!function_exists('format_date')) {
    function format_date($date)
    {
        if($date){
            return \Carbon\Carbon::parse($date)->format('d-M-Y');
        }
        //return date("d-M-Y", strtotime($date));
    }
}



if (!function_exists('display_date_format_and_time')) {
    function display_date_format_and_time($date)
    {
     
        if($date){
             return \Carbon\Carbon::parse($date)->format('d-M-Y h:m:s A');
        }
      
    }
}


if (!function_exists('display_date_format')) {
    function display_date_format($date)
    {
        //return "hello";
        if($date){
             return \Carbon\Carbon::parse($date)->format('d-M-Y');
        }
        //return date("j-M-Y", strtotime($date));
    }
}


if (!function_exists('calculate_bill_through')) {
    function calculate_bill_through($date)
    {
        return $date;
    }
}


