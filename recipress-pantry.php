<?php
/*
* Plugin Name: ReciPress - Pantry Widget add-on
* Plugin URI:  https://github.com/Omicron7/recipress-pantry
* Description: This plugin is an add-on for ReciPress. The Pantry Widget allows you to select ingredients you have in your pantry and to list them as links to recipes that contain the ingredient.
* Author:      Brian Zoetewey
* Author URI:  https://github.com/Omicron7
* Version:     1.0
* Text Domain: pantrywidget
* Domain Path: /languages/
* License:     Modified BSD
*/
?>
<?php
/*
 * Copyright (c) 2012, BRIAN ZOETEWEY
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 * 
 *     Redistributions of source code must retain the above copyright notice, this
 *         list of conditions and the following disclaimer.
 *     Redistributions in binary form must reproduce the above copyright notice,
 *         this list of conditions and the following disclaimer in the documentation
 *         and/or other materials provided with the distribution.
 *     Neither the name of BRIAN ZOETEWEY nor the names of its
 *         contributors may be used to endorse or promote products derived from this
 *         software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT,
 * INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE
 * OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED
 * OF THE POSSIBILITY OF SUCH DAMAGE.
 */
?>
<?php
//Only register the autoload function if the function does not exist yet
if( !function_exists( 'recipress_pantrywidget_autoloader' ) ) {
	/**
	 * Includes classes as they are needed
	 * @param string $classname Class name autoload is searching for
	 */
	function recipress_pantrywidget_autoloader( $classname ) {
		//List of classes and their location
		$classes = array(
			'ReciPress_PantryPlugin' => '/pantry.class.php',
			'ReciPress_PantryWidget' => '/widgets/pantry-widget.class.php',
		);
		
		if( array_key_exists( $classname, $classes ) )
			require_once( dirname( __FILE__ ) . $classes[ $classname ] );
	}
	
	//Register the autoload function with PHP
	spl_autoload_register( 'recipress_pantrywidget_autoloader' );
}

//Instantiate the Recipress Pantry plugin
ReciPress_PantryPlugin::singleton();
