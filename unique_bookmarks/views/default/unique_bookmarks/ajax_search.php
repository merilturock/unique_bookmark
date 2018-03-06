<?php

	if (!elgg_is_xhr()) {
		register_error('Sorry, Ajax only!');
		forward();
	}

	$address = get_input('address');
	
	if($address){
		$results = unique_bookmarks_search($address);	
		if(is_array($results)){
			echo json_encode([
				'status' => $results['status'],
				'message' => $results['message'],
				'entity' => elgg_view_entity($results['entity'], array('full_view' => false)),
			]);
		}	
	}	