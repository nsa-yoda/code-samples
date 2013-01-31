<?php  

/*
 * Class which validates a credit card number
*/

#start off by defining several card type constants.
define("CARD_TYPE_MC", 0);  #mastercard
define("CARD_TYPE_VS", 1);  #visa
define("CARD_TYPE_AX", 2);  #american express
define("CARD_TYPE_DC", 3);  #diners club
define("CARD_TYPE_DS", 4);  #discover
define("CARD_TYPE_JC", 5);  #jcb

class CCreditCard{  
    #class members  
    var $__ccName = '';  
    var $__ccType = '';  
    var $__ccNum = '';  
    var $__ccExpM = 0;  
    var $__ccExpY = 0;
    
    function CCreditCard($name, $type, $num, $expm, $expy){
        #set member variables  
        if(!empty($name)) $this->__ccName = $name;  
        else die('Must pass name to constructor');
        
        #make sure card type is valid  
        switch(strtolower($type)){  
            case 'mc':  
            case 'mastercard':  
            case 'm':  
            case '1':  
                $this->__ccType = CARD_TYPE_MC;  
                break;  
            case 'vs':  
            case 'visa':  
            case 'v':  
            case '2':  
                $this->__ccType = CARD_TYPE_VS;  
                break;  
            case 'ax':  
            case 'american express': 
            case 'Amex': /* grrr */
            case 'aMex': 
            case 'amEx': 
            case 'ameX': 
            case 'AmEx': 
            case 'aMeX': 
            case 'amex':
            case 'a':  
            case '3':  
                $this->__ccType = CARD_TYPE_AX;  
                break;  
            case 'dc':  
            case 'diners club':  
            case '4':  
                $this->__ccType = CARD_TYPE_DC;  
                break;  
            case 'ds':  
            case 'discover':  
            case '5':  
                $this->__ccType = CARD_TYPE_DS;  
                break;  
            case 'jc':  
            case 'jcb':  
            case '6':  
                $this->__ccType = CARD_TYPE_JC;  
                break;  
            default:  
                die('Invalid type ' . $type . ' passed to constructor');  
        }
        
        #don't check the number yet, just kill all non numerics    
        if(!empty($num)){
            $cardNumber = ereg_replace("[^0-9]", "", $num);    
            
            if(!empty($cardNumber)){ #make sure the card number isnt empty 
                $this->__ccNum = $cardNumber;    
            } else {    
                die('Must pass number to constructor');    
            }    
        } else {    
            die('Must pass number to constructor');    
        }
        
        #check the month for validity
        if(!is_numeric($expm) || $expm < 1 || $expm > 12){
            die('Invalid expiry month of ' . $expm . ' passed to constructor');    
        } else {    
            $this->__ccExpM = $expm;    
        }    
   
        #get the current year    
        $currentYear = date('Y');    
        settype($currentYear, 'integer');    
        
        #check the year for validity
        if(!is_numeric($expy) || $expy < $currentYear || $expy > $currentYear + 10){
            die('Invalid expiry year of ' . $expy . ' passed to constructor');
        } else {    
            $this->__ccExpY = $expy;    
        }    
    }
    
    function Name(){    
        return $this->__ccName;    
    }    
   
    function Type(){    
        switch($this->__ccType){    
            case CARD_TYPE_MC:    
                return 'mastercard [1]';    
                break;    
            case CARD_TYPE_VS:    
                return 'Visa [2]';    
                break;    
            case CARD_TYPE_AX:    
                return 'Amex [3]';    
                 break;    
            case CARD_TYPE_DC:    
                return 'Diners Club [4]';    
                break;    
            case CARD_TYPE_DS:    
                return 'Discover [5]';    
                break;    
            case CARD_TYPE_JC:    
                return 'JCB [6]';    
                break;    
            default:    
            return 'Unknown [-1]';    
        }
    }    
   
    function Number(){return $this->__ccNum;}
   
    function ExpiryMonth(){return $this->__ccExpM;}
   
    function ExpiryYear(){return $this->__ccExpY;}
    
    function SafeNumber($char = 'x', $numToHide = 4){    
        #return only part of the number    
        if($numToHide < 4) $numToHide = 4;
        if($numToHide > 10) $numToHide = 10;
        $cardNumber = $this->__ccNum;    
        $cardNumber = substr($cardNumber, 0, strlen($cardNumber) - $numToHide);    
        for($i = 0; $i < $numToHide; $i++)$cardNumber .= $char;
        return $cardNumber;    
    }
    
     function IsValid(){
        #not valid by default    
        $validFormat = false;    
        $passCheck = false;

        #is the number in the correct format?    
        switch($this->__ccType){    
            case CARD_TYPE_MC:    
                $validFormat = ereg("^5[1-5][0-9]{14}$", $this->__ccNum);    
                break;    
            case CARD_TYPE_VS:    
                $validFormat = ereg("^4[0-9]{12}([0-9]{3})?$", $this->__ccNum);    
                break;    
            case CARD_TYPE_AX:    
                $validFormat = ereg("^3[47][0-9]{13}$", $this->__ccNum);    
                break;    
            case CARD_TYPE_DC:    
                $validFormat = ereg("^3(0[0-5]|[68][0-9])[0-9]{11}$", $this->__ccNum);    
                break;    
            case CARD_TYPE_DS:    
                $validFormat = ereg("^6011[0-9]{12}$", $this->__ccNum);    
                break;    
            case CARD_TYPE_JC:    
                $validFormat = ereg("^(3[0-9]{4}|2131|1800)[0-9]{11}$", $this->__ccNum);    
                break;    
            default:    
                #should never be executed    
                $validFormat = false;    
        }
    
        #is the number valid?      
        $cardNumber = strrev($this->__ccNum);      
        $numSum = 0;      
     
        for($i = 0; $i < strlen($cardNumber); $i++){      
            $currentNum = substr($cardNumber, $i, 1);      
     
        #double every second digit      
        if($i % 2 == 1) $currentNum *= 2;
     
        #add digits of 2-digit numbers together      
        if($currentNum > 9){
            $firstNum = $currentNum % 10;      
            $secondNum = ($currentNum - $firstNum) / 10;      
            $currentNum = $firstNum + $secondNum;      
        }
     
        $numSum += $currentNum;      
        }
        
        #if the total has no remainder it's OK      
        $passCheck = ($numSum % 10 == 0);
        
        if($validFormat && $passCheck) return true;      
        else return false; 
    }
}
