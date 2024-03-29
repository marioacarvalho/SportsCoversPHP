<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  
 
class MY_Form_validation extends CI_Form_validation 
{
    public $CI;
    
    protected function _execute($row, $rules, $postdata = NULL, $cycles = 0)
    {
        // If the $_POST data is an array we will run a recursive call
        if (is_array($postdata))
        {
            foreach ($postdata as $key => $val)
            {
                $this->_execute($row, $rules, $val, $cycles);
                $cycles++;
            }

            return;
        }

        // --------------------------------------------------------------------

        // If the field is blank, but NOT required, no further tests are necessary
        $callback = FALSE;
        $one_language = FALSE;
        if ( ! in_array('required', $rules) AND is_null($postdata))
        {
            // Before we bail out, does the rule contain a callback?
            if (preg_match("/(callback_\w+(\[.*?\])?)/", implode(' ', $rules), $match))
            {
                $callback = TRUE;
                $rules = (array('1' => $match[1]));
            }
            elseif(preg_match("/(required_language)/", implode(' ', $rules), $match))
            {
                $one_language = TRUE; 
            }
            else
            {
                return;
            }
        }

        // --------------------------------------------------------------------

        // Isset Test. Typically this rule will only apply to checkboxes.
        if (is_null($postdata) AND $callback == FALSE AND $one_language == FALSE)
        {
            if (in_array('isset', $rules, TRUE) OR in_array('required', $rules))
            {
                // Set the message type
                $type = (in_array('required', $rules)) ? 'required' : 'isset';

                if ( ! isset($this->_error_messages[$type]))
                {
                    if (FALSE === ($line = $this->CI->lang->line($type)))
                    {
                        $line = 'The field was not set';
                    }
                }
                else
                {
                    $line = $this->_error_messages[$type];
                }

                // Build the error message
                $message = sprintf($line, $this->_translate_fieldname($row['label']));

                // Save the error message
                $this->_field_data[$row['field']]['error'] = $message;

                if ( ! isset($this->_error_array[$row['field']]))
                {
                    $this->_error_array[$row['field']] = $message;
                }
            }

            return;
        }

        // --------------------------------------------------------------------

        // Cycle through each rule and run it
        foreach ($rules As $rule)
        {
            $_in_array = FALSE;

            // We set the $postdata variable with the current data in our master array so that
            // each cycle of the loop is dealing with the processed data from the last cycle
            if ($row['is_array'] == TRUE AND is_array($this->_field_data[$row['field']]['postdata']))
            {
                // We shouldn't need this safety, but just in case there isn't an array index
                // associated with this cycle we'll bail out
                if ( ! isset($this->_field_data[$row['field']]['postdata'][$cycles]))
                {
                    continue;
                }

                $postdata = $this->_field_data[$row['field']]['postdata'][$cycles];
                $_in_array = TRUE;
            }
            else
            {
                $postdata = $this->_field_data[$row['field']]['postdata'];
            }

            // --------------------------------------------------------------------

            // Is the rule a callback?
            $callback = FALSE;
            if (substr($rule, 0, 9) == 'callback_')
            {
                $rule = substr($rule, 9);
                $callback = TRUE;
            }

            // Strip the parameter (if exists) from the rule
            // Rules can contain a parameter: max_length[5]
            $param = FALSE;
            if (preg_match("/(.*?)\[(.*)\]/", $rule, $match))
            {
                $rule    = $match[1];
                $param    = $match[2];
            }

            // Call the function that corresponds to the rule
            if ($callback === TRUE)
            {
                if ( ! method_exists($this->CI, $rule))
                {
                    continue;
                }

                // Run the function and grab the result
                $result = $this->CI->$rule($postdata, $param);

                // Re-assign the result to the master data array
                if ($_in_array == TRUE)
                {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                }
                else
                {
                    $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                }

                // If the field isn't required and we just processed a callback we'll move on...
                if ( ! in_array('required', $rules, TRUE) AND $result !== FALSE)
                {
                    continue;
                }
            }
            else
            {
                if ( ! method_exists($this, $rule))
                {
                    // If our own wrapper function doesn't exist we see if a native PHP function does.
                    // Users can use any native PHP function call that has one param.
                    if (function_exists($rule))
                    {
                        $result = $rule($postdata);

                        if ($_in_array == TRUE)
                        {
                            $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                        }
                        else
                        {
                            $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                        }
                    }
                    else
                    {
                        log_message('debug', "Unable to find validation rule: ".$rule);
                    }

                    continue;
                }

                $result = $this->$rule($postdata, $param);

                if ($_in_array == TRUE)
                {
                    $this->_field_data[$row['field']]['postdata'][$cycles] = (is_bool($result)) ? $postdata : $result;
                }
                else
                {
                    $this->_field_data[$row['field']]['postdata'] = (is_bool($result)) ? $postdata : $result;
                }
            }

            // Did the rule test negatively?  If so, grab the error.
            if ($result === FALSE)
            {
                if ( ! isset($this->_error_messages[$rule]))
                {
                    if (FALSE === ($line = $this->CI->lang->line($rule)))
                    {
                        $line = 'Unable to access an error message corresponding to your field name.';
                    }
                }
                else
                {
                    $line = $this->_error_messages[$rule];
                }

                // Is the parameter we are inserting into the error message the name
                // of another field?  If so we need to grab its "field label"
                if (isset($this->_field_data[$param]) AND isset($this->_field_data[$param]['label']))
                {
                    $param = $this->_translate_fieldname($this->_field_data[$param]['label']);
                }

                // Build the error message
                $message = sprintf($line, $this->_translate_fieldname($row['label']), $param);

                // Save the error message
                $this->_field_data[$row['field']]['error'] = $message;

                if ( ! isset($this->_error_array[$row['field']]))
                {
                    $this->_error_array[$row['field']] = $message;
                }

                return;
            }
        }
    }
    
