<?php
  require_once 'lib-supportbee.php';
  class API_Wrapper{
  	public $supportbee;
	
    function __construct($params) { 
		$this->supportbee = new SupportBee\Client($params);
	}

    public function getTickets($para) {
    	return $this->supportbee->fetch('tickets'.$para);
    }
	
	public function getUserInfo(){
		return $this->supportbee->fetch('users');
	}
	
	public function createTickets($vars){
		return $this->supportbee->post('tickets', $vars);
		
	}
	
	public function showTickets($id, $vars){
		$type = 'tickets/'.$id;
		return $this->supportbee->fetch($type, $vars);
	}
	
	// working only if we give some test data.
	public function archiveTicket($id, $vars){
		$type='tickets/'.$id.'/archive';
		return $this->supportbee->post($type, $vars);
	}
	
	public function unArchiveTicket($id, $vars){
		$type='tickets/'.$id.'/archive';
		return $this->supportbee->delete($type, $vars);
	}
	
	// for user and group.
	public function assignments($id, $vars){
		$type='tickets/'.$id.'/assignment';
		return $this->supportbee->post($type, $vars);
	}
	
	// Star Ticket.
	public function starTickets($id, $vars){
		$type='tickets/'.$id.'/star';
		return $this->supportbee->post($type, $vars);
	}
	
	// Un-Star Ticket.
	public function unstarTickets($id, $vars){
		$type='tickets/'.$id.'/star';
		return $this->supportbee->delete($type, $vars);
	}
	
	// Spam tickets
	public function spamTickets($id, $vars){
		$type='tickets/'.$id.'/spam';
		return $this->supportbee->post($type, $vars);
	}

	// Un-Spam tickets
	public function unSpamTickets($id, $vars){
		$type='tickets/'.$id.'/spam';
		return $this->supportbee->delete($type, $vars);
	}
	
	// Trash Tickets
	public function trashTickets($id, $vars){
		$type='tickets/'.$id.'/trash';
		return $this->supportbee->post($type, $vars);
	}

	// Un-Trash Tickets
	public function unTrashTickets($id, $vars){
		$type='tickets/'.$id.'/trash';
		return $this->supportbee->delete($type, $vars);
	}

	//fetching replies.
	public function fetchReplies($id, $vars){
		$type='tickets/'.$id.'/replies';
		return $this->supportbee->fetch($type, $vars);
	}
	
	// create Replies.
	public function createReplies($id, $vars){
		$type='tickets/'.$id.'/replies';
		return $this->supportbee->post($type, $vars);
	}
	
	// show Replies.
	public function showReplies($id, $rid, $vars){
		$type='tickets/'.$id.'/replies/'.$rid;
		return $this->supportbee->fetch($type, $vars);
	}
	
	// fetching Comments
	public function fetchComments($id, $vars){
		$type='tickets/'.$id.'/comments';
		return $this->supportbee->fetch($type, $vars);
	}
	
	// creating Comment
	public function createComments($id, $vars){
		$type='tickets/'.$id.'/comments';
		return $this->supportbee->post($type, $vars);
	}
	
	// fetching Agents/Users
	public function fetchAgents(){
		$type='users';
		$vars='';
		return $this->supportbee->fetch($type, $vars);
	}
	
	// show Agents/Users
	public function showUser($id){
		$type='users/'.$id;
		$vars='';
		return $this->supportbee->fetch($type, $vars);
	}
	
	// Create Agent/Admin
	public function createAgent($vars){
		$type='users';
		return $this->supportbee->post($type, $vars);
	}

	// fetching Labels.
	public function fetchLabel(){
		$type='labels';
		$vars='';
		return $this->supportbee->fetch($type, $vars);
	}
	
	// adding label to ticket.
	public function addingLabelTicket($id, $vars){
		$type='tickets/'.$id.'/labels/important';
		return $this->supportbee->post($type, $vars);
	}
	
	
  }
?>