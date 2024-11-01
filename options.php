<?php
/*	WP Options API v.1.0
	A simple solution to storage with the Wordpress options table in the database
	Released by Daniel, www.nexterous.com, GNU Public License
*/
class Option{
	public $name;
	public $storage = array();
	
	function __construct($name){
		if(!get_option($name)){
			add_option($name, serialize($this->storage), '', 'no');
		}
		$option = get_option($name);
		if(!is_array($option)):
			unserialize($option);
		endif;
		$this->storage = $option;
		$this->name = $name;
	}
	
	function add_value($key, $value){
		$this->storage[$key] = $value;
	}
	
	function delete_value($key){
		unset($this->storage[$key]);
	}
	
	function __destruct(){
		if(!is_array($this->storage)):
			$this->storage = array();
		endif;
		$option = serialize($this->storage);
		update_option($this->name, $option);
	}
}