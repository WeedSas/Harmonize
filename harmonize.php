<?php
// Enregistrement des variables correspondantes aux notes, aux modes, et aux intervalles
$tabChroma = array('Do','Do#','Réb','Ré','Ré#','Mib','Mi','Fa','Fa#','Solb','Sol','Sol#','Lab','La','La#','Sib','Si');
$tabNote = array('Do', 'Ré', 'Mi', 'Fa', 'Sol', 'La', 'Si');
$tabMode = array("Ionien", "Dorien", "Phrygien", "Lydien", "Mixolydien", "Aeolien", "Locrien");
$intervalles = array(2, 2, 1, 2, 2, 2, 1);
$tabIntervalles = array(
    'T' => 0,
    'b2' => 1,
    'M2' => 2,
    'b3' => 3,
    'M3' => 4,
    'P4' => 5,
    'Triton' => 6,
    'P5' => 7,
    'b6' => 8,
    'M6' => 9,
    'b7' => 10,
    'M7' => 11,
    'Octave' => 12,
    'b9' => 13,
    'M9' => 14,
    'b10' => 15,
    'M10' => 16,
    'P11' => 17,
    '#11/b12' => 18,
    'P12' => 19,
    'b13' => 20,
    'M13' => 21,
    'b14' => 22,
    'M14' => 23,
);

