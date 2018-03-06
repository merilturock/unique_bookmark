<?php

elgg_register_event_handler ( 'init', 'system', 'unique_bookmarks_init' );

function unique_bookmarks_init() {
	elgg_register_ajax_view('unique_bookmarks/ajax_search');
	elgg_extend_view('elgg.css', 'unique_bookmarks/css');
	elgg_register_plugin_hook_handler('action', 'bookmarks/save', 'unique_bookmarks_hook',1);	
}

function unique_bookmarks_hook($hook, $action, $return, $params){
	elgg_make_sticky_form('bookmarks');
	$address = get_input('address');
	if ($address){
		$results = unique_bookmarks_search($address);
		if(is_array($results)){
			elgg_clear_sticky_form('bookmarks');
			register_error($results['message']);
			$entity = $results['entity'];
			forward($entity->getURL());
		}
	}
	return true;	
}

function unique_bookmarks_search($address = false){
	$return = null;
	if($address){
		if(!preg_match("#^((ht|f)tps?:)?//#i", $address)) {
			$address = "http://$address";
		}
		$address = rtrim($address, '/');
		$entities = elgg_get_entities_from_metadata(array( 'type' => 'object', 'subtype' => 'bookmarks', 'metadata_name' => 'address', 'metadata_value' => $address, 'limit' => 1));
		if($entities){
			$owner_guid = $entities[0]->owner_guid;
			$logged_in_guid = (int) elgg_get_logged_in_user_guid();
			if($owner_guid == $logged_in_guid){
				$message = elgg_echo('uniquebookmarks:selfcreated');
			} else {
				$message = elgg_echo('uniquebookmarks:exists');
			}
			$return = array('status' => 1, 'message' => $message, 'entity' => $entities[0]);
		}	
	}
	return $return;
}