<?php
  require_once 'lib-supportbee.php';
  class Tickets{
    public $supportbee;
    function __construct($params) { 
		$this->supportbee = new SupportBee\Client($params);
	}

    public function getTickets($filters = array()) {
    	return $this->supportbee->fetch('tickets');
    }
	
	public function getTicketDetails(){
		// get ticket json
		$ticket_info = $this->supportbee->fetch('tickets');
		$ticket_ret=array();
		
		if(isset($ticket_info['tickets']) && !empty($ticket_info['tickets'])){
		
			// for each ticket 
			$replies = array();
			$comments = array();
			$count = 0;
			foreach($ticket_info['tickets'] as $ticket){
				$ticket_ret[$count]['id']=$ticket['id'];
				$ticket_ret[$count]['replies_count'] = $ticket['replies_count'];
                $ticket_ret[$count]['comments_count'] = $ticket['comments_count'];
				$ticket_ret[$count]['subject'] = $ticket['subject'];
				$ticket_ret[$count]['summary'] = $ticket['summary'];
				
				
				if(isset($ticket) && !empty($ticket)){
					// fetch relies
					$api_name = 'tickets/'.$ticket['id'].'/replies';
					$replies = $this->supportbee->fetch($api_name);
					// parse each replies
					if(isset($replies['replies'])){
						foreach($replies['replies'] as $reply){
							$reply_t = explode('working on', $reply['summary']);
							$replies_ret[$count][] = $reply_t[0];
						}
					} else{
						$replies_ret[$count] = NULL;
					}
					// fetch comments
					$api_name = 'tickets/'.$ticket['id'].'/comments';
					$comments = $this->supportbee->fetch($api_name);
					// parse each replies
					if(isset($comments['comments'])){
						foreach($comments['comments'] as $comment){
							$comments_ret[$count][] = $comment['content']['html'];
						}
					} else {
						$comments_ret[$count] = NULL;
					}
					$ticket_ret[$count]['replies']=$replies_ret[$count];
					$ticket_ret[$count]['comments']=$comments_ret[$count];
				}
				++$count;
			}
		}
		return $ticket_ret;
	}
  }

?>