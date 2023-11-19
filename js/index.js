$(document).ready(function () {

    const __icon = {
        erro_icon: '<i class="bi bi-exclamation-diamond"></i>',
        success_icon: '<i class="bi bi-check2-circle"></i>',
        spinner: '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
    }

    function trigger_toast(__toast) {
        const toastLiveExample = document.getElementById(__toast);
        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
        toastBootstrap.show();
    }

    function trigger_toast_message(__message, __icon, __backgrounColor, __textColor) {
        return `
        <div id="trigger-toast" class="toast rounded-0 align-items-center ${__backgrounColor}" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body ${__textColor}">
                    ${__icon}
                    ${__message}
                </div>
                <button type="button" class="btn-close me-2 m-auto shadow" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        `;
    }


    var __semester;
    var __school_year;
    var __section;
    var __teacher;
    var __room;

    var __year;
    var __course;

    function section_timetable(semester, school_year, section) {
        $.ajax({
            type: "POST",
            url: "../data/data.section_timetable.php",
            data: {

                semester: semester,
                school_year: school_year,
                section: section,
                submit: "submit"
            },
            success: function (response) {
                $("#section-timetable").html(response);
            }
        });
    }

    function teacher_timetable(semester, school_year, teacher) {
        $.ajax({
            type: "POST",
            url: "../data/data.teacher_timetable.php",
            data: {

                semester: semester,
                school_year: school_year,
                teacher: teacher,
                submit: "submit"
            },
            success: function (response) {
                $("#teacher-timetable").html(response);
            }
        });
    }

    function room_timetable(semester, school_year, room) {
        $.ajax({
            type: "POST",
            url: "../data/data.room_timetable.php",
            data: {

                semester: semester,
                school_year: school_year,
                room: room,
                submit: "submit"
            },
            success: function (response) {
                $("#room-timetable").html(response);
            }
        });
    }

    //FORGOT PASSWORD FUNCTION
    $(document).on("submit", "#forgot-password-form", (e) => {
        e.preventDefault();
        const form = document.getElementById('forgot-password-form');
        const formData = new FormData(form);

        // DATA TO BE SEND IN AJAX
        const email = formData.get('email');
        $.ajax({
            type: "POST",
            url: "./data/data.forgot_password.php",
            data: {
                email: email,
                submit: "submit"
            },
            beforeSend: () => {
                $("#forgot-password-btn").html(`
                <div class="d-flex justify-content-center">
                    ${__icon.spinner}
                </div>
                `);
            },
            success: function (response) {
                $("#forgot-password-btn").html(`Send`);
                if (response == "email_not_found") {
                    $("#forgot-password-messages").html(trigger_toast_message("Email Not Found.", __icon.erro_icon, "bg-danger", "text-light"));
                    trigger_toast("trigger-toast");
                } else if (response == "email_send_code") {
                    $("#forgot-password-messages").html(trigger_toast_message("We've send the verification link on your email address. Please check.", __icon.erro_icon, "bg-success", "text-light"));
                    trigger_toast("trigger-toast");
                }
            }
        })
    });

    //CHANGE PASSWORD FUNCTION
    $(document).on("submit", "#change-password-form", (e) => {
        e.preventDefault();
        const form = document.getElementById('change-password-form');
        const formData = new FormData(form);

        // DATA TO BE SEND IN AJAX
        const password = formData.get('password');
        const con_password = formData.get('con_password');
        $.ajax({
            type: "POST",
            url: "./data/data.change_password.php",
            data: {
                password: password,
                con_password: con_password,
                submit: "submit"
            },
            beforeSend: () => {
                $("#change-password-btn").html(`
                <div class="d-flex justify-content-center">
                    ${__icon.spinner}
                </div>
                `);
            },
            success: function (response) {
                $("#change-password-btn").html(`Change Password`);
                if (response == "reset_code_invalid") {
                    $("#change-password-messages").html(trigger_toast_message("Reset Link do not Match.", __icon.erro_icon, "bg-danger", "text-light"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "password_not_changed") {
                    $("#change-password-messages").html(trigger_toast_message("Password and Confirmed Password are not the same.", __icon.erro_icon, "bg-danger", "text-light"));
                    trigger_toast("trigger-toast");
                } else if (response == "password_changed") {
                    $("#change-password-messages").html(trigger_toast_message("Password Changed.", __icon.erro_icon, "bg-success", "text-light"));
                    trigger_toast("trigger-toast");
                }
            }
        })
    });
    // LOGIN IN SUBMIT FUNCTION
    $(document).on("submit", "#login-form", (e) => {
        e.preventDefault();

        const form = document.getElementById('login-form');
        const formData = new FormData(form);

        // DATA TO BE SEND IN AJAX
        const username = formData.get('username');
        const password = formData.get('password');

        // AJAX DATA SEND
        $.ajax({
            type: "POST",
            url: "./data/data.signin.php",
            data: {
                username: username,
                password: password,
                form_login: username + password //FORM_LOGIN TO BE CHECKED THAT THE BUTTON SUBMIT FORM IS TRIGGERED
            },
            beforeSend: () => {
                $("#form-login-btn").html(`
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Login
                `);
            },
            success: function (data) {
                $("#form-login-btn").html(`Login`);

                // CHECK LOGIN CREDENTIALS
                if (data == "error_username_email") {

                    $("#login-message").html(trigger_toast_message("Please check Username.", __icon.erro_icon, "bg-danger", "text-light"));
                    trigger_toast("trigger-toast");

                } else if (data == "error_password") {

                    $("#login-message").html(trigger_toast_message("Please check Password.", __icon.erro_icon, "bg-danger", "text-light"));
                    trigger_toast("trigger-toast");
                } else if (data == "user_email_not_verified") {
                    $("#login-message").html(trigger_toast_message("First verify you account through check your email and try again.", __icon.erro_icon, "bg-danger", "text-light"));
                    trigger_toast("trigger-toast");
                }
                else if (data == "user_email_verified") {
                    $("#login-message").html(trigger_toast_message("Account Verified.", __icon.erro_icon, "bg-danger", "text-light"));
                    trigger_toast("trigger-toast");
                    if (data == "Admin") {
                        window.location.href = "../admin/admin_home.php";
                    }
                    else if (data == "Teacher") {
                        window.location.href = "../teacher/teacher_home.php";
                    }
                    else if (data == "Student") {
                        window.location.href = "../student/student_home.php";
                    }
                    else {
                        alert(data)
                    }
                }
                else {
                    if (data == "Admin") {
                        window.location.href = "/raw_project_scheduling_email_verification/admin/admin_home.php";
                    }
                    else if (data == "Teacher") {
                        window.location.href = "/raw_project_scheduling_email_verification/teacher/teacher_home.php";
                    }
                    else if (data == "Student") {
                        window.location.href = "/raw_project_scheduling_email_verification/student/student_home.php";
                    }
                    else {
                        alert(data)
                    }
                }
            }
        })
    });

    // RETRIEVE TIMETABLE   
    function retrieve_timetable() {
        $.ajax({
            type: "GET",
            url: "../data/data.timetable.php",
            beforeSend: function () {
                $("#section-timetable").html(`
                    <div class="text-center">
                        ${__icon.spinner}
                    </div>
                `)
                $("#teacher-timetable").html(`
                    <div class="text-center">
                        ${__icon.spinner}
                    </div>
                `)
                $("#room-timetable").html(`
                    <div class="text-center">
                        ${__icon.spinner}
                    </div>
                `)
                $("#print-section-timetable").html(`
                    <div class="text-center">
                        ${__icon.spinner}
                    </div>
                `)
                $("#print-section-timetable-teacher").html(`
                    <div class="text-center">
                        ${__icon.spinner}
                    </div>
                `)
            },
            success: function (response) {
                $("#section-timetable").html(response)
                $("#teacher-timetable").html(response)
                $("#room-timetable").html(response)
            }
        });
    }
    retrieve_timetable();

    // // //RETRIEVE ANNOUNCEMENT
    // $(document).on("submit","#add-announcement-form-filter",(e)=>{
    //     e.preventDefault();
    //     const form = document.getElementById('add-announcement-form-filter');
    //     const formData = new FormData(form);

    //     const start_date = formData.get('announcement_filter_start_date');
    //     const end_date = formData.get('announcement_filter_end_date');
    //     $.ajax({
    //         type:"POST",
    //         url:"data.filter_announcement.php",
    //         data:{
    //             announcement_start_date:start_date,
    //             announcement_end_date:end_date,
    //             submit:"submit"
    //         },
    //     })
    // })








    // // RETRIEVE DEPARTMENT
    // function retrieve_department(){
    //     $.ajax({
    //         type: "GET",
    //         url: "../data/data.retrieve_department.php",
    //         success: function (response) {
    //             $("#select-department").html(response);
    //             $("#select-department-subject").html(response);
    //             $("#section-select-department").html(response);
    //             $("#room-select-department").html(response);
    //             $("#select-section-department").html(response);
    //             $("#print-select-department").html(response);
    //             $("#teacher-load-select-department").html(response);
    //         }
    //     });
    // }
    // retrieve_department();

    // // ADD DEPARTMENT FUNCTION
    // $(document).on("submit", "#add-department-form", (e)=>{
    //     e.preventDefault();

    //     const form = document.getElementById("add-department-form");
    //     const formData = new FormData(form);

    //     // VARIABLES TO BE SEND 
    //     const department_code = formData.get("department_code");
    //     const department_title = formData.get("department_title");
    //     const department_designation = formData.get("department_designation");

    //     $.ajax({
    //         type: "POST",
    //         url: "../data/data.add_department.php",
    //         data: {
    //             department_code: department_code.toUpperCase(),
    //             department_title: department_title,
    //             department_designation: department_designation,
    //             submit: "submit"
    //         },
    //         beforeSend: function(){
    //             $("#add-department-btn").html(`
    //                 <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    //                 Add Department
    //             `);
    //         },
    //         success: function (response) {
    //             $("#add-department-btn").html(`
    //                 Add Department
    //             `);

    //             if(response == "dept-title-error"){

    //                 $("#alert-messages").html(trigger_toast_message("Department title has been used.", __icon.erro_icon, "bg-ternary", "text-white"));
    //                 trigger_toast("trigger-toast");

    //             }else if(response == "dept-designation-error"){

    //                 $("#alert-messages").html(trigger_toast_message("Department Designation has been used.", __icon.erro_icon, "bg-ternary", "text-white"));
    //                 trigger_toast("trigger-toast");

    //             }else if(response == "dept-code-error"){

    //                 $("#alert-messages").html(trigger_toast_message("Department code has been used.", __icon.erro_icon, "bg-ternary", "text-white"));
    //                 trigger_toast("trigger-toast");

    //             }else if(response == 0){

    //                 $("#alert-messages").html(trigger_toast_message("Unable to add Department.", __icon.erro_icon, "bg-ternary", "text-white"));
    //                 trigger_toast("trigger-toast");

    //             }else {

    //                 $("#alert-messages").html(trigger_toast_message("Department has been added.", __icon.erro_icon, "bg-success", "text-dark"));
    //                 trigger_toast("trigger-toast");

    //             }
    //         }
    //     });
    // })

    // RETRIEVE ACADEMIC YEAR FUNCTION
    function retrieve_academic_year() {
        $.ajax({
            type: "GET",
            url: "../data/data.retrieve_academic_year.php",
            success: function (response) {
                $("#select-ay").html(response);
                $("#select-ay-subject").html(response);
                $("#select-section-ay").html(response);
                $("#register-student-select-ay").html(response);
                $("#print-select-school-year").html(response);
                $("#print-select-school-year-teacher").html(response);
                $("#print-select-school-year-student").html(response);
                $("#teacher-load-select-school-year").html(response);
                $("#edit-profile-student-select-ay").html(response);
            }
        });
    }
    retrieve_academic_year();

    function retrieve_academic_year_register() {
        $.ajax({
            type: "GET",
            url: "./data/data.retrieve_academic_year.php",
            success: function (response) {
                $("#register-student-select-ay").html(response);
            }
        });
    }
    retrieve_academic_year_register();


    // ADD ACADEMIC YEAR FUNCTION
    $(document).on("submit", "#add-academic-year-form", (e) => {
        e.preventDefault();

        const form = document.getElementById("add-academic-year-form");
        const formData = new FormData(form);

        // VARIABLES TO BE SEND IN AJAX
        const academic_year = formData.get("academic_year");
        const semester = formData.get("select_semester");

        $.ajax({
            type: "POST",
            url: "../data/data.add_academic_year.php",
            data: {
                academic_year: academic_year,
                semester: semester,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-academic-year-btn").html(`
                    ${__icon.spinner}
                    Add A.Y.
                `);
            },
            success: function (response) {
                $("#add-academic-year-btn").html(`
                    Add A.Y.
                `);

                if (response == 'ay_added') {

                    $("#alert-messages").html(trigger_toast_message("Academic Year has been used.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");

                } else if (response == 0) {

                    $("#alert-messages").html(trigger_toast_message("Unable to add Academic year.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");

                } else {

                    $("#alert-messages").html(trigger_toast_message("Academic year has been added.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");

                }
            }
        });
    });

    // ADD TEACHER FUNCTION
    $(document).on("submit", "#add-teacher-form", (e) => {
        e.preventDefault();

        const form = document.getElementById("add-teacher-form");
        const formData = new FormData(form);

        // DATA VARIABLES TO BE SEND IN AJAX
        const username = formData.get("username");
        const password = formData.get("password");
        const firstname = formData.get("firstname");
        const lastname = formData.get("lastname");
        const middlename = formData.get("middlename");
        const address = formData.get("address");
        const phone_number = formData.get("phone_number");
        const id_number = formData.get("id_number");
        const bachelor = formData.get("_bachelor");
        const master = formData.get("_master");
        const doctor = formData.get("_doctor");
        const special = formData.get("_special");
        const major = formData.get("_major");
        const minor = formData.get("_minor");
        const designation = formData.get("_designation");
        const status = formData.get("status");
        const research = formData.get("research");
        const production = formData.get("production");
        const extension = formData.get("extension");
        const others = formData.get("extension");

        $.ajax({
            type: "POST",
            url: "../data/data.add_teacher.php",
            data: {
                username: username,
                password: password,
                firstname: firstname,
                lastname: lastname,
                middlename: middlename,
                address: address,
                phone_number: phone_number,
                id_number: id_number,
                bachelor: bachelor,
                master: master,
                doctor: doctor,
                special: special,
                major: major,
                minor: minor,
                designation: designation,
                status: status,
                research: research,
                production: production,
                extension: extension,
                others: others,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-teacher-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-teacher-btn").html("Add Teacher");

                console.log(response)

                if (response == "id_number_error") {

                    $("#alert-messages").html(trigger_toast_message("ID Number is used.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_error") {
                    $("#alert-messages").html(trigger_toast_message("Invalid Username.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == 11) {

                    $("#alert-messages").html(trigger_toast_message("Teacher has been registered.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");

                } else {

                    $("#alert-messages").html(trigger_toast_message("Unable to register Teacher.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");

                }
            }
        });

    });

    //ADD STUDENT FUNCTION
    $(document).on("submit", "#add-student-form", (e) => {
        e.preventDefault();

        const form = document.getElementById("add-student-form");
        const formData = new FormData(form);
        const username = formData.get("username");
        const password = formData.get("password");
        const ctuid = formData.get("id_number");
        const firstname = formData.get("firstname");
        const lastname = formData.get("lastname");
        const middlename = formData.get("middlename");
        const phone_number = formData.get("phone_number");
        const email = formData.get("email");
        const course = formData.get("course");
        const year = formData.get("year");
        const section = formData.get("section");
        const address = formData.get("address");
        const status = formData.get("status");

        $.ajax({
            type: "POST",
            url: "../data/data.add_student.php",
            data: {
                username: username,
                password: password,
                ctuid: ctuid,
                firstname: firstname,
                lastname: lastname,
                middlename: middlename,
                phone_number: phone_number,
                email: email,
                course: course,
                year: year,
                section: section,
                address: address,
                status: status,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-student-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-student-btn").html("Add Student");

                console.log(response)

                if (response == "id_number_error") {
                    $("#alert-messages").html(trigger_toast_message("ID Number is used.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == 11) {

                    $("#alert-messages").html(trigger_toast_message("Student has been added.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");

                } else {

                    $("#alert-messages").html(trigger_toast_message("Unable to add Student.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");

                }
            }
        });
    });

    // ADD STUDENT REGISTER FUNCTION
    $(document).on("submit", "#register-student", (e) => {
        e.preventDefault();

        const form = document.getElementById("register-student");
        const formData = new FormData(form);

        const username = formData.get("register-student-username");
        const password = formData.get("register-student-password");
        const ctuid = formData.get("register-student-ctuid");
        const firstname = formData.get("register-student-first-name");
        const lastname = formData.get("register-student-last-name");
        const middlename = formData.get("register-student-middle-name");
        const phone_number = formData.get("register-student-phone-number");
        const email = formData.get("register-student-email");
        const course = formData.get("register-student-course");
        const year = formData.get("register-student-year");
        const ay = formData.get("register-student-select-ay");
        const semester = formData.get("register-student-select-semester");
        const section = formData.get("register-student-section");
        const address = formData.get("register-student-address");
        const status = formData.get("register-student-status");

        $.ajax({
            type: "POST",
            url: "./data/data.add_student_reg.php",
            data: {
                username: username,
                password: password,
                ctuid: ctuid,
                firstname: firstname,
                lastname: lastname,
                middlename: middlename,
                phone_number: phone_number,
                email: email,
                course: course,
                year: year,
                ay: ay,
                semester: semester,
                section: section,
                address: address,
                status: status,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-register-student-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-register-student-btn").html("Register as Student");

                console.log(response)
                if (response == "username_same_error") {
                    $("#alert-messages").html(trigger_toast_message("Some details has been used by another user. Please check your details.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_error") {
                    $("#alert-messages").html(trigger_toast_message("Invalid Username. Username should have atleast 1 number", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_errorpassword_error") {
                    $("#alert-messages").html(trigger_toast_message("Username should have atleast 1 number and create a Password with at least 8 characters and atleast 1 number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "password_error") {
                    $("#alert-messages").html(trigger_toast_message("Put a Password at least 8 characters and at least 1 number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "email_error") {
                    $("#alert-messages").html(trigger_toast_message("Please Enter Valid CTU Email.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_errorid_number_error") {
                    $("#alert-messages").html(trigger_toast_message("Invalid Username Or Password  And ID Number is Used. Please put a number both Username And Password.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "id_number_error") {
                    $("#alert-messages").html(trigger_toast_message("ID Number has been used by another user.Please check your ID Number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }

                else if (response == 11) {

                    $("#alert-messages").html(trigger_toast_message("Student has been added. We've send a verification code on your email addresss. Please Check and you wil go back to Login Page.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");
                    setTimeout(function () {
                        window.location.href = "/raw_project_scheduling_email_verification/index.php";
                    }, 3000);


                } else {

                    $("#alert-messages").html(trigger_toast_message("Unable to add Student. Please check the info required.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");

                }
            }
        });
    });


    // UPDATE STUDENT REGISTER FUNCTION
    $(document).on("submit", "#edit-profile-student", (e) => {
        e.preventDefault();

        const form = document.getElementById("edit-profile-student");
        const formData = new FormData(form);

        const username = formData.get("edit-profile-student-username");
        const password = formData.get("edit-profile-student-password");
        const ctuid = formData.get("edit-profile-student-ctuid");
        const firstname = formData.get("edit-profile-student-first-name");
        const lastname = formData.get("edit-profile-student-last-name");
        const middlename = formData.get("edit-profile-student-middle-name");
        const phone_number = formData.get("edit-profile-student-phone-number");
        const email = formData.get("edit-profile-student-email");
        const course = formData.get("edit-profile-student-course");
        const year = formData.get("edit-profile-student-year");
        const ay = formData.get("edit-profile-student-select-ay");
        const semester = formData.get("edit-profile-student-select-semester");
        const section = formData.get("edit-profile-student-select-section");
        const address = formData.get("edit-profile-student-address");
        const status = formData.get("edit-profile-student-status");

        $.ajax({
            type: "POST",
            url: "../data/data.update_student.php",
            data: {
                username: username,
                password: password,
                ctuid: ctuid,
                firstname: firstname,
                lastname: lastname,
                middlename: middlename,
                phone_number: phone_number,
                email: email,
                course: course,
                year: year,
                ay: ay,
                semester: semester,
                section: section,
                address: address,
                status: status,
                submit: "submit"
            },
            beforeSend: function () {
                $("#edit-profile-student-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#edit-profile-student-btn").html("Register as Teacher");

                console.log(response)
                if (response == "username_same_error") {
                    $("#alert-messages").html(trigger_toast_message("Some details has been used by another user. Please check your details.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_error") {
                    $("#alert-messages").html(trigger_toast_message("Invalid Username. Username should have atleast 1 number", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_errorpassword_error") {
                    $("#alert-messages").html(trigger_toast_message("Username should have atleast 1 number and create a Password with at least 8 characters and atleast 1 number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "password_error") {
                    $("#alert-messages").html(trigger_toast_message("Put a Password at least 8 characters and at least 1 number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "email_error") {
                    $("#alert-messages").html(trigger_toast_message("Please Enter Valid CTU Email.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_errorid_number_error") {
                    $("#alert-messages").html(trigger_toast_message("Invalid Username Or Password  And ID Number is Used. Please put a number both Username And Password.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "id_number_error") {
                    $("#alert-messages").html(trigger_toast_message("ID Number has been used by another user.Please check your ID Number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }

                else if (response == 11) {

                    $("#alert-messages").html(trigger_toast_message("Student has been updated. ", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");
                    // setTimeout(function () {
                    //     window.location.href = "/raw_project_scheduling_email_verification/index.php";
                    // }, 3000);


                } else {

                    $("#alert-messages").html(trigger_toast_message("Unable to add Student. Please check the info required.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");

                }
            }
        });
    });


    // ADD TEACHER REGISTER FUNCTION
    $(document).on("submit", "#register-teacher", (e) => {
        e.preventDefault();

        const form = document.getElementById("register-teacher");
        const formData = new FormData(form);

        const username = formData.get("register-teacher-username");
        const password = formData.get("register-teacher-password");
        const ctuid = formData.get("register-teacher-ctuid");
        const firstname = formData.get("register-teacher-first-name");
        const lastname = formData.get("register-teacher-last-name");
        const middlename = formData.get("register-teacher-middle-name");
        const phone_number = formData.get("register-teacher-phone-number");
        const address = formData.get("register-teacher-address")
        const email = formData.get("register-teacher-email");
        const bachelor = formData.get("register-teacher-bachelor");
        const master = formData.get("register-teacher-master");
        const doctor = formData.get("register-teacher-doctor");
        const special = formData.get("register-teacher-special");
        const major = formData.get("register-teacher-major");
        const minor = formData.get("register-teacher-minor");
        const designation = formData.get("register-teacher-designation");
        const research = formData.get("register-teacher-research");
        const production = formData.get("register-teacher-production");
        const extension = formData.get("register-teacher-extension");
        const others = formData.get("register-teacher-others");
        const status = formData.get("register-teacher-status");

        $.ajax({
            type: "POST",
            url: "./data/data.add_teacher_reg.php",
            data: {
                username: username,
                password: password,
                ctuid: ctuid,
                firstname: firstname,
                lastname: lastname,
                middlename: middlename,
                phone_number: phone_number,
                email: email,
                address: address,
                status: status,
                bachelor: bachelor,
                master: master,
                doctor: doctor,
                special: special,
                major: major,
                minor: minor,
                designation: designation,
                research: research,
                production: production,
                extension: extension,
                others: others,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-register-teacher-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-register-teacher-btn").html("Register as Teacher");

                console.log(response)
                if (response == "username_same_error") {
                    $("#alert-messages").html(trigger_toast_message("Some details has been used by another user. Please check your details.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_error") {
                    $("#alert-messages").html(trigger_toast_message("Invalid Username. Username should have atleast 1 number", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_errorpassword_error") {
                    $("#alert-messages").html(trigger_toast_message("Username should have atleast 1 number and create a Password with at least 8 characters and atleast 1 number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "password_error") {
                    $("#alert-messages").html(trigger_toast_message("Put a Password at least 8 characters and at least 1 number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "email_error") {
                    $("#alert-messages").html(trigger_toast_message("Please Enter Valid CTU Email.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_errorid_number_error") {
                    $("#alert-messages").html(trigger_toast_message("Invalid Username Or Password  And ID Number is Used. Please put a number both Username And Password.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "id_number_error") {
                    $("#alert-messages").html(trigger_toast_message("ID Number has been used by another user.Please check your ID Number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }

                else if (response == 11) {

                    $("#alert-messages").html(trigger_toast_message("Teacher has been added. We've send a verification code on your email addresss. Please Check and you wil go back to Login Page.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");
                    setTimeout(function () {
                        window.location.href = "/raw_project_scheduling_email_verification/index.php";
                    }, 3000);


                } else {

                    $("#alert-messages").html(trigger_toast_message("Unable to add Teacher. Please check the info required.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");

                }
            }
        });
    });


    // UPDATE TEACHER
    $(document).on("submit", "#edit-profile-teacher", (e) => {
        e.preventDefault();

        const form = document.getElementById("edit-profile-teacher");
        const formData = new FormData(form);

        const username = formData.get("edit-profile-teacher-username");
        const password = formData.get("edit-profile-teacher-password");
        const ctuid = formData.get("edit-profile-teacher-ctuid");
        const firstname = formData.get("edit-profile-teacher-first-name");
        const lastname = formData.get("edit-profile-teacher-last-name");
        const middlename = formData.get("edit-profile-teacher-middle-name");
        const phone_number = formData.get("edit-profile-teacher-phone-number");
        const address = formData.get("edit-profile-teacher-address")
        const email = formData.get("edit-profile-teacher-email");
        const bachelor = formData.get("edit-profile-teacher-bachelor");
        const master = formData.get("edit-profile-teacher-master");
        const doctor = formData.get("edit-profile-teacher-doctor");
        const special = formData.get("edit-profile-teacher-special");
        const major = formData.get("edit-profile-teacher-major");
        const minor = formData.get("edit-profile-teacher-minor");
        const designation = formData.get("edit-profile-teacher-designation");
        const research = formData.get("edit-profile-teacher-research");
        const production = formData.get("edit-profile-teacher-production");
        const extension = formData.get("edit-profile-teacher-extension");
        const others = formData.get("edit-profile-teacher-others");
        const status = formData.get("edit-profile-teacher-status");

        $.ajax({
            type: "POST",
            url: "../data/data.update_teacher.php",
            data: {
                username: username,
                password: password,
                ctuid: ctuid,
                firstname: firstname,
                lastname: lastname,
                middlename: middlename,
                phone_number: phone_number,
                email: email,
                address: address,
                status: status,
                bachelor: bachelor,
                master: master,
                doctor: doctor,
                special: special,
                major: major,
                minor: minor,
                designation: designation,
                research: research,
                production: production,
                extension: extension,
                others: others,
                submit: "submit"
            },
            beforeSend: function () {
                $("#edit-profile-teacher-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#edit-profile-teacher-btn").html("Edit Profile");

                console.log(response)
                if (response == "username_same_error") {
                    $("#alert-messages").html(trigger_toast_message("Some details has been used by another user. Please check your details.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_error") {
                    $("#alert-messages").html(trigger_toast_message("Invalid Username. Username should have atleast 1 number", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_errorpassword_error") {
                    $("#alert-messages").html(trigger_toast_message("Username should have atleast 1 number and create a Password with at least 8 characters and atleast 1 number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "password_error") {
                    $("#alert-messages").html(trigger_toast_message("Put a Password at least 8 characters and at least 1 number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "email_error") {
                    $("#alert-messages").html(trigger_toast_message("Please Enter Valid CTU Email.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "username_errorid_number_error") {
                    $("#alert-messages").html(trigger_toast_message("Invalid Username Or Password  And ID Number is Used. Please put a number both Username And Password.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == "id_number_error") {
                    $("#alert-messages").html(trigger_toast_message("ID Number has been used by another user.Please check your ID Number.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }

                else if (response == 11) {

                    $("#alert-messages").html(trigger_toast_message("Teacher has been updated. ", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");
                    // setTimeout(function () {
                    //     window.location.href = "/raw_project_scheduling_email_verification/index.php";
                    // }, 3000);


                } else {

                    $("#alert-messages").html(trigger_toast_message("Unable to update Teacher. Please check the info required.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");

                }
            }
        });
    });




    // ADD SECTION FUNCTION
    $(document).on("submit", "#add-section-form", (e) => {
        e.preventDefault();

        const form = document.getElementById("add-section-form");
        const formData = new FormData(form);

        const section_name = formData.get("section_name");
        const section_program = formData.get("section_program");

        const section_major = formData.get("section_major");

        $.ajax({
            type: "POST",
            url: "../data/data.add_section.php",
            data: {
                section_name: section_name.toUpperCase(),
                section_program: section_program,

                section_major: section_major,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-section-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-section-btn").html("Add Section");

                if (response == "section_error") {

                    $("#alert-messages").html(trigger_toast_message("Section is already added.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");

                } else if (response == 1) {

                    $("#alert-messages").html(trigger_toast_message("Section has been added.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");

                } else {

                    $("#alert-messages").html(trigger_toast_message("Unable to add Section.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");

                }
            }
        });
    });

    // ADD ROOM FUNCTION
    $(document).on("submit", "#add-room-form", (e) => {
        e.preventDefault();

        const form = document.getElementById("add-room-form");
        const formData = new FormData(form);

        // DATA VARIABLES TO BE SEND IN AJAX

        const room_name = formData.get("room_name");
        const room_building = formData.get("room_building");
        const room_capacity = formData.get("room_capacity");
        const room_type = formData.get("room_type");

        $.ajax({
            type: "POST",
            url: "../data/data.add_room.php",
            data: {

                room_name: room_name,
                room_building: room_building,
                room_capacity: room_capacity,
                room_type: room_type,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-room-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-room-btn").html("Add Room");

                if (response == "room_already_added") {
                    $("#alert-messages").html(trigger_toast_message("Room is already added.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                } else if (response == 1) {
                    $("#alert-messages").html(trigger_toast_message("Room is added.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");
                } else {
                    $("#alert-messages").html(trigger_toast_message("Unable to add room.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
            }
        });
    })

    // ADD SUBJECT FUNCTION
    $(document).on("submit", "#add-subject-form", (e) => {
        e.preventDefault();

        const form = document.getElementById("add-subject-form");
        const formData = new FormData(form);

        // DATA VARIABLES TO BE SEND IN AJAX
        const subject_name = formData.get("subject_name");
        const subject_title = formData.get("subject_title");
        const subject_unit = formData.get("subject_unit");
        const subject_lecture_hour = formData.get("subject_lecture_hour");
        const subject_laboratory_hour = formData.get("subject_laboratory_hour");

        $.ajax({
            type: "POST",
            url: "../data/data.add_subject.php",
            data: {
                subject_name: subject_name,
                subject_title: subject_title,
                subject_unit: subject_unit,
                subject_lecture_hour: subject_lecture_hour,
                subject_laboratory_hour: subject_laboratory_hour,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-subject-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-subject-btn").html("Add Subject");

                console.log(response);

                if (response == "subject_already_added") {
                    $("#alert-messages").html(trigger_toast_message("Subject is already added.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                } else if (response == 1) {
                    $("#alert-messages").html(trigger_toast_message("Subject is added.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");
                } else {
                    $("#alert-messages").html(trigger_toast_message("Unable to add subject.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
            }
        });

    })

    // TEACHER LIST DATATABLE
    if (window.location.pathname == "/scheduling/admin/add_plot.php") {
        $('#datatable-teacher').DataTable();
        $("#datatable-subject").DataTable();
        $("#datatable-section").DataTable();
    }


    // ADD TEACHER PLOT FUNCTION
    $(document).on("submit", "#add-teacher-plot-form", (e) => {
        e.preventDefault();

        const form = document.getElementById("add-teacher-plot-form");
        const formData = new FormData(form);

        // VARIABLES TO BE SEND IN AJAX

        const semester = formData.get("semester");
        const school_year = formData.get("school_year");
        const teacher_name = new Array();
        $("input:checked").each(function () {
            teacher_name.push($(this).val());
        })

        $.ajax({
            type: "POST",
            url: "../data/data.add_teacher_plot.php",
            data: {
                semester: semester,
                school_year: school_year,
                teacher_name: teacher_name,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-teacher-plot-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-teacher-plot-btn").html("Add Teacher Plot");

                if (response == 1) {
                    $("#alert-messages").html(trigger_toast_message("Teacher is added to plot.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");
                } else {
                    $("#alert-messages").html(trigger_toast_message(response, __icon.erro_icon, "bg-danger", "text-white"));
                    trigger_toast("trigger-toast");
                }
            }
        });

    })

    // THIS FUNCTION HELPS NOT TO DRY YOURSELF RETRIEVE TEACHER FOR SUBJECT PLOT
    function retrieve_teacher_for_subject_plot(semester, school_year) {
        $.ajax({
            type: "POST",
            url: "../data/data.retrieve_teacher_for_subject_plot.php",
            data: {

                semester: semester,
                school_year: school_year,
                submit: "submit"
            },
            success: function (response) {
                $("#select-teacher-subject-plot").html(response);
            }
        })
    }

    // SELECT DEPARTMENT CHANGE FOR SUBJECT PLOT


    // SELECT SEMESTER CHANGE FOR SUBJECT PLOT
    $(document).on("change", "#select-semester-subject", () => {
        var semester = $("#select-semester-subject").val();
        __semester = semester;

        retrieve_teacher_for_subject_plot(semester, __school_year);
    });

    // SELECT SCHOOL YEAR CHANGE FOR SUBJECT PLOT
    $(document).on("change", "#select-ay-subject", () => {
        var school_year = $("#select-ay-subject").val();
        __school_year = school_year;

        retrieve_teacher_for_subject_plot(__semester, school_year);
    });

    // ADD SUBJECT TO PLOT FUNCTION
    $(document).on("submit", "#add-subject-plot-form", (e) => {
        e.preventDefault();

        const form = document.getElementById("add-subject-plot-form");
        const formData = new FormData(form);

        // VARIABLES TO BE SEND IN AJAX

        const semester = formData.get("select_subject_semester");
        const school_year = formData.get("select_subject_school_year");
        const teacher = formData.get("select_subject_teacher");
        const subject = new Array();
        $("#subject_plot:checked").each(function () {
            subject.push($(this).val());
        })

        $.ajax({
            type: "POST",
            url: "../data/data.add_subject_plot.php",
            data: {

                semester: semester,
                school_year: school_year,
                teacher: teacher,
                subject: subject,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-subject-plot-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-subject-plot-btn").html("Add Subject Plot");

                if (response == 1) {
                    $("#alert-messages").html(trigger_toast_message("Subject is added to plot.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");
                } else {
                    $("#alert-messages").html(trigger_toast_message(response, __icon.erro_icon, "bg-danger", "text-white"));
                    trigger_toast("trigger-toast");
                }
            }
        })

    });

    // ADD SECTION TO PLUT FUNCTION
    $(document).on("submit", "#add-section-plot-form", (e) => {
        e.preventDefault();

        const form = document.getElementById("add-section-plot-form");
        const formData = new FormData(form);

        // VARIABLE DATA TO BE SEND IN AJAX
        const semester = formData.get("select_section_semester");
        const school_year = formData.get("select_section_school_year");
        const section_id = new Array();
        $("#section-plot:checked").each(function () {
            section_id.push($(this).val());
        })

        $.ajax({
            type: "POST",
            url: "../data/data.add_section_plot.php",
            data: {
                semester,
                school_year,
                section_id,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-section-plot-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-section-plot-btn").html("Add Section Plot");

                console.log(response)
            }
        });

    })

    // THIS FUNCTION HELPS NOT TO DRY YOURSELF RETRIEVE TEACHER SECTION FOR PLOT
    function retrieve_teacher_for_plot(semester, school_year) {
        $.ajax({
            type: "POST",
            url: "../data/data.retrieve_teacher_for_plot.php",
            data: {

                semester: semester,
                school_year: school_year,
                submit: "submit"
            },
            success: function (response) {
                $("#select-teacher").html(response);
                $("#select-teacher-timetable").html(response);
                $("#print-select-teacher").html(response);
                $("#print-select-teacher-teacher").html(response);
                $("#teacher-load-select-teacher").html(response);
            }
        });
    }

    function retrieve_section_for_plot(semester, school_year) {
        $.ajax({
            type: "POST",
            url: "../data/data.retrieve_section_for_plot.php",
            data: {

                semester: semester,
                school_year: school_year,
                submit: "submit"
            },
            success: function (response) {
                $("#select-section").html(response);
                $("#print-select-section").html(response);
                $("#select-section-timetable").html(response);
            }
        });
    }

    function retrieve_section_for_plot_register_student(semester, school_year, course, year) {
        year = $("#register-student-year").val();
        course = $("#register-student-course").val();
        $.ajax({
            type: "POST",
            url: "./data/data.retrieve_section_for_plot_reg_student.php",
            data: {
                year: year,
                course: course,
                semester: semester,
                school_year: school_year,
                submit: "submit"
            },
            success: function (response) {
                $("#register-student-select-section").html(response);
            }
        });
    }

    function retrieve_section_for_plot_edit_student(semester, school_year, course, year) {
        year = $("#edit-profile-student-year").val();
        course = $("#edit-profile-student-course").val();
        $.ajax({
            type: "POST",
            url: "../data/data.retrieve_section_for_plot_reg_student.php",
            data: {
                year: year,
                course: course,
                semester: semester,
                school_year: school_year,
                submit: "submit"
            },
            success: function (response) {
                $("#edit-profile-student-select-section").html(response);
            }
        });
    }

    function retrieve_section_for_plot_teacher(semester, school_year) {
        $.ajax({
            type: "POST",
            url: "../data/data.retrieve_section_for_plot_teacher.php",
            data: {

                semester: semester,
                school_year: school_year,
                submit: "submit"
            },
            success: function (response) {
                $("#print-select-section-teacher").html(response);
            }
        });
    }


    function retrieve_room_for_plot() {
        $.ajax({
            type: "GET",
            url: "../data/data.retrieve_room_for_plot.php",
            // data: {
            //     submit: "submit"
            // },
            success: function (response) {
                $("#select-room").html(response);
                $("#select-room-timetable").html(response);
                $("#print-select-room").html(response);
            }
        });
    }
    retrieve_room_for_plot();

    function retrieve_subject_for_teacher_plot(semester, school_year, teacher) {
        $.ajax({
            type: "POST",
            url: "../data/data.retrieve_subject_for_plot.php",
            data: {

                semester: semester,
                school_year: school_year,
                teacher: teacher,
                submit: "submit"
            },
            success: function (response) {
                $("#select-subject").html(response);
            }
        });
    }

    // SELECT DEPARTMENT FUNCTION FOR PLOT 
    // $(document).on("change", "#select-department", ()=>{
    //     var department = $("#select-department").val();
    //     __department = department;

    //     retrieve_teacher_for_plot(department, __semester, __school_year);
    //     retrieve_section_for_plot(department, __semester, __school_year);
    //     retrieve_room_for_plot(department);
    // });

    // SELECT SEMESTER FUNCTION FOR PLOT
    $(document).on("change", "#select-semester", () => {
        var semester = $("#select-semester").val();
        __semester = semester;

        retrieve_teacher_for_plot(semester, __school_year);
        retrieve_section_for_plot(semester, __school_year);
        retrieve_section_for_plot_teacher(__semester, __school_year);
    });

    // SELECT SCHOOL YEAR FOR PLOT
    $(document).on("change", "#select-ay", () => {
        var school_year = $("#select-ay").val();
        __school_year = school_year;

        retrieve_teacher_for_plot(__semester, school_year);
        retrieve_section_for_plot(__semester, school_year);
        retrieve_section_for_plot_teacher(__semester, __school_year);
    });

    // SELECT SEMESTER FUNCTION FOR EDITING STUDENT
    $(document).on("change", "#edit-profile-student-select-semester", () => {
        var semester = $("#edit-profile-student-select-semester").val();
        __semester = semester;


        retrieve_teacher_for_plot(semester, __school_year);
        retrieve_section_for_plot(semester, __school_year);
        retrieve_section_for_plot_teacher(__semester, __school_year);
    });

    // SELECT SCHOOL YEAR FOR EDITING STUDENT
    $(document).on("change", "#edit-profile-student-select-ay", () => {
        var school_year = $("#edit-profile-student-select-ay").val();
        __school_year = school_year;
        retrieve_teacher_for_plot(__semester, school_year);
        retrieve_section_for_plot(__semester, school_year);
        retrieve_section_for_plot_teacher(__semester, __school_year);
    });

    // SELECT SEMESTER FUNCTION FOR PLOT
    $(document).on("change", "#select-semester", () => {
        var semester = $("#select-semester").val();
        __semester = semester;

        retrieve_teacher_for_plot(semester, __school_year);
        retrieve_section_for_plot(semester, __school_year);
        retrieve_section_for_plot_teacher(__semester, __school_year);
    });

    // SELECT SCHOOL YEAR FOR PLOT
    $(document).on("change", "#select-ay", () => {
        var school_year = $("#select-ay").val();
        __school_year = school_year;

        retrieve_teacher_for_plot(__semester, school_year);
        retrieve_section_for_plot(__semester, school_year);
        retrieve_section_for_plot_teacher(__semester, __school_year);
    });


    // SELECT SEMESTER FUNCTION FOR REGISTER STUDENT
    $(document).on("change", "#register-student-select-semester", () => {
        var semester = $("#register-student-select-semester").val();
        __semester = semester;


        retrieve_section_for_plot_register_student(__semester, __school_year, __course, __year);


    });

    // SELECT SCHOOL YEAR FOR REGISTER STUDENT
    $(document).on("change", "#register-student-select-ay", () => {
        var school_year = $("#register-student-select-ay").val();
        __school_year = school_year;
        retrieve_section_for_plot_register_student(__semester, __school_year, __course, __year);

    });



    // SELECT COURSE FUNCTION FOR REGISTER STUDENT
    $(document).on("change", "#register-student-select-course", () => {
        var course = $("#register-student-course").val();
        __course = course;


        retrieve_section_for_plot_register_student(__semester, __school_year, __course, __year);

    });

    // SELECT YEAR FUNCTION FOR REGISTER STUDENT
    $(document).on("change", "#register-student-select-year", () => {
        var __year = $("#register-student-year").val();
        __year = year;


        retrieve_section_for_plot_register_student(__semester, __school_year, __course, __year);

    });


    // SELECT SEMESTER FUNCTION FOR EDITING STUDENT
    $(document).on("change", "#edit-profile-student-select-semester", () => {
        var semester = $("#edit-profile-student-select-semester").val();
        __semester = semester;



        retrieve_section_for_plot_edit_student(__semester, __school_year, __course, __year);

    });

    // SELECT SCHOOL YEAR FOR EDITING STUDENT
    $(document).on("change", "#edit-profile-student-select-ay", () => {
        var school_year = $("#edit-profile-student-select-ay").val();
        __school_year = school_year;

        retrieve_section_for_plot_edit_student(__semester, __school_year, __course, __year);
    });



    // SELECT COURSE FUNCTION FOR EDITING STUDENT
    $(document).on("change", "#edit-profile-student-course", () => {
        var course = $("#register-student-course").val();
        __course = course;



        retrieve_section_for_plot_edit_student(__semester, __school_year, __course, __year);
    });

    // SELECT YEAR FUNCTION FOR EDITING STUDENT
    $(document).on("change", "#edit-profile-student-year", () => {
        var __year = $("#edit-profile-student-year").val();
        __year = year;

        retrieve_section_for_plot_edit_student(__semester, __school_year, __course, __year);
    });





    // SELECT SCHOOL YEAR FOR REGISTER STUDENT
    // $(document).on("change", "#register-student-select-ay", () => {
    //     var school_year = $("#register-student-select-ay").val();
    //     __school_year = school_year;
    //     retrieve_section_for_plot_register_student(__semester, __school_year);
    // });

    // SELECT TEACHER 
    $(document).on("change", "#select-teacher", () => {
        var teacher = $("#select-teacher").val();

        retrieve_subject_for_teacher_plot(__semester, __school_year, teacher);
    })

    // ADD SCHEDULE FORM PLOT FUNCTION
    $(document).on("submit", "#add-schedule-form-plot", (e) => {
        e.preventDefault();

        const form = document.getElementById("add-schedule-form-plot");
        const formData = new FormData(form);

        // DATA VARIABLES TO BE SEND IN AJAX
        // const plot_department = formData.get("plot_department");
        const plot_semester = formData.get("plot_semester");
        const plot_school_year = formData.get("plot_school_year");
        const plot_room = formData.get("plot_room");
        const plot_section = formData.get("plot_section");
        const plot_week_day = formData.get("plot_week_day");
        const plot_teacher = formData.get("plot_teacher");
        const plot_subject = formData.get("plot_subject");
        const plot_start_time_hour = formData.get("plot_start_time_hour");
        const plot_start_time_minute = formData.get("plot_start_time_minute");
        const plot_end_time_hour = formData.get("plot_end_time_hour");
        const plot_end_time_minute = formData.get("plot_end_time_minute");

        if (plot_end_time_hour <= plot_start_time_hour && plot_end_time_minute <= plot_start_time_minute) {
            $("#alert-messages").html(trigger_toast_message("Starting time must not be greater to end time.", __icon.erro_icon, "bg-danger", "text-white"));
            trigger_toast("trigger-toast");
            return false
        }

        $.ajax({
            type: "POST",
            url: "../data/data.add_schedule.php",
            data: {
                // plot_department: plot_department,
                plot_semester: plot_semester,
                plot_school_year: plot_school_year,
                plot_room: plot_room,
                plot_section: plot_section,
                plot_week_day: plot_week_day,
                plot_teacher: plot_teacher,
                plot_subject: plot_subject,
                plot_start_time_hour: plot_start_time_hour,
                plot_start_time_minute: plot_start_time_minute,
                plot_end_time_hour: plot_end_time_hour,
                plot_end_time_minute: plot_end_time_minute,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-schedule-btn-plot").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-schedule-btn-plot").html("Add Schedule");

                if (response == 1) {
                    $("#alert-messages").html(trigger_toast_message("Schedule has been added.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");

                    section_timetable(plot_semester, plot_school_year, plot_section);
                    teacher_timetable(plot_semester, plot_school_year, plot_teacher);
                    room_timetable(plot_semester, plot_school_year, plot_room);

                } else {
                    $("#alert-messages").html(trigger_toast_message(response, __icon.erro_icon, "bg-danger", "text-white"));
                    trigger_toast("trigger-toast");
                }
            }
        });
    });

    //ADD ANNOUNCEMENT
    $(document).on("submit", "#add-announcement", (e) => {
        e.preventDefault();
        const form = document.getElementById("add-announcement");
        const formData = new FormData(form);

        const announcement_title = formData.get("announcement_title");
        const announcement_desc = formData.get("announcement_desc");
        const announcement_type = formData.get("announcement_type");
        const announcement_start_date = formData.get("announcement_start_date");
        const announcement_end_date = formData.get("announcement_end_date");


        $.ajax({
            type: "POST",
            url: "../data/data.add_announcement.php",
            data: {
                announcement_title: announcement_title,
                announcement_desc: announcement_desc,
                announcement_type: announcement_type,
                announcement_start_date: announcement_start_date,
                announcement_end_date: announcement_end_date,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-announcement-btn").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-announcement-btn").html("Add Announcement");

                if (response == "announcement_added") {
                    $("#alert-messages").html(trigger_toast_message("Annoucement has been already posted", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == 1) {
                    $("#alert-messages").html(trigger_toast_message("Announcement has been added.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");
                }
                else {

                    $("#alert-messages").html(trigger_toast_message("Unable to add Announcement.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");

                }
            }
        })
    });

    //ADD FEEDBACK FROM TEACHER
    $(document).on("submit", "#add-teacher-feedback", (e) => {
        e.preventDefault();
        const form = document.getElementById("add-teacher-feedback");
        const formData = new FormData(form);

        const feedback_title = formData.get("feedback_title");
        const feedback_desc = formData.get("feedback_desc");
        const feedback_type = formData.get("feedback_type");

        $.ajax({
            type: "POST",
            url: "../data/data.add_feedback_teacher.php",
            data: {
                feedback_title: feedback_title,
                feedback_desc: feedback_desc,
                feedback_type: feedback_type,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-feedback-btn-teacher").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-feedback-btn-teacher").html("Add Feedback");

                if (response == "feedback_teacher_added") {
                    $("#alert-messages").html(trigger_toast_message("Your feedback has been already sent", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == 1) {
                    $("#alert-messages").html(trigger_toast_message("Your feedback has been added to the admins.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");
                }
                else {
                    $("#alert-messages").html(trigger_toast_message("Unable to add Feedback.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
            }
        })
    });

    //ADD FEEDBACK FROM STUDENT
    $(document).on("submit", "#add-student-feedback", (e) => {
        e.preventDefault();
        const form = document.getElementById("add-student-feedback");
        const formData = new FormData(form);

        const feedback_title = formData.get("feedback_title");
        const feedback_desc = formData.get("feedback_desc");
        const feedback_type = formData.get("feedback_type");

        $.ajax({
            type: "POST",
            url: "../data/data.add_feedback_student.php",
            data: {
                feedback_title: feedback_title,
                feedback_desc: feedback_desc,
                feedback_type: feedback_type,
                submit: "submit"
            },
            beforeSend: function () {
                $("#add-feedback-btn-student").html(__icon.spinner);
            },
            success: function (response) {
                $("#add-feedback-btn-student").html("Add Feedback");

                if (response == "feedback_student_added") {
                    $("#alert-messages").html(trigger_toast_message("Your feedback has been already sent", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
                else if (response == 1) {
                    $("#alert-messages").html(trigger_toast_message("Your feedback has been added to the admins.", __icon.success_icon, "bg-success", "text-dark"));
                    trigger_toast("trigger-toast");
                }
                else {
                    $("#alert-messages").html(trigger_toast_message("Unable to add Feedback.", __icon.erro_icon, "bg-ternary", "text-white"));
                    trigger_toast("trigger-toast");
                }
            }
        })
    });

    // SELECT SECTION TIMETABLE
    $(document).on("change", "#select-section-timetable", () => {
        const section = $("#select-section-timetable").val();
        __section = $("#select-section-timetable").val();
        section_timetable(__semester, __school_year, section);
    });
    $(document).on("change", "#select-section", () => {
        const section = $("#select-section").val();
        __section = $("#select-section").val();
        section_timetable(__semester, __school_year, section);
    });

    // SELECT TEACHER TIMETABLE
    $(document).on("change", "#select-teacher-timetable", () => {
        const teacher = $("#select-teacher-timetable").val();
        __teacher = $("#select-teacher-timetable").val();
        teacher_timetable(__semester, __school_year, teacher);
    });
    $(document).on("change", "#select-teacher", () => {
        const teacher = $("#select-teacher").val();
        __teacher = $("#select-teacher").val();
        teacher_timetable(__semester, __school_year, teacher);
    });

    // SELECT ROOM TIMETABLE
    $(document).on("change", "#select-room-timetable", () => {
        const room = $("#select-room-timetable").val();
        __room = $("#select-room-timetable").val();
        room_timetable(__semester, __school_year, room);
    });
    $(document).on("change", "#select-room", () => {
        const room = $("#select-room").val();
        __room = $("#select-room").val();
        room_timetable(__semester, __school_year, room);
    });

    // RETRIEVE PRINT TIMETABLE   
    function retrieve_print_timetable() {
        $.ajax({
            type: "GET",
            url: "../data/data.print_timetable.php",
            success: function (response) {
                $("#print-section-timetable").html(response)
                $("#print-section-timetable-teacher").html(response)
                $("#print-teacher-timetable-teacher").html(response)
                $("#print-teacher-timetable").html(response);
                $("#print-student-timetable").html(response);
                $("#print-room-timetable").html(response);
            }
        });
    }
    retrieve_print_timetable();

    // // PRINT SELECT DEPARTMENT
    // $(document).on("change", "#print-select-department", function(){
    //     __department = $(this).val();

    //     retrieve_section_for_plot(__department, __semester, __school_year);
    //     retrieve_teacher_for_plot(__department, __semester, __school_year);
    //     retrieve_room_for_plot(__department, __semester, __school_year);
    // });

    // PRINT SELECT SEMESTER
    $(document).on("change", "#print-select-semester", function () {
        __semester = $(this).val();

        retrieve_section_for_plot(__semester, __school_year);
        retrieve_teacher_for_plot(__semester, __school_year);
        retrieve_room_for_plot(__semester, __school_year);
        retrieve_section_for_plot_teacher(__semester, __school_year);
    });

    // PRINT SELECT SCHOOL YEAR
    $(document).on("change", "#print-select-school-year", function () {
        __school_year = $(this).val();

        retrieve_section_for_plot(__semester, __school_year);
        retrieve_teacher_for_plot(__semester, __school_year);
        retrieve_room_for_plot(__semester, __school_year);
        retrieve_section_for_plot_teacher(__semester, __school_year);
    });

    // PRINT SELECT SEMESTER FOR TEACHER
    $(document).on("change", "#print-select-semester-teacher", function () {
        __semester = $(this).val();

        retrieve_teacher_for_plot(__semester, __school_year);
        retrieve_room_for_plot(__semester, __school_year);
        retrieve_section_for_plot_teacher(__semester, __school_year);
    });

    // PRINT SELECT SCHOOL YEAR FOR TEACHER
    $(document).on("change", "#print-select-school-year-teacher", function () {
        __school_year = $(this).val();

        retrieve_teacher_for_plot(__semester, __school_year);
        retrieve_room_for_plot(__semester, __school_year);
        retrieve_section_for_plot_teacher(__semester, __school_year);
    });



    // SELECT SECTION TIMETABLE FOR PRINT
    $(document).on("change", "#print-select-section", function () {
        var section = $(this).val();

        $.ajax({
            type: "POST",
            url: "../data/data.print_section_timetable.php",
            data: {

                semester: __semester,
                school_year: __school_year,
                section: section,
                submit: "submit"
            },
            success: function (response) {
                $("#print-section-timetable").html(response);
            }
        });
    })

    // SELECT SECTION TIMETABLE FROM TEACHER FOR PRINT
    $(document).on("change", "#print-select-section-teacher", function () {
        var section = $(this).val();

        $.ajax({
            type: "POST",
            url: "../data/data.print_section_timetable_teacher.php",
            data: {

                semester: __semester,
                school_year: __school_year,
                section: section,
                submit: "submit"
            },
            success: function (response) {
                $("#print-section-timetable-teacher").html(response);
            }
        });
    })



    // SELECT TEACHER TIMETABLE FOR PRINT
    $(document).on("change", "#print-select-teacher", function () {
        var teacher = $(this).val();

        $.ajax({
            type: "POST",
            url: "../data/data.print_teacher_timetable.php",
            data: {

                semester: __semester,
                school_year: __school_year,
                teacher: teacher,
                submit: "submit"
            },
            success: function (response) {
                $("#print-teacher-timetable").html(response);
            }
        });
    });


    // SELECT TEACHER TIMETABLE FROM TEACHER FOR PRINT
    $(document).on("change", "#print-select-school-year-teacher", function () {
        var teacher = $(this).val();

        $.ajax({
            type: "POST",
            url: "../data/data.print_teacher_timetable_teacher.php",
            data: {

                semester: __semester,
                school_year: __school_year,
                teacher: teacher,
                submit: "submit"
            },
            success: function (response) {
                $("#print-teacher-timetable-teacher").html(response);
            }
        });
    });
    // FOR STUDENTS TO PRINT TIMETABLE
    $(document).on("change", "#print-select-school-year-student", function () {
        var __school_year_student = $(this).val();
        var __semester_student = $("#print-select-semester-student").val();
        $.ajax({
            type: "POST",
            url: "../data/data.print_student_timetable.php",
            data: {
                semester: __semester_student,
                school_year: __school_year_student,
                submit: "submit"
            },
            success: function (response) {
                $("#print-student-timetable").html(response);
            }
        });
    });

    // SELECT ROOM TIMETABLE FOR PRINT
    $(document).on("change", "#print-select-room", function () {
        var room = $(this).val();

        $.ajax({
            type: "POSt",
            url: "../data/data.print_room_timetable.php",
            data: {

                semester: __semester,
                school_year: __school_year,
                room: room,
                submit: "submit"
            },
            success: function (response) {
                $("#print-room-timetable").html(response);
            }
        });
    })

    // BUTTON FOR PRINT SECTION TIMETABLE
    $(document).on("click", "#print-section", function () {

        printTimetable("print-section-timetable");

    });
    // BUTTON FOR PRINT TEACHER TIMETABLE
    $(document).on("click", "#print-teacher", function () {

        printTimetable("print-teacher-timetable");

    });
    // BUTTON FOR PRINT room TIMETABLE
    $(document).on("click", "#print-room", function () {

        printTimetable("print-room-timetable");

    });

    //BUTTON FOR PRINT SECTION TIMETABLE FROM TEACHER
    $(document).on("click", "#print-section-teacher", function () {

        printTimetable("print-section-timetable-teacher");

    });
    // BUTTON FOR PRINT TEACHER TIMETABLE FROM TEACHER
    $(document).on("click", "#print-teacher-teacher", function () {

        printTimetable("print-teacher-timetable-teacher");

    });

    //BUTTON FOR PRINT SECTION TIMETABLE FROM STUDENT
    $(document).on("click", "#print-section-student", function () {

        printTimetable("print-student-timetable");

    });

    function printTimetable(timetable_id) {
        var makePDF = document.getElementById(timetable_id);
        var windowPrint = window.open("", "", "height=100", "width=100");

        // windowPrint.document.write(makePDF.innerHTML);
        // windowPrint.document.close();
        // windowPrint.focus();
        // windowPrint.print();

        windowPrint.document.write('<html><head>');
        windowPrint.document.write('<style>\n' +
            'table {\n' +
            '  border-collapse: collapse;\n' +
            '  border-spacing: 0;\n' +
            '  width: 100%;\n' +
            '  height: 90%;\n' +
            '  border: 1px solid #ddd;\n' +
            '  font-family: Arial, Helvetica, sans-serif;\n' +
            '}\n' +
            '\n' +
            'th, td {\n' +
            '  text-align: left;\n' +
            '  padding: 16px;\n' +
            '}\n' +
            '\n' +
            'tr:nth-child(even) {\n' +
            '  background-color: #f2f2f2;\n' +
            '}\n' +
            '* {\n' +
            '  -webkit-print-color-adjust: exact !important;\n' +
            '   color-adjust: exact!important;\n' +
            '   print- color-adjust: exact!important;\n' +
            '}</style>');
        windowPrint.document.write('</head><body >');
        windowPrint.document.write(makePDF
            .innerHTML);
        windowPrint.document.write('</body></html>');
        windowPrint.focus();
        windowPrint.print();
        setTimeout(function () {
            windowPrint.close();
        }, 2000);

        return true;
    }

    $(document).on("click", ".sched", function () {
        var schedule_id = $(this).attr("data-id");

        $.ajax({
            type: "POST",
            url: "../data/data.retrieve_update_schedule.php",
            data: {
                schedule_id: schedule_id,
                submit: "submit"
            },
            success: function (response) {
                $("#update-schedule").html(response);
            }
        });
    })

    // RETRIEVE TEACHER FOR REVIEW TEACHER LOADS
    // DEPARTMENT
    // $(document).on("change", "#teacher-load-select-department", function(){
    //     __department = $(this).val();
    //     retrieve_teacher_for_plot(__department, __semester, __school_year);
    // });
    // SEMESTER
    $(document).on("change", "#teacher-load-select-semester", function () {
        __semester = $(this).val();
        retrieve_teacher_for_plot(__semester, __school_year);
    });
    // SCHOOL YEAR
    $(document).on("change", "#teacher-load-select-school-year", function () {
        __school_year = $(this).val();
        retrieve_teacher_for_plot(__semester, __school_year);
    });

    // TEACHER SELECT TO VIEW FOR TEACHER LOAD
    $(document).on("change", "#teacher-load-select-teacher", function () {

        var teacher = $(this).val();

        $.ajax({
            type: "POST",
            url: "../data/data.teacher_load.php",
            data: {

                semester: __semester,
                school_year: __school_year,
                teacher: teacher,
                submit: "submit"
            },
            success: function (response) {
                $("#teacher-load-data").html(response);
            }
        })

    });

    // DELETE SCHEDULE
    $(document).on("click", "#delete-schedule", function (e) {

        e.preventDefault();

        var deleteScheduleID = $(this).attr("data-id");
        var confirmDelete = confirm("Are you sure to delete this schedule?");

        if (confirmDelete) {
            $.ajax({
                type: "POST",
                url: "../data/data.delete_schedule.php",
                data: {
                    deleteScheduleID: deleteScheduleID
                },
                success: function (response) {
                    if (response == 1) {
                        $("#alert-messages").html(trigger_toast_message("Schedule successfully deleted.", __icon.success_icon, "bg-success", "text-white"));
                        trigger_toast("trigger-toast");
                    } else {
                        $("#alert-messages").html(trigger_toast_message("Unable to delete schedule.", __icon.erro_icon, "bg-danger", "text-white"));
                        trigger_toast("trigger-toast");
                    }

                    section_timetable(__semester, __school_year, __section);
                    teacher_timetable(__semester, __school_year, __teacher);
                    room_timetable(__semester, __school_year, __room);
                }
            });
        }

    })

    // UPDATE SCHEDULE 
    $(document).on("submit", "#update-schedule-form", function (e) {
        e.preventDefault();

        var form = document.getElementById("update-schedule-form");
        var formData = new FormData(form);

        const room = formData.get("schedule_room");
        const week_day = formData.get("schedule_week_day");
        const start_time_hour = formData.get("schedule_start_time_hour");
        const start_time_minute = formData.get("schedule_start_time_minute");
        const end_time_hour = formData.get("schedule_end_time_hour");
        const end_time_minute = formData.get("schedule_end_time_minute");

        $.ajax({
            type: "POST",
            url: "../data/data.update_schedule.php",
            data: {
                room: room,
                week_day: week_day,
                start_time_hour: start_time_hour,
                start_time_minute: start_time_minute,
                end_time_hour: end_time_hour,
                end_time_minute: end_time_minute,
                submit: "submit"
            },
            success: function (response) {

            }
        })
    });

});
function sendMessage() {
    const userInput = document.getElementById('userInput');
    const message = userInput.value.trim();

    if (message !== '') {
        const chatMessages = document.getElementById('chatMessages');
        const newMessage = document.createElement('div');
        newMessage.classList.add('message');
        newMessage.textContent = message;
        chatMessages.appendChild(newMessage);

        // Clear the input field after sending the message
        userInput.value = '';
    }
}
// Function to send a message
function sendMessage() {
    const userInput = document.getElementById('userInput');
    const message = userInput.value.trim();

    if (message !== '') {
        const sender = 'You';
        addMessageToChat(sender, message);

        // Send the message to the server using AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'backend.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                // Handle the server's response if needed
            }
        };

        xhr.send(`sender=${encodeURIComponent(sender)}&message=${encodeURIComponent(message)}`);
        userInput.value = '';
    }
}

// Function to add a received message to the chat
function addMessageToChat(sender, message) {
    const chatMessages = document.getElementById('chatMessages');
    const newMessage = document.createElement('div');
    newMessage.classList.add('message');
    newMessage.innerHTML = `<strong>${sender}:</strong> ${message}`;
    chatMessages.appendChild(newMessage);
}

// Function to retrieve messages from the server and update the chat
// Function to retrieve messages from the server and update the message list
function fetchMessages() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'backend.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const messages = JSON.parse(xhr.responseText);

                // Add each message to the message list
                const messageList = document.getElementById('messageList');
                messageList.innerHTML = '';

                messages.forEach(({ sender, message }) => {
                    const messageItem = document.createElement('div');
                    messageItem.classList.add('message-item');
                    messageItem.innerHTML = `<strong>${sender}</strong>: ${message}`;
                    messageList.appendChild(messageItem);
                });
            } else {
                console.error('Failed to fetch messages from the server.');
            }
        }
    };

    xhr.send();
}
//Filtering the Announcement Dates
$(document).ready(function () {
    // Handler for the form submission
    $("#add-announcement-form-filter").submit(function (event) {
        event.preventDefault();

        var startDate = $("#announcement_filter_start_date").val();
        var endDate = $("#announcement_filter_end_date").val();

        // Perform filtering
        $("#datatable-announcement tbody tr").hide();
        $("#datatable-announcement tbody tr").each(function () {
            var rowStartDate = $(this).find("td:eq(3)").text(); // Column index 3 is start date
            var rowEndDate = $(this).find("td:eq(4)").text();   // Column index 4 is end date

            if ((startDate === "" || rowStartDate >= startDate) &&
                (endDate === "" || rowEndDate <= endDate)) {
                $(this).show();
            }
        });
    });
});

//Resetting the Announcement Dates
$(document).ready(function () {
    // Handler for the form submission
    $("#add-announcement-form-filter").submit(function (event) {
        event.preventDefault();
        // ... (existing filtering code)

        // Show the reset button when filtering is applied
        $("#reset-filter-btn").show();
    });

    // Handler for the reset button
    $("#reset-filter-btn").click(function () {
        // Clear input fields
        $("#announcement_filter_start_date").val("");
        $("#announcement_filter_end_date").val("");

        // Show all rows
        $("#datatable-announcement tbody tr").show();

        // Hide the reset button
        $(this).hide();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const feedbackFormFilter = document.getElementById("feedback-form-filter");
    const feedbackBtnFilter = document.getElementById("feedback-btn-filter");
    const resetBtn = document.getElementById("reset-feedback-filter-btn");
    const feedbackRows = document.querySelectorAll("#datatable-feedback tbody tr");

    feedbackFormFilter.addEventListener("submit", function (e) {
        e.preventDefault();

        // Get selected filter values
        const userTypeFilter = document.getElementById("feedback_user_type_admin").value;
        const feedbackTypeFilter = document.getElementById("feedback_type_admin_filter").value;

        // Iterate through rows and apply filters
        feedbackRows.forEach(row => {
            const userTypeCell = row.querySelector("td:nth-child(4)").textContent;
            const feedbackTypeCell = row.querySelector("td:nth-child(3)").textContent;

            if (
                (userTypeFilter === "Select User Type" || userTypeCell === userTypeFilter) &&
                (feedbackTypeFilter === "Select Feedback Type" || feedbackTypeCell === feedbackTypeFilter)
            ) {
                row.style.display = "table-row";
            } else {
                row.style.display = "none";
            }
        });
    });

    resetBtn.addEventListener("click", function () {
        // Reset filter values and show all rows
        document.getElementById("feedback_user_type_admin").value = "Select User Type";
        document.getElementById("feedback_type_admin_filter").value = "Select Feedback Type";

        feedbackRows.forEach(row => {
            row.style.display = "table-row";
        });
    });
});

//   // Function to check screen resolution and load the appropriate sidebar file
// function loadSidebar() {
//     const sidebarContainer = document.getElementById("sidebarContainer");

//     // Check the screen width to decide which sidebar to load
//     if (window.innerWidth >= 768) {
//       // Larger resolutions, load sidebar_large.php
//       sidebarContainer.innerHTML = '<?php include "../Components/Sidebar.php"; ?>';
//     } else {
//       // Smaller resolutions, load sidebar_small.php
//       sidebarContainer.innerHTML = '<?php include "../Components/Sidebar_small.php"; ?>';
//     }
//   }

//   // Call the function when the page loads
//   document.addEventListener("DOMContentLoaded", loadSidebar);

//   // Recheck the screen resolution when the window is resized
//   window.addEventListener("resize", loadSidebar);
$(document).ready(function () {
    //jquery for toggle sub menus
    $('.sub-btn').click(function () {
        $(this).next('.sub-menu').slideToggle();
        $(this).find('.dropdown').toggleClass('rotate');
    });

    //jquery for expand and collapse the sidebar
    $('.menu-btn').click(function () {
        $('.side-bar').addClass('active');
        $('.menu-btn').css("visibility", "hidden");
    });

    $('.close-btn').click(function () {
        $('.side-bar').removeClass('active');
        $('.menu-btn').css("visibility", "visible");
    });
});
