<?php 

$no = 1;
foreach ($investasi as $a) {

    $no_2 = $no +1;
    foreach ($tahun as $b) {

        $no_3 = $no_2 +1;
        foreach ($aktiva as $c) {
            
            $no_4 = $no_3 +1;
            foreach ($rkap as $d) {

                $no_5 = $no_4 +1;
                foreach ($subpro as $e) {

                    $no_6 = $no_5 +1;
                    foreach ($addendum as $f) {
                        $no_6++;
                    }
                    $no_5++
                }

                $no_4 = $no_5 ++
            }

            $no_3 = $no_4 ++;
        }

        $no_2 = $no_3 ++;
    }

    $no = $no_2 ++;
}

 ?>