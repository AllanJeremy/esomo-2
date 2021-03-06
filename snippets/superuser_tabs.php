<?php 
    require_once (realpath(dirname(__FILE__) . "/../handlers/db_info.php")); #Allows retrieving information from database
    require_once (realpath(dirname(__FILE__) . "/../classes/student.php")); #Allows retrieving information from database
    require_once (realpath(dirname(__FILE__) . "/../classes/teacher.php")); #Allows retrieving information from database
    require_once (realpath(dirname(__FILE__) . "/../classes/principal.php")); #Allows retrieving information from database
    require_once (realpath(dirname(__FILE__) . "/../classes/superuser.php")); #Allows retrieving information from database
?>

<div class="container">

<?php
if(isset($section)):
    switch($section):
        case SECTION_SU_BASE:
?>
    <div class="row main-tab" id="dashboardTab">
        <p class="grey-text">Account Information</p>
        <div class="divider"></div>
        <br>

        <div class="card-panel">
            <p><b>First Name: </b><span> <?php echo $_SESSION["admin_first_name"]; ?> </span></p>
            <p><b>Last Name: </b><span> <?php echo $_SESSION["admin_last_name"]; ?> </span></p>
            <p><b>Email Address: </b><span> <?php echo $_SESSION["admin_email"]; ?> </span></p>
            <p><b>Phone Number: </b><span> <?php
             if(!empty($_SESSION["admin_phone"]))
             {
                 echo $_SESSION["admin_phone"];#if a phone number has been provided, echo it
             } 
             else
             {
                 echo "N/A";#if no phone number has been provided
             }
             ?> </span></p>
            <p><b>Username: </b><span> <?php echo $_SESSION["admin_username"]; ?> </span></p>
            <p><b>Account type: </b><span> <?php echo $_SESSION["admin_account_type"]; ?> </span></p>
        </div>
        <br>

        <?php
            //Number of accounts for each account type
            $student_count = $teacher_count = $principal_count = $superuser_count = 0;

            $current_date = EsomoDate::GetCurrentDate();
            $current_date = EsomoDate::GetOptimalDateTime($current_date);

            //Get all students
            if($students = DbInfo::GetAllStudents())
            {
                $student_count = $students->num_rows;
            }

            //Get all teachers
            if($teachers = DbInfo::GetAllTeachers())
            {
                $teacher_count = $teachers->num_rows;
            }

            //Get all principals
            if($principals = DbInfo::GetAllPrincipals())
            {
                $principal_count = $principals->num_rows;
            }

            //Get all superusers
            if($superusers = DbInfo::GetAllSuperusers())
            {
                $superuser_count = $superusers->num_rows;
            }
        ?>
        <!--Basic stats-->
        <div class="card-panel">
            <p class="grey-text">Basic Stats as of <i><?php echo $current_date["day"].", ".$current_date["date"]." at ".$current_date["time"];?></i></p>
            <div class="divider"></div><br>
            <table class="table bordered striped">
                <tr>
                    <th>Account type</th>
                    <th>Number of Accounts</th>
                </tr>
                <tr>
                    <td>Student</td>                
                    <td><?php echo $student_count; ?></td>                
                </tr>
                <tr>
                    <td>Teacher</td>                
                    <td><?php echo $teacher_count; ?></td>                
                </tr>
                <tr>
                    <td>Principal</td>                
                    <td><?php echo $principal_count; ?></td>                
                </tr>
                <tr>
                    <td>Superuser</td>                
                    <td><?php echo $superuser_count; ?></td>                
                </tr>
            </table>
        </div>
    </div>
    <?php
        break;
        case SECTION_SU_STUDENTS:
            $create_class = $import_class = $manage_class = "";
            $default_tab = TAB_CREATE;

            #If the current tab is set
            if(isset($tab)):
                switch($tab)
                {
                    case TAB_CREATE:
                        $create_class = SetClass(BASE_ACTIVE_CLASS);
                    break;
                    case TAB_IMPORT:
                        $import_class = SetClass(BASE_ACTIVE_CLASS);
                    break;
                    case TAB_MANAGE:
                        $manage_class = SetClass(BASE_ACTIVE_CLASS);
                    break;
                }
                
    ?>
    <!---->
    <div class="row main-tab" >
        <div class="col s12 m10 offset-m1">
        <ul class="tabs">
            <li class="tab col s4">
                <a target="_self" <?php echo $create_class;?> href="<?php echo GetSectionLink(SECTION_SU_STUDENTS,TAB_CREATE);?>">Create</a>
            </li>
            <li class="tab col s4">
                <a target="_self" <?php echo $import_class;?> href="<?php echo GetSectionLink(SECTION_SU_STUDENTS,TAB_IMPORT);?>" >Import</a>
            </li>
            <li class="tab col s4">
                <a target="_self" <?php echo $manage_class;?> href="<?php echo GetSectionLink(SECTION_SU_STUDENTS,TAB_MANAGE);?>" >Manage</a>
            </li>
        </ul>
        </div>
        <?php
        switch($tab):
            case TAB_CREATE:
        ?>
        <div id="createStudent" class="col s12 offset-m1 m10 ">
            <div class="row">
                <br>
                <br>
                <br>
                <form class="col s12" method="post" id="createStudentForm">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newStudentId" type="number" class="" name="new_student_id" required>
                            <label for="newStudentId">Student id<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newStudentFirstName" type="text" class="validate" name="new_student_first_name" required>
                            <label for="newStudentFirstName" >First name<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newStudentLastName" type="text" class="validate" name="new_student_last_name" required>
                            <label for="newStudentLastName">Last name<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newStudentUsername" type="text" class="" name="new_student_username" required>
                            <label for="newStudentUsername" >Username<sup>*</sup></label>
                        </div>
                    </div>

                    <div class="row">  
                        <div class="input-field col s12">
                            <a href="javascript:void(0)" class="right btn create-acc-btn" id="createStudentAccount" >Create account</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
            break;
            case TAB_IMPORT:
        ?>
        <div id="importStudent" class="col s12 offset-m1 m10 ">
            <div class="row">
                <br>
                <div class="col s12 no-data-message valign-wrapper grey lighten-3">
                    <h6 class="center-align valign grey-text " id="importMessage">
                        Add your student excel file here and click import
                        <br>
                        Note : The file must correspond to the agreed upon structure for the import to work
                    </h6>
                </div>
                <br>
                <br>
                <br>
                <br>
                <form class="col s12" method="post" action="">
                    <div class="row">
                        <div class="file-field input-field col s12">
                            <div class="btn">
                                <span>File</span>
                                <input type="file" id="importStudentDataFile">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="input-field col s12">
                            <a class="right btn" href="javascript:void(0)">Import students</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
            break;
            case TAB_MANAGE:
        ?>
        <div id="manageStudent" class="col s12 offset-m1 m10 ">
            <div class="row">
                <br>
                <br>

            <?php
                #Try to get students true if students found in database
                if($students = DbInfo::GetAllStudents()):
            ?>
                <div class="row" id="studentFilterList">
                    <form class="col s12" action="">
                        <div class="row">
                            <div class="input-field col m5 s12">
                                <select id="student_bulk_action" >
                                    <option value="" disabled selected>Bulk action</option>
                                    <option value="super_student_delete">Delete Account(s)</option>
                                    <option value="super_student_reset">Reset Account(s)</option>
                                    <option value="super_student_none">None</option>
                                </select>
                                <label>Bulk action</label>
                            </div>
                            <div class="input-field col m5 s9 hide">
                                <input id="filterListSearch" type="text" class="validate" name="filter-list-search">
                                <label for="filterListSearch">Search</label>
                            </div>
                            <div class="input-field col m2 s3 hide">
                                <a class="btn btn-floating waves-effect waves-light" type="submit"><i class="material-icons">search</i></a>
                            </div>
                        </div>
                        <div class="row hide">
                            <div class="input-field col s2">
                                <p>Filter: </p>
                            </div>

                            <div class="input-field col s10">
                                <div class="row">
                                    <div class="input-field col s6 m4">
                                        <p>
                                            <input type="checkbox" class="filled-in" id="filled-box-1" />
                                            <label for="filled-box-1">Adm no.</label>
                                        </p>
                                    </div>
                                    <div class="input-field col s6 m4">
                                        <p>
                                            <input type="checkbox" class="filled-in" id="filled-box-2" />
                                            <label for="filled-box-2">Name(s)</label>
                                        </p>
                                    </div>
                                    <div class="input-field col s6 m4">
                                        <p>
                                            <input type="checkbox" class="filled-in" id="filled-box-3" />
                                            <label for="filled-box-3">Username</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!--Student list table-->
                <table class="bordered highlight centered" id="super_student_list_table">
                    <thead>
                        <tr>
                            <th></th>
                            <th data-field="id">Adm. No</th>
                            <th data-field="name">Name(s)</th>
                            <th data-field="name">Username</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                        foreach($students as $student):#for each student - do this
                    ?>
                        <tr>
                            <td>
                                <input type="checkbox" value="<?php echo $student['acc_id']?>"
                                 class="filled-in selected_students" id="filled-box-student-<?php echo $student['acc_id']?>" />
                                <label for="filled-box-student-<?php echo $student['acc_id']?>"></label>
                            </td>
                            <td><?php echo $student["adm_no"]?></td>
                            <td><?php echo $student["first_name"] . " " . $student["last_name"] ?></td>
                            <td><?php echo $student["username"]?></td>
                        </tr>
                    <?php
                        endforeach;
                            
                        else: # No students were found
                    ?>
                    <div class="row">
                        <div class="col s12 m10 offset-m1">
                            <div class="card-panel blue-grey darken-3 blue-grey-text text-lighten-4">
                                <h5 class="center">NO STUDENT ACCOUNTS FOUND</h5>
                                <div class="divider blue-grey lighten-2"></div>
                                <p class="blue-grey-text text-lighten-3">No student accounts were found. Student accounts will appear here once added.</p>
                            </div>
                        </div>
                    </div>
                    <?php
                        endif;
                    ?>
                    </tbody>
                </table>

            </div>
        </div>
        <?php
            break;
            default:
        ?>
    <script>window.location = "<?php echo GetSectionLink(SECTION_SU_STUDENTS,$default_tab);?>";</script>         
    </div>
    <?php
                endswitch;
            else:#If the current tab is not set ~ Navigate to the default tab
    ?>
    <script>window.location = "<?php echo GetSectionLink(SECTION_SU_STUDENTS,$default_tab);?>";</script>
    <?php
    
            endif;
        break;
        case SECTION_SU_TEACHERS:
            $default_tab = TAB_CREATE;
            if(isset($tab)):
                $create_class = $manage_class= "";
                switch($tab)
                {
                    case TAB_CREATE:
                        $create_class = SetClass(BASE_ACTIVE_CLASS);
                    break;
                    case TAB_MANAGE:
                        $manage_class = SetClass(BASE_ACTIVE_CLASS);
                    break;
                }
    ?>
    <!---->
    <div class="row main-tab" id="teachersTab">
        <div class="col s12 m10 offset-m1">
        <ul class="tabs">
            <li class="tab col s6">
                <a target="_self" href="<?php echo GetSectionLink(SECTION_SU_TEACHERS,TAB_CREATE);?>" <?php echo $create_class;?>>Create</a>
            </li>
            <li class="tab col s6">
                <a target="_self" href="<?php echo GetSectionLink(SECTION_SU_TEACHERS,TAB_MANAGE);?>" <?php echo $manage_class;?>>Manage</a>
            </li>
        </ul>
        </div>

        <?php
            switch($tab):
                case TAB_CREATE:
        ?>
        <div id="createTeacher" class="col s12 offset-m1 m10 ">
            <div class="row">
                <br>
                <br>
                <br>
                <form class="col s12" method="post" id="createTeacherForm">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newTeacherFirstName" type="text" class="validate" name="new_teacher_first_name" required>
                            <label for="newTeacherFirstName">First name<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newTeacherLastName" type="text" class="validate" name="new_teacher_last_name" required>
                            <label for="newTeacherLastName">Last name<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newTeacherEmail" type="email" class="validate" name="new_teacher_email" required>
                            <label for="newTeacherEmail">Email<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newTeacherPhone" type="text" class="validate" name="new_teacher_phone">
                            <label for="new_teacher_phone">Phone (Optional)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newTeacherUsername" type="text" class="" name="new_teacher_username" required>
                            <label for="new_teacher_username">Username<sup>*</sup></label>
                        </div>
                    </div>

                    <div class="row">
                        
                        <div class="input-field col s12">
                            <a class="right btn create-acc-btn" id="createTeacherAccount">Create account</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
                break;
                case TAB_MANAGE:
        ?>
        <div id="manageTeacher" class="col s12 offset-m1 m10 ">
            <div class="row">
                <br>
                <br>
                <?php
                    #Try to get principals : true if principals found in database
                    if($teachers = DbInfo::GetAllTeachers()):
                ?>

                <div class="row" id="teacherFilterList">
                    <form class="col s12" action="">
                        <div class="row">
                            <div class="input-field col m5 s12">
                                <select id="teacher_bulk_action">
                                    <option value="" disabled selected>Bulk action</option>
                                    <option value="super_teacher_delete">Delete Account(s)</option>
                                    <option value="super_teacher_reset">Reset Account(s)</option>
                                    <option value="super_teacher_none">None</option>
                                </select>
                                <label>Bulk action</label>
                            </div>
                            <div class="input-field col m5 s9 hide">
                                <input id="filterListSearch" type="text" class="validate" name="filter-list-search">
                                <label for="filterListSearch">Search</label>
                            </div>
                            <div class="input-field col m2 s3 hide">
                                <a class="btn btn-floating waves-effect waves-light" type="submit"><i class="material-icons">search</i></a>
                            </div>
                        </div>
                        <div class="row hide">
                            <div class="input-field col s2">
                                <p>Filter: </p>
                            </div>

                            <div class="input-field col s10">
                                <div class="row">

                                    <div class="input-field col s6 m4">
                                        <p>
                                            <input type="checkbox" class="filled-in" id="filled-box-2" />
                                            <label for="filled-box-2">Name</label>
                                        </p>
                                    </div>
                                    <div class="input-field col s6 m4">
                                        <p>
                                            <input type="checkbox" class="filled-in" id="filled-box-3" />
                                            <label for="filled-box-3">Username</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!--Teacher list table-->
                <table class="bordered highlight centered" id="super_teacher_list_table">
                    <thead>
                        <tr>
                            <th></th>
                            <th data-field="name">Name(s)</th>
                            <th data-field="name">Username</th>
                            <th data-field="name">Email</th>
                            <th data-field="name">Phone</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php 
                        foreach ($teachers as $teacher):
                    ?>
                        <tr>
                            <td>
                                <input type="checkbox" value="<?php echo $teacher['acc_id']?>"
                                 class="filled-in selected_teachers" id="filled-box-admin-<?php echo $teacher['acc_id']?>" />
                                <label for="filled-box-admin-<?php echo $teacher['acc_id']?>"></label>
                            </td>
                            <td><?php echo $teacher["first_name"] . " " . $teacher["last_name"]  ?></td>
                            <td><?php echo $teacher["username"] ?></td>
                            <td><?php echo $teacher["email"] ?></td>
                            <td><?php
                                $phone = "N/A";
                                if(!empty($teacher["phone"]))
                                {
                                    $phone = $teacher["phone"];
                                }
                                echo $phone ?></td>
                        </tr>
                    <?php
                        endforeach;

                        else:#no principal accounts were found 
                    ?>

                    <div class="row">
                        <div class="col s12 m10 offset-m1">
                            <div class="card-panel blue-grey darken-3 blue-grey-text text-lighten-4">
                                <h5 class="center">NO TEACHER ACCOUNTS FOUND</h5>
                                <div class="divider blue-grey lighten-2"></div>
                                <p class="blue-grey-text text-lighten-3">No teacher accounts were found. Teacher accounts will appear here once added.</p>
                            </div>
                        </div>
                    </div>

                    <?php
                        endif;#end if statement to used check if there are teachers
                    ?>

                    </tbody>
                </table>

            </div>
        </div>
        <?php
                break;
                default:
        ?>
    <script>window.location = "<?php echo GetSectionLink(SECTION_SU_TEACHERS,TAB_MANAGE);?>";</script>
        <?php
                endswitch;
            else:#Tab is not set
        ?>
    <script>window.location = "<?php echo GetSectionLink(SECTION_SU_TEACHERS,$default_tab);?>";</script>
    </div>
    
    <?php

            endif;
        break;
        case SECTION_SU_PRINCIPALS:
            $default_tab = TAB_CREATE;
            if(isset($tab)):
                $create_class = $manage_class= "";
                switch($tab)
                {
                    case TAB_CREATE:
                        $create_class = SetClass(BASE_ACTIVE_CLASS);
                    break;
                    case TAB_MANAGE:
                        $manage_class = SetClass(BASE_ACTIVE_CLASS);
                    break;
                }
    ?>
    <!--Superuser principal tab-->
    <div class="row main-tab" id="principalTab">
        <div class="col s12 m10 offset-m1">
        <ul class="tabs">
            <li class="tab col s6">
                <a target="_self" <?php echo $create_class;?> href="<?php echo GetSectionLink(SECTION_SU_PRINCIPALS,TAB_CREATE);?>">Create</a>
            </li>
            <li class="tab col s6">
                <a target="_self" <?php echo $manage_class;?> href="<?php echo GetSectionLink(SECTION_SU_PRINCIPALS,TAB_MANAGE);?>">Manage</a>
            </li>
        </ul>
        </div>
        <?php
            switch($tab):
                case TAB_CREATE:
        ?>
        <div id="createPrincipal" class="col s12 offset-m1 m10 ">
            <div class="row">
                <br>
                <br>
                <br>
                
                <!--Account limitation message-->
                <div class="col s12 no-data-message valign-wrapper grey lighten-3">
                    <h6 class="center-align valign grey-text " id="principalCreateLimitMessage">
                        Account creation limit
                        <br>
                        Note : You can only create a maximum of <?php echo Principal::$MAX_PRINCIPAL_ACCOUNTS?> principal accounts
                    </h6>
                </div>
                <form class="col s12" method="post"  id="createPrincipalForm">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newPrincipalFirstName" type="text" class="validate" name="new_principal_first_name" required>
                            <label for="newPrincipalFirstName">First name<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newPrincipalLastName" type="text" class="validate" name="new_principal_last_name" required>
                            <label for="newPrincipalLastName">Last name<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newPrincipalEmail" type="email" class="validate" name="new_principal_email" required>
                            <label for="newPrincipalEmail">Email<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newPrincipalPhone" type="text" class="validate" name="new_principal_phone">
                            <label for="newPrincipalPhone">Phone (Optional)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newPrincipalUsername" type="text" class="" name="new_principal_username" required>
                            <label for="newPrincipalUsername">Username<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <p>
                                <input type="checkbox" id="createTeacherAccountFromPrincipal" name="create_corresponding_teacher_account"/>
                                <label for="createTeacherAccountFromPrincipal">Create a corresponding teacher account</label>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <a href="javascript:void(0)" class="right btn create-acc-btn" id="createPrincipalAccount" >Create account</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
                break;
                case TAB_MANAGE:
        ?>
        <div id="managePrincipal" class="col s12 offset-m1 m10 ">
            <div class="row">
                <br>
                <br>

            <?php
                #Try to get principals : true if principals found in database
                if($principals = DbInfo::GetAllPrincipals()):
            ?>
                <div class="row" id="principalFilterList">
                    <form class="col s12" action="">
                        <div class="row">
                            <div class="input-field col m4 s6">
                                <a class="btn btn-flat waves-effect waves-light hide" id="super_edit_principal_acc">Edit accounts</a>
                            </div>
                            <div class="input-field col m4 s6">
                                <a class="btn btn-flat waves-effect waves-light" id="super_reset_principal_acc">Reset accounts</a>
                            </div>
                            <div class="input-field col m4 s6">
                                <a class="btn btn-flat waves-effect waves-light" id="super_delete_principal_acc">Delete accounts</a>
                            </div>
                        </div>
                    </form>
                </div>

                <!--Principal list table-->
                <table class="bordered highlight centered" id="super_principal_list_table">
                    <thead>
                        <tr>
                            <th></th>
                            <th data-field="name">Name(s)</th>
                            <th data-field="name">Username</th>
                            <th data-field="name">Email</th>
                            <th data-field="name">Phone</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php 
                        foreach ($principals as $principal):
                    ?>
                        <tr>
                            <td>
                                <input type="checkbox" value="<?php echo $principal['acc_id']?>"
                                 class="filled-in selected_principals" id="filled-box-admin-<?php echo $principal['acc_id']?>" />
                                <label for="filled-box-admin-<?php echo $principal['acc_id']?>"></label>
                            </td>
                            <td><?php echo $principal["first_name"] . " " . $principal["last_name"] ?></td>
                            <td><?php echo $principal["username"] ?></td>
                            <td><?php echo $principal["email"] ?></td>
                            <td><?php
                                $phone = "N/A";
                                if(!empty($principal["phone"]))
                                {
                                    $phone = $principal["phone"];
                                }
                                echo $phone ?></td>
                        </tr>
                    <?php
                        endforeach;

                        else:#no principal accounts were found 
                    ?>

                    <div class="row">
                        <div class="col s12 m10 offset-m1">
                            <!--Message box-->
                            <div class="card-panel blue-grey darken-3 blue-grey-text text-lighten-4">
                                <h5 class="center">NO PRINCIPAL ACCOUNTS FOUND</h5>
                                <div class="divider blue-grey lighten-2"></div>
                                <p class="blue-grey-text text-lighten-3">No principal accounts were found. Principal accounts will appear here once added.</p>
                            </div>
                        </div>
                    </div>

                    <?php
                        endif;
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
        <?php
                break;
            default:
        ?>
        <script>window.location = "<?php echo GetSectionLink(SECTION_SU_PRINCIPALS,$default_tab);?>";</script>
        <?php
            endswitch;
        ?>
    </div>
    <?php
            else:#Tab is not set
    ?>
    
        <script>window.location = "<?php echo GetSectionLink(SECTION_SU_PRINCIPALS,$default_tab);?>";</script>
    <?php
            endif;
        break;
        case SECTION_SU_SUPERUSERS:
            $default_tab = TAB_CREATE;
            if(isset($tab)):
                $create_class = $manage_class= "";
                switch($tab)
                {
                    case TAB_CREATE:
                        $create_class = SetClass(BASE_ACTIVE_CLASS);
                    break;
                    case TAB_MANAGE:
                        $manage_class = SetClass(BASE_ACTIVE_CLASS);
                    break;
                }
    ?>
    <!--Superuser superuser tab-->
    <div class="row main-tab" id="superuserTab">
        <div class="col s12 m10 offset-m1">
        <ul class="tabs">
            <li class="tab col s6">
                <a target="_self" <?php echo $create_class;?> href="<?php echo GetSectionLink(SECTION_SU_SUPERUSERS,TAB_CREATE);?>">Create</a>
            </li>
            <li class="tab col s6">
                <a target="_self" <?php echo $manage_class;?> href="<?php echo GetSectionLink(SECTION_SU_SUPERUSERS,TAB_MANAGE);?>" >View</a>
            </li>
        </ul>
        </div>

        <?php
            $default_tab = TAB_CREATE;
            switch($tab):
                case TAB_CREATE:
        ?>
        <div id="createSuperuser" class="col s12 offset-m1 m10 ">
            <div class="row">
                <br>
                <br>
                <br>
                
                <!--Account limitation message-->
                <div class="col s12 no-data-message valign-wrapper grey lighten-3">
                    <h6 class="center-align valign grey-text " id="superuserCreateLimitMessage">
                        Account creation limit
                        <br>
                        Note : You can only create a maximum of <?php echo Superuser::$MAX_SUPERUSER_ACCOUNTS?> superuser accounts
                    </h6>
                </div>

                <form class="col s12" method="post" id="createSuperuserForm">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newSuperuserFirstName" type="text" class="validate" name="new_superuser_first_name" required>
                            <label for="newSuperuserFirstName">First name<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newSuperuserLastName" type="text" class="validate" name="new_superuser_last_name" required>
                            <label for="newSuperuserLastName">Last name<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newSuperuserEmail" type="email" class="validate" name="new_superuser_email" required>
                            <label for="newSuperuserEmail">Email<sup>*</sup></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newSuperuserPhone" type="text" class="validate" name="new_superuser_phone">
                            <label for="newSuperuserPhone">Phone (Optional)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="newSuperuserUsername" type="text" class="" name="new_superuser_username" required>
                            <label for="newSuperuserUsername">Username<sup>*</sup></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <a href="javascript:void(0)" class="right btn create-acc-btn" id="createSuperuserAccount" >Create account</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
                break;
                case TAB_MANAGE:
        ?>
        <div id="viewSuperuser" class="col s12 offset-m1 m10 ">
            <div class="row">
                <br>
                <br>

            <?php
                #Try to get principals : true if principals found in database
                if($superusers = DbInfo::GetAllSuperusers()):
            ?>
                <div class="row" id="superuserFilterList">
                    <form class="col s12" action="">
                        <div class="row hide">
                            <div class="input-field col m10 s9 hide">
                                <input id="filterListSearch" type="text" class="validate" name="filter-list-search">
                                <label for="filterListSearch">Search</label>
                            </div>
                            <div class="input-field col m2 s3 hide">
                                <a class="btn btn-floating waves-effect waves-light" type="submit"><i class="material-icons">search</i></a>
                            </div>
                        </div>
                        <div class="row hide">
                            <div class="input-field col s2">
                                <p>Filter: </p>
                            </div>

                            <div class="input-field col s10">
                                <div class="row">
                                    <div class="input-field col s6 m4">
                                        <p>
                                            <input type="checkbox" class="filled-in" id="filled-box-2" />
                                            <label for="filled-box-2">Name</label>
                                        </p>
                                    </div>
                                    <div class="input-field col s6 m4">
                                        <p>
                                            <input type="checkbox" class="filled-in" id="filled-box-3" />
                                            <label for="filled-box-3">Username</label>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!--Principal list table-->
                <table class="bordered highlight centered" id="super_superuser_list_table">
                    <thead>
                        <tr>
                            <th data-field="name">Name(s)</th>
                            <th data-field="name">Username</th>
                            <th data-field="name">Email</th>
                            <th data-field="name">Phone</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php 
                        foreach ($superusers as $superuser):
                    ?>
                        <tr>
                            <td><?php echo $superuser["first_name"] . " " . $superuser["last_name"] ?></td>
                            <td><?php echo $superuser["username"] ?></td>
                            <td><?php echo $superuser["email"] ?></td>
                            <td><?php
                                $phone = "N/A";
                                if(!empty($superuser["phone"]))
                                {
                                    $phone = $superuser["phone"];
                                }
                                echo $phone ?></td>
                        </tr>
                    <?php
                        endforeach;

                        else:#no superuser accounts were found 
                    ?>

                    <div class="row">
                        <div class="col s12 m10 offset-m1">
                            <div class="card-panel blue-grey darken-3 blue-grey-text text-lighten-4">
                                <h5 class="center">NO SUPERUSER ACCOUNTS FOUND</h5>
                                <div class="divider blue-grey lighten-2"></div>
                                <p class="blue-grey-text text-lighten-3">No superuser accounts were found. Superuser accounts will appear here once added.</p>
                            </div>
                        </div>
                    </div>

                    <?php
                        endif;
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
        <?php
                break;
                default:
        ?>
        <script>window.location = "<?php echo GetSectionLink(SECTION_SU_SUPERUSERS,$default_tab);?>";</script>
        <?php
            endswitch;
        ?>
    </div>
        <?php
            else:#tab is not set
        ?>
        <script>window.location = "<?php echo GetSectionLink(SECTION_SU_SUPERUSERS,$default_tab);?>";</script>
        <?php
            endif;
        break;
        case SECTION_CHAT:
    ?>
    <!--Superuser chat tab-->
    <!--<div class="row main-tab" id="superuserChatTab">
        <div class="col s12">
            <p>Chat section</p>
        </div>
    </div>-->
    <?php
        break;
        case SECTION_GROUP:
    ?>
    <!--Superuser group tab-->
    <!--<div class="row main-tab" id="superuserGroupsTab">
        <div class="col s12">
            <p>Group section</p>
        </div>
    </div> -->
    <?php
        break;
        case SECTION_ACCOUNT:
    ?>
    <!--Superuser account tab-->
    <div class="row main-tab" id="superuserAccountTab">
        <div class="row no-bottom-margin">
            <div class="col s12">
                <p class="grey-text">Your account</p>
            </div>

        </div>
        <div class="row">
            <br>
            <div class="col s12 no-data-message valign-wrapper grey lighten-3">
                <h6 class="center-align valign grey-text " id="changePasswordMessage">
                    Change your password here
                    <br>
                    Note : Passwords must be at least 8 characters long
                    <br>
                    Tip: For security, we recommend that you change your password if you are using the default password
                </h6>
            </div>

            <!--Change password-->
            <div class="col s12">
                <br>
                <form class="form account_form">
                    <div class="input-container col s12 m4">
                        <label for="oldPassword">Old Password</label>
                        <input type="password"  id="oldPassword" placeholder="Old password">
                    </div>
                    <div class="input-container col s12 m4">
                        <label for="newPassword">New Password</label>
                        <input type="password"  id="newPassword" placeholder="New password">
                    </div>
                    <div class="input-container col s12 m4">
                        <label for="confirmNewPassword">Confirm Password</label>
                        <input type="password"  id="confirmNewPassword" placeholder="Confirm password">
                    </div>
                    <div class="input-container col s12">
                        <a class="btn right" href="javascript:void(0)" id="btn_change_password">Change password</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php
    break;
    default:
?>
<script>window.location = "<?php echo GetSectionLink(SECTION_SU_BASE);?>";</script>
<?php
    endswitch;
else:
?>
<script>window.location = "<?php echo GetSectionLink(SECTION_SU_BASE);?>";</script>
<?php
endif;
?>
</div>

