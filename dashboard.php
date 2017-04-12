<?php
$team_code 		 = $this->session->userdata('team_code');

$user_id      	 = $this->session->userdata('user_id');
$user_info 		 = get_user_details($user_id);
$customer_id	 = $user_info->stripe_customer_id;
$payment_options = $user_info->payment_options;
$marvin_help	 = $user_info->marvin_help;

// Get user details
$user_details = get_user_details($user_id);

if($team_code != '') { ?>

<?  if(!is_teamleader() && $user_details->payment_options != 'YEARLY' && $user_details->asked_yearly < 5 && $this->session->userdata('just_logged')) { ?>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Upgrade to yearly?</h4>
                    </div>
                    <div class="modal-body">
                        <p>Do you want to save money by upgrading to a yearly subscription plan?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="dont-show-again" class="btn btn-default" data-dismiss="modal">Do not show again</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <a href="<?= site_url('membership/upgrade_yearly'); ?>"><button type="button" class="btn btn-primary">Yes</button></a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(function() {
                setTimeout(function() {
                    $('#myModal').modal('toggle');
                    // Add 1 to the users asked_yearly
                    var post_url = "/user/update_yearly";

                    var data = {
                        'type': 'increment',
                    }

                    // Save this
                    $.ajax({
                        type: "POST",
                        url: post_url,
                        data: data,
                        success: function(data) {
                            if(data == 'success') {
                                console.log('Works');
                            }
                        } //end success
                    });
                }, 500);
                $('#dont-show-again').click(function() {

                    // Update the users asked_yearly to 5
                    var post_url = "/user/update_yearly";

                    var data = {
                        'type': 'do-not-show',
                    }

                    // Save this
                    $.ajax({
                        type: "POST",
                        url: post_url,
                        data: data,
                        success: function(data) {
                            if(data == 'success') {
                                console.log('Works');
                            }
                        } //end success
                    });


                });
            });
        </script>

<?  } // endif ?>

    <div class="info-section">
        <div class="container clearfix">
            <div class="col-sm-12">
                <div class="left">
                    <!-- <img src="/img/user.png" alt="User Image" class="user"> -->
                    <div class="text">
                        <span class="welcome">Welcome</span>
                        <span><?= $first_name . ' ' . $last_name; ?></span>
                    </div>
                </div>
            </div>
<?  $pageHints = get_hints('dashboard'); ?>
<?          if(!empty($pageHints)) {
                if($pageHints->num_rows() > 0) { ?>
                    <div class="hints-toggle col-sm-12">
                        <button id="toggle-hints" class="<?= $top_colour; ?>">
                            <i class="fa fa-info"></i> Hints
                        </button>
                    </div>
<?              } // endif ?>
<?          } // endif ?>
    </div>
</div>
        </div>
    </div>

<?  if(!empty($pageHints)) {
        if($pageHints->num_rows() > 0) { ?>

            <div class="hints-container">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 hints-inner">
                            <div class="hints-content blue">
<?                              foreach($pageHints->result() as $hint) { ?>
                                    <div class="hints-title" hint-id="<?= $hint->id; ?>">
                                        <button class="hints-button"><p><?= $hint->title; ?> - View hint</p></button>
                                    </div>
                                    <div class="hints-content-text" hint-id="<?= $hint->id; ?>">
                                        <p><?= nl2br($hint->content); ?></p>
                                    </div>
<?                              } // endforeach ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(function() {
                    $('#toggle-hints').on('click', function() {
                        if($(this).hasClass('open')) {
                            $(this).html('<i class="fa fa-info"></i> Hints');
                            $(this).removeClass('open');
                        } else {
                            $(this).addClass('open');
                            $(this).html('<i class="fa fa-times-circle-o"></i> Close');
                        }
                        $('.hints-content').slideToggle();
                    });
                    $('.hints-button').on('click', function() {
                        var hintID = $(this).parent().attr('hint-id');
                        // Hide all of the hint contents
                        $('.hints-content-text').each(function() {
                            if($(this).attr('hint-id') != hintID) {
                                $(this).hide();
                            }
                        });
                        $('.hints-content-text[hint-id="' + hintID + '"]').slideToggle();
                    });
                });
            </script>

            <div style="height: 35px; background: #ECEFF4;"></div>

<?      } // endif ?>
<?  } // endif ?>

