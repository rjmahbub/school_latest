<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Attendance Calendar</title>
    <link rel="stylesheet" href="/public/assets/plugins/calendar/calendar.css">
    <link rel="stylesheet" href="/public/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="/public/assets/plugins/fontawesome-free/css/all.min.css">
    <script src="/public/assets/plugins/jquery/jquery.min.js"></script>
    <style>
        .input-group {
            position: relative;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-flex-wrap: wrap;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            -webkit-align-items: stretch;
            -ms-flex-align: stretch;
            align-items: stretch;
            width: 100%;
        }
        .form-control {
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px);
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            box-shadow: inset 0 0 0 transparent;
            transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }

    </style>
</head>
<body class="light">
    <?php
        if($request->type){
            $type = $request->type;
        }else{
            $type = 2;
        }
        if($request->id){
            $id = $request->id;
        }else{
            $id = null;
        }
    ?>
    <div class="calendar">
        <div class="calendar-week-day" style="display:flex;padding-left: 6px;padding-top: 5px;">
            <div class="calendar-info" style="display: flex;">
                <div class="bg-present"><span id="presentCount">0</span></div>
                <h6>Present</h6>
            </div>
            <div class="calendar-info" style="display: flex;">
                <div class="bg-absence"><span id="absenceCount">0</span></div>
                <h6>Absence</h6>
            </div>
            <div class="calendar-info" style="display: flex;">
                <div class="bg-holiday"><span id="holidayCount">0</span></div>
                <h6>Holiday</h6>
            </div>
        </div>
        <div class="calendar-header">
            <span class="month-picker" id="month-picker">February</span>
            <div class="year-picker">
                <span class="year-change" id="prev-year">
                    <pre><</pre>
                </span>
                <span id="year">2021</span>
                <span class="year-change" id="next-year">
                    <pre>></pre>
                </span>
            </div>
        </div>
        <div class="calendar-body">
            <form action="">
                <div style="display:flex;" class="form-group clearfix">
                    <div style="margin-left:10px;" class="icheck-success">
                        <input type="radio" name="type" id="rd2" value="2" onclick="searchTos($('#id').val())" @if($type == 2) checked @endif>
                        <label for="rd2">Student</label>
                    </div>
                    <div style="margin-left:10px;" class="icheck-success">
                        <input type="radio" name="type" id="rd1" value="1" onclick="searchTos($('#id').val())" @if($type == 1) checked @endif>
                        <label for="rd1">Teacher</label>
                    </div>
                </div>
                <h5 style="margin-bottom:5px;" class="clr">Name: {{ $name }}</h5>
                <div class="input-group">
                    <div style="display:flex;width:100%">
                        <input type="text" name="id" id="id" value="{{ $id }}" list="search-list" oninput="searchTos(this.value)" class="form-control" placeholder="@if($type == 1) name or id @else name, roll, id or session @endif" autocomplete="off" style="border-top-right-radius: 0;border-bottom-right-radius: 0;">
                        <button style="width: 42px;border: 1px solid #ddd;margin-left: 0px;font-size: 17px;border-top-right-radius: 4px;border-bottom-right-radius:4px;padding:5px;cursor:pointer;">GO!</button>
                    </div>
                    <datalist id="search-list">
                        
                    </datalist>
                </div>
            </form>
            <div class="calendar-week-day">
                <div>Sun</div>
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
            </div>
            <div class="calendar-days"></div>
        </div>
        <div class="calendar-footer">
            <div class="toggle">
                <span>Dark Mode</span>
                <div class="dark-mode-switch">
                    <div class="dark-mode-switch-ident"></div>
                </div>
            </div>
        </div>
        <div class="month-list"></div>
    </div>
<script>
    function searchTos(v){
        if($('#rd1').prop('checked') == true){
            var type = 1;
            $('#id').attr('placeholder','name, phone or id');
        }
        if($('#rd2').prop('checked') == true){
            var type = 2;
            $('#id').attr('placeholder','name, roll, phone, id or session');
        }
        $.ajax({
            url: "{{ route('searchTos') }}",
            type: 'POST',
            data: {_token:'{{ csrf_token() }}', type:type, q:v },
            success: function(result){
                $('#search-list').html(result)
            },
            error: function(e){
                alert('error')
            }
        })
    }
