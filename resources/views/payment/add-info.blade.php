@extends('layouts.iframe')
@section('title','Add Payment Info')
@section('content')
<section class="m-lg-3">
    <div class="card card-secondary">
        <div class="card-body p-md-3 p-2">
            <form id="cashoutForm" action="{{ route('sendPayment') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="pay_method">Payment Method</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span style="padding:0;" class="input-group-text">
                                    <img id="bank_logo" style="width: 50px;height:36px;" src="/public/assets/img/banking_logo/mobile_banking.svg" alt="">
                                </span>
                            </div>
                            <select class="custom-select @error('pay_method') is-invalid @enderror" id="pay_method" name="pay_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="bKash" @if(old('pay_method') == 'bKash') {{ 'selected' }} @endif>bKash</option>
                                <option value="Rocket" @if(old('pay_method') == 'Rocket') {{ 'selected' }} @endif>Rocket</option>
                                <option value="Nagad" @if(old('pay_method') == 'Nagad') {{ 'selected' }} @endif>Nagad</option>
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

                    <div class="form-group">
                        <label for="sender">Sender Number</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="number" name="sender" id="sender" class="form-control" placeholder="sender number">
                            @error('sender')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="reference">Reference Number</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            </div>
                            <input type="number" name="reference" id="reference" class="form-control" placeholder="reference number">
                            @error('reference')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-book"></i></span>
                            </div>
                            <input type="number" name="amount" id="" class="form-control" placeholder="amount">
                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="tnx_id">Tnx ID ( Transaction ID )</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-book"></i></span>
                            </div>
                            <input type="text" name="tnx_id" id="" class="form-control" placeholder="tnx id">
                            @error('tnx_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
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
</section>
@endsection