<? $this->breadcrumbs->show(); ?>

</div>

<div class="blue-content">
    <div class="container">
        <div class="page-section">
            <div class="row">

                <?= $this->load->view('template/sidebar');?>

                <div class="col-md-9">

                    <!-- Start of Search -->
                    <div class="row">
                        <!-- Dashboard Search -->
                        <div class="col-sm-12 dashboard-search">
                            <!-- Search Input -->
                            <input type="text" placeholder="Search..." id="search-input">
                            <!-- Search Spinner -->
                            <div class="search-spinner">
                                <i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>
                                <span class="sr-only">Loading...</span>
                            </div>
                            <!-- Search Results container -->
                            <div class="search-results">
                                <ul></ul>
                            </div>
                        </div>
                    </div>
                    <!-- End of search -->

                    <div class="row" data-toggle="isotope">
<?                      if($this->session->userdata('last_logged_in') == '0000-00-00 00:00:00') {
                            $this->session->unset_userdata('last_logged_in'); ?>
                            <div class="col-sm-12 welcome-message">
                                <button class="close-welcome-message">
                                    <i class="fa fa-times"></i>
                                </button>
                                <p>Hey <?= $this->session->userdata('first_name') . ' ' . $this->session->userdata('last_name'); ?>,</p>

                                <p>TheSmartPod is here to help you! The most successful FBO’s, all follow some simple steps to success, and we have done everything we can to lay these out for you.
    To get started with your training, click on <a href="<?= site_url('training'); ?>">Training</a> in the top menu. Work your way through the various training categories, and you will quickly start to learn the ropes of what can be a very profitable business.</p>

                                <p>Train smarter, not harder!</p>
                            </div>
<?                      } // endif ?>
<?                      $show_upgrade_message = 0;
                        if(!is_teamleader() && $payment_options == 'MONTHLY' && $customer_id != '') {
                            $show_upgrade_message = 1; ?>

                            <div class="dashboard-cta-banner col-sm-12">
                                <div class="dashboard-cta-inner col-sm-12">
                                    <h4>12 months for the price of 10! Only <span class="green-text">&pound;29.99</span></h4>
                                    <p>Get access to all of the latest training and updates for 12 whole months.</p>
                                    <div class="dashboard-cta-button">
                                        <a href="<?= site_url('membership/upgrade_yearly'); ?>">
                                            <button><span>Switch me</span> to a 12 month plan</button>
                                        </a>
                                    </div>
                                </div>
                            </div>

<?                      } // endif ?>
<?                      if(show_personalised_cta() && 1 == 2) { ?>

                            <div class="dashboard-cta-banner col-sm-12">
                                <div class="dashboard-cta-inner col-sm-12">
                                    <h4><b>Free</b> personalised link for your <span class="green-text">video</span></h4>
                                    <p>Get access to all of the latest training and updates for 12 whole months.</p>
                                    <div class="dashboard-cta-button">
                                        <a href="<?= site_url('video/manage'); ?>">
                                            <button><span>Interested?</span> View Details</button>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $('#hide-personalised-link').on('click', function() {
                                    $(this).attr('disabled', true);
                                    $(this).parent().parent().parent().parent().fadeOut();
                                    // Send off the ajax
                                    var personalisedCTA = "<?= site_url('/user/hidePersonalisedCTA'); ?>";
                                    $.ajax({
                                        type: "POST",
                                        url: personalisedCTA,
                                        data: null,
                                        dataType: "json",
                                        success: function(response) {
                                            // console.log(response);
                                        },
                                     });
                                });
                            </script>

<?                      } // endif ?>
                    </div>

                    <div class="row" data-toggle="isotope">
