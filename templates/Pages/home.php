<?php
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>BrewHub</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Core theme custom CSS (Grayscale overrides + site styles) -->
    <link href="css/styles.css" rel="stylesheet" />

</head>
<body id="page-top">
<!-- Masthead-->
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
        <img class="img-fluid" src="assets/img/coffee-bg2.png" alt="..." style="opacity: 0.7; width: 600px; height: 600px; margin-bottom: 50px;" />

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

<!-- Contact-->
<section class="contact-section bg-black">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5">
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card py-4 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-map-marked-alt text-primary mb-2"></i>
                        <h4 class="text-uppercase m-0">Address</h4>
                        <hr class="my-4 mx-auto" />
                        <div class="small text-black-50">3002 East Melbourne, Vic</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card py-4 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-envelope text-primary mb-2"></i>
                        <h4 class="text-uppercase m-0">Email</h4>
                        <hr class="my-4 mx-auto" />
                        <div class="small text-black-50"><a href="#!">BrewHub@gmail.com</a></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <div class="card py-4 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-mobile-alt text-primary mb-2"></i>
                        <h4 class="text-uppercase m-0">Phone</h4>
                        <hr class="my-4 mx-auto" />
                        <div class="small text-black-50">0492 199 332</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="social d-flex justify-content-center">
             <a class="mx-2" href="#!"><i class="fab fa-twitter"></i></a>
             <a class="mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
             <a class="mx-2" href="#!"><i class="fab fa-github"></i></a>
         </div> -->
    </div>
</section>
<!-- Footer-->
<footer class="footer bg-black small text-center text-white-50"><div class="container px-4 px-lg-5">Copyright &copy; 2025 BrewHub. All Rights Reserved.</div></footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<!-- * *                               SB Forms JS                               * *-->
<!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
<!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
<script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>
</html>
