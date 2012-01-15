<?php
$wpdb->show_errors();

$id = (int)$_GET['id'];
$exp = $wpdb->get_row($wpdb->prepare('SELECT * FROM wp_abtest_experiments WHERE id=%d', $id));

$variation_stats = $wpdb->get_results($wpdb->prepare('
  SELECT *,
  (SELECT COUNT(DISTINCT session_id) FROM wp_abtest_variation_views WHERE variation_id=wp_abtest_variations.id AND ip NOT IN (SELECT ip FROM wp_abtest_ip_filters)) AS views,
  (SELECT COUNT(DISTINCT wp_abtest_variation_views.session_id)
   FROM wp_abtest_variation_views
   INNER JOIN wp_abtest_goal_hits ON wp_abtest_goal_hits.session_id=wp_abtest_variation_views.session_id
   INNER JOIN wp_abtest_goals ON wp_abtest_goals.id=wp_abtest_goal_hits.goal_id
   WHERE wp_abtest_variation_views.variation_id=wp_abtest_variations.id AND wp_abtest_goals.experiment_id=wp_abtest_variations.experiment_id AND wp_abtest_variation_views.ip NOT IN (SELECT ip FROM wp_abtest_ip_filters)
  ) AS goal_hits
  FROM wp_abtest_variations
  WHERE experiment_id=%d
  ORDER BY name
', $id));

$variations = $wpdb->get_results($wpdb->prepare('SELECT * FROM wp_abtest_variations WHERE experiment_id=%d', $id));
$goals = $wpdb->get_results($wpdb->prepare('SELECT * FROM wp_abtest_goals WHERE experiment_id=%d', $id));
?>
<div class="wrap">
  <h2>Experiment</h2>
  <p>
    This is an overview of your <em><?php echo $exp->name ?></em> experiment.<br />
    <a href="?page=abtest&amp;action=edit_experiment&amp;id=<?php echo $exp->id ?>">Edit experiment</a>
    <small>|</small>
    <small><a href="?page=abtest&amp;action=delete_experiment&amp;id=<?php echo $exp->id ?>" style="color: #c00;">Delete experiment</a></small>
  </p>
  <?php
  $best_rate = 0;
  $worst_rate = PHP_INT_MAX;
  foreach ($variation_stats as $var) {
    if ($var->views > 0) {
      $rate = ($var->goal_hits / $var->views) * 100;
      if ($rate > $best_rate) {
        $best_rate = $rate;
        $best = $var;
      }
      if ($rate < $worst_rate) {
        $worst_rate = $rate;
        $worst = $var;
      }
    }
  }
  
  if ($best_rate == $worst_rate) {
    $worst = NULL;
  }
  ?>
  <div style="background: #eee; border: 1px solid #ccc; padding: 5px 20px; border-radius: 5px;">
    <h3>Current statistics</h3>
    <?php if ($best || $worst) { ?>
      <p>
        <?php if ($best) { ?>
          <strong><?php echo $best->name ?></strong> is the <span style="color: #080;">best performing</span> with a conversion rate of <strong><?php echo round($best_rate, 2) ?>%</strong>.
        <?php } ?>
        <?php if ($worst) { ?>
          <br /><strong><?php echo $worst->name ?></strong> is the <span style="color: #800;">worst performing</span> performing with a conversion rate of <strong><?php echo round($worst_rate, 2) ?>%</strong>.
        <?php } ?>
      </p>
    <?php } else { ?>
      <p>
        There is currently not enough data to display statistics.
      </p>
    <?php } ?>
  </div>
  
  <h3>How to use this experiment</h3>
  <p>
    This is a <strong><?php echo $exp->type ?></strong> experiment.
  </p>
  <?php if ($exp->type == 'content') { ?>
    <p>
      In <strong>posts, pages, or widgets</strong>, insert this code: <code>[abtest experiment="<?php echo $id ?>"]</code><br />
      Or, as <strong>PHP code</strong> in themes etc.: <code>&lt;?php abtest_experiment(<?php echo $id ?>) ?&gt;</code> or <code>&lt;?php echo abtest_get_experiment(<?php echo $id ?>) ?&gt;</code>
    </p>
  <?php } elseif ($exp->type == 'stylesheet') { ?>
    <p>
      This experiment is automatically inserted into the <strong>stylesheet</strong>.
    </p>
  <?php } elseif ($exp->type == 'javascript') { ?>
    <p>
      This experiment is automatically inserted into the <strong>javascript</strong>.
    </p>
  <?php } ?>
  <p>
    To insert the <strong>name of the variation</strong> currently being displayed (e.g. in tracking etc.), insert this code:
    <code>[abtest experiment="<?php echo $id ?>" variable="name"]</code><br />
    Or, as <strong>PHP code</strong> in themes etc.: <code>&lt;?php abtest_name(<?php echo $id ?>) ?&gt;</code> or <code>&lt;?php echo abtest_get_name(<?php echo $id ?>) ?&gt;</code>
  </p>
  <p>
    For information on tracking goals, click <em>Get tracking code</em> below each goal below.
  </p>
  
  
  <h3>Variations</h3>
  <table class="wp-list-table widefat" cellspacing="0">
  	<thead>
    	<tr>
    	  <th>Variation</th>
        <th class="num">Views</th>
        <th class="num">Goal hits</th>
        <th class="num">Conversion rate</th>
    	</tr>
  	</thead>

  	<tbody>
      <?php
      $views = 0;
      $goal_hits = 0;
      foreach ($variation_stats as $var) {
        $views += $var->views;
        $goal_hits += $var->goal_hits;
        ?>
      	<tr>
      	  <td>
            <a href="?page=abtest&amp;action=edit_variation&amp;id=<?php echo $var->id ?>"><strong><?php echo $var->name ?></strong></a><br />
            <small>
              <a href="?page=abtest&amp;action=edit_variation&amp;id=<?php echo $var->id ?>">Edit</a>
              |
              <a href="?page=abtest&amp;action=delete_variation&amp;id=<?php echo $var->id ?>">Delete</a>
            </small>
      	  </td>
      	  <td class="num"><?php echo $var->views ?></td>
      	  <td class="num"><?php echo $var->goal_hits ?></td>
      	  <td class="num">
      	    <?php if ($var->views > 0) { ?>
        	    <?php echo round(($var->goal_hits / $var->views) * 100, 2) ?>%
        	  <?php } else { ?>
        	    -
        	  <?php } ?>
      	  </td>
    	  </tr>
        <?php
      }
      ?>
      <tr>
        <td><strong>Total</strong></td>
    	  <td class="num"><strong><?php echo $views ?></strong></td>
    	  <td class="num"><strong><?php echo $goal_hits ?></strong></td>
    	  <td class="num">
    	    <strong>
      	    <?php if ($views > 0) { ?>
        	    <?php echo round(($goal_hits / $views) * 100, 2) ?>%
        	  <?php } else { ?>
        	    -
        	  <?php } ?>
      	  </strong>
    	  </td>
      </tr>
  	</tbody>
  </table>
  <p>
    <input type="button" value="Add new variation" class="button-secondary" onclick="document.location = '?page=abtest&amp;action=add_variation&amp;experiment_id=<?php echo $id ?>';" />
  </p>

  <h3>Goals</h3>
  <p>
    The WordPress A/B Test plugin currently only supports showing statistics for one goal. You can, however, add more goals and these will be tracked for future use.
  </p>
  <table class="wp-list-table widefat" cellspacing="0">
  	<thead>
    	<tr>
    		<th>Goal</th>
    	</tr>
  	</thead>

  	<tbody>
      <?php foreach ($goals as $goal) { ?>
        <tr>
          <td>
            <a href="?page=abtest&amp;action=edit_goal&amp;id=<?php echo $goal->id ?>"><strong><?php echo $goal->name ?></strong></a><br />
            <small>
              <a href="?page=abtest&amp;action=get_tracking_code&amp;id=<?php echo $goal->id ?>">Get tracking code</a>
              |
              <a href="?page=abtest&amp;action=edit_goal&amp;id=<?php echo $goal->id ?>">Edit</a>
              |
              <a href="?page=abtest&amp;action=delete_goal&amp;id=<?php echo $goal->id ?>">Delete</a>
            </small>
          </td>
        </tr>
      <?php } ?>
  	</tbody>
  </table>
  <p>
    <input type="button" value="Add new goal" class="button-secondary" onclick="document.location = '?page=abtest&amp;action=add_goal&amp;experiment_id=<?php echo $id ?>';" />
  </p>
  
  <p>
    &laquo; <a href="?page=abtest">Back to experiments</a>
  </p>

</div>