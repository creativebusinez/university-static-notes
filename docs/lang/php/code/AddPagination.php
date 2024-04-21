<?php
    // add pagination
        echo paginate_links(
            array(
                'total' => $pastEvents->max_num_pages
                
            )
        );