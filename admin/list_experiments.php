<?php
$experiments = $wpdb->get_results('SELECT * FROM wp_abtest_experiments ORDER BY name');
?>

<div class="wrap">
  <div style="float: right;">
    <?php
    if ($_SESSION['abtest_debug']) {
      ?>
      <p>
        <strong>Debug mode is on.</strong>
        <input type="button" value="Exit debug mode" class="button-secondary" onclick="document.location = '?page=abtest&amp;action=debug_mode&amp;debug=0';" />
      </p>
      <?php
    } else {
      ?>
      <p>
        <input type="button" value="Enter debug mode" class="button-secondary" onclick="document.location = '?page=abtest&amp;action=debug_mode&amp;debug=1';" />
        <a href="#" onclick="jQuery('#debug_help').toggle();">What's this?</a>
      </p>
      <?php
    }
    ?>
  </div>
  <h2>A/B Testing</h2>
  
  <p>
    Welcome to A/B Test for WordPress. Create or edit experiments below.
    Also see <a href="?page=abtest&amp;action=about">information and help</a>.
    To filter out IP addresses, see <a href="?page=abtest&amp;action=list_ip_filters">IP filters</a>.
  </p>
  
  <div id="debug_help" style="display: none; background: #FFFBCC; border: 1px solid #E6DB55; padding: 10px 20px;">
    <h3>Debug mode</h3>
    <p>
      Normally, when a user first sees a variation to an experiment, this variation is locked for this user so that – in this session – she always sees the same variation.<br />
      If you want to test your experiments without this variation lock taking place for you (and only you), you can enable debug mode. Also, when entering debug mode, all tracking will be disabled for your session.
    </p>
  </div>
  
  <h3>Experiments</h3>

  <table class="wp-list-table widefat" cellspacing="0">
  	<thead>
    	<tr>
    		<th>Name</th>
    	</tr>
  	</thead>

  	<tbody>
  	  <?php
  	  foreach ($experiments as $experiment) {
  	    ?>
  			<tr>
  			  <td>
  			    <a href="?page=abtest&amp;action=show_experiment&amp;id=<?php echo $experiment->id ?>"><strong><?php echo $experiment->name ?></strong></a><br />
  			    <small>
  			      <a href="?page=abtest&amp;action=show_experiment&amp;id=<?php echo $experiment->id ?>">Show</a>
  			      |
  			      <a href="?page=abtest&amp;action=edit_experiment&amp;id=<?php echo $experiment->id ?>">Edit</a>
  			      |
  			      <a href="?page=abtest&amp;action=delete_experiment&amp;id=<?php echo $experiment->id ?>">Delete</a>
  			  </td>
  			</tr>
  	    <?php
  	  }
  	  ?>
  	</tbody>
  </table>

  <p>
    <input type="button" value="Create new experiment" class="button-secondary" onclick="document.location = '?page=abtest&amp;action=create_experiment';" />
  </p>
  
  <!--
  <h3>Donate</h3>
  <p>
    If you like this plugin and use it, I'd be glad if you'd consider donating a small amount via PayPal:
  </p>
  
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="YG6AVTCGWSWS2">
    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
  </form>
  -->
  
</div>