<?php
class CodiceFiscale{
    /**
     * Array delle consonanti
     */
    private $_consonanti = array(
        'B', 'C', 'D', 'F', 'G', 'H', 'J', 'K',
        'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T',
        'V', 'W', 'X', 'Y', 'Z'
    );
    /**
     * Array delle vocali
     */
    private $_vocali = array(
        'A', 'E', 'I', 'O', 'U'
    );
    /**
     * Array per il calcolo della lettera del mese
     * Al numero del mese corrisponde una lettera
     */
    private $_mesi = array( 
        1  => 'A',  2 => 'B',  3 => 'C',  4 => 'D',  5 => 'E',  
        6  => 'H',  7 => 'L',  8 => 'M',  9 => 'P', 10 => 'R', 
        11 => 'S', 12 => 'T'
    );

    private $_pari = array(
        '0' =>  0, '1' =>  1, '2' =>  2, '3' =>  3, '4' =>  4, 
        '5' =>  5, '6' =>  6, '7' =>  7, '8' =>  8, '9' =>  9,
        'A' =>  0, 'B' =>  1, 'C' =>  2, 'D' =>  3, 'E' =>  4, 
        'F' =>  5, 'G' =>  6, 'H' =>  7, 'I' =>  8, 'J' =>  9,
        'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13, 'O' => 14, 
        'P' => 15, 'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19,
        'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23, 'Y' => 24, 
        'Z' => 25
    );

    private $_dispari = array(  
        '0' =>  1, '1' =>  0, '2' =>  5, '3' =>  7, '4' =>  9,
        '5' => 13, '6' => 15, '7' => 17, '8' => 19, '9' => 21,
        'A' =>  1, 'B' =>  0, 'C' =>  5, 'D' =>  7, 'E' =>  9, 
        'F' => 13, 'G' => 15, 'H' => 17, 'I' => 19, 'J' => 21,
        'K' =>  2, 'L' =>  4, 'M' => 18, 'N' => 20, 'O' => 11, 
        'P' =>  3, 'Q' =>  6, 'R' =>  8, 'S' => 12, 'T' => 14,
        'U' => 16, 'V' => 10, 'W' => 22, 'X' => 25, 'Y' => 24, 
        'Z' => 23
    );

    private $_controllo = array( 
        '0'  => 'A', '1'  => 'B', '2'  => 'C', '3'  => 'D', 
        '4'  => 'E', '5'  => 'F', '6'  => 'G', '7'  => 'H', 
        '8'  => 'I', '9'  => 'J', '10' => 'K', '11' => 'L', 
        '12' => 'M', '13' => 'N', '14' => 'O', '15' => 'P', 
        '16' => 'Q', '17' => 'R', '18' => 'S', '19' => 'T',
        '20' => 'U', '21' => 'V', '22' => 'W', '23' => 'X', 
        '24' => 'Y', '25' => 'Z'
    );    
    /*
     * Trasforma la stringa passata in un array di lettere
     * e lo incrocia con un ulteriore array 
     */
    public function _getLettere($string, array $haystack) { 
        $letters = array();
        foreach(str_split($string) as $needle) {
            if (in_array($needle, $haystack)) {
                $letters[] = $needle;
            }
        }
        return $letters;
    }

