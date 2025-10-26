<!-- Main Footer -->
<footer id="contact" class="main-footer">
    <!--Widgets Section-->
    <div class="widgets-section">
        <div class="auto-container">
            <div class="row">
                <!--Big Column-->
                <div class="big-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <!--Footer Column-->
                        <div class="footer-column col-xl-7 col-lg-6 col-md-6 col-sm-12">
                            <div class="footer-widget about-widget">
                                <div class="logo">
                                    <a href="/"><img width="80" src="/public/assets/plugins/main/images/logo.svg" alt="" /></a>
                                </div>
                                <div class="text">
                                    <p>শিক্ষাই জাতির মেরুদন্ড। পৃথিবীর বিভিন্ন দেশে ডিজিটাল শিক্ষায় যেমন এগিয়েছে তেমনি পিছিয়ে নেই বাংলাদেশও। শিক্ষার ভিত্তি উন্নত করতে প্রযুক্তির বিকল্প নেই। তাই এই লক্ষ্য বাস্তবায়নে আমাদের ক্ষুদ্র প্রচেষ্টা।</p>
                                </div>
                                <ul class="social-icon-one social-icon-colored">
                                    <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
                                    <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                                    <li><a href="#"><i class="fab fa-dribbble"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <!--Footer Column-->
                        <div class="footer-column col-xl-5 col-lg-6 col-md-6 col-sm-12">
                            <div class="footer-widget useful-links">
                                <h2 class="widget-title">Useful Links</h2>
                                <ul class="user-links">
                                    <li><a href="/">Home</a></li>
                                    <li><a href="{{ route('domainSearch') }}">Domain Search</a></li>
                                    <li><a href="#">Services</a></li>
                                    <li><a href="#documentation">Documentation</a></li>
                                    <li><a href="{{ route('AffiliateRegisterForm') }}">Affiliate Program</a></li>
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Big Column-->
                <div class="big-column col-xl-6 col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <!--Footer Column-->
                        <div class="footer-column col-lg-6 col-md-6 col-sm-12">
                            <!--Footer Column-->
                            <div class="footer-widget contact-widget">
                                <h2 class="widget-title">Contact Us</h2>
                                <!--Footer Column-->
                                <div class="widget-content">
                                    <ul class="contact-list">
                                        <li> <span class="icon flaticon-clock"></span>
                                            <div class="text">09:00am - 10:00pm</div>
                                        </li>
                                        <li> <span class="icon flaticon-phone"></span>
                                            <div class="text"><a href="tel:+8801789050186">+8801789050186</a></div>
                                        </li>
                                        <li> <span class="icon flaticon-paper-plane"></span>
                                            <div class="text"><a href="mailto:support@example.com">support{{ '@'.$domainName }}</a></div>
                                        </li>
                                        <li> <span class="icon flaticon-worldwide"></span>
                                            <div class="text">6700 Sirajganj Sadar,
                                                <br>Sirajganj</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!--Footer Column-->
                        <div class="footer-column col-lg-6 col-md-6 col-sm-12">
                            <!--Footer Column-->
                            <div class="footer-widget instagram-widget">
                                <h2 class="widget-title">facebook Page</h2>
                                <div class="widget-content">
                                    <!-- <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Ffreelancernasimfans%2F&tabs=timeline&width=340&height=250&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=213689553055484" width="340" height="250" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Footer Bottom-->
    <div class="footer-bottom">
        <div class="auto-container">
            <div class="inner-container clearfix">
                <div class="copyright-text">
                    <p>© Copyright {{ date('Y') }} All Rights Reserved by <a href="/">{{ $domainName }}</a></p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End Footer -->