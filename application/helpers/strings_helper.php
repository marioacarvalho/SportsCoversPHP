<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('cut_string'))
{
 	
	function cut_string($value,$cut_point,$suffix = "")
	{

        if($value==NULL || $value == FALSE)
            return $value;
        if(trim($value)=="")
            return "";

        if(strlen($value)<=$cut_point)
            return $value;
        
        $final_value = substr($value,0,$cut_point-strlen($suffix));
        $last_space_pos = strripos($final_value," ");
        if($last_space_pos === FALSE)
            return $final_value . $suffix;

        return substr($final_value,0,$last_space_pos) . $suffix; 

	}
} 

if ( ! function_exists('get_language_field'))
{
    function get_language_field($object,$field){
        $CI =& get_instance();
        if(isset($object[$field])){
            return $object[$field]; 
        }
  
        if(!empty($object[$field . "_" . get_active_language()]))
            return $object[$field . "_" . get_active_language()];   

        if(!empty($object[$field . "_" . get_main_language()]))
            return $object[$field . "_" . get_main_language()];

        $languages = $CI->lang->get_languages();
        $languages = array_keys($languages);
        foreach($languages as $language){
            if(!empty($object[$field . "_" . $language]))
                return $object[$field . "_" . $language];
        }
        return "";
    }
}

if ( ! function_exists('get_language_field_no_content'))
{
    function get_language_field_no_content($object,$field = FALSE){
        $CI =& get_instance();     
        if($field !== FALSE){
            if($object[$field . "_" . get_active_language()] !== FALSE &&
                $object[$field . "_" . get_active_language()] != NULL &&
                $object[$field . "_" . get_active_language()] != "")
                return $object[$field . "_" . get_active_language()];
            else
                return $CI->lang->line('warning_no_language_content');
        }else{
            if(	isset($object) && 
            	$object !== FALSE &&
                $object != NULL &&
                $object != "")
                return $object;
            else
                return $CI->lang->line('warning_no_language_content');
        }
    }
}

if ( ! function_exists('get_to_text_area'))
{    
    function get_to_text_area($content){
        if($content === FALSE || $content === NULL)
            return $content;

        return str_replace("<br/>","\n",$content); 
    }
}

if ( ! function_exists('get_from_text_area'))
{
    function get_from_text_area($content){
        if($content === FALSE || $content === NULL)
            return $content;

        $final_content = str_replace("\r\n","<br/>",$content); 
        return str_replace("\n","<br/>",$final_content);
    }
}

if ( ! function_exists('strip_hyperlink'))
{    
    function strip_hyperlink($url){
        if($url === FALSE || $url === NULL)
            return $url;

        return str_replace("http://","",$url); 
    }

}

if ( ! function_exists('add_hyperlink'))
{    
    function add_hyperlink($url){
        if($url === FALSE || $url === NULL)
            return $url;

        return "http://" . $url; 
    }

}

if ( ! function_exists('get_formated_price'))
{
    function get_formated_price($value = FALSE)
    {
        if($value === FALSE || $value == NULL){
            return $value;    
        }
    
        return "€" . number_format($value,2);
        
    }    
}

if ( ! function_exists('add_price_iva'))
{
    function add_price_iva($value = FALSE)
    {
        if($value === FALSE || $value == NULL || $value == ""){
            return $value;    
        }
    
        return $value * (1 + IVA / 100);
        
    }    
}

if ( ! function_exists('upper'))
{
    function upper($str = FALSE)
    {
        if(empty($str))
            return $str;

        $str = strtoupper(strtr($str, "àáâãäåæçèéêëìíîïðñòóôõöøùúûüý", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝ"));
        return strtr($str, array("ß" => "SS"));         
    }    
}

if ( ! function_exists('generateSalt'))
{
    function generateSalt($max = 15) {
        $characterList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $i = 0;
        $salt = "";
        do {
            $salt .= $characterList{mt_rand(0,strlen($characterList) - 1)};
            $i++;
        } while ($i <= $max);
        return $salt;
    }
}

 if ( ! function_exists('add_quotes_to_string'))
{
    function add_quotes_to_string($str)
    {
        if (is_string($str))
        {
            $str = "'".$str."'";
        }
        return $str;
    }
}

if ( ! function_exists('transform_string_to_array'))
{
     function transform_string_to_array($str){
        $result = preg_replace("/\(|\)|\s+/", "", $str);
        if(strlen($result) > 0) {
            $result = explode(",", $result); 
        } else {
            $result = array();
        }
        return $result;
    }
}

/* End of file strings_helper.php */
/* Location: ./system/application/helpers/strings_helper.php */