<?                      if($recent_videos){ ?>
                        <div class="item col-sm-12 recent_videos">
                            <div class="dashboard-videos panel panel-default paper-shadow" data-z="0.5">
                                <div class="panel-heading">
                                    <h4 class="text-headline margin-none">Recently Added Videos</h4>
                                    <a href="<?= site_url('/media/view#tab_videos'); ?>">
                                        <button>View All</button>
                                    </a>
                                </div>
                                    <ul class="list-group">
<?                                      foreach($recent_videos->result() as $row){ ?>
                                            <li class="list-group-item media v-middle">
                                                <div class="media-body">
                                                    <a href="<?= site_url("trainings/extra/".$row->album_id)."?video=".$row->id ?>" class="text-subhead list-group-link">
                                                        <div class="col-sm-3 media-image">
<?                                                          $thumb = $row->thumb;
                                                            $thumb = check_image_path("public/video_thumb/$thumb", $thumb);
                                                            $img_url = site_url('/public/video_thumb/' . $thumb);
                                                            $album_info = get_album_info($row->album_id);
                                                            if($thumb != '') { ?>
                                                                <img src="<?= TIMTHUMB . '?src=' . $img_url . '&h=361&w=670'; ?>" />
<?                                                          } else { ?>
                                                                <img src="<?= site_url("public/img/not_available.png"); ?>" class="thumb">
<?                                                          } // endif ?>
                                                        </div>
                                                        <div class="col-sm-9 media-title">
                                                            <h4><?= $album_info->album_name; ?></h4>
                                                            <p><?= $row->title ?></p>
                                                        </div>
                                                    </a>
                                                </div>
                                            </li>
<?                                      } // endforeach ?>
                                    </ul>
                            </div>
<?                      } // endif ?>
                        </div>
<?                      if($user_type==1 && 1 == 2) { ?>
<?                          $lecture_result = get_dashboard_lesson($team_member_id,$team_leader_id);
                            if($lecture_result) { ?>
                                <div class="item col-sm-5">
                                    <div class="dashboard-lectures panel panel-default paper-shadow" data-z="0.5">
                                        <div class="panel-heading">
                                            <h4 class="text-headline margin-none">Lectures</h4>
                                            <a href="<?= site_url('/trainings/view'); ?>">
                                                <button>View All</button>
                                            </a>
                                        </div>
                                        <ul class="list-group">
<?                                          $i = 1;
                                            $last_view = 1;
                                            $current_view = 0;
                                            $temp = 1;
                                            $oldLectureID = 0;
                                            foreach($lecture_result->result() as $lecture) {

                                                if($oldLectureID != 0) {

                                                    if(count_lecture_videos($oldLectureID) > 0) {
                                                        // See if the previous lecture is complete
                                                        if(is_lecture_complete($team_member_id, $oldLectureID)) {
                                                            $lecture_url =site_url('trainings/training_content/'.$lecture->id.'/'. $temp);
                                                            $link_class ="link_active";
                                                        } else {
                                                            $lecture_url = "";
                                                            $link_class ="link_inactive";
                                                        }
                                                    }

                                                } else {
                                                    $lecture_url =site_url('trainings/training_content/'.$lecture->id.'/'. $temp);
                                                    $link_class ="link_active";
                                                }

                                                $oldLectureID = $lecture->id;

                                                // $last_view = $current_view;

                                                if($lecture_url != "") {

                                                    if(count_lecture_videos($lecture->id) > 0) {
                                                        // The lecture has videos
                                                        if(is_lecture_complete($team_member_id, $lecture->id)) {
                                                            $lectureClass = 'complete';
                                                        } else {
                                                            if(is_lecture_started($team_member_id, $lecture->id)) {
                                                                $lectureClass = 'started';
                                                            } else {
                                                                $lectureClass = 'incomplete';
                                                            }
                                                        }
                                                    } else {
                                                        $lectureClass = 'incomplete';
                                                    }

                                                } else {
                                                    $lectureClass = 'unavailable';
                                                } ?>

                                                <li class="list-group-item media v-middle <?= $lectureClass; ?>">
                                                    <div class="media-body">
<?                                                      if($lecture_url != '') { ?>
                                                            <a href="<?= $lecture_url; ?>" class="text-subhead list-group-link">
<?                                                      } // endif ?>
                                                            <?= $lecture->lecture_title; ?>
<?                                                      if($lecture_url != '') { ?>
                                                            </a>
<?                                                      } // endif ?>
                                                    </div>
                                                </li>
<?                                          } // endforeach ?>
                                        </ul>
                                    </div>
                                </div>
<?                          } // endif ?>
<?                      } // endif ?>
                        <div class="col-sm-12">
                            <div class="dashboard-lectures dashboard-invite panel panel-default paper-shadow" data-z="0.5">
                                <div class="panel-heading">
                                    <h4 class="text-headline margin-none">Invite a Team Member</h4>
                                </div>
                                <div class="panel-body">
