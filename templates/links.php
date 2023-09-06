<?php

/**
 * @package D9SPL
 */

use \Inc\Base\LinksTable;
?>

<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e('Payment Links', D9SPL_TEXT_DOMAIN); ?></h1>
    <a href="/admin.php?page=d9spl-add-new" class="page-title-action"><?php _e('Add New', D9SPL_TEXT_DOMAIN); ?></a>

    <form action="" method="post">
        <?php
        $table = new LinksTable();
        $table->prepare_items();
        // // $table->search_box('search', 'search_id');
        $table->display();
        ?>
    </form>
</div>