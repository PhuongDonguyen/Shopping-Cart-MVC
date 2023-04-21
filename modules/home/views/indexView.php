<?php get_header(); ?>

<?php
    // show_array($macbook_cat_info);
    // show_array($macbook_product_list);
?>

<div id="main-content-wp" class="home-page">
    <div class="wp-inner clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section list-cat">
                <div class="section-head">
                    <h3 class="section-title"><?php echo $macbook_cat_info['cat_title'] ?></h3>
                </div>
                <div class="section-detail">
                    <?php if (!empty($macbook_product_list)) {
                        ?>
                        <ul class="list-item clearfix">
                            <?php foreach($macbook_product_list as $item) {
                                ?>
                                <li>
                                    <a href="?mod=product&controller=index&action=detail&id=<?php echo $item['id'] ?>" title="" class="thumb">
                                        <img src="<?php echo $item['product_thumb'] ?>" alt="">
                                    </a>
                                    <a href="?mod=product&controller=index&action=detail&id=<?php echo $item['id'] ?>" title="" class="title"><?php echo $item['product_title'] ?></a>
                                    <p class="price"><?php echo currency_format($item['price']) ?></p>
                                </li>
                                <?php
                            } ?>
                        </ul>
                        <?php
                    } ?>
                </div>
            </div>
            <div class="section list-cat">
                <div class="section-head">
                    <h3 class="section-title"><?php echo $phone_cat_info['cat_title'] ?></h3>
                </div>
                <div class="section-detail">
                    <?php if (!empty($phone_product_list)) {
                        ?>
                        <ul class="list-item clearfix">
                            <?php foreach($phone_product_list as $item) {
                                ?>
                                <li>
                                    <a href="?mod=product&controller=index&action=detail&id=<?php echo $item['id'] ?>" title="" class="thumb">
                                        <img src="<?php echo $item['product_thumb'] ?>" alt="">
                                    </a>
                                    <a href="?mod=product&controller=index&action=detail&id=<?php echo $item['id'] ?>" title="" class="title"><?php echo $item['product_title'] ?></a>
                                    <p class="price"><?php echo currency_format($item['price']) ?></p>
                                </li>
                                <?php
                            } ?>
                        </ul>
                        <?php
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>