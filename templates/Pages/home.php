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
                <h1 class="mx-auto my-0 text-uppercase">Experience Reliable Premium Coffee now</h1>
                <h2 class="text-white-50 mx-auto mt-2 mb-5">Premium Coffee Blends and Merchandise from the Eastern Suburbs of Melbourne.</h2>
                <a class="btn btn-primary" href="<?= $this->Url->Build(['controller' => 'Shop', 'action' => 'index']) ?>">Shop now</a>
            </div>
        </div>
    </div>
</header>
<!-- About-->
<section class="about-section text-center" id="about">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8">
                <h2 class="text-white mb-4">Experience our Blend of the Month!</h2>
                <p class="text-white-50">
                    This month's premium coffee blend was developed by our special blend makers in South Jamaica.
                    <!-- <a href="https://startbootstrap.com/theme/grayscale/">the preview page.</a> -->
                    With unique notes of Cinnamon and Soursop, try out our new speciality blend of the month. Stocks are limited.
                </p>
            </div>
        </div>
        <img class="img-fluid rounded-4 glassy-image-border" src="assets/img/coffee-bg2.png" alt="..." />
    </div>
    <a class="btn btn-secondary mb-5" href="<?= $this->Url->Build(['controller' => 'shop', 'action' => 'view/30']) ?>"> Buy Now </a>
</section>
<!-- Projects-->
<section class="projects-section bg-light" id="projects">
    <div class="container px-4 px-lg-5">
        <!-- Featured Project Row-->
        <div class="row gx-0 mb-5 mb-lg-0 justify-content-center">
            <div class="col-xl-6"><img class="img-fluid" src="assets/img/coffee-bg3.png" alt="..." style="width:650px; Height:600px" /></div>
            <div class="col-xl-6 order-lg-first">
                <div class="bg-black text-center h-100 project">
                    <div class="d-flex h-100">
                        <div class="project-text w-100 my-auto text-center text-lg-right">
                            <h4 class="text-white">Premium Blend </h4>
                            <p class="mb-0 text-white-50">Browse from our collection of premium hand-crafted beans, speciality blends and many more</p>
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
                            <h4 class="text-white">Straight from the source</h4>
                            <p class="mb-0 text-white-50">Experience fresh premium blends supplied straight from local farmers around the globe</p>
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
                            <h4 class="text-white">Subscription service</h4>
                            <p class="mb-0 text-white-50">Experience regular uncompromised delivery using our subscription based delivery service
                                which can deliver at intervals of your choosing so you never have to wait (Only available for local Melbourne based customers)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
