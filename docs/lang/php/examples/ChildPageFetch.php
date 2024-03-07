<?php 
    // Fetches the pages that are children to the current page, better name than $testArray
    $childPagesArray = get_pages(array(
        'child_of' => get_the_ID()
    ));
        
    // Checks whether this page has a parent or is a parent itself
    if ($theParent or $childPagesArray) { ?>
        <div class="page-links">
            <h2 class="page-links__title"><a href="<?php echo get_permalink($theParent); ?>""><?php echo get_the_title($theParent); ?></a></h2>
            <ul class="min-list">
                <?php
                    // Another check for the parent page
                    if ($theParent) {
                        $findChildrenOf = $theParent;
                    } else {
                        $findChildrenOf = get_the_ID();
                    }
                    // Lists all child pages from either current page or its parent
                    wp_list_pages(
                        array(
                            'title_li' => NULL,
                            'child_of' => $findChildrenOf,
                            'sort_column' => 'menu_order'
                        )
                    );
                ?>
            </ul>
        </div>
    <?php }
?>
