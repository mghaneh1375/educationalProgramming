@extends('layouts.menu')

@section('title')
    ساخت برنامه ی جدید
@stop

@section('extraLibraries')

    <script>

        var scheduleId = "{{$scheduleId}}";
        var intervalLength = "{{$intervalLength}}";

        var level = "{{$level}}";
        var out = "";

        var tags = <?php echo json_encode($tags) ?>;
        var subjects = <?php echo json_encode($subjects) ?>;

        $(document).ready(function () {
            counter = 0;
            out = generateTable(6, 12, counter);
            $("#table").append(out);

            while( $('#subject_' + counter).length )
                getDefaultValTagAndSubject(counter++, scheduleId, level);

        });
        
        function changeSelector() {
            selectorVal = $("#selector").find(":selected").val();
            start = 18;
            end = 24;
            counter = ((18 - 6) / (intervalLength / 60.0)) * 7;

            switch (selectorVal) {
                case "1":
                    start = 6;
                    end = 12;
                    counter = 0;
                    break;
                case "2":
                    start = 12;
                    end = 18;
                    counter = ((12 - 6) / (intervalLength / 60.0)) * 7;
            }

            out = generateTable(start, end, counter);
            $("#table").empty();
            $("#table").append(out);

            while( $('#subject_' + counter).length )
                getDefaultValTagAndSubject(counter++, scheduleId, level);

        }
        
        function generateTable(start, end, counter) {
            i = 0;
            out = "<table>";
            while(i != 7) {
                out += "<tr>";
                switch (i) {
                    case 0:
                        out += "<td><center>شنبه</center></td>";
                        break;
                    case 1:
                        out += "<td><center>یک شنبه</center></td>";
                        break;
                    case 2:
                        out += "<td><center>دو شنبه</center></td>";
                        break;
                    case 3:
                        out += "<td><center>سه شنبه</center></td>";
                        break;
                    case 4:
                        out += "<td><center>چهار شنبه</center></td>";
                        break;
                    case 5:
                        out += "<td><center>پنج شنبه</center></td>";
                        break;
                    case 6:
                        out += "<td><center>جمعه</center></td>";
                        break;
                }
                currHour = start;
                currMin = 0;
                limitHour = start;
                limitMin = 0;
                while(currHour * 60 + currMin < end * 60) {

                    minute = intervalLength;

                    while(minute >= 60){
                        limitHour++;
                        minute -= 60;
                    }
                    limitMin += minute;
                    if(limitMin >= 60) {
                        limitHour++;
                        limitMin -= 60;
                    }
                    if(limitHour * 60 + limitMin >= end * 60) {
                        limitHour = end;
                        limitMin = 0;
                    }

                    out += "<td style='width: 200px'><center><p>" + limitMin + " : " + limitHour + " - " + currMin + " : " + currHour + "</p>";
                    out += "<p>تگ</p>";
                    tmp = "subject_" + counter;

                    if(level == 1 || level == 2) {
                        out += "<select id='" + counter + "' onchange='changeTag(\"subject_\" + this.id, this.value, scheduleId, this.id)'>";
                        for (k = 0; k < tags.length; k++)
                            out += "<option value='" + tags[k][0] + "'>" + tags[k][1] + "</option>";
                        out += "</select>";
                    }
                    else if(level == 3) {
                        out += "<p id='" + counter + "'></p>";
                    }


                    out += "<p>زیر مبحث</p>";

                    if(level == 1 || level == 2) {
                        out += "<select onchange='changeScheduleItem(this.value, scheduleId, this.id)' id='" + tmp + "' style='max-width: 150px; visibility: hidden'>";
                        for (k = 0; k < subjects.length; k++)
                            out += "<option value='" + subjects[k][0] + "'>" + subjects[k][1] + " از صفحه ی  " + subjects[k][2] + " تا " + subjects[k][3] + "</option>";
                        out += "</select>";
                    }
                    else {
                        out += "<p style='max-width: 150px; visibility: hidden' id='" + tmp + "'></p>";
                    }

                    out += "</center></td>";
                    counter++;
                    currHour = limitHour;
                    currMin = limitMin;
                }
                out += "</tr>";
                i++;
            }
            return out + "</table>";
        }

        function generateTable2() {
            selectorVal = $("#selector").find(":selected").val();
            start = 18;
            end = 24;
            counter = ((18 - 6) / (intervalLength / 60.0)) * 7;

            switch (selectorVal) {
                case "1":
                    start = 6;
                    end = 12;
                    counter = 0;
                    break;
                case "2":
                    start = 12;
                    end = 18;
                    counter = ((12 - 6) / (intervalLength / 60.0)) * 7;
            }

            i = 0;
            out = "<table>";
            while(i != 7) {
                out += "<tr>";
                switch (i) {
                    case 0:
                        out += "<td><center>شنبه</center></td>";
                        break;
                    case 1:
                        out += "<td><center>یک شنبه</center></td>";
                        break;
                    case 2:
                        out += "<td><center>دو شنبه</center></td>";
                        break;
                    case 3:
                        out += "<td><center>سه شنبه</center></td>";
                        break;
                    case 4:
                        out += "<td><center>چهار شنبه</center></td>";
                        break;
                    case 5:
                        out += "<td><center>پنج شنبه</center></td>";
                        break;
                    case 6:
                        out += "<td><center>جمعه</center></td>";
                        break;
                }
                currHour = start;
                currMin = 0;
                limitHour = start;
                limitMin = 0;
                while(currHour * 60 + currMin < end * 60) {

                    minute = intervalLength;

                    while(minute >= 60){
                        limitHour++;
                        minute -= 60;
                    }
                    limitMin += minute;
                    if(limitMin >= 60) {
                        limitHour++;
                        limitMin -= 60;
                    }
                    if(limitHour * 60 + limitMin >= end * 60) {
                        limitHour = end;
                        limitMin = 0;
                    }

                    out += "<td style='width: 200px; border: 2px solid black'><center><p>" + limitMin + " : " + limitHour + " - " + currMin + " : " + currHour + "</p>";
                    out += "<p>تگ</p>";
                    tmp = document.getElementById(counter);

                    out += "<p>" + tmp.innerText + "</p>";

                    out += "<p>زیر مبحث</p>";
                    tmp = document.getElementById("subject_" + counter);

                    out += "<p>" + tmp.innerText + "</p>";

                    out += "</center></td>";
                    counter++;
                    currHour = limitHour;
                    currMin = limitMin;
                }
                out += "</tr>";
                i++;
            }
            return out + "</table>";
        }

        function generateTable3() {
            selectorVal = $("#selector").find(":selected").val();
            start = 18;
            end = 24;
            counter = ((18 - 6) / (intervalLength / 60.0)) * 7;

            switch (selectorVal) {
                case "1":
                    start = 6;
                    end = 12;
                    counter = 0;
                    break;
                case "2":
                    start = 12;
                    end = 18;
                    counter = ((12 - 6) / (intervalLength / 60.0)) * 7;
            }
            out = "";
            i = 0;
            while(i != 7) {
                switch (i) {
                    case 0:
                        out += "شنبه" + "\n";
                        break;
                    case 1:
                        out += "یک شنبه" + "\n";
                        break;
                    case 2:
                        out += "دو شنبه" + "\n";
                        break;
                    case 3:
                        out += "سه شنبه" + "\n";
                        break;
                    case 4:
                        out +=  "چهار شنبه" + "\n";
                        break;
                    case 5:
                        out += "پنج شنبه" + "\n";
                        break;
                    case 6:
                        out += "جمعه" + "\n";
                        break;
                }
                currHour = start;
                currMin = 0;
                limitHour = start;
                limitMin = 0;
                while(currHour * 60 + currMin < end * 60) {

                    minute = intervalLength;

                    while(minute >= 60){
                        limitHour++;
                        minute -= 60;
                    }
                    limitMin += minute;
                    if(limitMin >= 60) {
                        limitHour++;
                        limitMin -= 60;
                    }
                    if(limitHour * 60 + limitMin >= end * 60) {
                        limitHour = end;
                        limitMin = 0;
                    }

                    out +=  limitMin + " : " + limitHour + " - " + currMin + " : " + currHour + "\n";
                    out += "تگ" + "\n";
                    tmp = $("#" + counter).find(":selected").text();

                    out += tmp + "\n";

                    out += "زیر مبحث" + "\n";
                    if($("#subject_" + counter).css('visibility') !== 'hidden')
                        tmp = $("#subject_" + counter).find(":selected").text();
                    else
                        tmp = "تعریف نشده";
                    out += tmp + "\n";

                    counter++;
                    currHour = limitHour;
                    currMin = limitMin;
                }
                i++;
            }
            return out;
        }

        function createPDFLocal() {
            out = generateTable2();
            createPDF(out);
        }
        
        function sendToTelegramLocal() {
            if(level == 3)
                return;
            out = generateTable3();
            sendToTelegram(out, scheduleId);
        }
        
    </script>
    <script src="{{URL::asset('js/ajaxHandler.js')}}"></script>
@stop

@section('reminder')

    <style>
        td {
            font-size: 12px;
            min-width: 50px;
            max-width: 200px;
            padding: 5px;
        }
    </style>

    <div id="wholePage" class="row" style="margin-top: 130px">

        <center>
                <h3>برنامه ریزی</h3>
        </center>
        <div class="line"></div>
        <center style="margin-top: 10px">
            <label>
                <span>کدام بخش از روز را می خواهید</span>
                <select id="selector" onchange="changeSelector()">
                    <option value="1">صبح</option>
                    <option value="2">ظهر</option>
                    <option value="3">شب</option>
                </select>
            </label>
        </center>
        <center id="table" style="margin-top: 10px; overflow-x: auto; overflow-y: auto; max-height: 60vh">
        </center>
    </div>
    <center style="margin-top: 10px">
        <button class="MyBtn" style="width: auto" onclick="createPDFLocal()">دریافت فایل پی دی اف</button>
        @if($level == 1 || $level == 2)
            <button class="MyBtn" style="width: auto" onclick="sendToTelegramLocal()">ارسال به تلگرام</button>
        @endif
    </center>
@stop