<?php
    get_header(); 
    
    pageBanner(array(
      'title' => 'All Handhelds'
    ));
    
    ?>
    <div class="container container--narrow page-section">

    <div class="metabox metabox--position-up metabox--with-home-link">
        <p>
            <a class="metabox__blog-home-link" href="<?php echo site_url('/'); ?>">
                <i class="fa fa-home" aria-hidden="true"></i> Home
            </a>
                <span class="metabox__main">
                Handheld List
                </span>
        </p>
    </div>
    </div>




    <?php
    wp_reset_postdata();

    
    global $wpdb;
    $handheld_table = $wpdb->prefix . 'handhelds';
    $sql = "SELECT * FROM $handheld_table";
    $results = $wpdb->get_results( $sql );
    //var_dump($results);

    ?>

    <!--<div class="container container--narrow page-section">
        <ul class="link-list min-list">
    -->
    <div class="handheld-list">
        <p class="list-table-headline">Retro Handhelds List</p>
        <table class="link-list handheld-list-table">
        
        <thead>
        <tr class="list-table-header">
            <th>Photo</th>
            <th>Name</th>
            <th>Price</th>
            <th>Performance</th>
            <th>System On A Chip</th>
            <th>Screen Size</th>
            <th>Resolution</th>
            <th>Compare</th>
            
        </tr>
    </thead>

    <tbody>
        <?php foreach ($results as $result) { ?>
            <tr>
                <td class="list-table-photo">
                    <img src="data:image/jpeg;base64,<?php echo base64_encode($result->image); ?>" alt="Handheld Small Image">
                </td>
                <td class="list-table-td">
                <?php

    $post = get_page_by_title($result->name, OBJECT, 'handheld');
    if ($post) {
      $permalink = get_permalink($post->ID);
      echo '<a href="' . $permalink . '">' . $result->name . '</a>';
    } else {
      echo $result->name;
    }
  ?>
  </td>


                    <!--
                    <a href="<?php echo get_the_permalink($result->name) ?>">
                    <?php echo $result->name ?></a></td>
                    -->

                <td class="list-table-td"><?php echo $result->price ?></td>
                <td class="list-table-td">                
                    <?php for ($i = 0; $i < $result->performance; $i++) { ?>
                        &#127775;
                    <?php } ?>
                </td>
                <td class="list-table-td"><?php echo $result->soc ?></td>
                <td class="list-table-td"><?php echo $result->screen_size ?></td>
                <td class="list-table-td"><?php echo $result->resolution ?></td>
                <!-- heart button 
                <td class="list-table-td">
                    <span class="heart-box">
                        <i class="fa fa-heart-o heart-icon" 

                        handheld_id="<?php echo esc_attr(get_the_ID()); ?>"
                        handheld_name="<?php echo esc_attr(get_the_title()); ?>"
                        aria-hidden="true">

                        </i>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                    </span>

                </td>
                -->
                <td class="list-table-td">
                  <span class="heart-box">
                    <?php
                      $handheldId = esc_attr(get_the_ID());
                      $handheldName = esc_attr(get_the_title());
                    ?>

                    <i class="fa fa-heart-o heart-icon"
                      handheld_id="<?php echo $handheldId; ?>"
                      handheld_name="<?php echo $handheldName; ?>"
                      aria-hidden="true">
                    </i>
                    
                    
                  </span>
                </td>




            </tr>
        <?php } ?>
    </tbody>
  <?php
        wp_reset_postdata();

        ?>
        </table>


    </div>

    <!-- compare window  -->
    <div id="floating-window">
        <h3>Comparison</h3>
        <ul id="comparison-list">
        </ul>
        <div class="button-warp">
        <button id="compare-button">Compare</button>
        </div>
    </div> 



    <script>
   
document.addEventListener('DOMContentLoaded', function() {
  
    const heartIcons = document.querySelectorAll('.heart-icon');
    const comparisonList = document.getElementById('comparison-list');
    const compareButton = document.getElementById('compare-button');


    heartIcons.forEach(function(icon) {
      icon.addEventListener('click', function(event) {

        if (this.classList.contains('fa-heart')) {
          this.classList.remove('fa-heart');
          this.classList.add('fa-heart-o');
        } else {
          this.classList.remove('fa-heart-o');
          this.classList.add('fa-heart');
        }

        const handheldName = this.getAttribute('handheld_name');
        console.log('handheldName: ' + handheldName);
        // Make an AJAX request to retrieve the handheld ID
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/wp-admin/admin-ajax.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
          if (xhr.status === 200) {
            const handheldId = xhr.responseText;
            console.log('handheldId: ' + handheldId);
            // Check if the handheld is already in comparison
            const existingHandheld = document.querySelector(`#comparison-list li[data-handheld-id="${handheldId}"]`);

            if (!existingHandheld) {
              // Create a new list item for the handheld
              const listItem = document.createElement('li');
              listItem.dataset.handheldId = handheldId;
              listItem.textContent = handheldName;
              // Create a remove button for the handheld
              const removeButton = document.createElement('button');
              removeButton.textContent = 'Remove';
              removeButton.classList.add('remove-button');
              listItem.appendChild(removeButton);
              // Append the handheld to the comparison list
              comparisonList.appendChild(listItem);

              // Check if the maximum limit is reached
              if (comparisonList.children.length === 2) {
                heartIcons.forEach(function(icon) {
                icon.disabled = true;
                });
              }
            }
          }
        };

        // Prepare the AJAX request data
        const data = new URLSearchParams();
        data.append('action', 'retrieve_handheld_id');
        data.append('handheldName', handheldName);
        // Send the AJAX request
        xhr.send(data);
      });
    });




    comparisonList.addEventListener('click', function(event) {
      if (event.target.classList.contains('remove-button')) {
        let handheldId = event.target.parentNode.dataset.handheldId;
        let handheldItem = event.target.parentNode;
        // Remove the handheld from the comparison list
        comparisonList.removeChild(handheldItem);

        // Enable the heart icons
        heartIcons.forEach(function(icon) {
          icon.disabled = false;
        });

        compareButton.disabled = true; // Disable the compare button
      }
    });

    compareButton.addEventListener('click', function() {
      //e.preventDefault();
      let handheldIds = [];
      let handheldItems = comparisonList.querySelectorAll('li');

      handheldItems.forEach(function(item) {
        let handheldId = item.dataset.handheldId;
        //console.log('handheldId:', handheldId); 
        handheldIds.push(handheldId);
      });

      // Redirect to the comparison page with the handheld IDs as query parameters
      const url = '/handheld-comparison/?handheld1=' + handheldIds[0] + '&handheld2=' + handheldIds[1];
      window.location.href = url;
    });
  

});





</script>








 

<?php
    get_footer();
?> 

