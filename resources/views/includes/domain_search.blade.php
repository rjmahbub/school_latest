<section id="domain_search" class="domain-search sec-title mt-5 pt-5" style="z-index:1;">
    <form action="{{ route('package') }}">
        <h1 class="text-center title mb-0" style="font-size: 25px; letter-spacing:1px;">Search your perfect Domain</h1>
        <div class="form-group text-center" style="max-width: 800px;margin: 0 auto;">
            <div class="input-group py-3 px-1">
                <div class="input-group-prepend d-none d-sm-inline-block">
                    <span class="input-group-text"><i style="font-size:35px;" class="fas fa-globe"></i></span>
                </div>
                <div class="input-group-prepend">
                    <span class="input-group-text p-1 p-md-2">www.</span>
                </div>
                <input style="text-transform:lowercase;border: 3px solid #ddd;padding: 10px;" type="text" name="prefix" id="prefix" onkeypress="return /[0-9a-z]/i.test(event.key)" class="form-control" placeholder="sub-domain..." autocomplete="off" required>
                <div class="input-group-append">
                    <span class="input-group-text p-1 p-md-2">.dakbss.com</span>
                </div>
            </div>
            <div id="message"></div>
            <button style="width:130px;" type="submit" id="domainSubmit" class="btn btn-primary py-2" disabled><i class="fa fa-shopping-cart"></i> Check Out</button>
        </div>
    </form>
</section>
<script>
	//setup before functions
	var typingTimer;                //timer identifier
	var doneTypingInterval = 1000;  //time in ms, 5 second for example
	var $input = $('#prefix');

	//on keyup, start the countdown
	$input.on('keyup', function () {
	clearTimeout(typingTimer);
	typingTimer = setTimeout(doneTyping, doneTypingInterval);
	});

	//on keydown, clear the countdown 
	$input.on('keydown', function () {
	clearTimeout(typingTimer);
	});

	//user is "finished typing," do something
	function doneTyping () {
		$('#message').empty();
		$('.fa-globe').addClass('fa-spin');
		var prefix = $input.val();
		if(prefix !== ''){
			$.ajax({
				url: "{{ route('checkSubdomain') }}",
				type: 'post',
				data: {_token:'{{ csrf_token() }}', prefix:''+prefix+''},
				success: function(result){
					if(result == false){
						$('#message').show().html('<p class="text-success text-center"><i class="fa fa-check"></i> Congratulations! the domain is available.</p>');
						$('.fa-globe').removeClass('fa-spin');
						$('#domainSubmit').removeAttr('disabled');
					}else{
						$('.fa-globe').removeClass('fa-spin');
						$('#message').show().html('<p class="text-danger text-center"><i class="fa fa-times"></i> sorry! already taken another.</p>');
						$('#domainSubmit').attr('disabled','true');
					}
				}
			})
		}else{
			$('#domainSubmit').attr('disabled','true');
			$('.fa-globe').removeClass('fa-spin');
			$('#message').show().html('<p class="text-danger text-center"><i class="fa fa-times"></i> Please enter subdomain name</p>');
		}
	}
</script>