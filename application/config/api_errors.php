<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config["api_errors"] = array(
    "missing_token" => array(
                                "Error" => "missing_token",
                                "Description" => "The request is missing the access token" 
                                ),
    "missing_user_id" => array(
                                "Error" => "missing_user_id",
                                "Description" => "The request is missing the user id" 
                                ),
    "invalid_user_id" => array(
                                "Error" => "invalid_user_id",
                                "Description" => "The user id is invalid" 
                                ),                            
    "invalid_token" => array(
                                "Error" => "invalid_token",
                                "Description" => "The access token is invalid" 
                                ),
    "token_expired" => array(
                                "Error" => "token_expired",
                                "Description" => "The access token has expired" 
                                ),
    "user_blocked" => array(
                                "Error" => "user_blocked",
                                "Description" => "" 
                                ), 
    "unknown_error" => array(
                                "Error" => "unknown_error",
                                "Description" => "An unknown error has occurred" 
                                ),                            
    "validation_error" => array(
                                "Error" => "validation_error",
                                "Description" => "There are fields that missed the validation",
                                "Validation" => null 
                                ),
    "revalidate_token_error" => array(
                                "Error" => "revalidate_token_error",
                                "Description" => "The token could not be revalidated." 
                                ),
    "invalid_ids_given" => array(
                                "Error" => "invalid_ids_given",
                                "Description" => "One or more of the IDs given was incorrect." 
                                ), 
    "user_status_blocked" => array(
                                "Error" => "Account Blocked",
                                "Description" => "Your account is blocked." 
                                ), 
                                
    "user_status_incomplete" => array(
                                "Error" => "Account Suspended",
                                "Description" => "If you didn't receive or lost the validation email, just reset your password and we'll validate it for you.." 
                                ),     
    "login_error_email" => array(
                            "Error" => "Login error",
                            "Description" => "This email does not exist",
                            "Validation" => null 
                            ),
   "login_error_password" => array(
                            "Error" => "Login error",
                            "Description" => "Wrong password. Please repeat",
                            "Validation" => null 
                            ),
  "login_error_empty" => array(
                            "Error" => "Login error",
                            "Description" => "Empty fields",
                            "Validation" => null 
                            ),
         
         
    "update_error" => array(
                            "Error" => "Update error",
                            "Description" => "",
                            "Validation" => null 
                            ),
    "create_error" => array(
                            "Error" => "Create account error",
                            "Description" => "",
                            "Validation" => null 
                            ),
    "wish_creation_not_allowed" => array(
                            "Error" => "Wish creation not allowed",
                            "Description" => "This wish contains a black listed word. Please rephrase your wish.",
                            "Validation" => null 
                            ),
    "delete_error_wish_thanked" => array(
                            "Error" => "Delete error",
                            "Description" => "The wish can't be deleted because it was thanked.",
                            "Validation" => null 
                            ),
    "no_auth"	=> array(
    						"Error" => "Auth",
                            "Description" => "No authorization.",
                            "Validation" => null 
                            ),
);