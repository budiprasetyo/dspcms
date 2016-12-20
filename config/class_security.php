<?php
/**-------------------------------------------------------------------------------------------------
 *    Class:          requestFilter
 *    Extends:        requestVars
 *    Description:    Sets user defined "filter" array as the source of the variables
 *    Constructor(s): requestVars($filter)
/*-------------------------------------------------------------------------------------------------*/
class requestFilter extends requestVars{ // extend the common class
   /**-------------------------------------------------------------------------------------------------
    *    Constructor:    requestFilter()
    *    Class:          requestFilter
    *    Description:    Sets user defined "filter" array as the source of the variables
   /*-------------------------------------------------------------------------------------------------*/
   public function requestFilter($filter){
       $this->source = &$filter; //set the source to filter array
   }
}

/**-------------------------------------------------------------------------------------------------
 *    Class:          requestCookie
 *    Extends:        requestVars
 *    Description:    Sets global $_COOKIE array as the source of the variables
 *    Constructor(s): requestVars()
/*-------------------------------------------------------------------------------------------------*/
class requestCookie extends requestVars{ // extend the common class
   /**-------------------------------------------------------------------------------------------------
    *    Constructor:    requestCookie()
    *    Class:          requestCookie
    *    Description:    Sets global $_COOKIE array as the source of the variables
   /*-------------------------------------------------------------------------------------------------*/
   public function requestCookie(){
       $this->source = &$_COOKIE; //set the source to Cookie
   }
}

/**-------------------------------------------------------------------------------------------------
 *    Class:            requestGet
 *    Extends:          requestVars
 *    Description:      Sets global $_GET array as the source of the variables
 *    Constructor(s):   requestVars()
/*-------------------------------------------------------------------------------------------------*/
class requestGet extends requestVars{// extend the common class
   /**-------------------------------------------------------------------------------------------------
    *    Constructor:    requestGet()
    *    Class:          requestGet
    *    Description:    Sets global $_GET array as the source of the variables
   /*-------------------------------------------------------------------------------------------------*/
   public function requestGet(){
       $this->source = &$_GET;//set the source to Get
   }
}

/**-------------------------------------------------------------------------------------------------
 *    Class:            requestPost
 *    Extends:          requestVars
 *    Description:      Sets global $_POST array as the source of the variables
 *    Constructor(s):   requestVars()
/*-------------------------------------------------------------------------------------------------*/
class requestPost extends requestVars{// extend the common class
   /**-------------------------------------------------------------------------------------------------
    *    Constructor:    requestPost()
    *    Class:          requestPost
    *    Description:    Sets global $_POST array as the source of the variables
   /*-------------------------------------------------------------------------------------------------*/
   public function requestPost(){
       $this->source = &$_POST; //set the source to Post
   }
}

/**-------------------------------------------------------------------------------------------------
 *    Class:          requestSession
 *    Extends:        requestVars
 *    Description:    Sets global $_POST array as the source of the variables
 *    Constructor(s): requestVars()
/*-------------------------------------------------------------------------------------------------*/
class requestSession extends requestVars{// extend the common class
   /**-------------------------------------------------------------------------------------------------
    *    Constructor:    requestSession()
    *    Class:          requestSession
    *    Description:    Sets global $_SESSION array as the source of the variables
   /*-------------------------------------------------------------------------------------------------*/
   public function requestSession(){
       $this->source = &$_SESSION;//set the source to Session
   }
}

/**-------------------------------------------------------------------------------------------------
 *    Class:          requestVars
 *    Description:    Sets global $_REQUEST array as the source of the variables
 *    Constructor(s): requestVars()
/*-------------------------------------------------------------------------------------------------*/
class requestVars{
   protected $source = array();  // a common source container for filter(user defined), GET, POST, COOKIE or REQUEST (default in constructor)

