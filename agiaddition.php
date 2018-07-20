<?php
/**
 * phpagiaddition.php : PHP AGI Adition Functions for Asterisk
 * @see https://github.com/UndeXProject/phpagiadition
 *
 *
 * Copyright (c) 2018 Bogdan Volodin <undex.project@gmail.com>
 * All Rights Reserved.
 *
 * This software is released under the terms of the GNU Lesser General Public License v2.1
 * A copy of which is available from http://www.gnu.org/copyleft/lesser.html
 *
 *
 * Written for PHP 5.3.x, should work with older PHP 5.x versions.
 *
 * Please submit bug reports, patches, etc to https://github.com/UndeXProject/phpagiadition
 *
 *
 * @package phpAGIAdition
 * @version 1.22
 */


class AGIAddition{
    private $agi;
    private $language;
    public $resp;
    var $time;

    function __construct($agi,$lang = "ru"){
        $this->language=$lang;
        $this->agi=$agi;
        $this->agi->verbose("[AGI Adition][".date('H:i:s')."] - module was loaded. Use language: ".mb_strtoupper($lang));
    }

    function GenerateNumArray($phone,$cute = array()){
        $tel = str_replace($cute,"",$phone);
        if(preg_match('/^([0-9]{7})$/',$tel,$mt)) $tel = $mt[1];
        if(preg_match('/^62([0-9]{7})$/',$tel,$mt)) $tel = $mt[1];
        if(preg_match('/^64([0-9]{7})$/',$tel,$mt)) $tel = $mt[1];

        preg_match("/([0-9])([0-9])([0-9])([0-9])([0-9])([0-9])([0-9])/",$tel,$m);

        $t1=intval($m[2].$m[3]);
        $t2=intval($m[4].$m[5]);
        $t3=intval($m[6].$m[7]);

        $arr[] = $m[1]."00";
        if($t1<20){
            if($m[2]=="0"){
				$arr[] = "0";
				$arr[] = $m[3];
			}else{
				$arr[] = $t1;
			}
        }else{
			$arr[] = $m[2]."0";
			if($m[3]!="0") $arr[] = $m[3];
        }

        if($t2<20){
			if($m[4]=="0"){
				$arr[] = "0";
				$arr[] = $m[5];
			}else{
				$arr[] = $t2;
			}
        }else{
			$arr[] = $m[4]."0";
			if($m[5]!="0") $arr[] = $m[5];
        }

        if($t3<20){
            if($m[6]=="0"){
				$arr[] = "0";
				$arr[] = $m[7];
			}else{
				$arr[] = $t3;
			}
        }else{
            $arr[] = $m[6]."0";
			if($m[7]!="0") $arr[] = $m[7];
        }

        return $arr;
    }

    function SayPhone($phone,$cute=array()){
        $arr = $this->GenerateNumArray($phone,$cute);
		$this->agi->verbose(implode("|",$arr));
        foreach($arr as $k){
            $this->agi->stream_file("{$this->language}/digits/".$k);
            $this->agi->verbose("[AGI Adition][".date('H:i:s')."] - Say: {$k}");
        }
    }

    function NormalizePhone($num,$code="062",$cute=array()){
        $num = str_replace($cute,"",$num);
        $tel = false;
        if(preg_match('/^([0-9]{7})$/',$num)) $tel = $code.$num;
        if(preg_match('/^62([0-9]{7})$/',$num)) $tel = "0".$num;
        if(preg_match('/^64([0-9]{7})$/',$num)) $tel = "0".$num;
        if(preg_match('/^71([0-9]{7})$/',$num)) $tel = "0".$num;
        return $tel;
    }
}
?>
