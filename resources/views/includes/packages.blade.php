<section id="packages" class="pricing-section" style="background-image: url(/public/assets/plugins/main/images/background/6.jpg);">
    <div class="anim-icons"> <span class="icon icon-circle-green wow fadeIn"></span> <span class="icon icon-circle-blue wow fadeIn"></span> <span class="icon icon-circle-pink wow fadeIn"></span> </div>
    <div class="auto-container">
        <div class="sec-title text-center">
            <h2 class="text-white">Choose a Package</h2> </div>
        <div class="outer-box">
            <div class="row">
                <!-- Pricing Block -->
                <?php
                    $i = 0;
                    $a = array('flaticon-paper-plane','flaticon-diamond-1','flaticon-rocket-ship');
                ?>
                @foreach($packages as $package)
                <div class="pricing-block col-lg-4 col-md-6 col-sm-12 wow fadeInUp">
                    <div class="inner-box">
                        <div class="icon-box">
                            <div class="icon-outer"><span class="icon {{ $a[$i] }}"></span></div>
                        </div>
                        <div class="price-box">
                            <div class="title">{{ $package->name }}</div>
                            <h5 class="text-info">{{ $package->price }}</h5>
                        </div>
                        @php
                            $array = explode(',',rtrim($package->details,','));
                        @endphp
                        <ul class="features">
                        @foreach($array as $sa)
                            @php
                                $data = explode('::',$sa);
                            @endphp
                            <li class="{{ $data[1] }}">{{ $data[0] }}</li>
                        @endforeach
                        </ul>
                        <div class="btn-box"> <a href="{{ route('DomainRegisterForm').'?package='.$package->id }}@if(isset($_GET['prefix']))&prefix={{ $_GET['prefix'] }} @endif" class="theme-btn">BUY Now</a> </div>
                    </div>
                </div>
                <?php $i++; ?>
                @endforeach
            </div>
        </div>
    </div>
</section>