   /**-------------------------------------------------------------------------------------------------
    *    Constructor:    requestVar()
    *    Class:          requestVar
    *    Description:    Sets global $_REQUEST array as the source of the variables
   /*-------------------------------------------------------------------------------------------------*/
   public function requestVars(){
       $this->source = &$_REQUEST; // construct our source as _REQUEST, by default
   }
  
   /**-------------------------------------------------------------------------------------------------
    *    Function:        getVarCount
    *    Class:            requestVar
    *    Description:    Returns number of elements in an array type parameter.
    *                    Returns 0 if the parameter is not array, false if it doesnt exist
    *    Used For:        Running a loop on available parameters.
    *    Sample Output:    -1, 0, 12
    *    Parameter(s):    $param - Parameter name, this would be the element id to get from base array set in constructor
    *                    $default - Default value to return, (optional, 0 = default)
    *                    $sub - Element number if $param is an array, (optional, 0 = default)
   /*-------------------------------------------------------------------------------------------------*/
   function getVarCount($param){
       if (isset($this->source[$param])) {                        // check if parameter is set
           if (is_array($this->source[$param]))                // if its array count the elements
               return count($this->source[$param]);            // and return
           else
               return 0;                                        // return 0 if its just a variable
       }else
           return false;                                        // return false if param not set
   }

   /**-------------------------------------------------------------------------------------------------
    *    Function:        getVarInt
    *    Class:            requestVar
    *    Description:    Returns the required parameter if its integer, otherwise return default value.
    *    Used For:        Strictly Whole Numbers, e.g. Quantity
    *    Sample Output:    -1, 0, 12
    *    Parameter(s):    $param - Parameter name, this would be the element id to get from base array set in constructor
    *                    $default - Default value to return, (optional, 0 = default)
    *                    $sub - Element number if $param is an array, (optional, 0 = default)
   /*-------------------------------------------------------------------------------------------------*/
   function getVarInt($param, $default = 0, $sub=0){
  
       if (isset($this->source[$param])) {                        // check if parameter is set
           if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else
               $sourceParam =$this->source[$param];            //otherwise just get the parameter
           return (int)$sourceParam;                            // return the integer of parameter
       }else
           return $default;                                    // return default value if param not set
   }

   /**-------------------------------------------------------------------------------------------------
    *    Function:        getVarFloat
    *    Class:            requestVar
    *    Description:    Returns the required parameter if its float, otherwise return default value.
    *     Used For:        Strictly Float Numbers, e.g. Price
    *    Sample Output:    1.0, 0.765, -12.7
    *    Parameter(s):    $param - Parameter name, this would be the element id to get from base array set in constructor
    *                    $default - Default value to return, (optional, 0 = default)
    *                    $sub - Element number if $param is an array, (optional, 0 = default)
   /*-------------------------------------------------------------------------------------------------*/
   function getVarFloat($param, $default = 0, $sub = 0){
       if (isset($this->source[$param])) {                        // check if parameter is set
           if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else
               $sourceParam =$this->source[$param];            //otherwise just get the parameter
           return (float)$sourceParam;                        // return the float of parameter
       }else
           return $default;                                    // return default value if param not set
   }

   /**-------------------------------------------------------------------------------------------------
    *    Function:        getVarAlpha
    *    Class:            requestVar
    *    Description:    Returns the required parameter if its strict alphabetical, otherwise return default value.
    *    Used For:        Strictly Alphabetics, e.g. First Name / Last Name
    *    Sample Output:    david, bob
    *    Parameter(s):    $param - Parameter name, this would be the element id to get from base array set in constructor
    *                    $max - Maximum number of characters allowed, no restriction in default (optional, -1 = default)
    *                    $default - Default value to return, (optional, NULL = default)
    *                    $sub - Element number if $param is an array, (optional, 0 = default)
   /*-------------------------------------------------------------------------------------------------*/
   function getVarAlpha($param, $max = 0, $default = NULL, $sub = 0){
       if (isset($this->source[$param])) {                        // check if parameter is set
               if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else
               $sourceParam =$this->source[$param];            //otherwise just get the parameter
           preg_match("/^[A-Za-z]+$/",$sourceParam,$arr);        //check strictly there is one alphabetic atleast
           if (!empty($arr))                                    //if you have caught something as alphabetic, return it
               return ($max>0)
               ? substr($arr[0],0,$max)                        //truncate the length
               : $arr[0];
       }
       return $default;                                        // return  default if param not set or its not alphabetic
   }

