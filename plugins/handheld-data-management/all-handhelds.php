<!-- all-handhelds.php -->

<!--
<div class="wrap">
    <h1>All Handhelds</h1>

    <?php
    global $wpdb;
    
    // Retrieve all handhelds from the custom database table
    $handhelds = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}handhelds");
    //var_dump( $handhelds);

    if ($handhelds) :
        ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>

    <?php foreach ($handhelds as $handheld) : ?>
    <tr> 
        <td>
            <a href="<?php echo admin_url('admin.php?page=handheld-details&handheld_id=' . $handheld->id); ?>">
                <?php echo $handheld->id; ?>
            </a>
        </td>
        <td><?php echo $handheld->name; ?></td>
        <td>
            <a href="<?php echo admin_url('admin.php?page=all-handhelds&action=delete&handheld_id=' . $handheld->id); ?>" onclick="return confirm('Are you sure you want to delete this handheld?');">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>

</tbody>
        </table>
    <?php else : ?>
        <p>No handhelds found.</p>
    <?php endif; ?>
</div>






<div class="wrap">
    <h1>All Handhelds</h1>

    <?php
    global $wpdb;

    // Check if the delete action is triggered
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['handheld_id'])) {
        $handheld_id = absint($_GET['handheld_id']);

        // Delete the handheld from the custom database table
        $table_name = $wpdb->prefix . 'handhelds';
        $wpdb->delete($table_name, ['id' => $handheld_id]);

        // Redirect to the current page after deleting
        $current_url = remove_query_arg(['action', 'handheld_id'], $_SERVER['REQUEST_URI']);
        wp_redirect($current_url);
        exit();
    }

    // Retrieve all handhelds from the custom database table
    $handhelds = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}handhelds");

    if ($handhelds) :
    ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($handhelds as $handheld) : ?>
                    <tr>
                        <td>
                            <?php echo $handheld->id; ?>
                        </td>
                        <td><?php echo $handheld->name; ?></td>
                        <td>
                            <a href="<?php echo add_query_arg(['action' => 'delete', 'handheld_id' => $handheld->id], $_SERVER['REQUEST_URI']); ?>" onclick="return confirm('Are you sure you want to delete this handheld?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No handhelds found.</p>
    <?php endif; ?>
</div>


    -->

<!-- the DELETE function -->
<div class="wrap">
    <h1>All Handhelds</h1>

    <?php
    global $wpdb;

    // Check if the delete action is triggered
    if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['handheld_id'])) {
        $handheld_id = absint($_GET['handheld_id']);

        // Delete the handheld from the custom database table
        $table_name = $wpdb->prefix . 'handhelds';
        $wpdb->delete($table_name, ['id' => $handheld_id]);

        // Display success message and redirect
        echo '<div class="notice notice-success"><p>Handheld deleted successfully.</p></div>';
        echo '<script>setTimeout(function() { window.location.href = "' . admin_url('admin.php?page=handheld-data-management') . '"; }, 3000);</script>';
    }

    // Retrieve all handhelds from the custom database table
    $handhelds = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}handhelds");

    if ($handhelds) :
    ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($handhelds as $handheld) : ?>
                    <tr>
                    <td><a href="<?php echo admin_url('admin.php?page=handheld-details&handheld_id=' . $handheld->id); ?>">
                            <?php echo $handheld->id; ?>
                        </a></td>
                        <td><a href="<?php echo admin_url('admin.php?page=handheld-details&handheld_id=' . $handheld->id); ?>">
                            <?php echo $handheld->name; ?></a></td>
                        <td>
                            <a href="<?php echo add_query_arg(['action' => 'delete', 'handheld_id' => $handheld->id], admin_url('admin.php?page=handheld-data-management')); ?>" onclick="return confirm('Are you sure you want to delete this handheld?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No handhelds found.</p>
    <?php endif; ?>
</div>


