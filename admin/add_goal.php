<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $experiment_id = (int)$_POST['experiment_id'];
  // Insert the goal
  $name = stripslashes($_POST['name']);
  $wpdb->query($wpdb->prepare('INSERT INTO wp_abtest_goals SET experiment_id=%d, name=%s', $experiment_id, $name));
  
  redirect_to('?page=abtest&action=show_experiment&id=' . $experiment_id);
} else {
  $experiment_id = (int)$_GET['experiment_id'];
  $name = '';
}
?>

<div class="wrap">
  <h2>Add goal</h2>
  <form method="post">
    <input type="hidden" name="experiment_id" value="<?php echo $experiment_id ?>" />
    <p>
      <label for="name">Goal name:</label><br />
      <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name) ?>" style="width: 300px;" />
    </p>
    <p>
      <input class="button-primary" type="submit" name="Save" value="Add goal" id="submitbutton" />
      or <a href="?page=abtest&amp;action=show_experiment&amp;id=<?php echo $experiment_id ?>">Cancel</a>
    </p>
  </form>
</div>

<script type="text/javascript">
  jQuery('#name').focus();
</script>