   /**-------------------------------------------------------------------------------------------------
    *    Function:        getVarFileName
    *    Class:            requestVar
    *    Description:    Returns the required parameter if it can be a File Name, otherwise return default value.
    *    Used For:        File Names, e.g. image filename
    *    Sample Output:    image_01.gif, abc.php
    *    Parameter(s):    $param - Parameter name, this would be the element id to get from base array set in constructor
    *                    $max - Maximum number of characters allowed, no restriction in default (optional, -1 = default)
    *                    $encode - Checks if URL Encoding is requred, (optional, 1 = default)
    *                    $default - Default value to return, (optional, NULL = default)
    *                    $sub - Element number if $param is an array, (optional, 0 = default)
   /*-------------------------------------------------------------------------------------------------*/
   function getVarFileName($param, $max = -1, $encode = 1, $default = NULL, $sub = 0){
       if (isset($this->source[$param])) {                        // check if parameter is set
           if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else $sourceParam =$this->source[$param];            //otherwise just get the parameter
                                                               //check strictly there is no malicious characters
                                                               //allows only file name valid characters
           preg_match("/^[\.\-\s#_a-zA-Z\d]+$/",$sourceParam,$arr);
          
           if (!empty($arr))                                    //if you have caught something as filename, return it
           {    if ($encode==1) $arr[0]=urlencode($arr[0]);    //Check is URL Encoding is required
               return ($max>0)
               ? substr($arr[0],0,$max)                        //truncate the length
               : $arr[0];
           }
       }
       return $default; // return  default if param not set or it contains invalid characters
   }

   /**-------------------------------------------------------------------------------------------------
    *    Function:        getVarPath
    *    Class:            requestVar
    *    Description:    Returns the required parameter if it can be path to sub directory, otherwise return default value.
    *    Used For:        SUB Directories, e.g. image sub directory
    *    Sample Output:    images, files/docs
    *    Parameter(s):    $param - Parameter name, this would be the element id to get from base array set in constructor
    *                    $max - Maximum number of characters allowed, no restriction in default (optional, -1 = default)
    *                    $encode - Checks if URL Encoding is requred, (optional, 1 = default)
    *                    $default - Default value to return, (optional, NULL = default)
    *                    $sub - Element number if $param is an array, (optional, 0 = default)
   /*-------------------------------------------------------------------------------------------------*/
   function getVarPath($param, $max = -1, $encode = 1, $default = NULL, $sub = 0){
       if (isset($this->source[$param])) {                        // check if parameter is set
               if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else
               $sourceParam =$this->source[$param];            //otherwise just get the parameter
                                                                   //check strictly there is no malicious characters
                                                                   //allows only directory valid characters
                                                               //dont start with /
           preg_match("/^[\.\-\s_a-zA-Z\d][\/\.\-\s_a-zA-Z\d]*$/",$sourceParam,$arr);
           if (!empty($arr))                                    //if you have caught something as path
           {                                                   
                                                                   //never allow // or .. anywhere
                   preg_match("/\/\/|\.\./",$arr[0],$arrCatch);
                   if (!empty($arrCatch))                                //caught with // or ..
                       return $default;                            // return  default
                  
                   return ($max>0)                                //not caught, return the path
               ? substr($arr[0],0,$max)                        //truncate the length
               : $arr[0];
           }
       }
       return $default; // return  default if param not set or it contains invalid characters
   }
   //-----------------------------------------------------------------------------------
   //used for strict alphabetical words allowing a space e.g. bob robinson :: Full Name
   function getVarAlphaSpace($param, $max = -1, $default = NULL, $sub = 0){
       if (isset($this->source[$param])) { // check if parameter is set
               if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else $sourceParam =$this->source[$param];            //otherwise just get the parameter
           //check strictly there is one alphabetic atleast
           //start with aplhabetic, may include space, end with alhabetic
           preg_match("/^[A-Za-z]([A-Za-z\s]*[A-Za-z])*$/",$sourceParam,$arr);
           //if you have caught something as alphabetic with/without space, return it
           if (!empty($arr)) return ($max>0) ? substr($arr[0],0,$max) : $arr[0];
       }
       return $default; // return  default if param not set or its not alphabetic with/without space
   }