<?                                  $formData = array(
                                        'class' => 'invite-form',
                                    ); ?>
                                    <?= form_open(site_url('user/dashboard'), $formData); ?>
<?                                  if(validation_errors() || !empty($error)) { ?>
                                        <div class="errorMessage">
                                            <?= validation_errors(); ?>
                                            <?= display_error($error);?>
                                        </div>
<?                                  } // endif ?>
<?                                  if($this->session->flashdata('message')) { ?>
                                        <div class="alert alert-success">
                                            <?= $this->session->flashdata('message'); ?>
                                        </div>
<?                                  } // endif ?>
                                    <p>Don't forget to tell your new team member the code word for joining your team. They will need this when they sign up!</p>
                                    <p>The code word for <? echo get_team_name(); ?> is <strong><? echo get_team_code(); ?></strong></p>
                                    <p>Enter email addresses seperated by commas.</p>
<?                                  $contentField = array(
                                        'name'          => 'email',
                                        'id'            => 'email',
                                        'placeholder'   => 'Email address, email address',
                                        'maxlength'     => '50',
                                        'rows'          => '5',
                                        'cols'          => '20',
                                        'class'         => 'login',
                                        'required'      => 'required',
                                        'value'         => set_value('email')
                                    ); ?>
                                    <div class="invite-container">
                                        <?= form_input($contentField); ?>
                                        <?= form_submit('submit','Send','id="btnLogin" class="btn btn-primary"'); ?>
                                    </div>
                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<?  } // endif ?>

<? active_menu(8); ?>

<script>
    $('.close-welcome-message').click(function() {
        $(this).parent().parent().fadeOut();
    });
</script>

 <a id="hidden_link" style="display:none;" class="inline" href="#popup_message_display"></a>

<script>

    // Variables
    var typingTimer;                // Timer identifer
    var doneTypingInterval = 160;  // Time in MS, 5 seconds
    var $input = $('#search-input');

    // On key up, start the countdown
    $input.on('keyup', function() {
        // Clear the result
        $('DIV.dashboard-search DIV.search-results UL').empty();
        // Show the spinner
        $('DIV.dashboard-search DIV.search-spinner').fadeIn();
        // Clear the timeout
        clearTimeout(typingTimer);
        // Start the countdown
        typingTimer = setTimeout(function() { showResult($input.val()); }, doneTypingInterval);
    });

    // On key down, clear the countdown
    $input.on('keydown', function() {
        clearTimeout(typingTimer);
    });

    function showResult(query) {

        if(query.length != 0) {

            // Ajax
            data = {
                'query': query,
            };

            var post_url = "/user/dashboard_search";

            // Save this
            $.ajax({
                type: "POST",
                url: post_url,
                data: data,
                success: function(data) {
                    // Parse the JSON results
                    var objData = jQuery.parseJSON(data);
                    // Empty the results list
                    $('DIV.dashboard-search DIV.search-results UL').empty();
                    // Hide Spinner
                    $('DIV.dashboard-search DIV.search-spinner').fadeOut();
                    // if there are results found
                    if(jQuery.isEmptyObject(objData)) {
                        $('DIV.dashboard-search UL').append('<li><a href="#">No results...</a></li>');
                    }
                    // If results found
                    if(objData.length > 0) {
                        jQuery.each(objData, function(index, value) {
                            $('DIV.dashboard-search UL').append('<li><a href="' + value['link'] + '">' + value['type'] + ': ' + value['title'] + '</a></li>');
                        });
                    } // endif
                } //end success
            });

        } else {
            // Hide the spinner
            $('DIV.dashboard-search DIV.search-spinner').fadeOut();
        }
    }
</script>
