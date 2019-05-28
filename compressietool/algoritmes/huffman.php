<?php
/**
 * Created by Lennert Bontinck.
 * Date: 2019-05
 */

function huffman_encode($input)
{
    $originele_input = $input;
    $input_voor_karakters_bepaling = $input;
    $karakters = array();

    //zolang $input_voor_karakters_bepaling een (eerste) karakter bevat
    while (isset($input_voor_karakters_bepaling[0])) {
        //voeg eerste karakter toe aan de karakters array en tel alle voorkomens in $input_voor_karakters_bepaling
        $karakters[] = array(substr_count($input_voor_karakters_bepaling, $input_voor_karakters_bepaling[0]), $input_voor_karakters_bepaling[0]);
        //verwijder alle voorkomens van net toegevoegd karakter in $input_voor_karakters_bepaling
        $input_voor_karakters_bepaling = str_replace($input_voor_karakters_bepaling[0], '', $input_voor_karakters_bepaling);
    }

    //maak een boom van nodes met karakters en voorkomen en zet diegene met minste voorkomens eerst
    $huffman_bomen = $karakters;
    sort($huffman_bomen);

    //zolang er meerdere bomen zijn zet je de met minste voorkomens samen (bovenste in array door sort)
    while (count($huffman_bomen) > 1) {
        $row1 = array_shift($huffman_bomen);
        $row2 = array_shift($huffman_bomen);
        $huffman_bomen[] = array($row1[0] + $row2[0], array($row1, $row2));
        sort($huffman_bomen);
    }

    // op een recursieve manier de lookup table aanmaken. een gedeelde lookup table doorheen de functies gebruiken
    $lookup_table = [];
    recursive_huffman_lookup_table_generator($lookup_table, is_array($huffman_bomen[0][1]) ? $huffman_bomen[0][1] : $huffman_bomen);

    // De $originele_input encoderen door het karakter op te zoeken in de lookup table en de bijhorende bits toe te voegen aan de $ouput string
    $output = '';
    for ($i = 0; $i < strlen($originele_input); $i++) {
        $output .= $lookup_table[$originele_input[$i]];
    }

    return [$output, $lookup_table];
}

// zolang een karakter een array is verder gaan in die array waarbij stap naar 'links' 0 wordt en elke stap naar 'rechts' 1
function recursive_huffman_lookup_table_generator(&$lookup_table, $karakter, $pad_naar_karakter = '')
{
    if (!is_array($karakter[0][1])) {
        $lookup_table[$karakter[0][1]] = $pad_naar_karakter . '0';
    } else {
        recursive_huffman_lookup_table_generator($lookup_table, $karakter[0][1], $pad_naar_karakter . '0');
    }
    if (isset($karakter[1])) {
        if (!is_array($karakter[1][1])) {
            $lookup_table[$karakter[1][1]] = $pad_naar_karakter . '1';
        } else {
            recursive_huffman_lookup_table_generator($lookup_table, $karakter[1][1], $pad_naar_karakter . '1');
        }
    }
}

function huffman_decode($input, $lookup_table)
{
    $lookup_table = (array) $lookup_table;
    $input_array = str_split($input);
    $huidige_bit_stream = "";
    $output = "";

    //voor elke bit in de inputstream
    foreach ($input_array as $bit) {
        //huidige bit toevoegen aan de bit stream
        $huidige_bit_stream .= $bit;
        foreach ($lookup_table as $lookup_table_karakter=>$lookup_table_prefix_code) {
            //staat in lookup table
            if ($lookup_table_prefix_code === $huidige_bit_stream) {
                // in output zetten
                $output .= $lookup_table_karakter;
                //huidge bit stream opnieuw starten
                $huidige_bit_stream = "";
                break;
            }
        }
    }

    return $output;
}