<?php
    //Global sections
    const SECTION_ACCOUNT = "account";
    const SECTION_RESOURCES = "resources";
    const SECTION_CHAT = "chat";
    const SECTION_GROUP = "group";

    //Global page titles
    const PAGE_TITLE_ACCOUNT = "My account";
    const PAGE_TITLE_RESOURCES = "Resources";
    
    //Tabs that can be found in navigations
    const TAB_CREATE = "create";
    const TAB_MANAGE = "manage";
    const TAB_IMPORT = "import";
    const TAB_VIEW = "view";
    
    //Include required files
    require_once("handlers/session_handler.php");
    require_once("handlers/global_init_handler.php");

    #If user is not logged in, they will be redirected to this file
    $redirectPath = "login.php";

    //If statement that determines whether content can be viewed
    if (MySessionHandler::AdminIsLoggedIn() || MySessionHandler::StudentIsLoggedIn()):

        //Constants for the tabs and sections
        //Section and tab variable references
        $section = &$_GET["section"];
        $tab = &$_GET["tab"];
?>
<!DOCTYPE html>

<html lang="en" >
    <head>
        <?php require_once("handlers/header_handler.php");?>

        <title><?php echo MyHeaderHandler::GetPageTitle();?></title>

        <!--Site metadata-->
        <?php MyHeaderHandler::GetMetaData(); ?>
        
        <link  rel="stylesheet" type="text/css" href="stylesheets/compiled-materialize.css"/>
        <link  rel="stylesheet" type="text/css" href="stylesheets/pace-theme-flash.css"/>
<!--        <script src="js/head.min.js"></script>-->
        <script>
//            head.load('https://fonts.googleapis.com/icon?family=Material+Icons');
        </script>

        
    </head>

    <body class="<!--side-nav-page--> grey lighten-5">
        <?php 
            #Update license and check if the license info provided is valid
            if(!RainLicense::LicenseValid())
            {
                ErrorHandler::MsgBoxInfo(RainLicense::INVALID_LICENSE_MESSAGE,"no-margin");
                include_once("./snippets/site_footer.php");
                echo "</body>";
                die();
            }

            //Account type - from session variable storing the account type of the currently logged in user
            $snippet_folder = "snippets/";#folder that contains snippets
            $headerImageUrl = "";
            $accType="";
            $accountName ="";
            $firstName="";
            $logoutLink = "";
            //Determine what type of account is logged in and set accType to the appropriate value
            if(MySessionHandler::AdminIsLoggedIn())
            {
                $accType = $_SESSION["admin_account_type"];#corresponds with file name prefix as well as the database name of the account type
                $accountName = $_SESSION["admin_username"];
                $firstName = $_SESSION["admin_first_name"];
                $headerImageUrl = "images/stairway.jpg";
                $logoutLink = "?action=admin_logout";
            }
            else if(MySessionHandler::StudentIsLoggedIn())
            {
                $accType = "student";#corresponds with file name prefix
                $accountName = $_SESSION["student_username"];
                $firstName = $_SESSION["student_first_name"];
                $headerImageUrl = "";
                $logoutLink = "?action=student_logout";
            }

            //Check to see if the logout action has been triggered

            
            if(isset($_GET["action"]))
            {
                $actionVariable = htmlspecialchars($_GET["action"]);#sanitized action variable to get the GET action variable
                switch($actionVariable)
                {
                    case "student_logout":
                        MySessionHandler::StudentLogout();#logout
                    break;

                    case "admin_logout":#admin logs out
                        MySessionHandler::AdminLogout();
                    break;

                    default:#invalid entry, anything we hadn't planned for
                        echo "<p>If you're seeing this, there has been a problem with the logout, please try again</p>";

                }
                unset($_GET["action"]);#unset the action GET variable if it hasn't been automagically unset
            }
        ?>
        <header class="horizontal-navigation z-depth-1">
            <nav class="top-nav ">
                <div class="container ">
                    <div class="nav-wrapper ">
