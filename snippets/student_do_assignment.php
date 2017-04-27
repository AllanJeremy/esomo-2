    <?php
if (!isset($_SESSION["student_adm_no"])) {

?>
<div class="row">
    <div class=" container">
        <br>
        <br>
        <h5 class="grey-text text-darken-3 center-align">You need to log in first</h5>
        <br>
        <h6 class="grey-text text-lighten-2 center-align">Redirecting you...</h6>
        <div class=" col s6 offset-s3 container valign-wrapper">
<!--                <div class="" style="width:200px">-->
            <div class="valign progress" >
                    <div class="indeterminate" style="width:0%;"></div>
            </div>
<!--                </div>-->
        </div>
        <br>
        <br>
        <br>
        <br>
        <h6 class="right-align">
            If you are not directed to the login page <a class="inline" href="../index.php"> click here. </a>
        </h6>
    </div>
</div>
<script src="js/jquery-2.0.0.js"></script>
<script type="text/javascript">
    setTimeout(function () {
        location.replace('login.php');
    }, 3400)

</script>
        <?php
//            redirect
        } else {
    ?>

<header data-assignment-id="<?php echo $assignment['ass_id']; ?>" class="">
    <div class="brookhurst-theme-primary lighten-1">
        <div class="container ">
            <br>
            <div class="row no-bottom-margin">
                <h5 class="col s10 php-data white-text">Title: <?php echo $assignment['ass_title']; ?></h5>
                <p class="col s12 php-data white-text margin-vert-8">From <?php echo $assignment['teacher_name']['first_name'] .' '. $assignment['teacher_name']['last_name'] ; ?></p>
                <h5 class="col s12 php-data white-text">Description</h5>
                <p class="col s11 php-data white-text"><?php echo $assignment['ass_description']; ?></p>
            </div>
            <br>
        </div>
        <div class="assignment-action-header marg-16">
            <a class="btn btn-large js-assignment-submit" href="">Submit</a>
            <p class="center-align js-assignment-due <?php echo EsomoDate::GetDueText($assignment['due_date'])['due_class']; ?> pad-6 white-text"><?php echo EsomoDate::GetDueText($assignment['due_date'])['due_text']; ?></p>
        </div>
    </div>
    <div class="brookhurst-theme-primary lighten-2 row pin-nav-top">

        <div class="col s12">
            <a class="white-text btn-flat btn marg-6 hide"><i class="material-icons">arrow_back</i></a>
            <ul class="tabs inline tabs-transparent">
                <?php
    if(isset($_GET['sect'])) {
        if($_GET['sect'] == 'resources' && isset($_GET['sect'])) {
            $res_tab_class = 'active';
            $ass_tab_class = '';
        } else {
            $res_tab_class = '';
            $ass_tab_class = 'active';
        }
    } else {
        $res_tab_class = '';
        $ass_tab_class = 'active';
    }
                ?>
                <li class="tab col s6"><a class="<?php echo $ass_tab_class; ?>" href="#myAssignment">My assignment</a></li>
                <li class="tab col s6"><a href="#resources" class="<?php echo $res_tab_class; ?>">resources</a></li>
            </ul>

            <a class="white-text btn-flat btn right marg-6 js-download-assignment" title="download the whole assignment">download</a>
            <a class="white-text btn-flat btn right marg-6 js-upload-assignment" title="upload your assignment">upload </a>
        </div>
    </div>

</header>
<main>
    <div id="myAssignment" class="row container">
        <div class="m12 s12 col l8 assignment-tinymce">
            <div hidefocus="0" class="brookhurst-theme-primary lighten-3 row tinymce-toolbar inline-toolbar" id="mytoolbar">
            </div>
            <div class="header white row z-depth-2">
                <div class="col s6 input-field no-margin">
                    <input type="text" class="no-margin js-myAssignment-title" placeholder="assignment title" title="type your assignment title">

                </div>
                <div class="col s6">
                    <a class="js-save-myAssignment btn-flat marg-8 right" title="save your assignment">Save <i class="material-icons right">save</i></a>
                </div>
            </div>
            <div name="body" id="body" class="z-depth-1-half pad-16 inline-editor row tinymce-document">

            </div>
            <div id="editor"></div>
        </div>
        <div class="m12 col l3 offset-l1 hide-on-med-and-down">
            <div class="row resources-bar marg-16">
                <p class="grey-text">Resources</p>
                <div class="divider"></div>
                <div class="resource-bar">
                    <ul>
                        <?php

                        $attachments = explode(",",$assignment['attachments']);
                        array_pop($attachments);

                        foreach($attachments as $attachment):
                        ?>
                        <li class="margin-vert-8">
                            <a href="" class="black-text"><?php echo $attachment; ?></a>
                            <p class="no-margin grey-text text-lighten-1 secondary-title"><?php echo explode(".",$attachment)[count(explode(".",$attachment)) - 1]; ?></p>
                            <p class="no-margin grey-text text-lighten-1 secondary-title">23kb</p>
                        </li>
                        <li class="divider"></li>
                        <?php
                        endforeach;
                        ?>

                        <!--TEMPLATE-->
                        <!--<li class="margin-vert-8">
                            <a href="" class="black-text">This type of resources</a>
                            <p class="no-margin grey-text text-lighten-1 secondary-title">PDF.</p>
                            <p class="no-margin grey-text text-lighten-1 secondary-title">23kb</p>
                        </li>
                        <li class="divider"></li>-->

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div id="resources" class="row container">
        <div class="col s12">
            <div class="resources-bar"></div>
            <ul>
                <?php

                $attachments = explode(",",$assignment['attachments']);
                array_pop($attachments);

                foreach($attachments as $attachment):
                ?>
                <li class="margin-vert-8">
                    <a href="./uploads/assignments/<?php echo $attachment; ?>" target="_blank" class="black-text"><?php echo $attachment; ?></a>
                    <p class="no-margin grey-text text-lighten-1 secondary-title"><?php echo explode(".",$attachment)[count(explode(".",$attachment)) - 1]; ?></p>
                    <p class="no-margin grey-text text-lighten-1 secondary-title">23kb</p>
                </li>
                <li class="divider"></li>
                <?php
                endforeach;
                ?>

                <!--TEMPLATE-->
                <!--
                <li class="margin-vert-8">
                    <a href="" class="black-text">This type of resources</a>
                    <p class="no-margin grey-text text-lighten-1 secondary-title">PDF.</p>
                    <p class="no-margin grey-text text-lighten-1 secondary-title">23kb</p>
                </li>
                <li class="divider"></li>
                -->
            </ul>
        </div>
    </div>

    <div id="assignmentUpload" class="modal modal-fixed-footer">
        <div class="modal-content">
            <div id="dragDropArea">
                <h4 class="white-text">
                    Upload assignment documents
                </h4>
                <div class="row no-margin">
                    <div id="assignmentTotalInfo" class="col m6 s12">
                        <h6 class=" op-4">To upload</h6>
                        <h4 class="white-text">
                            <span id="totalAssignments">0</span> files
                        </h4>
                        <br>
                        <div class="progress" style="width:0%;">
                            <div class="determinate" style="width:0%;"></div>
                        </div>
                        <h6 class="num-progress hide secondary-text-color">
                            <i>Uploading <span class="js-num-progress">0%</span></i>
                        </h6>
                    </div>
                    <div class="col m6 s12">
                        <form id="createAssignmentForm">
                            <div class=" input-field col s12 file-field ">
                                <div class="btn">
                                    <span>add assignment</span>
                                    <input type="file" multiple name="assignments">
                                </div>
                            </div>
                            <input type="submit" name="submitBtn" class="hide btn material-icons btn-floating btn-large upload-btn" value="&#xE2C6;" />
                        </form>
                        <div style="padding-top:20px;margin-top:20px;" class="hide-on-med-and-down">
                            <br>
                            <h6 class="right-align op-4">or drag and drop on the colored area.</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row no-margin" id="errorContainer">
                <ul></ul>
            </div>
            <div class="row" id="assignmentsList">
                <div class="container row" >
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#!" id="modalFooterCloseAction" class=" modal-action modal-close waves-effect waves-red btn-flat">close</a>
            <a href="#!" id="uploadAssignment" class=" modal-action waves-effect waves-green btn disabled"><i class="material-icons left">&#xE2C6;</i>upload</a>
        </div>
    </div>
</main>
<script src="js/jquery-2.0.0.js"></script>
<script src="js/js_print.js"></script>
<script src="js/dashboard/lists_templates.js"></script>
<script src="js/dashboard/student_assignment_events.js"></script>

<!--DON'T MESS WITH-->
<script src="tinymce/jquery.tinymce.min.js"></script>
<script src="tinymce/tinymce.min.js"></script>
<script src="js/materialize.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: '#body',
        theme: 'modern',
        inline: true,
        skin: 'lightgray',
        //event_root: '#root',
        fixed_toolbar_container: '#mytoolbar',
        width: 'auto',
        height: 'auto',
        auto_focus: true,
        subfolder:"",
        toolbar1: 'forecolor backcolor | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
        toolbar2: 'undo redo | link unlink anchor image | fullscreen',
        forced_root_block: 0,
        relative_urls: false,
        plugins: [
            "advlist autolink autosave textpattern link image lists charmap preview hr anchor pagebreak",
            "table contextmenu directionality paste textcolor"
        ],
        image_advtab: false,
        toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect forecolor backcolor | link unlink anchor | image media"
    });

    Lists_Templates = new Lists_Templates();
    StudentAssignmentEvents = new StudentAssignmentEvents();

    var $target = $('.pin-nav-top'),
        $target2 = $('.inline-toolbar'),
        $target3 = $('.resources-bar');

    $target.pushpin({
        top: $target.offset().top,
        bottom: $('main').outerHeight(),
        offset: 0
    });
    $target2.pushpin({
        top: $target.offset().top + $target.outerHeight(),
        bottom: $('main').outerHeight(),
        offset: $target.outerHeight()
    });
    $target3.pushpin({
        top: $target.offset().top + $target.outerHeight(),
        bottom: $('main').outerHeight(),
        offset: $target.outerHeight() + 160
    });
</script>
<!--DON'T EVEN THINK ABOUT IT -->

<?php
}
?>