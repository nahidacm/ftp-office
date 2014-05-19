<?php
/**
 * Template Name: Portfolio 3 columns
 */
get_header();
?>
<br/>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=577966678880510&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div class="home-page-items">
    <div class="home-page-item-row-1" id="gallery" >
        <div class="admin-video portfolio">

            <ul class="home-page-flyer">
                <?php dynamic_sidebar('home-row-1'); ?>
            </ul >
            <ul class="home-admin-video">
                <li class="widget">
                    <?php
                    $latest_video = getLatestVideo();
                    $latest_video_post_id = $latest_video['ID'];
                    ?>
                    <header class="f-item-head latest-video-title">
                        <div class="fleft"><?php
                            if (function_exists('sl_get_ratings')) {
                                echo sl_get_ratings($latest_video_post_id);
                            }
                            ?></div>
                        <div class="fright"><?php comments_popup_link('0', '1', '%', 'comments-link', '-'); ?></div>
                    </header>

                    <div class="folio-desc">
                        <div class="fleft">
                            <?php
                            $title = $latest_video['post_title'];
                            ?>
                            <h4 class="latest-video-title"><a href="<?php echo get_permalink($latest_video_post_id); ?>"><?php if ($title != '') { ?><?php
//                                $title = the_title('', '', FALSE);
                                        echo substr($title, 0, 16);
                                        if (strlen($title) > 16) {
                                            echo "...";
                                        }
                                        ?><?php } else { ?>Untitled<?php } ?></a></h4>

                            <time datetime="<?php echo get_the_time('Y-m-d\TH:i', $latest_video_post_id); ?>"><?php echo get_the_time('m.d.Y', $latest_video_post_id); ?></time>
                        </div>

                        <div class="fright">
                            <?php
                            if (function_exists('sl_get_fire_trash_tip_icon')) {
                                sl_get_fire_trash_tip_icon($latest_video_post_id);
                            }
                            ?>
                        </div>
                        <div class="clear"></div>
                    </div>


                    <span class="image-border">
                        <a title="Permanent Link to howz it it’s me" href="http://spitlava.com/portfolio-view/howz-it-its-me/" class="image-wrap">
                            <img src="http://spitlava.com/wp-content/themes/theme1418/timthumb.php?src=http://view.vzaar.com/1215918/image&amp;w=196&amp;h=139&amp;q=100">
                        </a>
                    </span>
                </li>
            </ul>
            <div class="clear"></div>

            <?php if (has_post_thumbnail($latest_video_post_id)) { ?>
                <div class="latest-video-thumb">
                    <span class="image-border"><a class="image-wrap" href="<?php echo get_permalink($latest_video_post_id) ?>" title="<?php _e('Permanent Link to', 'theme1418'); ?> <?php echo $title ?>" ><?php get_the_post_thumbnail($latest_video_post_id, 'portfolio-post-thumbnail') ?></a></span>
                </div>
                <?php
            } else {

                $values1 = get_post_custom_values("sl_video_id");
                $video_id = $values1[0];
                if (isset($video_id)) {
                    ?>
                    <span class="image-border"><a class="image-wrap" href="<?php echo get_permalink($latest_video_post_id) ?>" title="<?php _e('Permanent Link to', 'theme1418'); ?> <?php echo $title ?>" ><img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=http://view.vzaar.com/<?php echo $video_id; ?>/image&w=196&h=139&q=100"></a></span>	
                    <?php
                }
            }
            ?>	
        </div>

        <div class="home-page-item-2">
            <ul>
                <?php dynamic_sidebar('home-row-2') ?>

                <li class="rating">
                    <div class="widget" id="sl-ratings-widget-4">
                        <h3>Ratings</h3>
                        <ul>
                            <li class="post-rating-item">
                                <span class="fleft">
                                    <a href="https://spitlava.com/?post_type=portfolio&amp;p=1030">SuperGeeks Rap</a>
                                </span>
                                <span class="fright"><div class="post-ratings"><img src="./wp-content/plugins/sl_rating_manager/images/stars-1.png" alt="Admin Rating" title="Admin Rating" class="post-ratings-image"></div></span>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
            <div class="clear"></div>
        </div>



        <h1 class="holder">Top 3 videos upload...</h1>

        <?php 
        $top3videos = getTop3video();
        ?>
        <div class="top-3-video-container">
            <ul class="portfolio">
                <?php foreach ($top3videos as $top3video){ ?>
                <li class="">
                    <header class="f-item-head">
                        <div class="fleft">
                            <?php
                            $top3id = $top3video['ID'];
                            if (function_exists('sl_get_ratings')) {
                                echo sl_get_ratings($top3id);
                            }
                            ?>
                        </div>
                        <div class="fright">
                            <?php comments_popup_link('0', '1', '%', 'comments-link', '-'); ?>
                        </div>
                    </header>
                    <div class="folio-desc">
                        <div class="fleft">
                           <?php
                            $top3title = $top3video['post_title'];
                            ?>
                            <h4 class="latest-video-title">
                                <a href="<?php echo get_permalink($top3id); ?>"><?php if ($top3title != '') { ?><?php
                                        echo substr($top3title, 0, 16);
                                        if (strlen($top3title) > 16) {
                                            echo "...";
                                        }
                                        ?><?php } else { ?>Untitled<?php } ?>
                                </a>
                            </h4>

                            <time datetime="<?php echo get_the_time('Y-m-d\TH:i', $top3id); ?>"><?php echo get_the_time('m.d.Y', $top3id); ?></time>
                        </div>
                        <div class="fright">
                            <?php
                            if (function_exists('sl_get_fire_trash_tip_icon')) {
                                sl_get_fire_trash_tip_icon($top3id);
                            }
                            ?>
                        </div>
   
                        <div class="clear"></div>
                    </div>
                    <span class="image-border">
                        <a title="Permanent Link to howz it it’s me" href="http://spitlava.com/portfolio-view/howz-it-its-me/" class="image-wrap">
                            <img src="http://spitlava.com/wp-content/themes/theme1418/timthumb.php?src=http://view.vzaar.com/1215918/image&amp;w=196&amp;h=139&amp;q=100" style="display: none;">
                        </a>
                    </span>	
                </li>
                <?php } ?>
            </ul>
        </div>


    </div>
</div>
<?php get_footer(); ?>