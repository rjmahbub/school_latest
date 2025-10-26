<div class="col-lg-3 col-6">
    <div class="small-box bg-info">
        <div class="inner">
            <h5><span class="count">{{ $user->balance }}</span></h5>
            <p>Balance</p>
        </div>
        <div class="icon"> <i class="fas fa-chart-pie"></i></div>
        <div class="text-center small-box-footer">
            <a href="{{ route('payment') }}" class="text-white mx-2">Payment</a>
            <span>|</span>
            <a href="javascript:void(0)" data-toggle="modal" data-target="#ModalRecharge" class="text-white mx-2">Recharge</a>
        </div>
    </div>
</div>

<!-- Modal Recharge -->
<div class="modal fade" id="ModalRecharge" data-keyboard="false" data-backdrop="static">
    <div style="max-width: 400px" class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 id="StudentName" class="modal-title text-center">Token Recharge</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body text-center">
                <form action="{{ route('TokenRecharge') }}" method="POST">
                    @csrf
                    <input type="number" name="token" class="form-control" placeholder="enter token number">
                    <button type="submit" class="btn btn-success mt-4">Recharge</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>