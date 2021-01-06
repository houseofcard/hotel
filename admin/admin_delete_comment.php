<?php
ob_start(); //this is so location header works
?>
<?php
// core configuration
include_once "../config/core.php";

// connect to database
include_once '../config/database.php';
 
// include objects and classes
include_once "../objects/comments.php";
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$comment = new Comments($db);

// include login checker
include_once "admin_login_checker.php";

// get ID of the room to be deleted
$commentid=isset($_GET['id']) ? $_GET['id'] : die('Missing room ID.');

// delete the room
$comment->commentid=$commentid;

if($comment->delete()){
 	header('Location: admin_comments.php?action=comment_deleted');
}

// if unable to delete the comment
else{
    echo "<p>Unable to delete object.</p>";
}
?>
<?php
include_once 'admin_template_footer.php';
?>