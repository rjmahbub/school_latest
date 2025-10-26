@extends('layouts.iframe')
@section('title','Cashout')
@section('content')
<?php $user = Auth::user(); ?>
<div class="card ml-2 mb-0">
    <ul id="iframeMenu" class="p-0 m-0">
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">
            <ul id="iframeNavigation" class="mb-0">
                <li><a href="#" onclick="window.history.back()" role="button"><i class="fas fa-arrow-left"></i></a></li>
                <li><a href="#" onclick="window.history.forward()" role="button"><i class="fas fa-arrow-right"></i></a></li>
                <li><a href="#" onclick="location.reload()" role="button"><i class="fas fa-sync"></i></a></li>
            </ul>
        </div>
        <div class="text-center text-bold d-none d-lg-inline-block col-lg-2 iframe_title">APPS ACCOUNT</div>
        <li><a class="active">Cashout</a></li>
        <li><a href="{{ route('statement') }}">Statement</a></li>
    </ul>
    <div class="card-body">
        <form id="cashoutForm" action="{{ route('cashout') }}" method="POST">
            @csrf
            <ul><li class="text-danger">Minimum cashout amount 100 taka</li></ul>
            <div class="form-group">
                <label for="">Current Balance</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img width="18" src="/public/assets/img/icons/tk-sign.svg" alt=""></span>
                    </div>
                    <input type="text" value="{{ $user->balance }}" class="form-control" disabled>
                </div>
            </div>
            
            <div class="form-group">
                <label for="cashout_amount">Cashout Amount</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><img width="18" src="/public/assets/img/icons/tk-sign.svg" alt=""></span>
                    </div>
                    <input type="number" name="cashout_amount" id="cashout_amount" min="100" max="{{ $user->balance }}" value="{{ old('cashout_amount') }}" class="form-control @error('cashout_amount') is-invalid @enderror" placeholder="cashout amount" required>
                    @error('cashout_amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="pay_method">Witdhrow Method</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span style="padding:0;" class="input-group-text">
                            <img id="bank_logo" style="width: 50px;height:36px;" src="/public/assets/img/banking_logo/mobile_banking.svg" alt="">
                        </span>
                    </div>
                    <select class="custom-select @error('pay_method') is-invalid @enderror" id="pay_method" name="pay_method" required>
                        <option value="">Select Witdhrow Method</option>
                        <option value="bKash" @if(old('pay_method') == 'bKash') {{ 'selected' }} @endif>bKash</option>
                        <option value="Rocket" @if(old('pay_method') == 'Rocket') {{ 'selected' }} @endif>Rocket</option>
                        <option value="Nagad" @if(old('pay_method') == 'Nagad') {{ 'selected' }} @endif>Nagad</option>
                        <option value="Mobile Recharge" @if(old('pay_method') == 'Mobile Recharge') {{ 'selected' }} @endif>Mobile Recharge</option>
                        <option value="HandCash" @if(old('pay_method') == 'HandCash') {{ 'selected' }} @endif>Hand Cash</option>
                    </select>
                    @error('pay_method')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <script>
                    $(document).ready(function(){
                        $('#pay_method').change(function(){
                            var val = $('#pay_method option:selected').val();
                            if(val == ''){
                                var val = 'mobile_banking';
                            }
                            $('#bank_logo').attr('src','/public/assets/img/banking_logo/'+val+'.svg');
                            if(val=='HandCash'){
                                $('#mobile').css('display','none');
                                $('#mobile_banking').val('');
                                $('#mobile_banking').attr('required',false);
                                $('#bank_logo').css('background','');
                            }else if(val=='Rocket'){
                                var len = $('#mobile_banking').attr('maxlength',12);
                                $('#mobile_banking').attr('required',true);
                                $('#bank_logo').css('background','rebeccapurple');
                            }else{
                                $("#mobile").css('display','block');
                                $('#mobile_banking').attr('maxlength',11);
                                $('#mobile_banking').attr('required',true);
                                $('#bank_logo').css('background','');
                            }
                        });
                    });
                </script>
            </div>
            
            <div id="mobile" class="form-group">
                <label for="mobile_banking">Mobile Banking Number</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i style="font-size:24px;" class="fas fa-mobile"></i></span>
                    </div>
                    <input type="number" name="mobile_banking" id="mobile_banking" value="{{ old('mobile_banking')?: $user->phone }}" class="form-control @error('mobile_banking') is-invalid @enderror" minlength="11" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" pattern="[0]{1}[1]{1}[3-9]{1}[0-9]{8}" placeholder="mobile banking number">
                    @error('mobile_banking')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="password">Transaction Password</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                    </div>
                    <input type="password" name="password" id="password" class="form-control pwd" placeholder="transaction password" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer d-flex">
                <div style="width:35px;height:35px;display:none;" class="spinner_container ml-3">
                    @include('includes.spinner')
                </div>
                <button type="submit" id="submit" class="btn btn-info pl-5 pr-5">Submit</button>
            </div>
        </form>
    </div>
</div>
<script>
    $('#cashoutForm').submit(function(){
        $('.spinner_container').show();
    })
</script>
@endsection