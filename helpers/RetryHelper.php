<?php

class RetryHelper{
    /*================ Helper method to make a retry when method execution fail ================*/
    public static function RetryOnException($times, $delay_in_seconds, $operation){
        $attempts = 0;
        do {
            try {
                $attempts++;
                $operation();
                break;
            }
            catch (Exception $e) {
                if ($attempts === $times)
                    break;
                sleep($delay_in_seconds);
            }
        } while (true);
    }

    public static function RetryOnExceptionWithReturn($times, $delay_in_seconds, $operation){
        $attempts = 0;
        $value = null;
        do {
            try {
                $attempts++;
                $value = $operation();
                break;
            }
            catch (Exception $e) {
                if ($attempts === $times)
                    break;
                sleep($delay_in_seconds);
            }
        } while (true);
        return $value;
    }    
}