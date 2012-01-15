<?php
$filters = $wpdb->get_results('SELECT * FROM wp_abtest_ip_filters ORDER BY id');
?>
<div class="wrap">
  <h2>IP filters</h2>
  
  <p>
    Here you can set up IP filters, e.g. to <strong>disable tracking</strong> for your own IP. Data will still be tracked but won't appear in measurements or statistics.
  </p>

  <table class="wp-list-table widefat" cellspacing="0">
  	<thead>
    	<tr>
    		<th>Description</th>
    		<th>IP</th>
    	</tr>
  	</thead>

  	<tbody>
  	  <?php
  	  if (count($filters) > 0) {
    	  foreach ($filters as $filter) {
    	    ?>
    			<tr>
    			  <td>
    			    <a href="?page=abtest&amp;action=edit_ip_filter&amp;id=<?php echo $filter->id ?>"><strong><?php echo $filter->description ?></strong></a><br />
    			    <small>
    			      <a href="?page=abtest&amp;action=edit_ip_filter&amp;id=<?php echo $filter->id ?>">Edit</a>
    			      |
    			      <a href="?page=abtest&amp;action=delete_ip_filter&amp;id=<?php echo $filter->id ?>">Delete</a>
    			  </td>
    			  <td>
    			    <?php echo $filter->ip ?>
    			  </td>
    			</tr>
    	    <?php
    	  }
  	  } else {
  	    ?>
  	    <tr>
  	      <td colspan="2">You have no filters.</td>
  	    </tr>
  	    <?php
  	  }
  	  ?>
  	</tbody>
  </table>

  <p>
    <input type="button" value="Add an IP filter" class="button-secondary" onclick="document.location = '?page=abtest&amp;action=add_ip_filter';" />
  </p>
  
  <p>
    &laquo; <a href="?page=abtest">Back to experiments</a>
  </p>
</div>