</script>
<script>
    let calendar = document.querySelector('.calendar')

    const month_names = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']

    isLeapYear = (year) => {
        return (year % 4 === 0 && year % 100 !== 0 && year % 400 !== 0) || (year % 100 === 0 && year % 400 ===0)
    }

    getFebDays = (year) => {
        return isLeapYear(year) ? 29 : 28
    }

    generateCalendar = (month, year) => {
        let calendar_days = calendar.querySelector('.calendar-days')
        let calendar_header_year = calendar.querySelector('#year')
        let days_of_month = [31, getFebDays(year), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31]
        calendar_days.innerHTML = ''
        let currDate = new Date()
        if (!month) month = currDate.getMonth()
        if (!year) year = currDate.getFullYear()

        let curr_month = `${month_names[month]}`
        month_picker.innerHTML = curr_month
        calendar_header_year.innerHTML = year
        // get first day of month
        let first_day = new Date(year, month, 1)
        for (let i = 0; i <= days_of_month[month] + first_day.getDay() - 1; i++) {
            let day = document.createElement('div')
            if (i >= first_day.getDay()) {
                var d = i - first_day.getDay() + 1;
                @if($request->id && $name !== null)
                var id = "{{ $id }}";
                if($('#rd1').prop('checked') == true){
                    var type = 1;
                }
                if($('#rd2').prop('checked') == true){
                    var type = 2;
                }
                if(d == 1){
                    $('#presentCount,#absenceCount,#holidayCount,#nullCount').text(0);
                }

                $.ajax({
                    url: "{{ route('getAttendance') }}",
                    type: 'POST',
                    data: {_token:'{{ csrf_token() }}', id:id, type:type, day:d, month:month, year:year},
                    success: function(result){
                        if(result == 'P'){
                            var t = $('#presentCount');
                            var c = parseInt(t.text())+1;
                            t.text(c);
                            day.classList.add('bg-present');
                        }
                        if(result == 'H'){
                            var t = $('#holidayCount');
                            var c = parseInt(t.text())+1;
                            t.text(c);
                            day.classList.add('bg-holiday');
                        }
                        if(result == ''){
                            var t = $('#absenceCount');
                            var c = parseInt(t.text())+1;
                            t.text(c);
                        }
                        day.innerHTML = i - first_day.getDay() + 1
                        day.innerHTML += `<span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>`
                        if (i - first_day.getDay() + 1 === currDate.getDate() && year === currDate.getFullYear() && month === currDate.getMonth()) {
                            day.classList.add('curr-date')
                        }
                    }
                })
                @endif
            }
            calendar_days.appendChild(day)
        }
    }

    let month_list = calendar.querySelector('.month-list')
    month_names.forEach((e, index) => {
        let month = document.createElement('div')
        month.innerHTML = `<div data-month="${index}">${e}</div>`
        month.querySelector('div').onclick = () => {
            month_list.classList.remove('show')
            curr_month.value = index
            generateCalendar(index, curr_year.value)
        }
        month_list.appendChild(month)
    })
    let month_picker = calendar.querySelector('#month-picker')
    month_picker.onclick = () => {
        month_list.classList.add('show')
    }
    let currDate = new Date()
    let curr_month = {value: currDate.getMonth()}
    let curr_year = {value: currDate.getFullYear()}

    generateCalendar(curr_month.value, curr_year.value)

    document.querySelector('#prev-year').onclick = () => {
        --curr_year.value
        generateCalendar(curr_month.value, curr_year.value)
    }

    document.querySelector('#next-year').onclick = () => {
        ++curr_year.value
        generateCalendar(curr_month.value, curr_year.value)
    }

    let dark_mode_toggle = document.querySelector('.dark-mode-switch')
    dark_mode_toggle.onclick = () => {
        document.querySelector('body').classList.toggle('light')
        document.querySelector('body').classList.toggle('dark')
    }
</script>
</body>
</html>