// Fonction de calcul de la gamme demandée, dans le mode choisi.
function calculGamme($note, $mode)
{
    // On initialise les variables qui seront utilisées dans tout le calcul
    $notesRef = array('Do', 'Ré', 'Mi', 'Fa', 'Sol', 'La', 'Si');
    $intervallesRef = array(2, 2, 1, 2, 2, 2, 1);
    $modesRef = array(
        "Ionien" => array(2, 2, 1, 2, 2, 2, 1),
        "Dorien" => array(2, 1, 2, 2, 2, 1, 2),
        "Phrygien" => array(1, 2, 2, 2, 1, 2, 2),
        "Lydien" => array(2, 2, 2, 1, 2, 2, 1),
        "Mixolydien" => array(2, 2, 1, 2, 2, 1, 2),
        "Aeolien" => array(2, 1, 2, 2, 1, 2, 2),
        "Locrien" => array(1, 2, 2, 1, 2, 2, 2)
    );

    $altRef = array("#", "b");

    // Si les Variables ont bien été transmises dans à la fonction
    if (isset($note) && isset($mode)) {
        $askNote = $note; // Contient la note transmise à la fonction
        $askMode = $mode; // Contient le mode transmis à la fonction

        $modeIsTrue = array_key_exists($askMode, $modesRef); // modeIsTrue = TRUE si le mode demandé existe dans le tableau des modes de référence

        if ($askMode ==='Ionien') {
          if ($askNote === 'Dob') {
            $askNote = 'Si';
            $note = 'Si';
          } else if ($askNote === 'Do#') {
            $askNote = 'Réb';
            $note = 'Réb';
          } else {
            $askNote = $askNote;
          }
        } else if ($askMode ==='Dorien') {
          if ($askNote === 'Réb') {
            $askNote = 'Do#';
            $note = 'Do#';
          } else if ($askNote === 'Ré#') {
            $askNote = 'Mib';
            $note = 'Mib';
          } else {
            $askNote = $askNote;
          }
        } else if ($askMode ==='Phrygien') {
          if ($askNote === 'Mib') {
            $askNote = 'Ré#';
            $note = 'Ré#';
          } else if ($askNote === 'Mi#') {
            $askNote = 'Fa';
            $note = 'Fa';
          } else {
            $askNote = $askNote;
          }
        } else if ($askMode ==='Lydien') {
          if ($askNote === 'Fab') {
            $askNote = 'Mi';
            $note = 'Mi';
          } else if ($askNote === 'Fa#') {
            $askNote = 'Solb';
            $note = 'Solb';
          } else {
            $askNote = $askNote;
          }
        } else if ($askMode ==='Mixolydien') {
          if ($askNote === 'Solb') {
            $askNote = 'Fa#';
            $note = 'Fa#';
          } else if ($askNote === 'Sol#') {
            $askNote = 'Lab';
            $note = 'Lab';
          } else {
            $askNote = $askNote;
          }
        } else if ($askMode ==='Aeolien') {
          if ($askNote === 'Lab') {
            $askNote = 'Sol#';
            $note = 'Sol#';
          } else if ($askNote === 'La#') {
            $askNote = 'Sib';
            $note = 'Sib';
          } else {
            $askNote = $askNote;
          }
        } else {
          if ($askNote === 'Sib') {
            $askNote = 'La#';
            $note = 'La#';
          } else if ($askNote === 'Do') {
            $askNote = 'Do';
            $note = 'Do';
          } else {
            $askNote = $askNote;
          }
        }


        // Si la note transmise est une note altérée, on lui retire son altération et on vérifie qu'elle existe avant de la transmettre
        if (stristr($askNote, "#") !== FALSE or stristr($askNote, "b") !== FALSE) {
            $askNote = str_replace($altRef, "", $askNote); //askNote devient la note sans son altération
            $askAlt = str_replace($askNote, "", $note); //askAlt enregistre l'altération demandée initialement
            $askNoteKey = array_search($askNote, $notesRef); //askNoteKey vaut la clé du tableau noteRef qui contient la note demandée.
            $altIsTrue = TRUE; //altIsTrue vaut TRUE et indique qu'une altération était demandée initialement
        // Si la note demandée initialement n'est pas altérée on peut la transmettre à la suite du code
        } else {
            $askNoteKey = array_search($askNote, $notesRef); //askNoteKey vaut la clé du tableau noteRef qui contient la note demandée.
            $altIsTrue = FALSE; //altIsTrue vaut FALSE et indique qu'aucune altération n'était demandée initialement
        }

        // Si la note transmise n'est pas altérée ou n'a plus son altération, existe dans la gamme de référence et que le mode existe
        if ($askNoteKey !== FALSE && $modeIsTrue !== FALSE) {
            $askModeIntervalles = $modesRef[$askMode]; // askModeIntervalles est un tableau contenant les intervalles du mode demandé
            // On fait tourner la gamme de référence pour que la note demandée devienne la Tonique, idem avec les intervalles de Référence
            for ($i = 0; $i < $askNoteKey; $i++) {
                $turnNotes = array_shift($notesRef);
                $turnIntervalles = array_shift($intervallesRef);
                array_push($notesRef, $turnNotes);
                array_push($intervallesRef, $turnIntervalles);
            }

            // Une fois que la gamme est prête on soustrait les intervalles de référence à la gamme demandée pour isoler les notes altérées
            for ($i = 0; $i < 7; $i++) {
                $calculAlt[$i] = $askModeIntervalles[$i] - $intervallesRef[$i];
            }

            // le résultat nous donne les notes qui doivent subir une altération
            $altDiese = array_keys($calculAlt, 1); // altDiese recoit toutes les clés dont la valeur correspond à 1 (soit monter de un demi ton)
            $altBemol = array_keys($calculAlt, -1); // altBemol recoit toutes les clés dont la valeur correspond à -1 (soit descendre de un demi ton)
            $gammeRef = array_keys($calculAlt, 0); // gammeRef recoit toutes les clés dont la valeur correspond à 0, si les 7 entrées = 0 cela signifie que la gamme demandée est la gamme de référence sans altérations
            $countRef = count($gammeRef); // CountRef compte le nombre d'intervalles qui ne subissent pas d'altérations
            $safeGamme = $notesRef; // safeGamme est la gamme demandée sans altérations

            //----------------------------------------------------------------------------------------------------------------
            //---------------------------- GAMME MONTANTE --------------------------------------------------------------------
            //----------------------------------------------------------------------------------------------------------------

            //------------------------------------------------------------------------------------------------------------------------------------------------------
            // Si la note demandée n'est pas altérée ce calcul est obligatoire, si elle est altérée la gamme demandée comporte l'altération de la note demandée. ---
            //------------------------------------------------------------------------------------------------------------------------------------------------------

            // Si la première valeur du tableau altDiese est plus petite que son homologue altBémol alors la première altération est un diese et donc toute la gamme aussi. de plus, countRef doit être inférieure à 7
            if ($countRef < 7 && $altDiese[0] < $altBemol[0]) {
                $notesAlt = array_slice($notesRef, $altDiese[0] + 1, $altBemol[0] - $altDiese[0]); // notesAlt contient les notes subissant une altération dans la gamme demandée
                $count = count($notesAlt); // Ici on compte les altérations trouvées, si il y en a 6 la gamme est complète et il ne nous reste plus qu'à altérer les notes

                // Si $count vaut moins de 6 et que la gamme demandée comporte plus d'une altération alors on continue de chercher les altérations
                if ($count < 6 && isset($altDiese[1])) {
                    $notesAltwo = array_slice($notesRef, $altDiese[1] + 1, $altBemol[1] - $altDiese[1]);
                    $notesAlter = array_merge($notesAlt, $notesAltwo); // notesAlter est un tableau contenant l'ensemble des notes qui doivent subir une altération
                    $notesNonAlt = array_diff($notesRef, $notesAlter); // notesNonAlt est un tableau contenant les notes qui ne sont pas altérées
                    $count = count($notesAlter); // count est le nombre de notes qui subissent une altération

                    // Cette boucle ajoute l'altération # aux notes qui subissent une altération dans la gamme demandée
                    for ($i = 0; $i < $count; $i++) {
                        $altGo[$i] = array_search($notesAlter[$i], $notesRef);
                        $notesRef[$altGo[$i]] = $notesRef[$altGo[$i]] . "#";
                    }

                    // Ajoute l'octave à la gamme demandée.
                    array_push($notesRef, $askNote);

                // si notesAlt vaut 6 alors la gamme est prête, seule la tonique n'est pas altérée
                } else if ($count === 6) {
                    for ($i = 0; $i < $count; $i++) {
                        $altGo[$i] = array_search($notesAlt[$i], $notesRef);
                        $notesRef[$altGo[$i]] = $notesRef[$altGo[$i]] . "#";
                    }
                    array_push($notesRef, $askNote);

                    // Si noteAlt vaut 1, il n'y a qu'une seule note altérée dans la gamme
                } else {
                    $altGo[0] = array_search($notesAlt[0], $notesRef);
                    $notesRef[$altGo[0]] = $notesRef[$altGo[0]] . "#";
                    array_push($notesRef, $askNote);
                }

                //----------------------------------------------------------------------------------------------------------------
                //------------------ GAMME FINALE MONTANTE AVEC ALTERATIONS SI LA TONIQUE EST ALTERÉE ----------------------------
                //----------------------------------------------------------------------------------------------------------------
                // Si la note demandée était une note altérée et que l'altération était un #
                if ($altIsTrue !== FALSE && $askAlt === "#") {
                    $askNote = $safeGamme[1];
                    $askAlt = "b";
                    if ($askNote !== "Fa" && $askNote !== "Do") {
                        // On fait tourner la gamme de référence pour que la note demandée devienne la Tonique, idem avec les intervalles de Référence
                        $turnNotes = array_shift($safeGamme);
                        $turnIntervalles = array_shift($intervallesRef);
                        array_push($safeGamme, $turnNotes);
                        array_push($intervallesRef, $turnIntervalles);
                        $sureGamme = $safeGamme;

                        // Une fois que la gamme de référence est prête on soustrait les intervalles de référence à la gamme demandée pour isoler les notes altérées
                        for ($i = 0; $i < 7; $i++) {
                            $calculAlt[$i] = $askModeIntervalles[$i] - $intervallesRef[$i];
                        }
                        // le résultat nous donne les notes qui doivent subir une altération
                        $altDiese = array_keys($calculAlt, 1); // altDiese recoit toutes les clés dont la valeur correspond à 1 (soit monter en #)
                        $altBemol = array_keys($calculAlt, -1); // altBemol recoit toutes les clés dont la valeur correspond à -1 (soit descendre en bémol)

                        $notesAlt = array_slice($safeGamme, $altDiese[0] + 1, $altBemol[0] - $altDiese[0]);
                        $count = count($notesAlt); // Ici on compte les altérations trouvées, si il y en a 6 la gamme est complète et il ne nous reste plus qu'a altérer les notes

                        // Si notesAlt vaut moins de 6 et que la gamme demandée comporte plus d'une altération alors on continue de chercher les altérations
                        if ($count < 6 && isset($altDiese[1])) {
                            $notesAltwo = array_slice($safeGamme, $altDiese[1] + 1, $altBemol[1] - $altDiese[1]);
                            $notesAlter = array_merge($notesAlt, $notesAltwo);
                            $notesNonAlt = array_diff($safeGamme, $notesAlter);
                            $count = count($notesAlter);

                            for ($i = 0; $i < $count; $i++) {
                                $altGo[$i] = array_search($notesAlter[$i], $safeGamme);
                                $safeGamme[$altGo[$i]] = $safeGamme[$altGo[$i]] . "#";
                            }
                            array_push($safeGamme, $askNote);

                            // si notesAlt vaut 6 alors la gamme est prête
                        } else if ($count === 6) {
                            for ($i = 0; $i < $count; $i++) {
                                $altGo[$i] = array_search($notesAlt[$i], $safeGamme);
                                $safeGamme[$altGo[$i]] = $safeGamme[$altGo[$i]] . "#";
                            }
                            array_push($safeGamme, $askNote);

                            // Si noteAlt vaut 1, il n'y a qu'une seule note altérée dans la gamme
                        } else {
                            $altGo[0] = array_search($notesAlt[0], $safeGamme);
                            $safeGamme[$altGo[0]] = $safeGamme[$altGo[0]] . "#";
                            array_push($safeGamme, $askNote);
                        }

                        if (isset($notesAlter)) {
                            $count = count($safeGamme);

                            for ($i = 0; $i < $count; $i++) {
                                $safeGamme[$i] = $safeGamme[$i] . "b";
                            }
                            $count = count($notesAlter);
                            for ($i = 0; $i < $count; $i++) {
                                $cleanNotes[$i] = array_search($notesAlter[$i], $sureGamme);
                                $safeGamme[$cleanNotes[$i]] = $notesAlter[$i];
                            }

                            $askGamme = $safeGamme;
                            return $askGamme;
                        } else if (!isset($notesAlter)) {
                            $count = count($safeGamme);
                            for ($i = 0; $i < $count; $i++) {
                                $safeGamme[$i] = $safeGamme[$i] . "b";
                            }

                            $count = count($notesAlt);
                            for ($i = 0; $i < $count; $i++) {
                                $cleanNotes[$i] = array_search($notesAlt[$i], $sureGamme);
                                $safeGamme[$cleanNotes[$i]] = $notesAlt[$i];
                            }
                            $askGamme = $safeGamme;
                            return $askGamme;
                        }

                        //----------------------------------------------------------------------------------------------------------------
                        //------------------ EXEPTION POUR FA ET DO ------ ICI -----------------------------------------------------------
                        //----------------------------------------------------------------------------------------------------------------
                    } else if ($askNote === "Fa" or $askNote === "Do") {

                        $turnNotes = array_shift($safeGamme);
                        $turnIntervalles = array_shift($intervallesRef);
                        array_push($safeGamme, $turnNotes);
                        array_push($intervallesRef, $turnIntervalles);
                        $sureGamme = $safeGamme;

                        // Une fois que la gamme de référence est prête on soustrait les intervalles de référence à la gamme demandée pour isoler les notes altérées
                        for ($i = 0; $i < 7; $i++) {
                            $calculAlt[$i] = $askModeIntervalles[$i] - $intervallesRef[$i];
                        }
                        // le résultat nous donne les notes qui doivent subir une altération
                        $altDiese = array_keys($calculAlt, 1); // altDiese recoit toutes les clés dont la valeur correspond à 1 (soit monter en #)
                        $altBemol = array_keys($calculAlt, -1); // altBemol recoit toutes les clés dont la valeur correspond à -1 (soit descendre en bémol)
                        $gammeRef = array_keys($calculAlt, 0); // gammeRef recoit toutes les clées dont la valeur correspond à 0, si les 7 entrées = 0 cela signifie que la gamme demandée est la gamme de référence sans altérations
                        $countRef = count($gammeRef); // CountRef nous indique si nous avons affaire à la gamme de référence ou non

                        if ($countRef < 7) {
                            $notesAlt = array_slice($safeGamme, $altBemol[0] + 1, $altDiese[0] - $altBemol[0]);
                            $count = count($notesAlt); // Ici on compte les altérations trouvées, si il y en a 6 la gamme est complète et il ne nous reste plus qu'a altérer les notes

                            // Si notesAlt vaut moins de 6 et que la gamme demandée comporte plus d'une altération alors on continue de chercher les altérations
                            if ($count < 6 && isset($altBemol[1])) {
                                $notesAltwo = array_slice($safeGamme, $altBemol[0] + 1, $altDiese[0] - $altBemol[0]);
                                $notesAlter = array_merge($notesAlt, $notesAltwo);
                                $notesNonAlt = array_diff($safeGamme, $notesAlter);
                                $count = count($notesAlter);

                                for ($i = 0; $i < $count; $i++) {
                                    $altGo[$i] = array_search($notesAlter[$i], $safeGamme);
                                    $safeGamme[$altGo[$i]] = $safeGamme[$altGo[$i]] . "b";
                                }
                                array_push($safeGamme, $askNote);

                                // si notesAlt vaut 6 alors la gamme est prête
                            } else if ($count === 6) {
                                for ($i = 0; $i < $count; $i++) {
                                    $altGo[$i] = array_search($notesAlt[$i], $safeGamme);
                                    $safeGamme[$altGo[$i]] = $safeGamme[$altGo[$i]] . "b";
                                }
                                array_push($safeGamme, $askNote);

                                // Si noteAlt vaut 1, il n'y a qu'une seule note altérée dans la gamme
                            } else {
                                $altGo[0] = array_search($notesAlt[0], $safeGamme);
                                $safeGamme[$altGo[0]] = $safeGamme[$altGo[0]] . "b";
                                array_push($safeGamme, $askNote);
                            }
                            $askGamme = $safeGamme;
                            return $askGamme;
                        } else if ($countRef === 7) {
                            array_push($safeGamme, $askNote);
                            $askGamme = $safeGamme;
                            return $askGamme;
                        }
                    }

                    //----------------------------------------------------------------------------------------------------------------
                    //------------------ GAMME FINALE MONTANTE AVEC ALTERATION SI LA TONIQUE EST ALTERÉE EN BEMOL --- OK -------------
                    //----------------------------------------------------------------------------------------------------------------
                    // Sinon l'altération demandée était en bémol et dans ce cas la gamme correspondante est la gamme opposée
                } else if ($altIsTrue !== FALSE && $askAlt === "b") {

                    if (isset($notesAlter)) {
                        $count = count($notesRef);
                        for ($i = 0; $i < $count; $i++) {
                            $notesRef[$i] = $notesRef[$i] . "b";
                        }

                        $count = count($notesAlter);
                        for ($i = 0; $i < $count; $i++) {
                            $cleanNotes[$i] = array_search($notesAlter[$i], $safeGamme);
                            $notesRef[$cleanNotes[$i]] = $notesAlter[$i];
                        }
                        $askGamme = $notesRef;
                        return $askGamme;
                    } else if (!isset($notesAlter)) {
                        $count = count($notesRef);
                        for ($i = 0; $i < $count; $i++) {
                            $notesRef[$i] = $notesRef[$i] . "b";
                        }

                        $count = count($notesAlt);
                        for ($i = 0; $i < $count; $i++) {
                            $cleanNotes[$i] = array_search($notesAlt[$i], $safeGamme);
                            $notesRef[$cleanNotes[$i]] = $notesAlt[$i];
                        }
                        $askGamme = $notesRef;
                        return $askGamme;
                    }

                    //----------------------------------------------------------------------------------------------------------------
                    //------------------- GAMME FINALE MONTANTE AVEC ALTERATIONS SI LA TONIQUE NE L'EST PAS --> OK -------------------
                    //----------------------------------------------------------------------------------------------------------------
                    // Si la note n'était pas altérée on transmet la gamme créée.
                } else if ($altIsTrue === FALSE) {
                    // La Gamme Finale
                    $askGamme = $notesRef;
                    return $askGamme;
                }
            }

            //----------------------------------------------------------------------------------------------------------------
            //------------------ GAMME DESCENDANTE ------------------- OK ----------------------------------------------------
            //----------------------------------------------------------------------------------------------------------------
            // Si la première valeur du tableau altDiese est plus grande que son homologue altBémol alors la première altération est un bémol et donc toute la gamme aussi. de plus, countRef doit être inférieure à 7
            else if ($countRef < 7 && $altDiese[0] > $altBemol[0]) {
                $notesAlt = array_slice($notesRef, $altBemol[0] + 1, $altDiese[0] - $altBemol[0]);
                $count = count($notesAlt); // Ici on compte les altérations trouvées, si il y en a 6 la gamme est complète et il ne nous reste plus qu'a altérer les notes

                // Si notesAlt vaut moins de 6 et que la gamme demandée comporte plus d'une altération alors on continue de chercher les altérations
                if ($count < 6 && isset($altBemol[1])) {
                    $notesAltwo = array_slice($notesRef, $altBemol[1] + 1, $altDiese[1] - $altBemol[1]);
                    $notesAlter = array_merge($notesAlt, $notesAltwo);
                    $notesNonAlt = array_diff($notesRef, $notesAlter);
                    $count = count($notesAlter);

                    for ($i = 0; $i < $count; $i++) {
                        $altGo[$i] = array_search($notesAlter[$i], $notesRef);
                        $notesRef[$altGo[$i]] = $notesRef[$altGo[$i]] . "b";
                    }
                    array_push($notesRef, $askNote);

                    // si notesAlt vaut 6 alors la gamme est prête
                } else if ($count === 6) {
                    for ($i = 0; $i < $count; $i++) {
                        $altGo[$i] = array_search($notesAlt[$i], $notesRef);
                        $notesRef[$altGo[$i]] = $notesRef[$altGo[$i]] . "b";
                    }
                    array_push($notesRef, $askNote);

                    // Si noteAlt vaut 1, il n'y a qu'une seule note altérée dans la gamme
                } else {
                    $altGo[0] = array_search($notesAlt[0], $notesRef);
                    $notesRef[$altGo[0]] = $notesRef[$altGo[0]] . "b";
                    array_push($notesRef, $askNote);
                }

                //----------------------------------------------------------------------------------------------------------------
                //------------------ GAMME FINALE DESCENDANTE AVEC ALTERATIONS SI LA TONIQUE EST ALTERÉE --- OK ------------------
                //----------------------------------------------------------------------------------------------------------------
                // Si la note demandée était une note altérée et que l'altération était un b
                if ($altIsTrue !== FALSE && $askAlt === "b") {
                    $askNote = $safeGamme[6];
                    $askAlt = "#";

                    if ($askNote !== "Mi" && $askNote !== "Si") {
                        // On fait tourner la gamme de référence pour que la note demandée devienne la Tonique, idem avec les intervalles de Référence


                        for ($i = 0; $i < 6; $i++) {
                            $turnNotes = array_shift($safeGamme);
                            $turnIntervalles = array_shift($intervallesRef);
                            array_push($safeGamme, $turnNotes);
                            array_push($intervallesRef, $turnIntervalles);
                        }
                        $sureGamme = $safeGamme;

                        // Une fois que la gamme de référence est prête on soustrait les intervalles de référence à la gamme demandée pour isoler les notes altérées
                        for ($i = 0; $i < 7; $i++) {
                            $calculAlt[$i] = $askModeIntervalles[$i] - $intervallesRef[$i];
                        }
                        // le résultat nous donne les notes qui doivent subir une altération
                        $altDiese = array_keys($calculAlt, 1); // altDiese recoit toutes les clés dont la valeur correspond à 1 (soit monter en #)
                        $altBemol = array_keys($calculAlt, -1); // altBemol recoit toutes les clés dont la valeur correspond à -1 (soit descendre en bémol)

                        $notesAlt = array_slice($safeGamme, $altBemol[0] + 1, $altDiese[0] - $altBemol[0]);
                        $count = count($notesAlt); // Ici on compte les altérations trouvées, si il y en a 6 la gamme est complète et il ne nous reste plus qu'a altérer les notes

                        // Si notesAlt vaut moins de 6 et que la gamme demandée comporte plus d'une altération alors on continue de chercher les altérations
                        if ($count < 6 && isset($altBemol[1])) {
                            $notesAltwo = array_slice($safeGamme, $altBemol[1] + 1, $altDiese[1] - $altBemol[1]);
                            $notesAlter = array_merge($notesAlt, $notesAltwo);
                            $notesNonAlt = array_diff($safeGamme, $notesAlter);
                            $count = count($notesAlter);

                            for ($i = 0; $i < $count; $i++) {
                                $altGo[$i] = array_search($notesAlter[$i], $safeGamme);
                                $safeGamme[$altGo[$i]] = $safeGamme[$altGo[$i]] . "b";
                            }
                            array_push($safeGamme, $askNote);

                            // si notesAlt vaut 6 alors la gamme est prête
                        } else if ($count === 6) {
                            for ($i = 0; $i < $count; $i++) {
                                $altGo[$i] = array_search($notesAlt[$i], $safeGamme);
                                $safeGamme[$altGo[$i]] = $safeGamme[$altGo[$i]] . "b";
                            }
                            array_push($safeGamme, $askNote);

                            // Si noteAlt vaut 1, il n'y a qu'une seule note altérée dans la gamme
                        } else {
                            $altGo[0] = array_search($notesAlt[0], $safeGamme);
                            $safeGamme[$altGo[0]] = $safeGamme[$altGo[0]] . "b";
                            array_push($safeGamme, $askNote);
                        }

                        if (isset($notesAlter)) {
                            $count = count($safeGamme);

                            for ($i = 0; $i < $count; $i++) {
                                $safeGamme[$i] = $safeGamme[$i] . "#";
                            }
                            $count = count($notesAlter);
                            for ($i = 0; $i < $count; $i++) {
                                $cleanNotes[$i] = array_search($notesAlter[$i], $sureGamme);
                                $safeGamme[$cleanNotes[$i]] = $notesAlter[$i];
                            }

                            $askGamme = $safeGamme;
                            return $askGamme;
                            echo "La Gamme relative de " . $notesRef[0] . "b est " . $askNote . "#";
                        } else if (!isset($notesAlter)) {
                            $count = count($safeGamme);
                            for ($i = 0; $i < $count; $i++) {
                                $safeGamme[$i] = $safeGamme[$i] . "#";
                            }

                            $count = count($notesAlt);
                            for ($i = 0; $i < $count; $i++) {
                                $cleanNotes[$i] = array_search($notesAlt[$i], $sureGamme);
                                $safeGamme[$cleanNotes[$i]] = $notesAlt[$i];
                            }
                            $askGamme = $safeGamme;
                            return $askGamme;
                        }


                        //----------------------------------------------------------------------------------------------------------------
                        //------------------ EXEPTION POUR MI ET SI ------ OK -----------------------------------------------------------
                        //----------------------------------------------------------------------------------------------------------------
                    } else if ($askNote === "Mi" or $askNote === "Si") {
                        for ($i = 0; $i < 6; $i++) {
                            $turnNotes = array_shift($safeGamme);
                            $turnIntervalles = array_shift($intervallesRef);
                            array_push($safeGamme, $turnNotes);
                            array_push($intervallesRef, $turnIntervalles);
                        }
                        $sureGamme = $safeGamme;

                        // Une fois que la gamme de référence est prête on soustrait les intervalles de référence à la gamme demandée pour isoler les notes altérées
                        for ($i = 0; $i < 7; $i++) {
                            $calculAlt[$i] = $askModeIntervalles[$i] - $intervallesRef[$i];
                        }
                        // le résultat nous donne les notes qui doivent subir une altération
                        $altDiese = array_keys($calculAlt, 1); // altDiese recoit toutes les clés dont la valeur correspond à 1 (soit monter en #)
                        $altBemol = array_keys($calculAlt, -1); // altBemol recoit toutes les clés dont la valeur correspond à -1 (soit descendre en bémol)
                        $gammeRef = array_keys($calculAlt, 0); // gammeRef recoit toutes les clées dont la valeur correspond à 0, si les 7 entrées = 0 cela signifie que la gamme demandée est la gamme de référence sans altérations
                        $countRef = count($gammeRef); // CountRef nous indique si nous avons affaire à la gamme de référence ou non

                        if ($countRef < 7) {
                            $notesAlt = array_slice($safeGamme, $altDiese[0] + 1, $altBemol[0] - $altDiese[0]);
                            $count = count($notesAlt); // Ici on compte les altérations trouvées, si il y en a 6 la gamme est complète et il ne nous reste plus qu'a altérer les notes

                            // Si notesAlt vaut moins de 6 et que la gamme demandée comporte plus d'une altération alors on continue de chercher les altérations
                            if ($count < 6 && isset($altDiese[1])) {
                                $notesAltwo = array_slice($safeGamme, $altDiese[1] + 1, $altBemol[1] - $altDiese[1]);
                                $notesAlter = array_merge($notesAlt, $notesAltwo);
                                $notesNonAlt = array_diff($safeGamme, $notesAlter);
                                $count = count($notesAlter);

                                for ($i = 0; $i < $count; $i++) {
                                    $altGo[$i] = array_search($notesAlter[$i], $safeGamme);
                                    $safeGamme[$altGo[$i]] = $safeGamme[$altGo[$i]] . "#";
                                }
                                array_push($safeGamme, $askNote);

                                // si notesAlt vaut 6 alors la gamme est prête
                            } else if ($count === 6) {
                                for ($i = 0; $i < $count; $i++) {
                                    $altGo[$i] = array_search($notesAlt[$i], $safeGamme);
                                    $safeGamme[$altGo[$i]] = $safeGamme[$altGo[$i]] . "#";
                                }
                                array_push($safeGamme, $askNote);

                                // Si noteAlt vaut 1, il n'y a qu'une seule note altérée dans la gamme
                            } else {
                                $altGo[0] = array_search($notesAlt[0], $safeGamme);
                                $safeGamme[$altGo[0]] = $safeGamme[$altGo[0]] . "#";
                                array_push($safeGamme, $askNote);
                            }
                            $askGamme = $safeGamme;
                            return $askGamme;
                        } else if ($countRef === 7) {
                            array_push($safeGamme, $askNote);
                            $askGamme = $safeGamme;
                            return $askGamme;
                        }
                    }

                    //----------------------------------------------------------------------------------------------------------------
                    //------------------ GAMME FINALE DESCENDANTE AVEC ALTERATION SI LA TONIQUE EST ALTERÉE EN DIESE --- OK ----------
                    //----------------------------------------------------------------------------------------------------------------
                    // Sinon l'altération demandée était en diese et dans ce cas la gamme correspondante est la gamme opposée
                } else if ($altIsTrue !== FALSE && $askAlt === "#") {

                    if (isset($notesAlter)) {
                        $count = count($notesRef);
                        for ($i = 0; $i < $count; $i++) {
                            $notesRef[$i] = $notesRef[$i] . "#";
                        }

                        $count = count($notesAlter);
                        for ($i = 0; $i < $count; $i++) {
                            $cleanNotes[$i] = array_search($notesAlter[$i], $safeGamme);
                            $notesRef[$cleanNotes[$i]] = $notesAlter[$i];
                        }
                        $askGamme = $notesRef;
                        return $askGamme;
                    } else if (!isset($notesAlter)) {
                        $count = count($notesRef);
                        for ($i = 0; $i < $count; $i++) {
                            $notesRef[$i] = $notesRef[$i] . "#";
                        }

                        $count = count($notesAlt);
                        for ($i = 0; $i < $count; $i++) {
                            $cleanNotes[$i] = array_search($notesAlt[$i], $safeGamme);
                            $notesRef[$cleanNotes[$i]] = $notesAlt[$i];
                        }
                        $askGamme = $notesRef;
                        return $askGamme;
                    }


                    //----------------------------------------------------------------------------------------------------------------
                    //------------------- GAMME FINALE DESCENDANTE AVEC ALTERATIONS SI LA TONIQUE NE L'EST PAS --> OK ----------------
                    //----------------------------------------------------------------------------------------------------------------
                    // Si la note n'était pas altérée on transmet la gamme créée.
                } else if ($altIsTrue === FALSE) {
                    // La Gamme Finale
                    $askGamme = $notesRef;
                    return $askGamme;
                }


                //----------------------------------------------------------------------------------------------------------------
                //---------------------------- GAMME DE REFERENCE DU MODE --> OK -------------------------------------------------
                //----------------------------------------------------------------------------------------------------------------
                // Si la gamme est la gamme de référence du mode demandé
            } else {
                array_push($notesRef, $askNote);

                // Si la note demandée était une note altérée et est, sans son altération la note de référence du mode
                if ($altIsTrue !== FALSE) {
                    $count = count($notesRef);
                    for ($i = 0; $i < $count; $i++) {
                        $notesRef[$i] = $notesRef[$i] . $askAlt;
                    }
                    $askGamme = $notesRef;
                    return $askGamme;
                    // ICI ON DOIT AFFICHER LA GAMME RELATIVE SANS ABBERATIONS EN PLUS DE LA GAMME TROUVÉE


                    // Si non on affiche la gamme de référence du mode demandé
                } else {
                    $askGamme = $notesRef;
                    return $askGamme;
                }
            }


            //----------------------------------------------------------------------------------------------------------------
            //------------------------------------------------------------------- OK -----------------------------------------
            //----------------------------------------------------------------------------------------------------------------
            // Si la note transmise n'existe pas
        } else {
            echo "La note ou le mode demandé n'existe pas";
        }

        // Si les variables n'ont pas été transmises
    } else {
        echo "Choisissez une note et un mode pour trouver la gamme correspondante";
    }
}

