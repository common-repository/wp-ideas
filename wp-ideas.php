<?php
/*
Plugin Name: WP Ideas
Plugin URI: http://www.nexterous.com/plugins/wp-ideas/
Description: A plugin that allows you to organize ideas for future blog posts, plugins, anything at all in one simple page under Manage > Ideas.
Version: 1.0
Author: Daniel
Author URI: http://www.nexterous.com
*/

# Hook for adding admin menus
add_action('admin_menu', 'ideas_menu');
function ideas_menu(){
	add_submenu_page('edit.php', 'Ideas', 'Ideas', 1, __FILE__, 'manage_ideas');
}

# Start up the options API
	$path = dirname(__FILE__) . '/options.php';
	require_once($path);
	$option = new Option('wp_ideas');

# Add a new idea to storage
if(isset($_POST['submit'])):
	$newidea = mysql_real_escape_string($_POST['newidea']);
	$priority = (float) $_POST['priority'];
	$option->add_value($newidea, $priority);
endif;

# Delete an idea from storage
if(isset($_GET['idea'])):
	$newidea = mysql_real_escape_string($_GET['idea']);
	$option->delete_value($newidea);
endif;

# Get storage
	$ideas = $option->storage;

// The HTML Part now...
function manage_ideas(){
GLOBAL $ideas;

?>
<div id="wpbody"><div class="wrap">
<h2>Manage Ideas</h2>
<form id="ideas-submit" action="edit.php?page=wp-ideas/wp-ideas.php" method="post">
<table class="form-table">
<tr valign="top">
<th scope="row">New Idea</th>
<td><input name="newidea" type="text" style="width: 75%" size="45" /> 
<select name="priority" style="width: 10%">
	<option value="1.5" selected="selected">Priority</option>
	<option value="1">One</option>
	<option value="1.5">Two</option>
	<option value="2">Three</option>
</select>&nbsp; &nbsp; <input type="submit" name="submit" value="Add Idea!" class="button" />
<br />
An idea can be anything: a future blog post, a new plugin, a simple to-do, etc.<br />
Priority defaults to two if no value is selected from the list.</td></tr></table>
</form>
<br /><br />
<?php if(empty($ideas)){ echo 'There are no ideas yet.'; } else { ?>

<?php foreach($ideas as $idea => $priority):	?>
<font style="font-size: <?php echo $priority; ?>em"><?php echo stripslashes($idea); ?></font>
 <strong><a href="edit.php?page=wp-ideas/wp-ideas.php&idea=<?php echo $idea; ?>">x</a></strong> &nbsp; &nbsp; &nbsp;
<?php endforeach; } ?>
</div></div>
<?php } ?>