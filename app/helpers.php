<?php 

function getPrice($price){
  $price=floatval($price);
   $price=($price*1000);
   $price=$price/550;
  return  number_format($price,2,'.','');
}

function textFormat($string){
$pieces = explode(" ", $string);
$a=count($pieces);
if($a<15){
for ($i=0;$i<$a;$i++){
   echo $valeur=" ".$pieces[$i];
  }

}
 else if($a>15 ){
 for ($i=0;$i<15;$i++){
   echo $valeur=" ".$pieces[$i];
  }
 

}
}