<?php
/*
Constants to be used by the teacher navigation. ~ names of the sections and tabs
Note: TR is short for Teacher
Naming convention being used it TypeOfTheConst_OwnerOfTheConst_NameOfTheConst
*/

//Sections
const SECTION_TR_BASE = "classrooms";
const SECTION_TR_ASS_CREATE = "create-assignment";
const SECTION_TR_ASS_SENT = "sent-assignments";
const SECTION_TR_ASS_SUBS = "assignment-submissions";
const SECTION_TR_SCHEDULES = "schedules";
const SECTION_TR_TEST_CREATE = "create-test";
const SECTION_TR_TEST_VIEW_RESULTS = "view-test-results";
const SECTION_TR_TEST_TAKE = "take-test";


//Navigation active classes
$classrooms_class = $ass_class = $create_ass_class = $sent_ass_class = $ass_sub_class = $schedules_class = $tests_class = $create_test_class = $view_test_results_class = $take_test_class = $resources_class = $account_class = "";

global $pageTitle;#Get the global variable representing the page title
switch($section)
{
    case SECTION_TR_BASE:
        $classrooms_class = SetClass(BASE_ACTIVE_CLASS);
        $pageTitle = "Classrooms";
    break;
    case SECTION_TR_ASS_CREATE:
        $ass_class = BASE_ACTIVE_CLASS;
        $create_ass_class = SetClass(BASE_ACTIVE_CLASS);
        $pageTitle = "Create assignment";
    break;
    case SECTION_TR_ASS_SENT:
        $ass_class = BASE_ACTIVE_CLASS;
        $sent_ass_class = SetClass(BASE_ACTIVE_CLASS);
        $pageTitle = "Sent assignments";
    break;
    case SECTION_TR_ASS_SUBS:
        $ass_class = BASE_ACTIVE_CLASS;
        $ass_sub_class = SetClass(BASE_ACTIVE_CLASS);
        $pageTitle = "Assignment submissions";
    break;
    case SECTION_TR_SCHEDULES:
        $schedules_class = SetClass(BASE_ACTIVE_CLASS);
        $pageTitle = "Schedules";
    break;
    case SECTION_TR_TEST_CREATE:
        $tests_class = BASE_ACTIVE_CLASS;
        $create_test_class = SetClass(BASE_ACTIVE_CLASS);
        $pageTitle = "Create a test";
    break;
    case SECTION_TR_TEST_VIEW_RESULTS:
        $tests_class = BASE_ACTIVE_CLASS;
        $view_test_results_class = SetClass(BASE_ACTIVE_CLASS);
        $pageTitle = "View test results";
    break;
    case SECTION_TR_TEST_TAKE:
        $tests_class = BASE_ACTIVE_CLASS;
        $take_test_class = SetClass(BASE_ACTIVE_CLASS);
        $pageTitle = "Take test";
    break;
    case SECTION_RESOURCES:
        $resources_class = SetClass(BASE_ACTIVE_CLASS);
        $pageTitle = PAGE_TITLE_RESOURCES;
    break;
    case SECTION_ACCOUNT:
        $account_class = SetClass(BASE_ACTIVE_CLASS);
        $pageTitle = PAGE_TITLE_ACCOUNT;
    break;
}
?>
<div class="_s12 container">
    <h4 class="page-title light white-text" id="pageTitle">
        <?php echo ucwords(@$pageTitle);?>
    </h4>
</div>
<div class="horizontal-overflow-wrapper">
<ul id="slide-out" class="horizontal-nav fixed">
    <li <?php echo $classrooms_class;?>>
        <a href="<?php echo GetSectionLink(SECTION_TR_BASE);?>">Classrooms</a>
    </li>
    <li class="<?php echo $ass_class;?>">
        <a class="center dropdown-button <?php echo $ass_class;?>" data-beloworigin="true" href="#" data-activates="assDropDown">
        Assignments
            <i class="material-icons ">&#xE5C5;</i>
        </a>
        <ul id="assDropDown" class="dropdown-content ">
            <li <?php echo $create_ass_class;?>>
                <a href="<?php echo GetSectionLink(SECTION_TR_ASS_CREATE);?>">Create</a>
            </li>
            <li <?php echo $sent_ass_class;?>>
                <a href="<?php echo GetSectionLink(SECTION_TR_ASS_SENT);?>">Sent</a>
            </li>
            <li <?php echo $ass_sub_class;?>>
                <a href="<?php echo GetSectionLink(SECTION_TR_ASS_SUBS);?>">Submissions</a>
            </li>
        </ul>
    </li>
    <li <?php echo $schedules_class;?>>
        <a href="<?php echo GetSectionLink(SECTION_TR_SCHEDULES);?>">Schedules</a>
    </li>
    <li class="<?php echo $tests_class;?>">
        <a class="center dropdown-button <?php echo $tests_class;?>" data-beloworigin="true" href="#" data-activates="testsDropDown">
        Tests
            <i class="material-icons ">&#xE5C5;</i>
        </a>
        <ul id="testsDropDown" class="dropdown-content">
            <li <?php echo $create_test_class;?>>
                <a href="<?php echo GetSectionLink(SECTION_TR_TEST_CREATE);?>">Create</a>
            </li>
            <li <?php echo $view_test_results_class;?>>
                <a href="<?php echo GetSectionLink(SECTION_TR_TEST_VIEW_RESULTS);?>">View results</a>
            </li>
            <li <?php echo $take_test_class;?>>
                <a href="<?php echo GetSectionLink(SECTION_TR_TEST_TAKE);?>">Take test</a>
            </li>
        </ul>
    </li>
    <li <?php echo $resources_class;?>>
        <a href="<?php echo GetSectionLink(SECTION_RESOURCES);?>">Resources</a>
    </li>
</ul>
</div>

