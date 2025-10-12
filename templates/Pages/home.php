<?php
/**
 * @var \App\View\AppView $this
 */
$this->setLayout('frontend');
$this->assign('title', 'Home');
?>

<header class="masthead">
    <div class="container px-4 px-lg-5 d-flex h-100 align-items-center justify-content-center">
        <div class="d-flex justify-content-center">
            <div class="text-center">
                <h1 class="mx-auto my-0 text-uppercase"><?= $this->ContentBlock->text('home_hero_title') ?></h1>
                <h2 class="text-white-50 mx-auto mt-2 mb-5"><?= $this->ContentBlock->text('home_hero_subtitle') ?></h2>
                <a class="btn btn-primary" href="<?= $this->Url->Build(['controller' => 'Shop', 'action' => 'index']) ?>"><?= $this->ContentBlock->text('home_hero_call_to_action') ?></a>
            </div>
        </div>
    </div>
</header>
<!-- About-->
<section class="about-section text-center" id="about">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-white mb-4"><?= $this->ContentBlock->text('home_promo_heading') ?></h2>
                <p class="text-white-50">
                    <?= $this->ContentBlock->text('home_promo_desc') ?>
                </p>
            </div>
        </div>
        <img class="img-fluid"
             src="<?= $this->Url->build(!empty($featuredProduct->product_images[0]) ? '/img/products/' . $featuredProduct->product_images[0]->image_file : '/assets/img/featureddefault.png') ?>"
    </div>
    <a class="btn btn-secondary mb-5" href="<?= $this->Url->Build(['controller' => 'shop', 'action' => 'view', $featuredProduct->id]) ?>"><?= $this->ContentBlock->text('home_promo_call_to_action') ?></a>
</section>
<!-- Projects-->
<section class="projects-section bg-light" id="projects">
    <div class="container px-4 px-lg-5">
        <!-- Featured Project Row-->
        <div class="row gx-0 mb-5 mb-lg-0 justify-content-center">
            <div class="col-xl-6"><img class="img-fluid" src="assets/img/coffee-bg6.jpg" alt="..." /></div>
            <div class="col-xl-6 order-lg-first">
                <div class="bg-black text-center h-100 project">
                    <div class="d-flex h-100">
                        <div class="project-text w-100 my-auto text-center text-lg-right">
                            <h4 class="text-white"><?= $this->ContentBlock->text('home_p1_heading') ?></h4>
                            <p class="mb-0 text-white-50"><?= $this->ContentBlock->text('home_p1_desc') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project One Row-->
        <div class="row gx-0 mb-5 mb-lg-0 justify-content-center">
            <div class="col-lg-6"><img class="img-fluid" src="assets/img/coffee-bg4.jpg" alt="..." /></div>
            <div class="col-lg-6">
                <div class="bg-black text-center h-100 project">
                    <div class="d-flex h-100">
                        <div class="project-text w-100 my-auto text-center text-lg-left">
                            <h4 class="text-white"><?= $this->ContentBlock->text('home_p2_heading') ?></h4>
                            <p class="mb-0 text-white-50"><?= $this->ContentBlock->text('home_p2_desc') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Project Two Row-->
        <div class="row gx-0 justify-content-center">
            <div class="col-lg-6"><img class="img-fluid" src="assets/img/coffee-bg5.jpg" alt="..." /></div>
            <div class="col-lg-6 order-lg-first">
                <div class="bg-black text-center h-100 project">
                    <div class="d-flex h-100">
                        <div class="project-text w-100 my-auto text-center text-lg-right">
                            <h4 class="text-white"><?= $this->ContentBlock->text('home_p3_heading') ?></h4>
                            <p class="mb-0 text-white-50"><?= $this->ContentBlock->text('home_p3_desc') ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
