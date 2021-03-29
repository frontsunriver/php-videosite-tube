<?php
$id = 0;
$data = array('status' => 400);
if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
	$id = PT_Secure($_GET['id']);
	$video = $db->where('id', $id)->getOne(T_VIDEOS);

	if ($video->converted != 1) {
		if ($pt->config->queue_count > 0) {
			$video_in_queue = $db->where('video_id',$video->id)->getOne(T_QUEUE);
			$process_queue = $db->getValue(T_QUEUE,'video_id',$pt->config->queue_count);
			if ($pt->config->queue_count == 1) {
		        if ($process_queue == $video->id && $video_in_queue->processing == 1) {
		            $db->where('video_id', $video->id);
		            $db->update(T_QUEUE, array(
		                'processing' => 2
		            ));
					$data = array('status' => 200);
		        }
		    }
			elseif ($pt->config->queue_count > 1) {
				if (in_array($video->id, $process_queue) && $video_in_queue->processing == 1) {
					$db->where('video_id', $video->id);
		            $db->update(T_QUEUE, array(
		                'processing' => 2
		            ));
					$data = array('status' => 200);
				}
			}
		}
			
	}else{
		$data = array('status' => 200);
	}
}