<!--                        <a href="#" class="brand-logo">Logo</a>-->
                        <ul class="right ">
                            <li>
                                <a data-beloworigin="true" href="#" data-activates="accDropDown" class="account-name dropdown-button with-photo" >
                                    <span class="profile-photo"></span>
                                     <?php echo "$firstName ($accountName)"; ?>
                                </a>
                                <ul id="accDropDown" class="dropdown-content">
                                    <li>
                                        <a href="?section=account">Profile</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo $logoutLink; ?>">Log out</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="hide"><a href="#!searchBar">Search</a></li>
                        </ul>

                    </div>
                </div>
            </nav>
            <?php
                # show the side navigation for respective account types
                include_once($snippet_folder . $accType."_horizontal_navigation.php");
            ?>

            <div class="header-bg" style="background-image:url('<?php echo $headerImageUrl; ?>');"></div>
        </header>
        <main>
            <?php
                #show respective tabs for the respective account type
                include_once($snippet_folder . $accType.'_tabs.php');
            ?>
                <!-- chatbox Structure -->
            <div class="chatbox-container hide z-depth-1 active full-open grey lighten-5">
                <div class="chatbox">
                    <div class="chatbox-header-container">
                        <nav class="box-header z-depth-0 active">
                            <p data-user-id="" data-user-type="" class="white-text bold heavy box-title">Gabriel Muchiri</p>
                            <div class="box-action">
                                <a href="#!" class="pad-6 marg-8 js-close-chatbox"><i class="material-icons">close</i> </a>
                                <a href="#!" class="pad-6 marg-8 js-chatbox-menu"><i class="material-icons">more_horiz</i> </a>
                            </div>
                        </nav>
                        <div class="padding-horiz-16 box-sub-header grey lighten-4 z-depth-1-half">
                            <p class="no-margin js-chat-ref light grey-text text-darken-3" data-ref="">Ref: <span>Math assignment submission</span></p>
                        </div>
                    </div>
                    <div class="box-body padding-vert-8">
                        <div class="js-chat-text-cont self">
                            <div class="js-chat-text">
                                <div class="chat-text">
                                    <ul class="chat-txt no-margin">
<!--                                        <div>-->
                                            <li class="txt">I'd be on now if it had a genuine stock thing with rewards
                                                uninstalled for productivity reasons
                                            </li>
                                            <li class="txt">uninstalled for productivity reasons
                                            </li>
<!--                                        </div>-->
<!--                                        <div class="txt-bg"></div>-->
                                    </ul>
                                    <div class="chat-point">
                                        <div class="point"></div>
                                    </div>
                                </div>
                                <div class="chat-info">
                                    <span>8/10/2017</span>
                                </div>
                            </div>
                        </div>
                        <div class="js-chat-text-cont other">
                            <div class="js-chat-text">
                                <div class="chat-text">
                                    <ul class="chat-txt">
<!--                                        <div>-->
                                            <li class="txt">Ey, hope you see this soon.
                                                I've pushed
                                            </li>
                                            <li class="txt">Ey, hope you see this soon.
                                                I've pushed
                                            </li>
<!--                                        </div>-->
<!--                                        <div class="txt-bg"></div>-->
                                    </ul>
                                    <div class="chat-point">
                                        <div class="point"></div>
                                    </div>
                                </div>
                                <div class="chat-info">
                                    <span>Gabriel</span>
                                    <span>.</span>
                                    <span>8/10/2017</span>
                                </div>
                            </div>
                        </div>
                        <div class="js-chat-text-cont self">
                            <div class="js-chat-text">
                                <div class="chat-text">
                                    <ul class="chat-txt no-margin">
<!--                                        <div>-->
                                            <li class="txt">I'd be on now i reasons
                                            </li>
                                            <li class="txt">uninstalled for productivity reasons
                                            </li>
<!--                                        </div>-->
<!--                                        <div class="txt-bg"></div>-->
                                    </ul>
                                    <div class="chat-point">
                                        <div class="point"></div>
                                    </div>
                                </div>
                                <div class="chat-info">
                                    <span>8/10/2017</span>
                                </div>
                            </div>
                        </div>
                        <div class="js-chat-text-cont other">
                            <div class="js-chat-text">
                                <div class="chat-text">
                                    <ul class="chat-txt">
