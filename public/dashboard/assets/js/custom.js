$(document).ready(function () {
    var notification = function () {
        $.ajax({
            type: "GET",
            url: base_url + "/notifications/read/other",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function (msg) {
                if (msg.success == true) {
                    $("#notificationCountButtonArea").remove();
                }
            },
        });
    };

    var boardsNotification = function () {
        $.ajax({
            type: "GET",
            url: base_url + "/notifications/read/other",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function (msg) {
                if (msg.success == true) {
                    $("#boardOrderCountButtonArea").remove();
                }
            },
        });
    };

    var orderCount = function () {
        $.ajax({
            type: "GET",
            url: base_url + "/notifications/read/order",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function (msg) {
                if (msg.success == true) {
                    $("#orderCountButtonArea").remove();
                }
            },
        });
    };

    $("#notificationButton").click(notification).hover(notification);

    $("#orderCountButton").click(orderCount).hover(orderCount);

    $("#boardOrderCountButtonArea").click(boardsNotification).hover(boardsNotification);

    setInterval(orderNotify, 2000);
    setInterval(boardOrderNotify, 2000);
});

function orderNotify() {
    $.ajax({
        type: "GET",
        url: base_url + "/notifications/notify",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            _token: "{{ csrf_token() }}",
        },
        success: function (msg) {
            if (msg.success == true) {
                for (var i = 0; i < msg.data.length; i++) {
                    ion.sound({
                        sounds: [
                            {
                                name: "beer_can_opening",
                            },
                            {
                                name: "bell_ring",
                            },
                            {
                                name: "branch_break",
                            },
                            {
                                name: "button_click",
                            },
                        ],

                        // main config
                        path: asset_url + "dashboard/ion-sound/sounds/",
                        preload: true,
                        multiplay: true,
                        volume: 1.0,
                    });
                    // play sound
                    ion.sound.play("bell_ring", {
                        loop: 4,
                    });

                    $.notify(
                        {
                            title: "<a style='text-decoration: none;color:#fff' href='"+base_url+"/orders/view/"+ msg.data[i].model_id+"'><strong>" + msg.data[i].title + "</strong></a>",
                            message: "<a style='text-decoration: none;color:#fff' href='"+base_url+"/orders/view/"+ msg.data[i].model_id+"'>" + msg.data[i].content + "</a>",
                        },
                        {
                            type: "info",
                            allow_dismiss: false,
                            newest_on_top: true,
                            mouse_over: true,
                            showProgressbar: false,
                            spacing: 20,
                            timer: 10000,
                            placement: {
                                from: "bottom",
                                align: "left",
                            },
                            offset: {
                                x: 30,
                                y: 30,
                            },
                            delay: 1000,
                            z_index: 10000,
                            animate: {
                                enter: "animated rollIn",
                                exit: "animated rollOut",
                            },
                        }
                    );
                }
            }
        },
    });
}

function boardOrderNotify() {
    $.ajax({
        type: "GET",
        url: base_url + "/notifications/board_notify",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            _token: "{{ csrf_token() }}",
        },
        success: function (msg) {
            if (msg.success == true) {
                for (var i = 0; i < msg.data.length; i++) {
                    ion.sound({
                        sounds: [
                            {
                                name: "beer_can_opening",
                            },
                            {
                                name: "bell_ring",
                            },
                            {
                                name: "branch_break",
                            },
                            {
                                name: "button_click",
                            },
                        ],

                        // main config
                        path: asset_url + "dashboard/ion-sound/sounds/",
                        preload: true,
                        multiplay: true,
                        volume: 1.0,
                    });
                    // play sound
                    ion.sound.play("bell_ring", {
                        loop: 4,
                    });

                    $.notify(
                        {
                            title: "<a style='text-decoration: none;color:#fff' href='"+base_url+"/boards/orders/view/"+ msg.data[i].model_id+"'><strong>" + msg.data[i].title + "</strong></a>",
                            message: "<a style='text-decoration: none;color:#fff' href='"+base_url+"/boards/orders/view/"+ msg.data[i].model_id+"'>" + msg.data[i].content + "</a>",
                        },
                        {
                            type: "warning",
                            allow_dismiss: false,
                            newest_on_top: true,
                            mouse_over: true,
                            showProgressbar: false,
                            spacing: 20,
                            timer: 10000,
                            placement: {
                                from: "bottom",
                                align: "left",
                            },
                            offset: {
                                x: 30,
                                y: 30,
                            },
                            delay: 1000,
                            z_index: 10000,
                            animate: {
                                enter: "animated rollIn",
                                exit: "animated rollOut",
                            },
                        }
                    );
                }
            }
        },
    });
}

function changeTheme(theme) {
    $.ajax({
        type: "GET",
        url: base_url + "/settings/theme/"+theme,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            _token: "{{ csrf_token() }}",
        },
        success: function (msg) {
            return false;
        },
    });
}
