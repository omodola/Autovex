$(function() {

    var defaultStartTime = null;
    var display = $('#clockDisplay');
    var time_edit_holder = $('#time_edit_holder');
    var time_picker = $('#custom_time');
    var save_time_button = $('#save_time_button');
    var collapse_edit_trigger = $('#collapse_edit_trigger');
    var reset_time_button = $('#reset_time_button');
    var clock_url = 'http://localhost/api/clock';

    function timeDifferenceSeconds(date1, date2) {
        return Math.ceil(date1 - date2) / 1000;
    }

    function showTime(date=null){
        if(!date){
            date = new Date();
        }

        if(typeof date == 'string'){
            date = new Date(date);
        }
        var h = date.getHours(); // 0 - 23
        var m = date.getMinutes(); // 0 - 59
        var s = date.getSeconds(); // 0 - 59
        var session = "AM";

        if(h === 0){
            h = 12;
        }

        if(h > 12){
            h = h - 12;
            session = "PM";
        }

        h = (h < 10) ? "0" + h : h;
        m = (m < 10) ? "0" + m : m;
        s = (s < 10) ? "0" + s : s;

        var time = h + ":" + m + ":" + s + " " + session;
        document.getElementById("clockDisplay").innerText = time;
        document.getElementById("clockDisplay").textContent = time;

        date.setSeconds(date.getSeconds() + 1);
        setTimeout(showTime, 1000, date);

    }

    if(typeof logged_in_user_token != 'undefined'){
        updateClock();
    }else {
        if(display.length > 0){
            showTime(defaultStartTime);
        }
    }

    function createAjaxSetUp() {
        $.ajaxSetup({
            headers:{
                'Authorization':'Bearer '+logged_in_user_token,
                'Accept':'application/json',
                'Content-Type':'application/json'
            }
        });
    }

    function updateClock() {
            createAjaxSetUp();

        $.get( clock_url+'/display')
            .done(function( data ) {
                defaultStartTime = data.data;
                if(time_edit_holder.length > 0){
                    time_edit_holder.css('display','block');
                }

                if(time_picker.length > 0){
                    var curDate = new Date(defaultStartTime);
                    time_picker.val(curDate.toTimeString().split(' ')[0]);
                }
            })
            .fail(function () {
                if(time_edit_holder.length > 0){
                    time_edit_holder.css('display','none');
                }
            })
            .always(function() {

                if(display.length > 0){
                    showTime(defaultStartTime);
                }
            });
    }

    function setClock(timeDifferenceInSeconds=0) {
        $('#loader').css('display','block');
        createAjaxSetUp();

        $.get( clock_url)
            .done(async function (data) {  // record exists
                await $.ajax({
                    url: clock_url,
                    type: 'PUT',
                    data: JSON.stringify({
                        'time_difference_seconds' : timeDifferenceInSeconds
                    }),
                }).then(function () {
                    location.reload();
                });
            })
            .fail(async function () { // create new record
                await $.post(clock_url, JSON.stringify({'time_difference_seconds': timeDifferenceInSeconds})).then(function () {
                    location.reload();
                });
            });
    }

    $.fn.collapseView = function (options={}) {
        if(!options.hasOwnProperty('arrow') || !options.hasOwnProperty('div_to_collapse')){
            return;
        }

        var arrow = $(options.arrow);
        var div_to_collapse = $(options.div_to_collapse);

        arrow.toggleClass('rotate-collapsible');
        arrow.toggleClass('rotate-collapsible-reset');

        div_to_collapse.slideToggle(500);
    };

    reset_time_button.click(function () {
        setClock(0);
    });

    save_time_button.click(function () {
        var value = time_picker.val();
        var now = new Date();
        var date = now.toISOString().split('T')[0];
        var timeNow = now.toTimeString().split(' ')[0];

        let date1 = new Date(date+' '+value);
        let date2 = new Date(date+' '+timeNow);
        var timeDifferenceInSeconds = timeDifferenceSeconds(date1, date2);

        setClock(timeDifferenceInSeconds);
    });

    collapse_edit_trigger.click(function () {
        collapse_edit_trigger.collapseView({
            caller_id: '#collapse_edit_trigger',
            arrow: '#arrow_for_edit',
            div_to_collapse : '#edit_caret'
        });
    });
});