<!--                                        <div>-->
                                            <li class="txt">Ey, hope you see this soon.
                                                I've pushed
                                            </li>
                                            <li class="txt">Ey, hope you see this soon.
                                                I've pushed
                                            </li>
<!--                                        </div>-->
<!--                                        <div class="txt-bg"></div>-->
                                    </ul>
                                    <div class="chat-point">
                                        <div class="point"></div>
                                    </div>
                                </div>
                                <div class="chat-info">
                                    <span>Gabriel</span>
                                    <span>.</span>
                                    <span>8/10/2017</span>
                                </div>
                            </div>
                        </div>
                        <div class="js-chat-text-cont self">
                            <div class="js-chat-text">
                                <div class="chat-text">
                                    <ul class="chat-txt no-margin">
<!--                                        <div>-->
                                            <li class="txt">I'd be on now a genuine 
                                            </li>
<!--                                        </div>-->
<!--                                        <div class="txt-bg"></div>-->
                                    </ul>
                                    <div class="chat-point">
                                        <div class="point"></div>
                                    </div>
                                </div>
                                <div class="chat-info">
                                    <span>8/10/2017</span>
                                </div>
                            </div>
                        </div>
                        <div class="js-chat-text-cont other">
                            <div class="js-chat-text">
                                <div class="chat-text">
                                    <ul class="chat-txt">
<!--                                        <div>-->
                                            <li class="txt">Ey, hope you see this soon.
                                                I've pushed
                                            </li>
                                            <li class="txt">Ey, hope you see this soon.
                                                I've pushed
                                            </li>
<!--                                        </div>-->
<!--                                        <div class="txt-bg"></div>-->
                                    </ul>
                                    <div class="chat-point">
                                        <div class="point"></div>
                                    </div>
                                </div>
                                <div class="chat-info">
                                    <span>Gabriel</span>
                                    <span>.</span>
                                    <span>8/10/2017</span>
                                </div>
                            </div>
                        </div>
                        <div class="js-chat-text-cont self">
                            <div class="js-chat-text">
                                <div class="chat-text">
                                    <ul class="chat-txt no-margin">
<!--                                        <div>-->
                                            <li class="txt">I'd be on now if it had a genuine stock thing with rewards
                                                uninstalled for productivity reasons
                                            </li>
                                            <li class="txt">uninstalled for productivity reasons
                                            </li>
<!--                                        </div>-->
<!--                                        <div class="txt-bg"></div>-->
                                    </ul>
                                    <div class="chat-point">
                                        <div class="point"></div>
                                    </div>
                                </div>
                                <div class="chat-info">
                                    <span>8/10/2017</span>
                                </div>
                            </div>
                        </div>
                        <div class="js-chat-text-cont other">
                            <div class="js-chat-text">
                                <div class="chat-text">
                                    <ul class="chat-txt">
<!--                                        <div>-->
                                            <li class="txt">Ey, hope you see this soon.
                                                I've pushed
                                            </li>
                                            <li class="txt">Ey, hope you see this soon.
                                                I've pushed
                                            </li>
<!--                                        </div>-->
<!--                                        <div class="txt-bg"></div>-->
                                    </ul>
                                    <div class="chat-point">
                                        <div class="point"></div>
                                    </div>
                                </div>
                                <div class="chat-info">
                                    <span>Gabriel</span>
                                    <span>.</span>
                                    <span>8/10/2017</span>
                                </div>
                            </div>
                        </div>
                        <div class="js-chat-text-cont self">
                            <div class="js-chat-text">
                                <div class="chat-text">
                                    <ul class="chat-txt no-margin">
<!--                                        <div>-->
                                            <li class="txt">I'd be on now if it had a genuine stock thing with rewards
                                                uninstalled for productivity reasons
                                            </li>
                                            <li class="txt">uninstalled for productivity reasons
                                            </li>
