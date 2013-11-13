<?php

require_once 'lib-api-wrapper.php'; 
$params = array(
  'sub_domain' => 'sb-phpwrapper',
  'auth_token' => 'zwCyp5wsg4kY1cJGdszv'  # You can find your API token in Settings > API Token screen.
);

// Initialize api.
$api = new API_Wrapper($params);

// 1. get user informantion
//$user_data = $api->getUserInfo();

$para='';
// 2. get ticket data
//$ticket_data = $api->getTickets($para);

$para='{
    "ticket": {
        "subject": "Subject",
        "requester_name": "John Doe",
        "requester_email": "john@example.com",
        "cc": [
            "Test1 <test1@example.com>",
            "Test2 <test2@example.com>"
        ],
        "content": {
            "text": "Creating a ticket",
            "html": "Creating a ticket",
            "attachment_ids": [
            ]
        }
    }
}';
$para=json_decode($para, TRUE);
// 3. create tickets. 
//$ticket_data = $api->createTickets($para);


// 4. Show ticket.
$vars='';
//$ticket_data = $api->showTickets(1676981, $vars);

// 5. Actions on ticket.
// 5.1. Archive a Ticket.
//$vars=array('test'=>1);
//$ticket_data = $api->archiveTicket(1676981, $vars);


// 5.2. Un- Archive a Ticket. 
// $vars=null;
// $ticket_data = $api->unArchiveTicket(1676981, $vars);
// var_dump($ticket_data); die;

// Assigning tickets to user/Group
// 5.3. Assigning to a user. 
$vars='  {
    "assignment": {
        "user_id": 531271
    }
}';
//$ticket_data = $api->assignments(1676967, $vars);

// 5.4. Assigning to a user. 
$vars='  {
    "assignment": {
        "group_id": 531271
    }
}';
//$ticket_data = $api->assignments(1676967, $vars);

// 5.5. Star Ticket.
// $vars=array('test'=>1);
// $ticket_data = $api->starTickets(1676967, $vars);
// var_dump($ticket_data); die;

// // 5.6. Un-Star Ticket.
// $vars=array('test'=>1);
// $ticket_data = $api->unstarTickets(1676967, $vars);
// var_dump($ticket_data); die;

// // 5.7. Spam Ticket.
// $vars=array('test'=>1);
// $ticket_data = $api->spamTickets(1676967, $vars);
// var_dump($ticket_data); die;

// // 5.8. Un-Spam Ticket.
// $vars=array('test'=>1);
// $ticket_data = $api->unSpamTickets(1676967, $vars);
// var_dump($ticket_data); die;

// // 5.8. Trash Ticket.
// $vars=array('test'=>1);
// $ticket_data = $api->trashTickets(1676967, $vars);
// var_dump($ticket_data); die;

// // 5.9. Un-Trash Ticket.
// $vars=array('test'=>1);
// $ticket_data = $api->unTrashTickets(1676967, $vars);
// var_dump($ticket_data); die;


// 6. Fetching Replies for a tickets.
// $vars='';
// $ticket_data = $api->fetchReplies(1676967, $vars);
// var_dump($ticket_data); die;

// 7. Create Reply.
$vars='{
    "reply": {
        "content": {
            "html": "Reply Content",
            "text": "Reply Content",
            "attachment_ids": []
        }
    }
}';
// $vars=json_decode($vars, TRUE);
// $ticket_data = $api->createReplies(1676967, $vars);
// var_dump($ticket_data); die;

// 7.1. Show Reply
// $vars=json_decode($vars, TRUE);
// $ticket_data = $api->showReplies(1676967, 1, $vars);
// var_dump($ticket_data); die;

// 8. Fetching Comments.
// $vars='';
// $ticket_data = $api->fetchComments(1676967, $vars);
// var_dump($ticket_data); die;

// 9. Create Comments.
$vars='{
    "comment": {
        "content": {
            "html": "Reply Comment",
            "text": "Reply Comment",
            "attachment_ids": []
        }
    }
}';
// $vars=json_decode($vars, TRUE);
// $ticket_data = $api->createComments(1676967, $vars);
// var_dump($ticket_data); die;

// 10. Fetching Agents.
// $user_data = $api->fetchAgents();
// var_dump($user_data); die;

// 11. Show User.
// $user_data = $api->showUser(531271);
// var_dump($user_data); die;

// 12. Create Agent/Admin.
$vars='{
    "user": {
        "email": "test@example.com",
        "first_name": "Test",
        "last_name": "Name",
        "role": 10,
        "group_ids": []
    }
}';
// $vars=json_decode($vars, TRUE);
// $user_data = $api->createAgent($vars);
// var_dump($user_data); die;

// 13. Fetching Labels.
// $user_data = $api->fetchLabel();
// var_dump($user_data); die;

// 14. Add Label to Tickets.
$vars='{
    "label": {
        "id": 2,
        "label": "important",
        "ticket": 1
    }
}';
$vars=json_decode($vars, TRUE);
$user_data = $api->addingLabelTicket(1676967, $vars);
var_dump($user_data); die;

// 15. Create Attachment.

// 16. Fetching Snippets.

// 17. Create Snippet.

// 18. Update Snippet.

// 19. Delete Snippet.

// 20. Create Filter.

// 21. Fetching Webhooks.

// 22. Create Webhook.

// 23. Update Webhook.

// 24. Delete Webhook.

// 25. Repoorts. 


?>