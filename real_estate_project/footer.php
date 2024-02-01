<div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <h2 class="heading">Important Links</h2>
                        <ul class="useful-links">
                            <li><a href="">Home</a></li>
                            <li><a href="">Properties</a></li>
                            <li><a href="">Agents</a></li>
                            <li><a href="">Blog</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <h2 class="heading">Locations</h2>
                        <ul class="useful-links">
                            <li><a href="">New York</a></li>
                            <li><a href="">Boston</a></li>
                            <li><a href="">Orlanco</a></li>
                            <li><a href="">Los Angeles</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <h2 class="heading">Contact</h2>
                        <div class="list-item">
                            <div class="left">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="right">
                                34 Antiger Lane, USA, 12937
                            </div>
                        </div>
                        <div class="list-item">
                            <div class="left">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="right">contact@arefindev.com</div>
                        </div>
                        <div class="list-item">
                            <div class="left">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="right">122-222-1212</div>
                        </div>
                        <ul class="social">
                            <li>
                                <a href=""><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li>
                                <a href=""><i class="fab fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href=""><i class="fab fa-pinterest-p"></i></a>
                            </li>
                            <li>
                                <a href=""><i class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li>
                                <a href=""><i class="fab fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <h2 class="heading">Newsletter</h2>
                        <p>
                            To get the latest news from our website, please
                            subscribe us here:
                        </p>
                        <form action="" method="post">
                            <div class="form-group">
                                <input type="text" name="" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" value="Subscribe Now">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="copyright">
                        Copyright 2023, ArefinDev. All Rights Reserved.
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="right">
                        <ul>
                            <li><a href="terms.html">Terms of Use</a></li>
                            <li>
                                <a href="privacy.html">Privacy Policy</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="scroll-top">
        <i class="fas fa-angle-up"></i>
    </div>

    <script src="<?php echo BASE_URL; ?>dist/js/custom.js"></script>

    <?php if(isset($error_message)): ?>
        <script>
            iziToast.show({
                message: '<?php echo $error_message; ?>',
                position: 'topRight',
                color: 'red',
            });
        </script>
    <?php endif; ?>

    <?php if(isset($success_massage)): ?>
        <script>
            iziToast.show({
                message: '<?php echo $success_massage; ?>',
                position: 'topRight',
                color: 'green',
            });
        </script>
    <?php endif; ?>
    <!-- condition for registration success  -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <script>
            iziToast.show({
                message: '<?php echo $_SESSION['success_message']; ?>',
                position: 'topRight',
                color: 'green',
            });
        </script>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
</body>
</html>