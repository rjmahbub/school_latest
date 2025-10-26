$(function(){
    $("#form-total").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "fade",
        enableAllSteps: true,
        autoFocus: true,
        transitionEffectSpeed: 500,
        titleTemplate : '<div class="title">#title#</div>',
        labels: {
            previous : 'Previous',
            next : 'Next Step',
            finish : 'Submit',
            current : ''
        },
        onStepChanging: function (event, currentIndex, newIndex) { 
            var fullname = $('#full_name').val();
            var nickname = $('#nick_name').val();
			var gender = $('form input[type=radio]:checked').val();
            var email = $('#email').val();
            var phone = $('#phone').val();
			
			var db_prefix = $('#prefix').val();
			var inst_name = $('#inst_name').val();
			var inst_addr = $('#inst_addr').val();
            var inst_phone = $('#inst_phone').val();
            var inst_phone2 = $('#inst_phone2').val();
            var inst_email = $('#inst_email').val();
            

            $('#fullname-val').text(fullname);
            $('#nickname-val').text(nickname);
			$('#gender-val').text(gender);
			$('#phone-val').text(phone);
            $('#email-val').text(email);
            
			$('#prefix-val').text(db_prefix);
			$('#inst_name-val').text(inst_name);
			$('#inst_addr-val').text(inst_addr);
            $('#inst_phone-val').text(inst_phone);
            $('#inst_phone2-val').text(inst_phone2);
            $('#inst_email-val').text(inst_email);
            
            return true;
        }
    });
    $("#Submit").click(function(){
		$("#AddInstitute").submit();
	});
});
