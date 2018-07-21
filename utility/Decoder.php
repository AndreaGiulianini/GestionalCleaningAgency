<?php

class Decoder
{
    public static function encodeVisibility($visibility)
    {
        switch ($visibility) {
            case 'Tutti':
                return "A";
                break;
            case 'Clienti':
                return "C";
                break;
            case 'Operatori':
                return "O";
                break;
            case 'Utente Specifico':
                return "X";
                break;
        }
    }

    public static function decodeVisibility($code)
    {
        switch ($code) {
            case 'A':
                return "Tutti";
                break;
            case 'C':
                return "Clienti";
                break;
            case 'O':
                return "Operatori";
                break;
            case 'X':
                return "Utente Specifico";
                break;
        }
    }

    public static function decodeFileIcons($extension)
    {
        switch ($extension) {
            case 'JPG':
            case 'JPEG':
                return "fa-file-image-o";
                break;
            case 'PNG':
                return "fa-file-image-o";
                break;
            case 'DOCX':
                return "fa-file-word-o";
                break;
            case 'XLS':
                return "fa-file-excel-o";
                break;
            case 'PDF':
                return "fa-file-pdf-o";
                break;
            default:
                return "fa-file-o";
        }
    }

    public static function decodeState($state)
    {
        switch ($state) {
            case 'A':
                return "In Attesa";
                break;
            case 'V':
                return "Accettata";
                break;
            case 'X':
                return "Rifiutata";
                break;
        }
    }

    public static function encodeState($state)
    {
        switch ($state) {
            case 'In Attesa':
                return "A";
                break;
            case 'Accettata':
                return "V";
                break;
            case 'Rifiutata':
                return "V";
                break;
        }
    }

    public static function decodeActivityType($type)
    {
        switch ($type) {
            case 'G':
                return "Giornaliera";
                break;
            case 'S':
                return "Settimanale";
                break;
            case 'M':
                return "Mensile";
                break;
            case 'A':
                return "Annuale";
                break;
            case 'N':
                return "Nessuna";
                break;
        }
    }

    public static function encodeActivityType($type)
    {
        switch ($type) {
            case 'Giornaliera':
                return "G";
                break;
            case 'Settimanale':
                return "S";
                break;
            case 'Mensile':
                return "M";
                break;
            case 'Annuale':
                return "A";
                break;
            case 'Nessuna':
                return "N";
                break;
        }
    }

    public static function decodePermissionType($type)
    {
        switch ($type) {
            case 'M':
                return "Malattia";
                break;
            case 'P':
                return "Permesso";
                break;
            case 'F':
                return "Ferie";
                break;
        }
    }
}
