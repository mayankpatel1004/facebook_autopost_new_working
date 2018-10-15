<?php
define('FB','https://m.facebook.com');
define('FORM','~<form method="post" (.*?)</form>~s');
define('ACTION','~action=(?:["\'])?([^"\'\s]*)~i');
define('INPUT','~<input(.*?)>~');
define('NAME','~name=(?:["\'])?([^"\'\s]*)~i');
define('VALUE','~value=(?:["\'])?([^"\'\s]*)~i');

class FBform extends HttpCurl	{
private $_url;
private $_inputs = array();

public function __construct() 	{}	 	
public function __destruct()	{}
	
public function fbLogin($username, $password) {
	unset ($this->_inputs);
	unset ($this->_url);	
	$this->getFormFields();
	$this->_inputs['email']=$username;
	$this->_inputs['pass']=$password;
//	$this->_url = FB . $this->_url;	
	$post_field = $this->arrayImplode( '=', '&', $this->_inputs);
	$this->post($this->_url,  $post_field);	
}
	
public function fbStatusUpdate($status) {
	unset ($this->_inputs);
	unset ($this->_url);	
	$this->getFormFields();
//	$this->_inputs['status']=$status;   // Not working anymore. Change to xc_message
	$this->_inputs['xc_message']=$status;	
	$this->_url = FB . $this->_url;
	$post_field = $this->arrayImplode( '=', '&', $this->_inputs);
	$this->post($this->_url,  $post_field);	
}
	
public function arrayImplode( $glue, $separator, $array ) {
	$string = array();
	foreach ( $array as $key => $val ) {
		if ( is_array( $val ) )
		$val = implode( ',', $val );
		$string[] = "{$key}{$glue}{$val}";
	}
	return implode( $separator, $string );
}

public function getFormFields() {	
	if (preg_match(FORM, parent::getBody(), $form)) {
		preg_match(ACTION, $form[0], $action); 
		$this->_url= $action[1];
		preg_match_all(INPUT, $form[0], $fields); 	
		
		foreach ($fields[0] as $field) {
			if (preg_match(NAME, $field, $name)) {
				$name = $name[1];
                $value = '';

			if (preg_match(VALUE, $field, $value))	$value = $value[1];

			if ($value!=NULL) 	 $this->_inputs[$name] = $value;			
			}
		}
		return $this->_inputs;	
		} else {
		echo "Error, Form not found!";  }
	}		
}

?>