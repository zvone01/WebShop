<?php

$brojljudipojelu = array("4", "3", "2", "1");
$brojLjudi = 10;
$trenutacni = 0;
$sljedeci = 0;
$sljedeciuNizu = 0;
$trenutacniBrojLjudi = 0;
$kombo = array();
$komboBest = array();
$najblizaKombinacija = 100;
rsort($brojljudipojelu);


while($trenutacni < count($brojljudipojelu))
{
    if($brojljudipojelu[$trenutacni] > $brojLjudi)
    {
                array_push( $komboBest,$brojljudipojelu[$trenutacni]);
                $najblizaKombinacija = $brojljudipojelu[$trenutacni] - $brojLjudi;
                
                $sljedeciuNizu += 1;
                $sljedeci = $sljedeciuNizu;
                $trenutacni =  $sljedeciuNizu;

    }

    else
    {

        if ($brojLjudi == $trenutacniBrojLjudi)
        {   
            print_r($kombo);
            echo "<br>";

            if(count($komboBest) == 0 || $najblizaKombinacija != 0 || count($komboBest) > count($kombo) )
            {
                unset($komboBest);
                $komboBest = array();
                $najblizaKombinacija = 0;
                foreach ($kombo as $result) {
                     array_push($komboBest, $result);                
                 } 
    
            }

            unset($kombo);
            $kombo = array();
            array_push($kombo,$brojljudipojelu[$sljedeciuNizu]);
    
            $trenutacniBrojLjudi =  $brojljudipojelu[$sljedeciuNizu];
            
            $sljedeci += 1;
            $trenutacni = $sljedeci;
           

            if($trenutacni >  count($brojljudipojelu) - 1)
            { 
                if( $sljedeciuNizu + 1 > count($brojljudipojelu) - 1)
                {
                    print_r($komboBest );
                    exit;
                    //// Ovaj je najbolji
                    
                }
                $sljedeciuNizu += 1;
                $sljedeci = 0;
                $trenutacni =  $sljedeciuNizu;
    
                unset($kombo);
                $kombo = array();
                array_push($kombo,$brojljudipojelu[$sljedeciuNizu]);
        
                $trenutacniBrojLjudi =  $brojljudipojelu[$sljedeciuNizu];
            }        
        }
        elseif ($brojLjudi >= $trenutacniBrojLjudi + $brojljudipojelu[$trenutacni])
        {
            $trenutacniBrojLjudi =  $trenutacniBrojLjudi + $brojljudipojelu[$trenutacni];
            array_push($kombo,$brojljudipojelu[$trenutacni]);
        }
    
        else
        {

            if(count($komboBest) == 0 || $najblizaKombinacija > ($trenutacniBrojLjudi + $brojljudipojelu[$trenutacni]) - $brojLjudi && count($komboBest) > count($kombo) )
            {
                unset($komboBest);
                $komboBest = array();
                
                foreach ($kombo as $result) {
                     array_push($komboBest, $result);

                 } 

                 array_push($komboBest,$brojljudipojelu[$trenutacni]);

                 $najblizaKombinacija =  ($trenutacniBrojLjudi + $brojljudipojelu[$trenutacni]) - $brojLjudi;;
    
                 print_r($komboBest);
            }

            $trenutacni += 1;


        }

    }

}


?>