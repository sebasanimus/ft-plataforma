<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('fecha_desde_mysql'))
{
    function fecha_desde_mysql($fecha, $sinhora=false)    {        
        $year = substr($fecha,2,2);
        $mes = substr($fecha,5,2);
		$dia = substr($fecha,8,2);
		if($sinhora) return $dia.'/'.$mes.'/'.$year;
        $hora = substr($fecha,11,2);
        $minutos = substr($fecha,14,2);  
        $ampm = 'AM';
        if($hora>12){
            $hora = $hora-12;
            $ampm = 'PM';
        }else if($hora==12){
            $ampm = 'PM';
		}		
        return $dia.'/'.$mes.'/'.$year.' '.$hora.':'.$minutos.' '.$ampm;
    } 
}



if ( ! function_exists('fecha_arg'))
{
    function fecha_arg($fecha)    {          
        $mes= array('01'=>'Ene',
                    '02'=>'Feb',
                    '03'=>'Mar',
                    '04'=>'Abr',
                    '05'=>'May',
                    '06'=>'Jun',
                    '07'=>'Jul',
                    '08'=>'Ago',
                    '09'=>'Sep',
                    '10'=>'Oct',
                    '11'=>'Nov',
                    '12'=>'Dic');
        return substr($fecha,8,2).' '.$mes[substr($fecha,5,2)].', '.substr($fecha,0,4);      
    }   
}

if ( ! function_exists('fecha_evento'))
{
    function fecha_evento($fecha)    {          
        $mes= array('01'=>'enero',
                    '02'=>'febrero',
                    '03'=>'marzo',
                    '04'=>'abril',
                    '05'=>'mayo',
                    '06'=>'junio',
                    '07'=>'julio',
                    '08'=>'agosto',
                    '09'=>'septiembre',
                    '10'=>'octubre',
                    '11'=>'noviembre',
                    '12'=>'diciembre');
        return substr($fecha,0,2).' de '.$mes[substr($fecha,3,2)].' de '.substr($fecha,6,4);      
    }   
}

if ( ! function_exists('fecha_dia'))
{
    function fecha_dia($fecha)    {  
        return substr($fecha,8,2);      
    }   
}

if ( ! function_exists('fecha_mes'))
{
    function fecha_mes($fecha)    {  
        $mes= array('01'=>'Ene',
                    '02'=>'Feb',
                    '03'=>'Mar',
                    '04'=>'Abr',
                    '05'=>'May',
                    '06'=>'Jun',
                    '07'=>'Jul',
                    '08'=>'Ago',
                    '09'=>'Sep',
                    '10'=>'Oct',
                    '11'=>'Nov',
                    '12'=>'Dic');
        return $mes[substr($fecha,5,2)];      
    }   
}


if ( ! function_exists('fromDDMMYYYtoYYYYMMDD'))
{
    function fromDDMMYYYtoYYYYMMDD($fecha, $sinhora=true){   
		if(empty($fecha)) return null;
        $year = substr($fecha,6,4);
        $mes = substr($fecha,3,2);
		$dia = substr($fecha,0,2);
		if($sinhora) return $year.'-'.$mes.'-'.$dia;
        $hora = substr($fecha,11,2);
		$minutos = substr($fecha,14,2);   	
        return $year.'-'.$mes.'-'.$dia.' '.$hora.':'.$minutos.':00';
    } 
}

if ( ! function_exists('fromYYYYMMDDtoDDMMYYY'))
{
    function fromYYYYMMDDtoDDMMYYY($fecha, $sinhora=true){   
		if(empty($fecha)) return null;     
        $year = substr($fecha,0,4);
        $mes = substr($fecha,5,2);
		$dia = substr($fecha,8,2);
		if($sinhora) return $dia.'/'.$mes.'/'.$year;
        $hora = substr($fecha,11,2);
        $minutos = substr($fecha,14,2);  
		//$segundos = substr($fecha,17,2);          		
        return $dia.'/'.$mes.'/'.$year.' '.$hora.':'.$minutos;
    } 
}

if ( ! function_exists('fromYYYYMMDDtoReadable'))
{
    function fromYYYYMMDDtoReadable($fecha, $lang){   
		if(empty($fecha)) return null;    
		$mesLetra = Array(
				'es'=>
					Array('01'=>'Enero',
                    '02'=>'Febrero',
                    '03'=>'Marzo',
                    '04'=>'Abril',
                    '05'=>'Mayo',
                    '06'=>'Junio',
                    '07'=>'Julio',
                    '08'=>'Agosto',
                    '09'=>'Septiembre',
                    '10'=>'Octubre',
                    '11'=>'Noviembre',
					'12'=>'Diciembre'),
				'en'=>
					Array('01'=>'January',
                    '02'=>'February',
                    '03'=>'March',
                    '04'=>'April',
                    '05'=>'May',
                    '06'=>'June',
                    '07'=>'July',
                    '08'=>'August',
                    '09'=>'September',
                    '10'=>'October',
                    '11'=>'November',
					'12'=>'December'));
					 
        $year = substr($fecha,0,4);
        $mes = $mesLetra[$lang][substr($fecha,5,2)];
		$dia = substr($fecha,8,2);
		if($lang=='es') return $dia.' de '.$mes.' '.$year;
		return $dia.' '.$mes.' '.$year;
    } 
}


if ( ! function_exists('removeAccents'))
{
	function removeAccents( $str ){
		$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð',
			'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã',
			'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ',
			'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ',
			'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę',
			'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī',
			'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ',
			'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ',
			'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť',
			'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ',
			'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ',
			'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
		$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O',
			'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c',
			'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
			'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D',
			'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g',
			'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K',
			'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o',
			'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S',
			's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W',
			'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i',
			'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
		return str_replace($a, $b, $str);
	}
}

if ( ! function_exists('toURLFriendly'))
{
/**
* @param  String $str The input string
* @return String      The URL-friendly string (lower-cased, accent-stripped, spaces to dashes).
*/
	function toURLFriendly( $str ){
		$str = removeAccents($str);
		$str = preg_replace(array('/[^a-zA-Z0-9 \'-]/', '/[ -\']+/', '/^-|-$/'), array('', '-', ''), $str);
		$str = preg_replace('/-inc$/i', '', $str);
		$str = (strlen($str) > 250) ? substr($str,0,249) : $str;
		return strtolower($str);
	}
}

?>