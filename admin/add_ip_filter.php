<?php
$wpdb->show_errors();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $ip = stripslashes($_POST['ip']);
  $description = stripslashes($_POST['description']);
  $wpdb->query($wpdb->prepare('INSERT INTO wp_abtest_ip_filters SET ip=%s, description=%s', $ip, $description));
  
  redirect_to('?page=abtest&action=list_ip_filters');
} else {
  $ip = '';
  $description = '';
}
?>

<div class="wrap">
  <h2>Add IP filter</h2>
  <form method="post">
    <p>
      <label for="ip">IP address:</label> <small>(e.g. 127.0.0.1)</small><br />
      <input type="text" id="ip" name="ip" value="<?php echo htmlspecialchars($name) ?>" style="width: 150px;" />
      <a href="#" onclick="jQuery('#ip').val('<?php echo $_SERVER['REMOTE_ADDR'] ?>');">Insert my current IP</a>
    </p>
    <p>
      <label for="description">Description:</label> <small>(e.g. Home IP)</small><br />
      <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($name) ?>" style="width: 300px;" />
    </p>
    <p>
      <input class="button-primary" type="submit" name="Save" value="Add IP filter" id="submitbutton" />
      or <a href="?page=abtest&amp;action=list_ip_filters">Cancel</a>
    </p>
  </form>
</div>

<script type="text/javascript">
  jQuery('#ip').focus();
</script>