// Cette fonction trouve tous les accords de la gamme demandée
function harmonize()
{
    global $gamme;

    for ($i = 0; $i < 7; $i++) {
        // Chaque note de la gamme est harmonisée
        $harmonisation[$i] = array(
            'Tonique' => $gamme[0],
            'Tierce' => $gamme[2],
            'Quinte' => $gamme[4],
            'Septième' => $gamme[6],
            'Neuvième' => $gamme[1],
            'Onzième' => $gamme[3],
            'Treizième' => $gamme[5]
        );

        $noteSuivante = array_shift($gamme);
        array_push($gamme, $noteSuivante);
        $gamme[7] = $gamme[0];
    }

    return $harmonisation;
}

// Cette fonction trouve toutes les intervalles de la gamme demandée
function intervalles($mode)
{
    global $intervalles, $tabIntervalles, $tabMode, $gamme;

    $askKeyMode = array_search($mode, $tabMode);

    // Cette boucle fais tourner les intervalles de référence pour qu'ils soient en concordance avec le mode demandé
    for ($i = 0; $i < $askKeyMode; $i++) {
        $turnIntervalles = array_shift($intervalles);
        array_push($intervalles, $turnIntervalles);
    }

    // Cette boucle calcule la valeur des accords
    for ($i = 0; $i < 7; $i++) {
        $intervalleSeconde = $intervalles[0];
        $intervalleTierce = $intervalleSeconde + $intervalles[1];
        $intervalleQuarte = $intervalleTierce + $intervalles[2];
        $intervalleQuinte = $intervalleQuarte + $intervalles[3];
        $intervalleSixte = $intervalleQuinte + $intervalles[4];
        $intervalleSept = $intervalleSixte +  $intervalles[5];
        $intervalleNeuf = $intervalleSept +  $intervalles[6] +  $intervalles[0];
        $intervalleDix = $intervalleNeuf + $intervalles[1];
        $intervalleOnze = $intervalleDix + $intervalles[2];
        $intervalleDouze = $intervalleOnze + $intervalles[3];
        $intervalleTreize = $intervalleDouze + $intervalles[4];
        $intervalleQuatorze = $intervalleTreize + $intervalles[5];

        $intervalleSeconde = array_search($intervalleSeconde, $tabIntervalles);
        $intervalleTierce = array_search($intervalleTierce, $tabIntervalles);
        $intervalleQuarte = array_search($intervalleQuarte, $tabIntervalles);
        $intervalleQuinte = array_search($intervalleQuinte, $tabIntervalles);
        $intervalleSixte = array_search($intervalleSixte, $tabIntervalles);
        $intervalleSept = array_search($intervalleSept, $tabIntervalles);
        $intervalleNeuf = array_search($intervalleNeuf, $tabIntervalles);
        $intervalleDix = array_search($intervalleDix, $tabIntervalles);
        $intervalleOnze = array_search($intervalleOnze, $tabIntervalles);
        $intervalleDouze = array_search($intervalleDouze, $tabIntervalles);
        $intervalleTreize = array_search($intervalleTreize, $tabIntervalles);
        $intervalleQuatorze = array_search($intervalleQuatorze, $tabIntervalles);

        $intervalleHuit = 'Octave';

        $intervallesGamme[$i] = array(
            'Seconde' => $intervalleSeconde,
            'Tierce' => $intervalleTierce,
            'Quarte' => $intervalleQuarte,
            'Quinte' => $intervalleQuinte,
            'Sixte' => $intervalleSixte,
            'Septième' => $intervalleSept,
            'Octave' => $intervalleHuit,
            'Neuvième' => $intervalleNeuf,
            'Dixième' => $intervalleDix,
            'Onzième' => $intervalleOnze,
            'Douzième' => $intervalleDouze,
            'Treizième' => $intervalleTreize,
            'Quatorzième' => $intervalleQuatorze
        );

        $turnIntervalles = array_shift($intervalles);
        array_push($intervalles, $turnIntervalles);
        $noteSuivante = array_shift($gamme);
        array_push($gamme, $noteSuivante);
        $gamme[7] = $gamme[0];
    }
    return $intervallesGamme;
}

