

<div class="handheld-wrap">
      <h1>Handheld Data Management</h1>
  
      <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_handheld">

      <table>
          <tr>
              <th><label for="handheld-name">Name</label></th>
              <td><input type="text" name="handheld-name" id="handheld-name" required></td>
          </tr>
          <tr>
              <th><label for="handheld-brand">Brand</label></th>
              <td><input type="text" name="handheld-brand" id="handheld-brand" ></td>
          </tr>
          <tr>
              <th><label for="handheld-released">Released</label></th>
              <td><input type="text" name="handheld-released" id="handheld-released" ></td>
          </tr>
          <tr>
              <th><label for="handheld-price">Price</label></th>
              <td><input type="text" name="handheld-price" id="handheld-price" ></td>
          </tr>
          <tr>
              <th><label for="handheld-os">Operating System</label></th>
              <td><input type="text" name="handheld-os" id="handheld-os" ></td>
          </tr>
          <tr>
              <th><label for="handheld-soc">System On A Chip</label></th>
              <td><input type="text" name="handheld-soc" id="handheld-soc" ></td>
          </tr>
          <tr>
              <th><label for="handheld-ram">RAM</label></th>
              <td><input type="text" name="handheld-ram" id="handheld-ram" ></td>
          </tr>
          <tr>
              <th><label for="handheld-screen_size">Screen Size</label></th>
              <td><input type="text" name="handheld-screen_size" id="handheld-screen_size" ></td>
          </tr>
          <tr>
              <th><label for="handheld-screen_type">Screen Type</label></th>
              <td><input type="text" name="handheld-screen_type" id="handheld-screen_type" ></td>
          </tr>
          <tr>
              <th><label for="handheld-resolution">Resolution</label></th>
              <td><input type="text" name="handheld-resolution" id="handheld-resolution" ></td>
          </tr>
          <tr>
              <th><label for="handheld-ppi">Pixels Per Inch</label></th>
              <td><input type="text" name="handheld-ppi" id="handheld-ppi" ></td>
          </tr>
          <tr>
              <th><label for="handheld-aspect_ratio">Aspect Ratio</label></th>
              <td><input type="text" name="handheld-aspect_ratio" id="handheld-aspect_ratio" ></td>
          </tr>
          <tr>
              <th><label for="handheld-battery">Battery</label></th>
              <td><input type="text" name="handheld-battery" id="handheld-battery"></td>
          </tr>
          <tr>
              <th><label for="handheld-storage">Storage</label></th>
              <td><input type="text" name="handheld-storage" id="handheld-storage" ></td>
          </tr>
          <tr>
              <th><label for="handheld-dimensions">Dimensions</label></th>
              <td><input type="text" name="handheld-dimensions" id="handheld-dimensions"></td>
          </tr>
          <tr>
              <th><label for="handheld-weight">Weight</label></th>
              <td><input type="text" name="handheld-weight" id="handheld-weight" ></td>
          </tr>
          <tr>
              <th><label for="handheld-material">Material</label></th>
              <td><input type="text" name="handheld-material" id="handheld-material" ></td>
          </tr>
          <tr>
              <th><label for="handheld-performance">Performance</label></th>
              <td><input type="text" name="handheld-performance" id="handheld-performance" ></td>
          </tr>
          <tr>
              <th><label for="handheld-review">Review</label></th>
              <td><input type="text" name="handheld-review" id="handheld-review" ></td>
          </tr>
          <tr>
              <th><label for="handheld-vendor">Vendor</label></th>
              <td><input type="text" name="handheld-vendor" id="handheld-vendor"></td>
          </tr>
          <tr>
                <th><label for="handheld-image">Image</label></th>
                <td><input type="file" name="handheld-image" id="handheld-image"></td>
        </tr>
        
      </table>

      <?php submit_button('Add Handheld'); ?>
    </form>

    </div>


