<?php




add_action('rest_api_init', 'custom_api');

function custom_api(){
    // namespace, route, controller
    register_rest_route('api','search',array(
        // CRUD
        // method = GET
        // callback = promise back
        'method' => WP_REST_SERVER::READABLE,
        'callback' => 'good_api'
    ));
}

// WP auto convert PHP format to JSON
function good_api(){
    $mainQuery = new WP_Query(array(
        // post & page & professor
        'post_type'=>array('post','page','note','handheld')
        // /api/search?term=$data
        //'s' => sanitize_text_field($data['term']) 
    ));

    $results = array(
        'generalInfo'=> array(),
        'handhelds'=> array()

    );

    while ($mainQuery->have_posts()){
        $mainQuery->the_post();

        // callback 'post' and 'page'
        if(get_post_type()=='post' || get_post_type()=='page'){
            // add custom results to the array
            array_push($results['generalInfo'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }



        // callback 'handheld'
        if(get_post_type()=='handheld'){
            // add custom results to the array
            array_push($results['handhelds'], array(
                'title' => get_the_title(),
                'permalink' => get_the_permalink()
            ));
        }        

    }

    return $results;




}





?>