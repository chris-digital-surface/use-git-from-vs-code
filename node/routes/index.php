<?php


/**
 * G�n�rateur de nombres al�atoires utilisant l'algorithme SHA1 sur lui-m�me.
 *
 * @param $int_minimum - integer - intevale
 * @param $int_maximum - integer - intevale
 * @return int - retourne un entier al�atoire dans l'intervale demand� ou un int sinon.
 */
function sha_rand($int_minimum = NULL, $int_maximum = NULL)
{
    // On g�n�re une seed.
    static $arr_raw_nombre, $int_index;
    if (!$arr_raw_nombre) {
        $arr_raw_nombre = sha1(uniqid(mt_rand(), TRUE) . microtime() . mt_rand(), TRUE);
        $int_index      = 0;
    }
    // On reg�n�re le hash que l'on applique � lui-m�me.
    if ($int_index == 5) {
        // Le sha1 renvoie 160 bits soit 5 mots de 32 bits.
        $arr_raw_nombre  = sha1($arr_raw_nombre, TRUE);
        $int_index       = 0;
    }
    // On extrait une valeur (al�atoire) du hash.
    $int_valeur_aleatoire = substr($arr_raw_nombre, 4 * $int_index, 4);
    $int_valeur_aleatoire = unpack('L', $int_valeur_aleatoire);
    $int_valeur_aleatoire = reset($int_valeur_aleatoire);
    $int_index++;
    // On g�re l'intervale demand�.
    if (!is_null($int_minimum) && !is_null($int_maximum)) {
        if ($int_minimum <= $int_maximum) {
            $int_valeur_aleatoire = $int_minimum + abs($int_valeur_aleatoire) % abs($int_maximum - $int_minimum + 1);
        }
    }

    return $int_valeur_aleatoire;
}


$arr_int_nombre = array();
foreach (range(1, 5) as $z) {
    do {
        $int_nombre = sha_rand(1, 49);
    } while (in_array($int_nombre, $arr_int_nombre));
    $arr_int_nombre[] = $int_nombre;
}
sort($arr_int_nombre, SORT_NUMERIC);

echo '<table style="font-family:monospace"><tr>';
foreach ($arr_int_nombre as $int_nombre) {
    $int_nombre = str_pad($int_nombre, 3, ' ', STR_PAD_LEFT);
    $int_nombre = str_replace(' ', '&nbsp;', $int_nombre);
    echo '<td>' . $int_nombre . '</td>';
}
$int_nombre = sha_rand(1, 10);
$int_nombre = str_pad($int_nombre, 5, ' ', STR_PAD_LEFT);
$int_nombre = str_replace(' ', '&nbsp;', $int_nombre);
echo '<td><b>' . $int_nombre . '</d></td>';

echo '</tr></table>';

echo '<hr />';
highlight_file(__FILE__);
