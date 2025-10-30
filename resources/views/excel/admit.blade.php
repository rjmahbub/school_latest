<!DOCTYPE html>
<html>
<head>
    <title>Admit Card</title>
    <style>

        @media print {
            body {
                margin: 5px;
                padding: 5px;
            }
            .page {
                page-break-after: always;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                grid-template-rows: repeat(4, 1fr);
                gap: 10px;
            }
            .admit-card:nth-child(8n) {
                page-break-after: always; /* প্রতি 8 কার্ডে page break */
            }
        }
        
        body {
            font-family: Arial, sans-serif;
            padding: 3px;
        }
        .admit-card {
            width: 500px;
            border: 5px dashed #000;
            padding-left: 10px;
            margin: 5px auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            top: 10px;
            left: 10px;
            width: 50px;
            height: 50px;
        }
        .school-name {
            font-size: 20px;
            font-weight: bold;
        }
        .school-address {
            font-size: 14px;
        }
        .exam-title {
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0 10px 0;
        }
        .card-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .card-table, .card-table th, .card-table td {
            border: 1px solid #000;
        }
        .card-table th, .card-table td {
            padding: 8px;
            text-align: left;
        }
        .footer {
            display: flex;
            justify-content: space-between;
            margin: 78px 10px 5px 5px;
            font-weight: bold;
        }
        .admit-sheet {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 columns */
            grid-template-rows: repeat(4, 1fr);    /* 4 rows → 8 cards */
            gap: 50px;
        }
    </style>
</head>
<body>
<div class="admit-sheet">
    @foreach($students as $index => $student)
    <div class="admit-card">
        <!-- Header -->
        <div style="display: flex" class="header">
            <img src="{{ asset('public/uploads/demo/logo/dghs.png') }}" alt="Logo">
            <div style="margin-left: 130px">
                <div class="school-name">Dhukuria Girls’ High School</div>
                <div class="school-address">Belkuchi, Sirajganj</div>
                <div style="margin-bottom: 0" class="exam-title">Annual Examination 2025</div>
                <div style="margin-top: 0" class="exam-title">ADMIT CARD</div>
            </div>
        </div>

        <!-- Student Info Table -->
        <table class="card-table">
            <tr>
                <th>Name</th>
                <td>{{ $student[1] ?? 'MST. TANDRA KHATUN' }}</td>
                <th>Shift</th>
                <td>{{ $student['shift'] ?? 'Day' }}</td>
            </tr>
            <tr>
                <th>Class</th>
                <td>{{ $student[2] ?? 'Six' }}</td>
                <th>Section</th>
                <td>{{ $student['section'] ?? 'A' }}</td>
            </tr>
            <tr>
                <th>Roll</th>
                <td>{{ $student[0] ?? '1' }}</td>
                <th>Group</th>
                <td>{{ $student['group'] ?? '' }}</td>
            </tr>
        </table>

        <!-- Footer Signatures -->
        <div class="footer">
            <div>Class Teacher</div>
            <div>Headmaster</div>
        </div>
    </div>
        {{-- 8 কার্ডের পর নতুন page --}}
        @if(($index + 1) % 8 == 0)
            </div><div class="admit-sheet page">
        @endif
    @endforeach
</div>


</body>
</html>
