<?php
// handheld-details.php
// the READ function
$handheld_id = isset($_GET['handheld_id']) ? absint($_GET['handheld_id']) : 0;

if ($handheld_id) {
    // Retrieve the handheld details from the custom database table based on the handheld ID
    global $wpdb;
    $table_name = $wpdb->prefix . 'handhelds';
    $handheld = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $handheld_id));

    if ($handheld) {
        // Display the handheld details in an editable form
        ?>
        <div class="wrap">
            <h1>Edit Handheld</h1>
            
            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="handheld-form" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_handheld">

                <label for="handheld-id">ID:</label>
                <input type="text" name="handheld_id" readonly value="<?php echo $handheld->id; ?>">

                <label for="handheld-name">Name:</label>
                <input type="text" name="handheld_name" id="handheld-name" value="<?php echo $handheld->name; ?>">

                <label for="handheld-brand">Brand:</label>
                <input type="text" name="handheld_brand" id="handheld-brand" value="<?php echo $handheld->brand; ?>">

                <label for="handheld-released">Released:</label>
                <input type="text" name="handheld_released" id="handheld-released" value="<?php echo $handheld->released; ?>">

                <label for="handheld-price">Price:</label>
                <input type="text" name="handheld_price" id="handheld-price" value="<?php echo $handheld->price; ?>">

                <label for="handheld-os">Operating System:</label>
                <input type="text" name="handheld_os" id="handheld-os" value="<?php echo $handheld->os; ?>">

                <label for="handheld-soc">System On A Chip:</label>
                <input type="text" name="handheld_soc" id="handheld-soc" value="<?php echo $handheld->soc; ?>">

                <label for="handheld-ram">RAM:</label>
                <input type="text" name="handheld_ram" id="handheld-ram" value="<?php echo $handheld->ram; ?>">

                <label for="handheld-screen_size">Screen Size:</label>
                <input type="text" name="handheld_screen_size" id="handheld-screen_size" value="<?php echo $handheld->screen_size; ?>">

                <label for="handheld-screen_type">Screen Type:</label>
                <input type="text" name="handheld_screen_type" id="handheld-screen_type" value="<?php echo $handheld->screen_type; ?>">

                <label for="handheld-resolution">Resolution:</label>
                <input type="text" name="handheld_resolution" id="handheld-resolution" value="<?php echo $handheld->resolution; ?>">

                <label for="handheld-ppi">Pixels Per Inch:</label>
                <input type="text" name="handheld_ppi" id="handheld-ppi" value="<?php echo $handheld->ppi; ?>">

                <label for="handheld-aspect_ratio">Aspect Ratio:</label>
                <input type="text" name="handheld_aspect_ratio" id="handheld-aspect_ratio" value="<?php echo $handheld->aspect_ratio; ?>">

                <label for="handheld-battery">Battery:</label>
                <input type="text" name="handheld_battery" id="handheld-battery" value="<?php echo $handheld->battery; ?>">

                <label for="handheld-storage">Storage:</label>
                <input type="text" name="handheld_storage" id="handheld-storage" value="<?php echo $handheld->storage; ?>">

                <label for="handheld-dimensions">Dimensions:</label>
                <input type="text" name="handheld_dimensions" id="handheld-dimensions" value="<?php echo $handheld->dimensions; ?>">

                <label for="handheld-weight">Weight:</label>
                <input type="text" name="handheld_weight" id="handheld-weight" value="<?php echo $handheld->weight; ?>">

                <label for="handheld-material">Material:</label>
                <input type="text" name="handheld_material" id="handheld-material" value="<?php echo $handheld->material; ?>">

                <label for="handheld-review">Review:</label>
                <input type="text" name="handheld_review" id="handheld-review" value="<?php echo $handheld->review; ?>">

                <label for="handheld-vendor">Vendor:</label>
                <input type="text" name="handheld_vendor" id="handheld-vendor" value="<?php echo $handheld->vendor; ?>">

                <label for="handheld-performance">Performance:</label>
                <input type="text" name="handheld_performance" id="handheld-performance" value="<?php echo $handheld->performance; ?>">

                <label for="handheld-image" class="image-field">Image:</label>
                <?php
                    $imageData = $handheld->image;
                    if ($imageData) {
                        $imageSrc = 'data:image/jpeg;base64,' . base64_encode($imageData);
                        echo '<img src="' . $imageSrc . '" alt="Handheld Image"><br>';
                    } ?>
                <input type="file" name="handheld_image" id="handheld-image">



                <?php submit_button('Update Handheld'); ?>
            </form>
        </div>
        <?php
    } else {
        echo 'Invalid handheld ID.';
    }
} else {
    echo 'Handheld ID not provided.';
}
?>

<style>
.handheld-form label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

.handheld-form input[type="text"] {
    width: 300px;
    margin-bottom: 10px;
}

.handheld-form .image-field img {
    display: block;
    max-width: 300px;
    margin-top: 10px;
}

.handheld-form .image-field input[type="file"] {
    margin-top: 10px;
}
</style>