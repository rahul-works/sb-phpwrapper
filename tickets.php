<?php

require_once 'lib-supportbee.php'; 
require_once 'lib-tickets.php'; 

$params = array(
  'sub_domain' => 'sb-phpwrapper',
  'auth_token' => 'zwCyp5wsg4kY1cJGdszv'  # You can find your API token in Settings > API Token screen.
);

//$supportbee = new SupportBee\Client($params);
$tickets = new Tickets($params);
$ticket_data=array();
switch ($_GET['id']) {
	case 'report':
		$ticket_data = $tickets->getTicketDetails();
		break;
	
	default:
		$ticket_data = $tickets->getTickets();
		break;
}

echo '<pre>';
print_r($ticket_data);

if(isset($_GET['id'])&&$_GET['id']=='report'){
	$list[] = array('Ticket-No ', ' Subject',' Summary', ' Replies-Count', ' Replies', ' Comment-Count', ' Comment' );
	
	
	// create a data.
	foreach($ticket_data as $ticket){
		$flied[] = array();
		$field[]=''.$ticket['id'].' ';
		$field[]=' "'.$ticket['subject'].'"';
		$field[]=' "'.$ticket['Summary'].'"';
		$field[]=' '.$ticket['replies_count'].'';
		$replies=NULL;
		if(!empty($ticket['replies'])){
			foreach ($ticket['replies'] as $test) {
				$replies .='~'.$test;
			}
		}
		$field[]=' "'.$replies.'"';
		$field[]=' '.$ticket['comments_count'].'';
		$field[]=' '.$ticket['comments'].'';
		$list[] = $field;
	}
	
	
	$fp = fopen('file.csv', 'w');
	
	foreach ($list as $fields) {
	    fputcsv($fp, $fields, ',',  "'");
	}

	fclose($fp);
}
//echo json_encode($ticket_data);
?>
