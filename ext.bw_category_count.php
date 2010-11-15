<?php

/**
* @package ExpressionEngine
* @author Wouter Vervloet
* @copyright  Copyright (c) 2010, Baseworks
* @license    http://creativecommons.org/licenses/by-sa/3.0/
* 
* This work is licensed under the Creative Commons Attribution-Share Alike 3.0 Unported.
* To view a copy of this license, visit http://creativecommons.org/licenses/by-sa/3.0/
* or send a letter to Creative Commons, 171 Second Street, Suite 300,
* San Francisco, California, 94105, USA.
* 
*/

if ( ! defined('EXT')) { exit('Invalid file request'); }

class Bw_category_count_ext
{
  public $settings            = array();
  
  public $name                = 'BW Category Count';
  public $version             = 0.9;
  public $description         = "Add a {category_count} variable to the {exp:channel:entries} loop.";
  public $settings_exist      = 'n';
  public $docs_url            = '';
			
	// -------------------------------
	// Constructor
	// -------------------------------
	function Bw_category_count_ext($settings='')
	{
	  $this->__construct($settings);
	}
	
	function __construct($settings='')
	{

    $this->EE =& get_instance();
	  
		$this->settings = $settings;
		
	}
	// END Bw_category_count
	
  /**
  * Count the categories and add the category_count variable
  */
  function add_category_count($obj, $row)
  {

    $cat_count = 0;
    
    if( isset($obj->categories[$row['entry_id']]) AND is_array($obj->categories[$row['entry_id']]) )
    {
      $cat_count = count($obj->categories[$row['entry_id']]);
    }
    
    $row['category_count'] = $cat_count;
    
    return $row;

  }
  // END settings_form
	
	// --------------------------------
	//  Activate Extension
	// --------------------------------
	function activate_extension()
	{

    // hooks array
    $hooks = array(
      'channel_entries_row' => 'add_category_count'
    );

    // insert hooks and methods
    foreach ($hooks AS $hook => $method)
    {
      // data to insert
      $data = array(
        'class'		=> get_class($this),
        'method'	=> $method,
        'hook'		=> $hook,
        'priority'	=> 1,
        'version'	=> $this->version,
        'enabled'	=> 'y',
        'settings'	=> ''
      );

      // insert in database
      $this->EE->db->insert('exp_extensions', $data);
    }

    return true;
	}
	// END activate_extension
	 
	 
	// --------------------------------
	//  Update Extension
	// --------------------------------  
	function update_extension($current='')
	{
		
    if ($current == '' OR $current == $this->version)
    {
      return FALSE;
    }
    
    if($current < $this->version) { }

    // init data array
    $data = array();

    // Add version to data array
    $data['version'] = $this->version;    

    // Update records using data array
    $this->EE->db->where('class', get_class($this));
    $this->EE->db->update('exp_extensions', $data);
  }
  // END update_extension

	// --------------------------------
	//  Disable Extension
	// --------------------------------
	function disable_extension()
	{		
    // Delete records
    $this->EE->db->where('class', get_class($this));
    $this->EE->db->delete('exp_extensions');
  }
  // END disable_extension

	 
}
// END CLASS