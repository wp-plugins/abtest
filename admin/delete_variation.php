<?php
$id = (int)$_GET['id'];
$var = $wpdb->get_row($wpdb->prepare('SELECT * FROM wp_abtest_variations WHERE id=%d', $id));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Delete the variation
  $wpdb->query($wpdb->prepare('DELETE FROM wp_abtest_variation_views WHERE variation_id=%d', $id));
  $wpdb->query($wpdb->prepare('DELETE FROM wp_abtest_variations WHERE id=%d', $id));
  
  redirect_to('?page=abtest&action=show_experiment&id=' . $var->experiment_id);
}
?>

<div class="wrap">
  <h2>Delete variation</h2>
  <form method="post">
    <p>
      Are you sure you want to delete the variation <em><?php echo htmlspecialchars($var->name) ?></em>? This can't be undone.
    </p>
    <p>
      <input class="button-primary" type="submit" name="Save" value="Delete variation" id="submitbutton" />
      or <a href="?page=abtest&amp;action=show_experiment&amp;id=<?php echo $var->experiment_id ?>">Cancel</a>
    </p>
  </form>
</div>