// Cette fonction calcule le type d'accord pour chaque degré de la gamme
function typesAccords()
{
    global $intervallesGamme;

    for ($i = 0; $i < 7; $i++) {
        switch ($intervallesGamme[$i]['Seconde']) {
            case 'b2':
                $seconde = 0;
                break;
            case 'M2':
                $seconde = 1;
                break;
        }
        switch ($intervallesGamme[$i]['Tierce']) {
            case 'b3':
                $tierce = 0;
                break;
            case 'M3':
                $tierce = 1;
                break;
        }
        switch ($intervallesGamme[$i]['Quarte']) {
            case 'P4':
                $quarte = 1;
                break;
            case 'Triton':
                $quarte = 0;
                break;
        }
        switch ($intervallesGamme[$i]['Quinte']) {
            case 'Triton':
                $quinte = 0;
                break;
            case 'P5':
                $quinte = 1;
                break;
        }
        switch ($intervallesGamme[$i]['Sixte']) {
            case 'b6':
                $sixte = 0;
                break;
            case 'M6':
                $sixte = 1;
                break;
        }
        switch ($intervallesGamme[$i]['Septième']) {
            case 'b7':
                $septieme = 0;
                break;
            case 'M7':
                $septieme = 1;
                break;
        }
        if ($tierce == 1 && $quinte == 1 && $septieme == 1 && $seconde == 1 && $quarte == 1 && $sixte == 1) {
            $typesAccords[$i] = array(
                'triade' => 'Majeur',
                'tetrade' => 'Maj7',
                'enrichissementNeuf' => 'Maj9',
                'enrichissementOnze' => 'Maj11',
                'enrichissementTreize' => 'Maj13'
            );
        } elseif ($tierce == 0 && $quinte == 1 && $septieme == 0 && $seconde == 1 && $quarte == 1 && $sixte == 1) {
            $typesAccords[$i] = array(
                'triade' => 'mineur',
                'tetrade' => 'min7',
                'enrichissementNeuf' => 'min9',
                'enrichissementOnze' => 'min11',
                'enrichissementTreize' => 'min13'
            );
        } elseif ($tierce == 0 && $quinte == 1 && $septieme == 0 && $seconde == 0 && $quarte == 1 && $sixte == 0) {
            $typesAccords[$i] = array(
                'triade' => 'mineur',
                'tetrade' => 'min7',
                'enrichissementNeuf' => 'm7b9',
                'enrichissementOnze' => 'm7b9/11',
                'enrichissementTreize' => 'm7b9b13'
            );
        } elseif ($tierce == 1 && $quinte == 1 && $septieme == 1 && $seconde == 1 && $quarte == 0 && $sixte == 1) {
            $typesAccords[$i] = array(
                'triade' => 'Majeur',
                'tetrade' => 'Maj7',
                'enrichissementNeuf' => 'Maj9',
                'enrichissementOnze' => 'Maj7#11',
                'enrichissementTreize' => 'M7#11/13'
            );
        } elseif ($tierce == 1 && $quinte == 1 && $septieme == 0 && $seconde == 1 && $quarte == 1 && $sixte == 1) {
            $typesAccords[$i] = array(
                'triade' => 'Majeur',
                'tetrade' => '7',
                'enrichissementNeuf' => 'Maj9',
                'enrichissementOnze' => 'Maj11',
                'enrichissementTreize' => 'Maj13'
            );
        } elseif ($tierce == 0 && $quinte == 1 && $septieme == 0 && $seconde == 1 && $quarte == 1 && $sixte == 0) {
            $typesAccords[$i] = array(
                'triade' => 'mineur',
                'tetrade' => 'min7',
                'enrichissementNeuf' => 'min9',
                'enrichissementOnze' => 'min11',
                'enrichissementTreize' => 'm7b13'
            );
        } elseif ($tierce == 0 && $quinte == 0 && $septieme == 0 && $seconde == 0 && $quarte == 1 && $sixte == 0) {
            $typesAccords[$i] = array(
                'triade' => 'diminué',
                'tetrade' => 'm7b5',
                'enrichissementNeuf' => 'm7b5b9',
                'enrichissementOnze' => 'm7b5b9/11',
                'enrichissementTreize' => 'm7b5b9/11b13'
            );
        } else {
            echo $tierce, $quinte, $septieme, $seconde, $quarte, $sixte;
        }
    }
    return $typesAccords;
}

