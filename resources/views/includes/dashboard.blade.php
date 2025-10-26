@extends('layouts.iframe')
@section('title','Dashboard')
@section('content')
<?php $user = Auth::user(); ?>
@if($user->who == 3)
<section class="m-lg-3">
    <div class="card card-secondary mb-0">
        <div class="card-header" onclick="cardCollaspFunc($(this))" data-card-widget="collapse">
            <h3 class="card-title">Account</h3>
            <div class="card-tools">
                <button style="position: relative;top: 10px;" type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-md-3 p-2">
            <div class="row">
                @include('includes.recharge')

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h5>Registered</h5>
                            <p>{{ date('d M Y h:i:sa',strtotime($inst->created_at)) }}</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i></div>
                        <a href="javascript:void(0)" onclick="location.reload()" class="small-box-footer">Refresh <i class="fas fa-sync"></i></a>
                    </div>
                </div>

                @if($user->who == 3)
                @if(strtotime($inst->valid_till)-864000 > strtotime(now()))
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h5>Expire</h5>
                            <p>{{ date('d M Y h:i:sa',strtotime($inst->valid_till)) }}</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i></div>
                        <a href="{{ route('InstituteRenewForm') }}" class="small-box-footer">Renew <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @else
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h5>Expire</h5>
                            <p class="blink">{{ $inst->valid_till }}</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i></div>
                        <a href="{{ route('InstituteRenewForm') }}" class="small-box-footer">Renew <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</section>
@endif

@if($user->who == 1 || $user->who == 2 || $user->who == 3)
<section class="m-lg-3">
	<?php
        $totalUser = null;
        foreach($usersCount as $k => $v){
            $totalUser += $v;
        }
    ?>
    <div class="card card-secondary mb-0">
        <div class="card-header" onclick="cardCollaspFunc($(this))" data-card-widget="collapse">
            <h3 class="card-title collapsebar">Registered User</h3>
            <div class="card-tools">
                <button style="position: relative;top: 10px;" type="button" class="btn btn-tool">
                <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-md-3 p-2">
            <div class="row">
                @if($user->who == 1 || $user->who == 2)
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h5 class="count">{{ $usersCount[1] }}</h5>
                            <p>Super Admin</p>
                        </div>
                        <div class="icon"><i class="fas fa-user"></i></div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h5 class="count">{{ $usersCount[2] }}</h5>
                            <p>Sub Super Admin</p>
                        </div>
                        <div class="icon"> <i class="fas fa-user"></i> </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> 
                    </div>
                </div>
                @endif
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h5 class="count">{{ $usersCount[3] }}</h5>
                            <p>Institute Admin</p>
                        </div>
                        <div class="icon"> <i class="fas fa-user"></i> </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h5 class="count">{{ $usersCount[4] }}</h5>
                            <p>Teacher</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chalkboard-teacher"></i> </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h5 class="count">{{ $usersCount[5] }}</h5>
                            <p>Student</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i> </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h5 class="count">{{ $usersCount[6] }}</h5>
                            <p>Guardian</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i> </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @if($user->who == 1 || $user->who == 2)
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h5 class="count">{{ $usersCount[7] }}</h5>
                            <p>Affiliate User</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i> </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="m-lg-3">
	<?php
        $totalUser = null;
        foreach($usersCount as $k => $v){
            $totalUser += $v;
        }
    ?>
    <div class="card card-secondary mb-0">
        <div class="card-header" onclick="cardCollaspFunc($(this))" data-card-widget="collapse">
            <h3 class="card-title">Total Student & Teacher</h3>
            <div class="card-tools">
                <button style="position: relative;top: 10px;" type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-md-3 p-2">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h5 class="count">{{ $studentsCount }}</h5>
                            <p>Total Student</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i></div>
                        <a href="{{ route('students') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h5 class="count">{{ $teachersCount }}</h5>
                            <p>Total Teacher</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i></div>
                        <a href="{{ route('teachers') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@if($user->who == 7)
<section class="m-lg-3">
    <div class="card card-secondary mb-0">
        <div class="card-header" onclick="cardCollaspFunc($(this))" data-card-widget="collapse">
            <h3 class="card-title">Income History</h3>
            <div class="card-tools">
                <button style="position: relative;top: 10px;" type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-md-3 p-2">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h5><span class="count">{{ $user->balance }}</span>.00</h5>
                            <p>Current Balance</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i></div>
                        <a href="{{ route('cashoutForm') }}" class="small-box-footer">Withdraw <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h5 class="count">{{ $totalCashout }}</h5>
                            <p>Withdrawal Balance</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i></div>
                        <a href="{{ route('cashoutHistory') }}" class="small-box-footer">Withdraw History <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h5 class="count">{{ $totalRefer }}</h5>
                            <p>Number of Referral</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i></div>
                        <a style="font-weight:bold" href="{{ route('DomainRegisterForm') }}?q=1&refer={{ $user->id }}" class="small-box-footer"><span class="blink">Refer Now <i class="fas fa-arrow-circle-right"></i></span></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h5 class="count">{{ $user->balance + $totalCashout }}</h5>
                            <p>Total Income</p>
                        </div>
                        <div class="icon"> <i class="fas fa-chart-pie"></i></div>
                        <a href="{{ route('statement') }}" class="small-box-footer">Statement <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
@endif