<!--                                        </div>-->
<!--                                        <div class="txt-bg"></div>-->
                                    </ul>
                                    <div class="chat-point">
                                        <div class="point"></div>
                                    </div>
                                </div>
                                <div class="chat-info">
                                    <span>8/10/2017</span>
                                </div>
                            </div>
                        </div>
                        <div class="js-chat-text-cont other">
                            <div class="js-chat-text">
                                <div class="chat-text">
                                    <ul class="chat-txt">
<!--                                        <div>-->
                                            <li class="txt">Ey, hope you see this soon.
                                                I've pushed
                                            </li>
                                            <li class="txt">Ey, hope you see this soon.
                                                I've pushed
                                            </li>
<!--                                        </div>-->
<!--                                        <div class="txt-bg"></div>-->
                                    </ul>
                                    <div class="chat-point">
                                        <div class="point"></div>
                                    </div>
                                </div>
                                <div class="chat-info">
                                    <span>Gabriel</span>
                                    <span>.</span>
                                    <span>8/10/2017</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer no-margin pad-8">
<!--                        <div class="input-field col s12">-->
                            <input type="text" class="chat-input marg-8">
                            <button class="padding-horiz-16 chat-btn btn-flat js-btn-send marg-6">
                                <i class="material-icons">send</i>
                            </button>
<!--                        </div>-->
                    </div>
                </div>
            </div>
                <!-- Modal Structure -->
                <!-- Will be transferred to esomo2-templates.js -->
<!--
                <div id="modal1" class="modal">
                    <div class="modal-content">
                    <h4>Modal Header</h4>
                    <p>A bunch of text</p>
                    </div>
                    <div class="modal-footer">
                    <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
                    </div>
                </div>
-->
        </main>
        <?php
            include_once("./snippets/site_footer.php");
        ?>
        <script type="text/javascript" src="js/jquery-2.0.0.js"></script>
        <script type="text/javascript" src="js/materialize.js"></script>
        <script type="text/javascript" src="js/lodash.js"></script>
        <script type="text/javascript" src="js/moment.js"></script>
<!--        <script type="text/javascript" src="js/masonry.pkgd.min.js"></script>-->
        <script type="text/javascript" src="js/dashboard/result.js"></script>
        <script type="text/javascript" src="js/dashboard/lists_templates.js"></script>
        <script type="text/javascript" src="js/dashboard/forms_templates.js"></script>
        <script type="text/javascript" src="js/dashboard/modals_events.js"></script>
        <script type="text/javascript" src="js/dashboard/classroom_events.js"></script>
        <script type="text/javascript" src="js/dashboard/assignment_events.js"></script>
        <script type="text/javascript" src="js/dashboard/schedule_events.js"></script>
        <script type="text/javascript" src="js/dashboard/resources_events.js"></script>
        <script type="text/javascript" src="js/dashboard/comments_events.js"></script>
        <script type="text/javascript" src="js/dashboard/events.js"></script>
        <script type="text/javascript" src="js/dashboard/test_events.js"></script>
        <script type="text/javascript" src="js/dashboard.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript" src="js/pace.js"></script>