   //-----------------------------------------------------------------------------------
   //used for alphanumeric input, no spaces, no underscores e.g. user123 :: Usernames(no underscores)
   function getVarAlphaNum($param, $max = -1, $default = NULL, $sub = 0){
       if (isset($this->source[$param])) { // check if parameter is set
               if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else $sourceParam =$this->source[$param];            //otherwise just get the parameter
           //check strictly there is one alpha/nums atleast
           //start with aplhabetic, may include alpha/numerics, end with alhabetic/numeric
           preg_match("/^[A-Za-z][A-Za-z0-9]*$/",$sourceParam,$arr);
           //if you have caught something as alphaNum, return it
           if (!empty($arr)) return ($max>0) ? substr($arr[0],0,$max) : $arr[0];
       }
       return $default; // return  default if param not set or its not alphaNum
   }

   //-----------------------------------------------------------------------------------
   //used for alphanumeric input with spaces, no underscores e.g. Product 123 :: Product Name(no underscores)
   function getVarAlphaNumSpace($param, $max = -1, $default = NULL, $sub = 0){
       if (isset($this->source[$param])) { // check if parameter is set
               if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else $sourceParam =$this->source[$param];            //otherwise just get the parameter
           //check strictly there is one alpha/nums atleast
           //start with aplhabetic, may include space/numerics, end with alhabetic/numeric
           preg_match("/^[A-Za-z]([A-Za-z0-9\s]*[A-Za-z0-9])*$/",$sourceParam,$arr);
           //if you have caught something as alphaNum, return it
           if (!empty($arr)) return ($max>0) ? substr($arr[0],0,$max) : $arr[0];
       }
       return $default; // return  default if param not set or its not alphaNum
   }

   //-----------------------------------------------------------------------------------
   //used for alphanumeric input with underscores, no spaces e.g. product_color_1 :: DB Field(using underscores)
   function getVarAlpha_Num($param, $max = -1, $default = NULL, $sub = 0){
       if (isset($this->source[$param])) { // check if parameter is set
               if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else $sourceParam =$this->source[$param];            //otherwise just get the parameter
           //check strictly there is one alpha/nums atleast
           //start with aplhabetic, may include underscore/numerics, end with alhabetic/numeric
           preg_match("/^[A-Za-z]([A-Za-z0-9_]*[A-Za-z0-9])*$/",$sourceParam,$arr);
           //if you have caught something as alpha_Num, return it
           if (!empty($arr)) return ($max>0) ? substr($arr[0],0,$max) : $arr[0];
       }
       return $default; // return  default if param not set or its not alpha_Num
   }

   //-----------------------------------------------------------------------------------
   //used for alphanumeric input with underscores and spaces e.g. product_color 1 :: Maybe someday I will need it (using underscores and spaces)
   function getVarAlpha_NumSpace($param, $max = -1, $default = NULL, $sub = 0){
       if (isset($this->source[$param])) { // check if parameter is set
               if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else $sourceParam =$this->source[$param];            //otherwise just get the parameter
           //check strictly there are two alpha/nums atleast
           //start with aplhabetic, may include space/numerics/underscores/alphabetics, end with alhabetic/numeric
           preg_match("/^[A-Za-z]([A-Za-z0-9\s_]*[A-Za-z0-9])*$/",$sourceParam,$arr);
           //if you have caught something as alpha_num Num, return it
           if (!empty($arr)) return ($max>0) ? substr($arr[0],0,$max) : $arr[0];
       }
       return $default; // return  default if param not set or its not alpha_num Num
   }

