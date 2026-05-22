<?php
$is_premium_user = get_option('ovation_slider_is_premium', false);
?>
<div class="mian-slider-sec">
    <!--------- Second Slider Header START ----------->
    <div class="serch-header row align-items-center mb-4">

        <div class="left-div col-xl-10 col-lg-9 col-md-8">
            <ul class="nav nav-tabs-slider-sec" id="Sliderheader" role="tablist">
                <li class="nav-item-slider">
                    <a class="nav-link-slider active" data-bs-toggle="tab" href="#all" role="tab">All</a>
                </li>
                <li class="nav-item-slider">
                    <a class="nav-link-slider" data-bs-toggle="tab" href="#business" role="tab">Business</a>
                </li>
                <li class="nav-item-slider">
                    <a class="nav-link-slider" data-bs-toggle="tab" href="#education" role="tab">Education</a>
                </li>
                <li class="nav-item-slider">
                    <a class="nav-link-slider" data-bs-toggle="tab" href="#travel" role="tab">Travel</a>
                </li>
                <li class="nav-item-slider">
                    <a class="nav-link-slider" data-bs-toggle="tab" href="#ecommerce" role="tab">Ecommerce</a>
                </li>
                <li class="nav-item-slider">
                    <a class="nav-link-slider" data-bs-toggle="tab" href="#restaurant" role="tab">Restaurant</a>
                </li>
                <li class="nav-item-slider">
                    <a class="nav-link-slider" data-bs-toggle="tab" href="#blogs" role="tab">Blogs</a>
                </li>
            </ul>
        </div>


        <div class="right-div col-xl-2 col-lg-3 col-md-4 mt-3 mt-md-0">
            <div class="slider-search-container">
                <input type="search" id="ov-template-search-input" placeholder="Search for Template |">
                <i class="fas fa-search search-icon"></i>
            </div>
        </div>
    </div>
    <!-- for content -->

    <!--------- Second Slider Header END ----------->
    <div class="container-custom-one ">
        <div class="row">
            <div class="tab-content mt-4">

                <?php
                $is_premium_user = get_option('ovation_slider_is_premium', false);

                $templates = array(
                    array('id' => 1, 'title' => 'Business Slider Template', 'category' => 'business', 'image' => OVA_ELEMS_URL . 'assets/images/template-1.png'),
                    array('id' => 2, 'title' => 'Travel Slider Template', 'category' => 'travel', 'image' => OVA_ELEMS_URL . 'assets/images/template-2.png'),
                    array('id' => 3, 'title' => 'Ecommerce Slider Template', 'category' => 'ecommerce', 'image' => OVA_ELEMS_URL . 'assets/images/template-3.png'),
                    array('id' => 4, 'title' => 'News Slider Template', 'category' => 'blogs', 'image' => OVA_ELEMS_URL . 'assets/images/template-4.png'),
                    array('id' => 5, 'title' => 'Food Slider Template', 'category' => 'restaurant', 'image' => OVA_ELEMS_URL . 'assets/images/template-5.png'),
                    array('id' => 6, 'title' => 'Restaurant Slider Template', 'category' => 'restaurant', 'image' => OVA_ELEMS_URL . 'assets/images/template-6.png'),
                    array('id' => 7, 'title' => 'Travel Slider Template2', 'category' => 'travel', 'image' => OVA_ELEMS_URL . 'assets/images/template-7.png'),
                    array('id' => 8, 'title' => 'Education Slider Template', 'category' => 'education', 'image' => OVA_ELEMS_URL . 'assets/images/template-8.png'),
                    array('id' => 9, 'title' => 'Business Slider Template2', 'category' => 'business', 'image' => OVA_ELEMS_URL . 'assets/images/template-9.png'),
                    array('id' => 10, 'title' => 'Ecommerce Slider Template2', 'category' => 'ecommerce', 'image' => OVA_ELEMS_URL . 'assets/images/template-10.png'),
                    array('id' => 11, 'title' => 'Travel Slider Template3', 'category' => 'travel', 'image' => OVA_ELEMS_URL . 'assets/images/template-11.png'),
                    array('id' => 12, 'title' => 'Restaurant Slider Template2', 'category' => 'restaurant', 'image' => OVA_ELEMS_URL . 'assets/images/template-12.png'),
                    array('id' => 13, 'title' => 'Ecommerce Slider Template3', 'category' => 'ecommerce', 'image' => OVA_ELEMS_URL . 'assets/images/template-13.png'),
                    array('id' => 14, 'title' => 'Business Slider Template3', 'category' => 'business', 'image' => OVA_ELEMS_URL . 'assets/images/template-14.png'),
                    array('id' => 15, 'title' => 'Education Slider Template2', 'category' => 'education', 'image' => OVA_ELEMS_URL . 'assets/images/template-15.png'),
                );
                ?>

                <!-- TEMPLATE POOL (hidden, single source) -->
                <div id="template-pool" class="d-none">
                    <?php
                    foreach ($templates as $template) {
                        $is_pro_template = in_array($template['id'], [6, 7, 8, 9]);
                        $coming_soon_ids = [10, 11, 12, 13, 14, 15];
                        ?>
                        <div class="col-md-4 col-lg-2 col-12 mb-4 inner-cards"
                            data-title="<?php echo esc_attr(strtolower($template['title'])); ?>"
                            data-category="<?php echo esc_attr($template['category']); ?>">

                            <div class="slider-card">
                                <div class="slider-image">
                                    <img src="<?php echo esc_url($template['image']); ?>" alt="">
                                </div>

                                <div class="heading-wrapper mt-2">
                                    <h5 class="card-title"><?php echo esc_html($template['title']); ?></h5>

                                    <div class="template-actions">
                                        <?php
                                        if (in_array($template['id'], $coming_soon_ids)) {
                                            if (!$is_premium_user) {
                                                echo '<a href="https://www.ovationthemes.com/products/ovation-elements-pro" target="_blank" class="btn btn-primary">Upgrade to Pro</a>';
                                            } else {
                                                echo '<button class="btn btn-secondary" disabled>Select Template</button>';
                                            }
                                            echo '<img src="' . esc_url(OVA_ELEMS_URL . 'assets/images/coming-soon.png') . '" class="coming-soon-image">';
                                        } elseif (!$is_premium_user && $is_pro_template) {
                                            echo '<a href="https://www.ovationthemes.com/products/ovation-elements-pro" target="_blank" class="btn btn-primary">Upgrade to Pro</a>';
                                        } else {
                                            echo '<a href="' . esc_url(admin_url('admin-post.php?action=create_ova_elems&template_id=' . $template['id'])) . '" class="btn btn-primary">Select Template</a>';
                                        }

                                        if (!in_array($template['id'], $coming_soon_ids)) {
                                            echo $is_pro_template
                                                ? '<span class="oe-crown"><i class="fa-solid fa-crown"></i> PRO</span>'
                                                : '<span class="badge oe-free">FREE</span>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <?php
                $tabs = ['all', 'business', 'education', 'travel', 'ecommerce', 'restaurant', 'blogs'];
                foreach ($tabs as $i => $tab) {
                    ?>
                    <div class="tab-pane fade <?php echo $i === 0 ? 'show active' : ''; ?>" id="<?php echo $tab; ?>">
                        <div class="row template-target" data-target="<?php echo $tab; ?>"></div>
                    </div>
                <?php } ?>

                <p id="no-templates-found" style="display:none;text-align:center;font-weight:bold;">No templates found.
                </p>

            </div>

        </div>
    </div>

</div>