if (isset($_GET["note"]) && isset($_GET["mode"]) && in_array($_GET["note"], $tabChroma) != FALSE && in_array($_GET["mode"], $tabMode) != FALSE) {

    $n = $_GET["note"];
    $m = $_GET["mode"];

    // Calcul de la gamme et harmonisation
    // Contient un tableau contenant les notes de la gamme demandée
    $gamme = calculGamme($n, $m);
    // Contient les accords de tout les degrés de la gamme créée après l'harmonisation $accords['0']['Tonique'] affiche la tonique du premier accord de la gamme
    $accords = harmonize();
    // Contient le type d'intervalle qui sépare les notes de la gamme entre elles $intervallesGamme['0']['Seconde'] compare la tonique de la gamme demandée à sa seconde
    $intervallesGamme = intervalles($m);
    // Contient le type d'accord $typesAccords[0]['triade'] affiche Majeur pour l'accord I du mode Ionien par exemple
    $typesAccords = typesAccords();

?>
    <!-- Affichage des résultats et Formulaire de nouvelle recherche -->
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="styles/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="styles/global.css" type="text/css">
    </head>

    <body onload="drawGuitar();drawGamme();">
        <div class="container-sm table-responsive-md">
            <table class="table caption-top">
                <caption>Gamme <?php echo $n;?> <?php echo $m;?></caption>
                <thead class="table-light">
                    <tr>
                        <th scope="col">I</th>
                        <th scope="col">II</th>
                        <th scope="col">III</th>
                        <th scope="col">IV</th>
                        <th scope="col">V</th>
                        <th scope="col">VI</th>
                        <th scope="col">VII</th>
                        <th scope="col">VIII</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div id="tonique" class="d-none"><?php echo $gamme[0];?></div>
                            <div class="d-grid"><button type="button" class="btn btn-secondary">
                                    <?php echo $gamme[0];?> <span class="badge bg-tonique">T</span>
                                </button></div>
                        </td>
                        <td>
                            <div id="seconde" class="d-none"><?php echo $gamme[1];?></div>
                            <div class="d-grid"><button type="button" class="btn btn-secondary">
                                    <?php echo $gamme[1];?> <span class="badge bg-seconde"><?php echo $intervallesGamme[0]['Seconde'];?></span>
                                </button></div>
                        </td>
                        <td>
                            <div id="tierce" class="d-none"><?php echo $gamme[2];?></div>
                            <div class="d-grid"><button type="button" class="btn btn-secondary">
                                    <?php echo $gamme[2];?> <span class="badge bg-tierce"><?php echo $intervallesGamme[0]['Tierce'];?></span>
                                </button></div>
                        </td>
                        <td>
                            <div id="quarte" class="d-none"><?php echo $gamme[3];?></div>
                            <div class="d-grid"><button type="button" class="btn btn-secondary">
                                    <?php echo $gamme[3];?> <span class="badge bg-quarte"><?php echo $intervallesGamme[0]['Quarte'];?></span>
                                </button></div>
                        </td>
                        <td>
                            <div id="quinte" class="d-none"><?php echo $gamme[4];?></div>
                            <div class="d-grid"><button type="button" class="btn btn-secondary">
                                    <?php echo $gamme[4];?> <span class="badge bg-quinte"><?php echo $intervallesGamme[0]['Quinte'];?></span>
                                </button></div>
                        </td>
                        <td>
                            <div id="sixte" class="d-none"><?php echo $gamme[5];?></div>
                            <div class="d-grid"><button type="button" class="btn btn-secondary">
                                    <?php echo $gamme[5];?> <span class="badge bg-sixte"><?php echo $intervallesGamme[0]['Sixte'];?></span>
                                </button></div>
                        </td>
                        <td>
                            <div id="septieme" class="d-none"><?php echo $gamme[6];?></div>
                            <div class="d-grid"><button type="button" class="btn btn-secondary">
                                    <?php echo $gamme[6];?> <span class="badge bg-septieme"><?php echo $intervallesGamme[0]['Septième'];?></span>
                                </button></div>
                        </td>
                        <td>
                            <div id="octave" class="d-none"><?php echo $gamme[7];?></div>
                            <div class="d-grid"><button type="button" class="btn btn-secondary">
                                    <?php echo $gamme[7];?> <span class="badge bg-tonique">8</span>
                                </button></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="container-fluid">
          <canvas id="Guitare" class="mx-auto d-block" height="210px" width="1500px"></canvas>
        </div>

        <script type="text/javascript">
          // récupère les notes de la gamme
          var tonique = document.getElementById('tonique').innerHTML;
          var seconde = document.getElementById('seconde').innerHTML;
          var tierce = document.getElementById('tierce').innerHTML;
          var quarte = document.getElementById('quarte').innerHTML;
          var quinte = document.getElementById('quinte').innerHTML;
          var sixte = document.getElementById('sixte').innerHTML;
          var septieme = document.getElementById('septieme').innerHTML;

          var cubeCoordY = [15, 45, 75, 105, 135, 165];
          var cubeCoordX = [10, 93, 210, 328, 445, 562, 679, 796, 913, 1030, 1147, 1264, 1381, 1462];

          var circleCoordY = [30, 60, 90, 120, 150, 180];
          var circleCoordX = [25, 108, 226, 343, 460, 577, 694, 811, 928, 1045, 1162, 1279, 1396, 1477];

          var roundDo = [
              circleCoordX[8],
              circleCoordX[1],
              circleCoordX[5],
              circleCoordX[10],
              circleCoordX[3],
              circleCoordX[8]
          ];
          var roundDoD = [
              circleCoordX[9],
              circleCoordX[2],
              circleCoordX[6],
              circleCoordX[11],
              circleCoordX[4],
              circleCoordX[9]
          ];
          var roundRe = [
              circleCoordX[10],
              circleCoordX[3],
              circleCoordX[7],
              circleCoordX[12],
              circleCoordX[5],
              circleCoordX[10]
          ];
          var roundReD = [
              circleCoordX[11],
              circleCoordX[4],
              circleCoordX[8],
              circleCoordX[1],
              circleCoordX[6],
              circleCoordX[11]
          ];
          var roundMi = [
              circleCoordX[12],
              circleCoordX[5],
              circleCoordX[9],
              circleCoordX[2],
              circleCoordX[7],
              circleCoordX[12],
          ];
          var roundFa = [
              circleCoordX[1],
              circleCoordX[6],
              circleCoordX[10],
              circleCoordX[3],
              circleCoordX[8],
              circleCoordX[1]
          ];
          var roundFaD = [
              circleCoordX[2],
              circleCoordX[7],
              circleCoordX[11],
              circleCoordX[4],
              circleCoordX[9],
              circleCoordX[2]
          ];
          var roundSol = [
              circleCoordX[3],
              circleCoordX[8],
              circleCoordX[12],
              circleCoordX[5],
              circleCoordX[10],
              circleCoordX[3]
          ];
          var roundSolD = [
              circleCoordX[4],
              circleCoordX[9],
              circleCoordX[1],
              circleCoordX[6],
              circleCoordX[11],
              circleCoordX[4]
          ];
          var roundLa = [
              circleCoordX[5],
              circleCoordX[10],
              circleCoordX[2],
              circleCoordX[7],
              circleCoordX[12],
              circleCoordX[5]
          ];
          var roundLaD = [
              circleCoordX[6],
              circleCoordX[11],
              circleCoordX[3],
              circleCoordX[8],
              circleCoordX[1],
              circleCoordX[6]
          ];
          var roundSi = [
              circleCoordX[7],
              circleCoordX[12],
              circleCoordX[4],
              circleCoordX[9],
              circleCoordX[2],
              circleCoordX[7]
          ];

          var squareDo = [
              cubeCoordX[8],
              cubeCoordX[1],
              cubeCoordX[5],
              cubeCoordX[10],
              cubeCoordX[3],
              cubeCoordX[8]
          ];
          var squareDoD = [
              cubeCoordX[9],
              cubeCoordX[2],
              cubeCoordX[6],
              cubeCoordX[11],
              cubeCoordX[4],
              cubeCoordX[9]
          ];
          var squareRe = [
              cubeCoordX[10],
              cubeCoordX[3],
              cubeCoordX[7],
              cubeCoordX[12],
              cubeCoordX[5],
              cubeCoordX[10]
          ];
          var squareReD = [
              cubeCoordX[11],
              cubeCoordX[4],
              cubeCoordX[8],
              cubeCoordX[1],
              cubeCoordX[6],
              cubeCoordX[11]
          ];
          var squareMi = [
              cubeCoordX[12],
              cubeCoordX[5],
              cubeCoordX[9],
              cubeCoordX[2],
              cubeCoordX[7],
              cubeCoordX[12]
          ];
          var squareFa = [
              cubeCoordX[1],
              cubeCoordX[6],
              cubeCoordX[10],
              cubeCoordX[3],
              cubeCoordX[8],
              cubeCoordX[1]
          ];
          var squareFaD = [
              cubeCoordX[2],
              cubeCoordX[7],
              cubeCoordX[11],
              cubeCoordX[4],
              cubeCoordX[9],
              cubeCoordX[2]
          ];
          var squareSol = [
              cubeCoordX[3],
              cubeCoordX[8],
              cubeCoordX[12],
              cubeCoordX[5],
              cubeCoordX[10],
              cubeCoordX[3]
          ];
          var squareSolD = [
              cubeCoordX[4],
              cubeCoordX[9],
              cubeCoordX[1],
              cubeCoordX[6],
              cubeCoordX[11],
              cubeCoordX[4]
          ];
          var squareLa = [
              cubeCoordX[5],
              cubeCoordX[10],
              cubeCoordX[2],
              cubeCoordX[7],
              cubeCoordX[12],
              cubeCoordX[5]
          ];
          var squareLaD = [
              cubeCoordX[6],
              cubeCoordX[11],
              cubeCoordX[3],
              cubeCoordX[8],
              cubeCoordX[1],
              cubeCoordX[6]
          ];
          var squareSi = [
              cubeCoordX[7],
              cubeCoordX[12],
              cubeCoordX[4],
              cubeCoordX[9],
              cubeCoordX[2],
              cubeCoordX[7]
          ];

          // Fonction de calcul des coordonnées de la Tonique
          function drawTonique(tonique){

            var coordY = cubeCoordY;

            if (tonique == "Do" || tonique == "Si#") {
              var coordX_I = squareDo;
            } else if (tonique == "Do#" || tonique == "Réb") {
              var coordX_I = squareDoD;
            } else if (tonique == "Ré") {
              var coordX_I = squareRe;
            } else if (tonique == "Ré#" || tonique == "Mib") {
              var coordX_I = squareReD;
            } else if (tonique == "Mi" || tonique == "Fab") {
              var coordX_I = squareMi;
            } else if (tonique == "Fa" || tonique == "Mi#") {
              var coordX_I = squareFa;
            } else if (tonique == "Fa#" || tonique == "Solb") {
              var coordX_I = squareFaD;
            } else if (tonique == "Sol") {
              var coordX_I = squareSol;
            } else if (tonique == "Sol#" || tonique == "Lab") {
              var coordX_I = squareSolD;
            } else if (tonique == "La") {
              var coordX_I = squareLa;
            } else if (tonique == "La#" || tonique == "Sib") {
              var coordX_I = squareLaD;
            } else if (tonique == "Si" || tonique == "Dob") {
              var coordX_I = squareSi;
            } else {
              window.alert("Erreur dans l'assignation des coordonnées T");
            }

            var canvas = document.getElementById('Guitare');
            if (canvas.getContext) {
              var ctx = canvas.getContext('2d');
              for (coordonnees in coordX_I) {
                if (coordX_I[coordonnees] == 1381) {
                  ctx.fillStyle = '#ff0008';
                  ctx.fillRect(10, coordY[coordonnees], 30, 30);
                  ctx.fillStyle = '#ff0008';
                  ctx.fillRect(1381, coordY[coordonnees], 30, 30);
                } else {
                  ctx.fillStyle = '#ff0008';
                  ctx.fillRect(coordX_I[coordonnees], coordY[coordonnees], 30, 30);
                }
              }
            }
          }

          // Fonction de calcul des coordonnées de la Seconde
          function drawSeconde(seconde){

            var coordY = circleCoordY;

            if (seconde == "Do" || seconde == "Si#") {
              var coordX_I = roundDo;
            } else if (seconde == "Do#" || seconde == "Réb") {
              var coordX_I = roundDoD;
            } else if (seconde == "Ré") {
              var coordX_I = roundRe;
            } else if (seconde == "Ré#" || seconde == "Mib") {
              var coordX_I = roundReD;
            } else if (seconde == "Mi" || seconde == "Fab") {
              var coordX_I = roundMi;
            } else if (seconde == "Fa" || seconde == "Mi#") {
              var coordX_I = roundFa;
            } else if (seconde == "Fa#" || seconde == "Solb") {
              var coordX_I = roundFaD;
            } else if (seconde == "Sol") {
              var coordX_I = roundSol;
            } else if (seconde == "Sol#" || seconde == "Lab") {
              var coordX_I = roundSolD;
            } else if (seconde == "La") {
              var coordX_I = roundLa;
            } else if (seconde == "La#" || seconde == "Sib") {
              var coordX_I = roundLaD;
            } else if (seconde == "Si" || seconde == "Dob") {
              var coordX_I = roundSi;
            } else {
              window.alert("Erreur dans l'assignation des coordonnées T");
            }

            var canvas = document.getElementById('Guitare');
            if (canvas.getContext) {
              var ctx = canvas.getContext('2d');
              for (coordonnees in coordX_I) {
                if (coordX_I[coordonnees] == 1396) {
                  ctx.beginPath();
                  ctx.fillStyle = '#f40080';
                  ctx.arc(25, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                  ctx.beginPath();
                  ctx.fillStyle = '#f40080';
                  ctx.arc(1396, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                } else {
                  ctx.beginPath();
                  ctx.fillStyle = '#f40080';
                  ctx.arc(coordX_I[coordonnees], coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                }
              }
            }
          }

          // Fonction de calcul des coordonnées de la Tierce
          function drawTierce(tierce){

            var coordY = circleCoordY;

            if (tierce == "Do" || tierce == "Si#") {
              var coordX_I = roundDo;
            } else if (tierce == "Do#" || tierce == "Réb") {
              var coordX_I = roundDoD;
            } else if (tierce == "Ré") {
              var coordX_I = roundRe;
            } else if (tierce == "Ré#" || tierce == "Mib") {
              var coordX_I = roundReD;
            } else if (tierce == "Mi" || tierce == "Fab") {
              var coordX_I = roundMi;
            } else if (tierce == "Fa" || tierce == "Mi#") {
              var coordX_I = roundFa;
            } else if (tierce == "Fa#" || tierce == "Solb") {
              var coordX_I = roundFaD;
            } else if (tierce == "Sol") {
              var coordX_I = roundSol;
            } else if (tierce == "Sol#" || tierce == "Lab") {
              var coordX_I = roundSolD;
            } else if (tierce == "La") {
              var coordX_I = roundLa;
            } else if (tierce == "La#" || tierce == "Sib") {
              var coordX_I = roundLaD;
            } else if (tierce == "Si" || tierce == "Dob") {
              var coordX_I = roundSi;
            } else {
              window.alert("Erreur dans l'assignation des coordonnées T");
            }

            var canvas = document.getElementById('Guitare');
            if (canvas.getContext) {
              var ctx = canvas.getContext('2d');
              for (coordonnees in coordX_I) {
                if (coordX_I[coordonnees] == 1396) {
                  ctx.beginPath();
                  ctx.fillStyle = '#c200e2';
                  ctx.arc(25, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                  ctx.beginPath();
                  ctx.fillStyle = '#c200e2';
                  ctx.arc(1396, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                } else {
                  ctx.beginPath();
                  ctx.fillStyle = '#c200e2';
                  ctx.arc(coordX_I[coordonnees], coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                }
              }
            }
          }

          // Fonction de calcul des coordonnées de la Quarte
          function drawQuarte(quarte){

            var coordY = circleCoordY;

            if (quarte == "Do" || quarte == "Si#") {
              var coordX_I = roundDo;
            } else if (quarte == "Do#" || quarte == "Réb") {
              var coordX_I = roundDoD;
            } else if (quarte == "Ré") {
              var coordX_I = roundRe;
            } else if (quarte == "Ré#" || quarte == "Mib") {
              var coordX_I = roundReD;
            } else if (quarte == "Mi" || quarte == "Fab") {
              var coordX_I = roundMi;
            } else if (quarte == "Fa" || quarte == "Mi#") {
              var coordX_I = roundFa;
            } else if (quarte == "Fa#" || quarte == "Solb") {
              var coordX_I = roundFaD;
            } else if (quarte == "Sol") {
              var coordX_I = roundSol;
            } else if (quarte == "Sol#" || quarte == "Lab") {
              var coordX_I = roundSolD;
            } else if (quarte == "La") {
              var coordX_I = roundLa;
            } else if (quarte == "La#" || quarte == "Sib") {
              var coordX_I = roundLaD;
            } else if (quarte == "Si" || quarte == "Dob") {
              var coordX_I = roundSi;
            } else {
              window.alert("Erreur dans l'assignation des coordonnées T");
            }

            var canvas = document.getElementById('Guitare');
            if (canvas.getContext) {
              var ctx = canvas.getContext('2d');
              for (coordonnees in coordX_I) {
                if (coordX_I[coordonnees] == 1396) {
                  ctx.beginPath();
                  ctx.fillStyle = '#0740d2';
                  ctx.arc(25, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                  ctx.beginPath();
                  ctx.fillStyle = '#0740d2';
                  ctx.arc(1396, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                } else {
                  ctx.beginPath();
                  ctx.fillStyle = '#0740d2';
                  ctx.arc(coordX_I[coordonnees], coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                }
              }
            }
          }

          // Fonction de calcul des coordonnées de la Quinte
          function drawQuinte(quinte){

            var coordY = circleCoordY;

            if (quinte == "Do" || quarte == "Si#") {
              var coordX_I = roundDo;
            } else if (quinte == "Do#" || quinte == "Réb") {
              var coordX_I = roundDoD;
            } else if (quinte == "Ré") {
              var coordX_I = roundRe;
            } else if (quinte == "Ré#" || quinte == "Mib") {
              var coordX_I = roundReD;
            } else if (quinte == "Mi" || quarte == "Fab") {
              var coordX_I = roundMi;
            } else if (quinte == "Fa" || quarte == "Mi#") {
              var coordX_I = roundFa;
            } else if (quinte == "Fa#" || quinte == "Solb") {
              var coordX_I = roundFaD;
            } else if (quinte == "Sol") {
              var coordX_I = roundSol;
            } else if (quinte == "Sol#" || quinte == "Lab") {
              var coordX_I = roundSolD;
            } else if (quinte == "La") {
              var coordX_I = roundLa;
            } else if (quinte == "La#" || quinte == "Sib") {
              var coordX_I = roundLaD;
            } else if (quinte == "Si" || quarte == "Dob") {
              var coordX_I = roundSi;
            } else {
              window.alert("Erreur dans l'assignation des coordonnées T");
            }

            var canvas = document.getElementById('Guitare');
            if (canvas.getContext) {
              var ctx = canvas.getContext('2d');
              for (coordonnees in coordX_I) {
                if (coordX_I[coordonnees] == 1396) {
                  ctx.beginPath();
                  ctx.fillStyle = '#01aec0';
                  ctx.arc(25, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                  ctx.beginPath();
                  ctx.fillStyle = '#01aec0';
                  ctx.arc(1396, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                } else {
                  ctx.beginPath();
                  ctx.fillStyle = '#01aec0';
                  ctx.arc(coordX_I[coordonnees], coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                }
              }
            }
          }

          // Fonction de calcul des coordonnées de la Sixte
          function drawSixte(sixte){

            var coordY = circleCoordY;

            if (sixte == "Do" || quarte == "Si#") {
              var coordX_I = roundDo;
            } else if (sixte == "Do#" || sixte == "Réb") {
              var coordX_I = roundDoD;
            } else if (sixte == "Ré") {
              var coordX_I = roundRe;
            } else if (sixte == "Ré#" || sixte == "Mib") {
              var coordX_I = roundReD;
            } else if (sixte == "Mi" || quarte == "Fab") {
              var coordX_I = roundMi;
            } else if (sixte == "Fa" || quarte == "Mi#") {
              var coordX_I = roundFa;
            } else if (sixte == "Fa#" || sixte == "Solb") {
              var coordX_I = roundFaD;
            } else if (sixte == "Sol") {
              var coordX_I = roundSol;
            } else if (sixte == "Sol#" || sixte == "Lab") {
              var coordX_I = roundSolD;
            } else if (sixte == "La") {
              var coordX_I = roundLa;
            } else if (sixte == "La#" || sixte == "Sib") {
              var coordX_I = roundLaD;
            } else if (sixte == "Si" || quarte == "Dob") {
              var coordX_I = roundSi;
            } else {
              window.alert("Erreur dans l'assignation des coordonnées T");
            }

            var canvas = document.getElementById('Guitare');
            if (canvas.getContext) {
              var ctx = canvas.getContext('2d');
              for (coordonnees in coordX_I) {
                if (coordX_I[coordonnees] == 1396) {
                  ctx.beginPath();
                  ctx.fillStyle = '#0bd619';
                  ctx.arc(25, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                  ctx.beginPath();
                  ctx.fillStyle = '#0bd619';
                  ctx.arc(1396, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                } else {
                  ctx.beginPath();
                  ctx.fillStyle = '#0bd619';
                  ctx.arc(coordX_I[coordonnees], coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                }
              }
            }
          }

          // Fonction de calcul des coordonnées de la Septieme
          function drawSeptieme(septieme){

            var coordY = circleCoordY;

            if (septieme == "Do" || quarte == "Si#") {
              var coordX_I = roundDo;
            } else if (septieme == "Do#" || septieme == "Réb") {
              var coordX_I = roundDoD;
            } else if (septieme == "Ré") {
              var coordX_I = roundRe;
            } else if (septieme == "Ré#" || septieme == "Mib") {
              var coordX_I = roundReD;
            } else if (septieme == "Mi" || septieme == "Fab") {
              var coordX_I = roundMi;
            } else if (septieme == "Fa" || septieme == "Mi#") {
              var coordX_I = roundFa;
            } else if (septieme == "Fa#" || septieme == "Solb") {
              var coordX_I = roundFaD;
            } else if (septieme == "Sol") {
              var coordX_I = roundSol;
            } else if (septieme == "Sol#" || septieme == "Lab") {
              var coordX_I = roundSolD;
            } else if (septieme == "La") {
              var coordX_I = roundLa;
            } else if (septieme == "La#" || septieme == "Sib") {
              var coordX_I = roundLaD;
            } else if (septieme == "Si" || septieme == "Dob") {
              var coordX_I = roundSi;
            } else {
              window.alert("Erreur dans l'assignation des coordonnées T");
            }

            var canvas = document.getElementById('Guitare');
            if (canvas.getContext) {
              var ctx = canvas.getContext('2d');
              for (coordonnees in coordX_I) {
                if (coordX_I[coordonnees] == 1396) {
                  ctx.beginPath();
                  ctx.fillStyle = '#d4d60b';
                  ctx.arc(25, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                  ctx.beginPath();
                  ctx.fillStyle = '#d4d60b';
                  ctx.arc(1396, coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                } else {
                  ctx.beginPath();
                  ctx.fillStyle = '#d4d60b';
                  ctx.arc(coordX_I[coordonnees], coordY[coordonnees], 14, 0, 2 * Math.PI);
                  ctx.fill();
                }
              }
            }
          }

          // Dessin de la guitare sur le Canvas
          function drawGuitar() {
            var canvas = document.getElementById('Guitare');
            if (canvas.getContext) {
              var ctx = canvas.getContext('2d');
              ctx.strokeStyle = 'grey';
              // Cordes
              var axeY = 0;
              for (var i = 0; i < 6; i++) {
                // ctx.lineWidth = (1 + i);
                var axeY = axeY + 30;
                ctx.beginPath();
                ctx.moveTo(0,axeY);
                ctx.lineTo(1500, axeY);
                ctx.stroke()
              }
              // Haut du manche
              ctx.lineWidth = 10;
              ctx.beginPath();
              ctx.moveTo(50,25);
              ctx.lineTo(50, 185);
              ctx.stroke()
              // Frettes
              var coord = 167;
              for (let i = 0; i < 12; i++) {
                ctx.lineWidth = 3;
                ctx.beginPath();
                ctx.moveTo(coord,26);
                ctx.lineTo(coord, 184);
                ctx.lineCap = "round";
                ctx.stroke()
                var coord = coord+117;
              }
              // points de repère guitare
              for (var i = 0; i < 5; i++) {
                var point = [3,5,7,9,12];

                if (point[i] == 7 || point[i] == 12) {
                  ctx.beginPath();
                  ctx.fillStyle = 'grey';
                  ctx.arc(circleCoordX[point[i]], 75, 7, 0, 2 * Math.PI);
                  ctx.fill();
                  ctx.beginPath();
                  ctx.fillStyle = 'grey';
                  ctx.arc(circleCoordX[point[i]], 135, 7, 0, 2 * Math.PI);
                  ctx.fill();
                } else {
                  ctx.beginPath();
                  ctx.fillStyle = 'grey';
                  ctx.arc(circleCoordX[point[i]], 105, 7, 0, 2 * Math.PI);
                  ctx.fill();
                }
              }
            }
          }

          // appel des fonctions de dessin des notes
          function drawGamme(){
            drawTonique(tonique);
            drawSeconde(seconde);
            drawTierce(tierce);
            drawQuarte(quarte);
            drawQuinte(quinte);
            drawSixte(sixte);
            drawSeptieme(septieme);
          }
        </script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>

        <hr/>

        <div class="mx-auto" style="width: 200px;">
            <form action="harmonize.php" method="GET">
                <div class="mb-3">
                    <label for="note" class="form-label">Choisissez une note </label>
                    <select name="note" class="form-control">
                      <option value="<?php echo $n;?>"><?php echo $n;?></option>
                      <option value="Do">Do</option>
                      <option value="Do#">Do#</option>
                      <option value="Réb">Réb</option>
                      <option value="Ré">Ré</option>
                      <option value="Ré#">Ré#</option>
                      <option value="Mib">Mib</option>
                      <option value="Mi">Mi</option>
                      <option value="Fa">Fa</option>
                      <option value="Fa#">Fa#</option>
                      <option value="Solb">Solb</option>
                      <option value="Sol">Sol</option>
                      <option value="Sol#">Sol#</option>
                      <option value="Lab">Lab</option>
                      <option value="La">La</option>
                      <option value="La#">La#</option>
                      <option value="Sib">Sib</option>
                      <option value="Si">Si</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="mode" class="form-label">Choisissez un mode </label>
                    <select name="mode" class="form-control">
                      <option value="Ionien">Ionien</option>
                      <option value="Dorien">Dorien</option>
                      <option value="Phrygien">Phrygien</option>
                      <option value="Lydien">Lydien</option>
                      <option value="Mixolydien">Mixolydien</option>
                      <option value="Aeolien">Aeolien</option>
                      <option value="Locrien">Locrien</option>
                    </select>
                </div>
                  <input type="submit" value="Harmoniser"class="btn btn-primary">
            </form>
      </div>

    </body>

    </html>
    <!-- Fin -->
<?php

// Si aucune note n'est transmise
} else {
?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="styles/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="styles/global.css" type="text/css">
    </head>

    <body>
      <div class="mx-auto" style="width: 200px;">
          <form action="harmonize.php" method="GET">
              <div class="mb-3">
                  <label for="note" class="form-label">Choisissez une note </label>
                  <select name="note" class="form-control">
                    <option value="Do">Do</option>
                    <option value="Do#">Do#</option>
                    <option value="Réb">Réb</option>
                    <option value="Ré">Ré</option>
                    <option value="Ré#">Ré#</option>
                    <option value="Mib">Mib</option>
                    <option value="Mi">Mi</option>
                    <option value="Fa">Fa</option>
                    <option value="Fa#">Fa#</option>
                    <option value="Solb">Solb</option>
                    <option value="Sol">Sol</option>
                    <option value="Sol#">Sol#</option>
                    <option value="Lab">Lab</option>
                    <option value="La">La</option>
                    <option value="La#">La#</option>
                    <option value="Sib">Sib</option>
                    <option value="Si">Si</option>
                  </select>
              </div>
              <div class="mb-3">
                  <label for="mode" class="form-label">Choisissez un mode </label>
                  <select name="mode" class="form-control">
                    <option value="Ionien">Ionien</option>
                    <option value="Dorien">Dorien</option>
                    <option value="Phrygien">Phrygien</option>
                    <option value="Lydien">Lydien</option>
                    <option value="Mixolydien">Mixolydien</option>
                    <option value="Aeolien">Aeolien</option>
                    <option value="Locrien">Locrien</option>
                  </select>
              </div>
                <input type="submit" value="Harmoniser"class="btn btn-primary">
          </form>
    </div>
    </body>

    </html>
<?php
}