   //-----------------------------------------------------------------------------------
   //used for alpha OR numeric input with spaces, no underscores e.g. product 123 :: Search Keyword(no underscores)
   function getVarAlphaOrNum($param, $max = -1, $default = NULL, $sub = 0){
       if (isset($this->source[$param])) { // check if parameter is set
               if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else $sourceParam =$this->source[$param];            //otherwise just get the parameter
           //check strictly there is either an alpha or a num atleast
           //min length is 2
           //start with alpha / num, may include space, end with alhabetic/numeric
           preg_match("/^[A-Za-z0-9]([A-Za-z0-9\s]*[A-Za-z0-9])*$/",$sourceParam,$arr);
           //if you have caught something as alpha or num, return it
           if (!empty($arr)) return ($max>0) ? substr($arr[0],0,$max) : $arr[0];
       }
       return $default; // return  default if param not set or its not alpha or num
   }

   //-----------------------------------------------------------------------------------
   //used for alpha OR numeric input with spaces, underscores and some special characters
   // e.g. product-123 @ $20 :: More Sensible(maybe weird) Product Titles
   function getVarString($param, $max = -1, $default = NULL, $sub = 0){
       if (isset($this->source[$param])) { // check if parameter is set
               if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else $sourceParam =$this->source[$param];            //otherwise just get the parameter
           //check strictly there is either an alpha or a num atleast
           //include alpha / num, may also include space, special characters
           preg_match("/^[\(\)\/\'\"\,\.\-\$\&\£\s@\?#_a-zA-Z\d]+$/",$sourceParam,$arr);
           //if you have caught something as alpha or num, return it
           if (!empty($arr)) return ($max>0) ? substr($arr[0],0,$max) : $arr[0];
       }
       return $default; // return  default if param not set or its not alpha or num
   }

   //-----------------------------------------------------------------------------------
   //maybe this is the most dangreous version, very low security in this one
   //used for all string, just convert html to its entities, it will display (when printed)
   //malicious tags like <script> on output instead of removing it or executing it
   function getVar($param, $addslash = 1, $max = -1,  $default = NULL, $sub = 0){
       if (isset($this->source[$param])) { // check if parameter is set
               if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else $sourceParam =$this->source[$param];            //otherwise just get the parameter
               if ($max>0) $textvar= substr($this->source[$param],0,$max);
           else $textvar=$this->source[$param];
/*              if ($addslash==1 && !get_magic_quotes_gpc()) $textvar=addslashes(addslashes($textvar));
               if ($addslash==0 && get_magic_quotes_gpc())  { $textvar=stripslashes($textvar);            }*/
//            if ($addslash==1) $textvar=stripsla($textvar,$conn);
           //cleaning up data
           $textvar=htmlentities($this->source[$param]);
          
           return $textvar;
       }
       return $default; // return  default if param not set or its not alpha or num
   }

   //-----------------------------------------------------------------------------------
   //This is the open version, NO security in this one, use only in admin panel
   function getVarHTML($param, $max = 0,  $default = NULL, $sub = 0){
       if (isset($this->source[$param])) { // check if parameter is set
               if (is_array($this->source[$param]))                //if its array get the required sub
               $sourceParam=$this->source[$param][$sub];
           else $sourceParam =$this->source[$param];            //otherwise just get the parameter
               if ($max>0) $textvar= substr($this->source[$param],0,$max);
           else $textvar=$this->source[$param];
          
           return $textvar;
       }
       return $default; // return  default if param not set or its not alpha or num
   }
}

?>