    public function html_max_length($str, $val)
    {
        return $this->max_length(strip_tags($str),$val);  
    }
    
    public function required_language($str, $val)
    {
        foreach($this->CI->lang->get_languages() as $iso => $language){
            $str_lang = strip_tags($this->CI->input->post($val . "_" . $iso,TRUE));

            if($this->required($str_lang)){
                return TRUE;
            }
        }

        return FALSE; 
    }

    public function valid_url($str)
    {
        $url_regexp = "((https|http):((//)|(\\\\))+[\w\d:#@%/;$()~_?\+-=\\\.&]*)";
        return ( ! preg_match($url_regexp, $str)) ? FALSE : TRUE;     
    }

    public function valid_youtube_url($str){ // Default to requiring http://, http://www., or www.  prefix
        $protocol = '(http://)|(http://www.)|(www.)';
        $protocol = str_replace('.', '\.', str_replace('/', '\/', $protocol)); // escape those reg exp characters
        $protocol = ($protocol != '') ? '^(' . $protocol . ')' : $protocol; //if empty arg passed, let it it match anything at beginning
        $match_str = '/' . $protocol . 'youtube\.com\/(.+)(v=.+)/'; //build the match string
        preg_match($match_str, $str, $matches); // find the matches and put them in $matches variable
        if(count($matches) < 3){ //No matter what protocol/prefix, we should have at least 3 matches
          return FALSE; //bad URI
        }else{ //so far so good....
          $qs = explode('&',$matches[count($matches)-1]); //the last match will be the querystring - split them at amperstands
          $vid = false; //default the video ID to false
          for($i=0; $i<count($qs); $i++){ //loop through the params
              $x = explode('=', $qs[$i]); //split at = to find key/value pairs
              if($x[0] == 'v' && $x[1]){ //if the param is 'v', and it has a value associated, we want it
                  return TRUE;
              }else{
                  return FALSE; //invalid querystring - couldn't find the video ID
              }
          }
          return FALSE; //everything went wrong....ouch
        }
    }
    
    public function valid_date($str){ 
        
        $regexp = '/^(19|20)[0-9]{2}[- \/.](0[1-9]|1[012])[- \/.](0[1-9]|[12][0-9]|3[01])$/';

        if(preg_match($regexp, $str)){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function valid_frontend_date($str){ 
        $regexp = '/^(0[1-9]|[12][0-9]|3[01])[- \/.](0[1-9]|1[012])[- \/.](19|20)[0-9]{2}$/';
        if(preg_match($regexp, $str)){
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function valid_color($str){ 
        $regexp = '/^#?([a-f]|[A-F]|[0-9]){3}(([a-f]|[A-F]|[0-9]){3})?$/i';
        if(preg_match($regexp, $str)){               
            return TRUE;
        }else{
            return FALSE;
        }

    }

    public function alpha($str)
    {
        return parent::alpha(strtolower($str));
    }
    
   
    public function alpha_numeric($str)
    {
        return parent::alpha_numeric(strtolower($str));
    }
    
  
    public function alpha_dash($str)
    {
        return parent::alpha_dash(strtolower($str));
    }
    
    public function get_errors(){
        return $this->_error_array;
    }
    
}