<!--        <script type="text/javascript" src="js/picker.time.js"></script>-->

        <script>
        $(document).ready(function() {

            paceOptions = {
                ajax: true
            };
            //init the dashboard application except on login page
            if (location.pathname.split('/').pop() != 'login.php') {
                var dashboard = new Dashboard();
            }

//            $('.mobile-button-collapse').sideNav();
            $('select').material_select();
            $('.tooltipped').tooltip({delay: 50});
            $('.modal').modal({
                dismissible : false,
                ready: function(m,t) {
                    console.log(m,t);
                },
                complete: function() {
                    console.log('closed');
                }
            });//a workaround the lean-overlay click event
            $('.dropdown-button').dropdown({
                constrain_width: false, // Does not change width of dropdown to that of the activator
                hover: false, // Activate on hover
                gutter: 0, // Spacing from edge
                belowOrigin: false, // Displays dropdown below the button
                alignment: 'right' // Displays dropdown with edge aligned to the left of button
            });

            //Ensure labels don't overlap text fields
            Materialize.updateTextFields();//doesn't work
            $('.datepicker').pickadate({
                selectMonths: false, // Creates a dropdown to control month
                selectYears: false, // Creates a dropdown of 2 years to control year
                formatSubmit: 'yyyy-mm-dd',
                hiddenName: true,
                clear: 'Clear',
                close: 'Ok',
                closeOnSelect: false, // Close upon selecting a date
                firstDay: 1,
                disable: [7]
            });
            
            var $input = $( '.timepicker' ).pickatime({
                formatSubmit: 'HH:i',
                hiddenName: true,
                donetext: 'OK', // text for done-button
                cleartext: 'Clear', // text for clear-button
                canceltext: 'Cancel', // Text for cancel-button
                autoclose: false, // automatic close timepicker
                ampmclickable: true, // make AM PM clickable
                aftershow: function(){}
                
            });
            
            var picker = $input.pickatime('picker');
            //picker.open();

            //Create test button
            var $create_test_btn = $("#create_test_btn");

            //Missing create test test fields, returns true if theres any missing values
            function MissingCreateTestFields()
            {
                return ($("#createTestTitle").val()=="" || $("#createTestInstructions").val()=="");
            }

            //Update the Create test button ~ Enabling and disabling the button
            function UpdateCreateTestButton()
            {
                if(MissingCreateTestFields())
                {
                    $create_test_btn.addClass("disabled");
                    $create_test_btn.prop("disabled",true);
                }
                else
                {
                    $create_test_btn.removeClass("disabled");
                    $create_test_btn.prop("disabled",false);
                }
            }

            //Disable all input fields ~ when the create test button is clicked
            function DisableAllInputFields()
            {
                $("#createTestForm").children(":input",function(){
                    $(this).disabled=true;
                });

            }
            //Update the Create test button at start ~ when document first loads
            UpdateCreateTestButton();

            //When the value of either the test title or instructions changes ~ update the button status
            $(document.body).on("input",("#createTestTitle,#createTestInstructions"),function()
            {
                UpdateCreateTestButton();
            });

            //When the create test button is clicked
            $($create_test_btn).click(function(){

                //If there are any values missing
                if(MissingCreateTestFields())
                {
                    Materialize.toast('Failed to create test. Ensure you have filled in all details', 4000);
                }
                else
                {
                    DisableAllInputFields()
                    //Stores test data
                    var testJson =
                    {
                        "test_title" : $("#createTestTitle").val(),
                        "test_subject_id" : $("#createTestSubject").val(),
                        "test_question_count" : $("#createTestQuestionCount").val(),
                        "test_difficulty" : $("#createTestDifficulty").val(),
                        "test_max_grade" : $("#createTestMaxGrade").val(),
                        "test_pass_grade" : $("#createTestPassGrade").val(),
                        "test_completion_time" : $("#createTestCompletionTime").val(),
                        "test_instructions" : $("#createTestInstructions").val(),
                    }

                    console.log(testJson);

                    $.post("handlers/db_handler.php",{"action":"CreateTest","test_data":testJson},function(data,status){

                        //Parse the data as JSON for data retrieval
                        data = JSON.parse(data);
                        var toast_delay = 2500;

                        //Successfully created the test
                        if(data["message"]=="success")
                        {
                            Materialize.toast('Successfully created the test. Redirecting to the question creation section', toast_delay);
                            setTimeout(function(){
                                window.location = (data["redirect_url"]);//Redirect to the page for editing questions
                            },(toast_delay+250));

                        }
                        else //Failed to create the test
                        {
                            Materialize.toast('Error : '+data["error"]+'. Failed to create test', 4000);
                        }
                    });
                }

            });

        });
            
        function hideSideNav() {
            $(".mobile-button-collapse").sideNav('hide');
            //console.log('already open');
        }
        
        </script>
        <script type="text/javascript" src="js/test_functions.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    </body>
</html>
        <?php
            else:#redirect user to the login page
                header('Location: '.$redirectPath);
        exit;
            endif;#end the main if statement

        ?>