    /**
     * Ritorna un array con le vocali di una data stringa
     */
    public function _getVocali($string) {
        return $this->_getLettere($string, $this->_vocali);
    }
    /**
     * Ritorna un array con le consonanti di una data stringa
     */
    public function _getConsonanti($string) {
        return $this->_getLettere($string, $this->_consonanti);
    }
    /**
     * Pulisce la stringa filtrando tutti i caratteri che
     * non sono lettere. Lo switch $toupper se impostato a TRUE
     * converte la stringa risultante in MAIUSCOLO.
     */
    public function _sanitize($string, $toupper = true) {
        $result = preg_replace('/[^A-Za-z]*/', '', $string);
        return ($toupper) ? strtoupper($result) : $result;
    }
    /**
     * Se la stringa passata a funzione e' costituita
     * da meno di 3 caratteri, rimpiazza le lettere
     * mancanti con la lettera X.
     */
    public function _addMissingX($string) {
        $code = $string;
        while(strlen($code) < 3) {
            $code .= 'X';
        }    
        return $code;
    }
    /**
     * Ottiene il codice identificativo del nome
     */
    public function genFromNome($string) {
        $code = "";
        $nome = $this->_sanitize($string);

        // Se il nome inserito e' piu' corto di 3 lettere
        // si aggiungono tante X quanti sono i caratteri
        // mancanti.
        if (strlen($nome) < 3) {
            return $this->_addMissingX($nome);
        } 
        
        $nome_cons = $this->_getConsonanti($nome);

        // Se le consonanti contenute nel nome sono minori 
        // o uguali a 3 vengono considerate nell'ordine in cui
        // compaiono.
        if (count($nome_cons) <= 3) {
            $code = implode('', $nome_cons);
        } else {
            // Se invece abbiamo almeno 4 consonanti, prendiamo
            // la prima, la terza e la quarta.
            for($i=0; $i<4; $i++) {
                if ($i == 1) continue;
                if (!empty($nome_cons[$i])) {
                    $code .= $nome_cons[$i];
                }
            }
        }
        // Se compaiono meno di 3 consonanti nel nome, si
        // utilizzano le vocali, nell'ordine in cui compaiono
        // nel nome.
        if (strlen($code) < 3) {
            $nome_voc = $this->_getVocali($nome);
            while (strlen($code) < 3) {
               $code .= array_shift($nome_voc); 
            }
        }
        
        return $code;
    }

    public function genFromCognome($string) {
        $code = "";
        $cognome = $this->_sanitize($string);
    
        // Se il cognome inserito e' piu' corto di 3 lettere
        // si aggiungono tante X quanti sono i caratteri
        // mancanti.
        if (strlen($cognome) < 3) {
            return $this->_addMissingX($cognome);
        }

        $cognome_cons = $this->_getConsonanti($cognome);
        
        // Per il calcolo del cognome si prendono le prime
        // 3 consonanti. 
        for ($i=0; $i<3; $i++) {
            if (array_key_exists($i, $cognome_cons)) {
                $code .= $cognome_cons[$i];
            }
        }

        // Se le consonanti non bastano, vengono prese
        // le vocali nell'ordine in cui compaiono.
        if (strlen($code) < 3) {
            $cognome_voc = $this->_getVocali($cognome);
            while (strlen($code) < 3) {
                $code .= array_shift($cognome_voc);
            }
        }

        return $code;   
    }

    /**
     * Ritorna la parte di codice fiscale corrispondente
     * alla data di nascita del soggetto (Forma: AAMGG)
     */
    public function genFromDataNascita($giorno,$mese,$anno,$sesso) {
        // Le ultime due cifre dell'anno di nascita
        $aa = substr($anno, -2);
        
        // La lettera corrispondente al mese di nascita
        $mm = $this->_mesi[$mese];

        // Il giorno viene calcolato a seconda del sesso
        // del soggetto di cui si calcola il codice:
        // se e' Maschio si mette il giorno reale, se e' 
        // Femmina viene aggiungo 40 a questo numero.
        $gg = (strtoupper($sesso) == 'M') ? $giorno : ($giorno + 40);
        if (strlen($gg) < 2) $gg = '0' . $gg;
        return $aa . $mm . $gg;        
    }
    /**
     * Ritorna la cifra di controllo sulla base dei
     * 15 caratteri del codice fiscale calcolati.
     */
    public function _calcolaCifraControllo($codice) {
        $code = str_split($codice);
        $sum  = 0;

        for($i=1; $i <= count($code); $i++) {
            $cifra = $code[$i-1];
            $sum += ($i % 2) ? $this->_dispari[$cifra] : $this->_pari[$cifra];
        }

        $sum %= 26;

        return $this->_controllo[$sum];
    }
}
?>