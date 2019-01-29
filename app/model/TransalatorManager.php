<?php
/**
 * Created by PhpStorm.
 * User: Programovani
 * Date: 29.1.2019
 * Time: 11:12
 */

namespace App\Model;

use Nette,
    Nette\Utils\Validators,
    Nette\Utils\Strings,
    Nette\Utils\Arrays;


class TransalatorManager {

    private $transalateText = '',
            $searchText = '',
            $consonants = ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'z'],
            $vowels = ['a', 'e', 'i', 'o', 'u', 'y'],
            $foundConstants = [],
            $additional = 'ay';


    public function setText(string $transalateText){
        $this->transalateText = $this->controllText($transalateText);
    }

    public function getText(){

        if($this->translateOperation($this->transalateText)){
            $this->saveOperation();
        }

        return $this->transalateText;
    }

    private function controllText(string $transalateText){
        if(!Validators::isNone($transalateText) && Validators::is($transalateText, 'string:1..50')){
            return($transalateText);
        }else{
            return('validator error');
        }
    }

    private function translateOperation(string $translateText){
        $countText = Strings::length($translateText);

        //projdu každé slovíčko zvlášt
        for($n=0; $n<$countText; $n++){

            //projdu pole napevno daných souhlásek
            foreach ($this->consonants as $key => $consonant) {

                //pokud písmeno souhlasí se souhláskou
                if($translateText[$n] === $consonant){
                    $this->searchText .=  $translateText[$n];
                    $m = $n + 1;
                    $this->transalateText = (substr($translateText,$m,$countText));
                    break;
                }else{
                    $key++;
                    if(count($this->consonants) == $key){
                        //projdeme zda se nenachází samohláska
                        if (in_array($translateText[$n], $this->vowels) && $this->searchText == ''){
                            $random = array_rand($this->consonants, 1);
                            $this->searchText = $this->consonants[$random];
                        }
                        break 2;
                    }
                }

            }

        }
        return true;
    }


    private function saveOperation(){
            $this->transalateText = (''.$this->transalateText.'-'.$this->searchText.''.$this->additional.'');
    }
}