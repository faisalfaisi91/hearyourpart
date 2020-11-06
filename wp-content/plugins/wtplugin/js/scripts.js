jQuery(document).ready(function ($) {

    $('.invite_people').click(function () {
        $('.invite_inputs').slideToggle()
    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    $('.send-invite').click(function () {
        $('p.message').html('').slideUp()
        if (isEmail($('#invite_email').val())) {
            var ajax_url = $(this).data('ajax-url');
            $(this).prepend('<i class="fa fa-refresh fa-spin fa-fw"></i>').attr('disabled', true);

            $.ajax({
                url: ajax_url,
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'invite_people_send_email',
                    invite_email: $('#invite_email').val()
                },
                success: function (response) {
                    $('.send-invite').attr('disabled', false).find('i').remove();
                    $('p.message').html(response.message).slideDown();
                    if (!response.error) {
                        location.reload();
                    }

                }

            })
        } else {
            $('p.message').html('Please input valid Email address').slideDown()
        }
    })

    $('.user-resend').click(function () {
        var ajax_url = $(this).data('ajax-url');
        $(this).find('i').removeClass('fa-envelope-o').addClass('fa-refresh fa-spin fa-fw');
        $.ajax({
            url: ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'invite_people_send_email',
                invite_email: $(this).data('email')
            },
            success: function (response) {
                $('.send-invite').attr('disabled', false).find('i').remove();
                $('.user-resend').find('i').removeClass('fa-refresh fa-spin fa-fw').addClass('fa-envelope-o');
                setTimeout(function () {
                    $('p.message').html('').slideUp()
                }, 5000)

            }

        })
    });
    $('.user-remove').click(function () {
        var ajax_url = $(this).data('ajax-url');
        $(this).find('i').removeClass('fa-close').addClass('fa-refresh fa-spin fa-fw');
        $.ajax({
            url: ajax_url,
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'remove_people_send_email',
                remove_email: $(this).data('user-email')
            },
            success: function (response) {
                $('.user-remove').find('i').removeClass('fa-refresh fa-spin fa-fw').addClass('fa-close');
                if (!response.error) {
                    location.reload();
                }

            }

        })
    });

    function update_playlist(hf) {
        hf.attr('disabled', true);
        hf.val('Adding...');
        hf.append('<i class="fa fa-refresh fa-spin fa-fw"></i> ');
        var old_playlist_id = $('#playlist_selected_id').val();
        var new_playlist_title = $('#playlist_input').val();
        $.ajax({
            url: hf.data('url'),
            dataType: 'json',
            type: 'POST',
            data: {
                action: 'update_playlist',
                type: hf.data('type'),
                'song-id': hf.data('song-id'),
                'old_playlist': old_playlist_id,
                'new_playlist': new_playlist_title
            },
            success: function () {
                hf.find('i.fa-refresh').remove();
                if (hf.data('type') == 'remove') {
                    hf.closest('article').remove();
                }
                if (hf.data('type') == 'add') {
                    $('.selection-success').html('Song Added to your Playlist');
                    window.location.href = hf.data('redirect') + '/playlist';
                }
            },
            error: function () {
                hf.attr('disabled', false);
                hf.val('Add Song');
            }
        })
    }

    function remove_playlist(hf) {
        $.ajax({
            url: hf.data('url'),
            dataType: 'json',
            type: 'POST',
            data: {
                action: 'remove_playlist',
                type: hf.data('type'),
                'song-id': hf.data('song-id')
            },
            success: function () {
                hf.find('i.fa-refresh').remove();
                if (hf.data('type') == 'remove') {
                    hf.closest('article').remove();
                }
                location.reload();
            },
            error: function () {

            }
        })
    }

    function remove_song(hf) {
        $.ajax({
            url: hf.data('url'),
            dataType: 'json',
            type: 'POST',
            data: {
                action: 'remove_song',
                type: hf.data('type'),
                'song-id': hf.data('song-id'),
                'playlist-id': hf.data('playlist-id')
            },
            success: function () {
                hf.find('i.fa-refresh').remove();
                if (hf.data('type') == 'remove') {
                    hf.closest('article').remove();
                }
                location.reload();
            },
            error: function () {

            }
        })
    }

    function create_playlist(hf) {
        hf.attr('disabled', true);
        hf.val('Adding...');
        hf.append('<i class="fa fa-refresh fa-spin fa-fw"></i> ');
        var new_playlist_title = $('#createplaylist_input').val();
        $.ajax({
            url: hf.data('url'),
            dataType: 'json',
            type: 'POST',
            data: {
                action: 'create_playlist',
                type: hf.data('type'),
                'new_playlist': new_playlist_title
            },
            success: function () {
                hf.find('i.fa-refresh').remove();
                if (hf.data('type') == 'remove') {
                    hf.closest('article').remove();
                }
                if (hf.data('type') == 'add') {
                    $('.selection-success').html('New playlist created!');
                    window.location.href = hf.data('redirect') + '/artists-2';
                }
            },
            error: function () {
                hf.attr('disabled', false);
                hf.val('Create');
            }
        });
        return false;
    }

    $('#playlist_select').change(function () {
        $('#playlist_selected_id').val($(this).val());
    });

    $('.add_song_btn').click(function (e) {
        if (($('#playlist_selected_id').val() === '') && ($('#playlist_input').val() === '')) {
            $('.selection-error').html('Please select from list or add new playlist');
            return false;
        } else {
            $('.selection-error').html('');
            var hf = $(this);
            update_playlist(hf);
            $('.add_song_btn').attr('disabled', true);
        }
    })

    $('.create_playlist_btn').click(function (e) {
        if ($('#createplaylist_input').val() === '')
    {
        $('.selection-error').html('Please enter title for your playlist');
        return false;
    }
else
    {
        $('.selection-error').html('');
        var hf = $(this);
        create_playlist(hf);
        $('.create_playlist_btn').attr('disabled', true);
    }
})

    $('.update_playlist').click(function (e) {
        var hf = $(this);
        // When the user clicks on the button, open the modal
        document.getElementById("myModal").style.display = "block";
        // When the user clicks anywhere outside of the modal, close it
        //update_playlist(hf)
    })
    $('#myModal .close').click(function(){
        $('#myModal').fadeOut('slow');
    });
    // document.getElementsByClassName("close")[0].onclick = function () {
    //     document.getElementById("myModal").style.display = "none";
    // }
    window.onclick = function (event) {
        if (event.target == document.getElementById("myModal")) {
            document.getElementById("myModal").style.display = "none";
        }
    }
    $('.notify_members_btn').click(function () {
        $(this).html('Loading...');
        $(this).css('pointer-events', 'none');
        var hf = $(this);
        $.ajax({
            url: hf.data('url'),
            dataType: 'json',
            type: 'POST',
            data: {
                action: 'notify_members',
                type: hf.data('type')
            },
            success: function (response) {
                $('.notify_success').slideDown();
                $('.notify_success').delay(5000).fadeOut('slow');
                $('.notify_members_btn').html('Notify Members');
                $('.notify_members_btn').css('pointer-events', 'auto');
            },
            error: function (response) {
            }
        });
        return false;
    });

    $('.create_playlist').click(function () {
        var hf = $(this);
        // When the user clicks on the button, open the modal
        document.getElementById("createModal").style.display = "block";
        // When the user clicks anywhere outside of the modal, close it
        //update_playlist(hf)
    })

    $('#createModal .close').click(function(){
       $('#createModal').fadeOut('slow');
    });
    // document.getElementsByClassName("close")[0].onclick = function () {
    //     document.getElementById("createModal").style.display = "none";
    // }
    window.onclick = function (event) {
        if (event.target == document.getElementById("createModal")) {
            document.getElementById("createModal").style.display = "none";
        }
    }
    $('.wtmusic_player').delegate('.update_playlist', 'click', function () {
        var hf = $(this);
        update_playlist(hf);
    })
    $('.delete_playlist').click(function () {
        if (!confirm("Do you want to delete")) {
            return false;
        }
        var hf = $(this);
        remove_playlist(hf);
    });
    $('.delete_song').click(function () {
        if (!confirm("Do you want to delete")) {
            return false;
        }
        var hf = $(this);
        remove_song(hf);
    });
    $(document).ready(function () {
        $('#new_playlist_section').hide();
        $('#show_playlist_input_btn').click(function () {
            $('#old_playlists').fadeOut('fast');
            $('#new_playlist_section').fadeIn('slow');
        });
        $('#show_old_playlist_btn').click(function () {
            $('#new_playlist_section').fadeOut('fast');
            $('#old_playlists').fadeIn('slow');
        })
    })

});