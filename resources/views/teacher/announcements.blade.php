@extends('layouts.teacher')

@section('content')

<div class="announcement-page">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span>Portal</span>
        <i class="fa-solid fa-angle-right"></i>
        <span>Announcements</span>
    </div>

    <!-- Header -->
    <div class="announcement-header">

        <div>

            <h1>Announcements</h1>

            <p>Stay updated with the latest school news and notices.</p>

        </div>

        <button class="view-btn">
            <i class="fa-solid fa-bullhorn"></i>
            View Announcements
        </button>

    </div>

    <!-- Filter -->
    <div class="filter-card">

        <span>Filter Category:</span>

        <button class="active">All</button>
        <button>Events</button>
        <button>Academic</button>
        <button>Important</button>

    </div>

</div>


<!-- ================= Announcement Card 1 ================= -->

<div class="announcement-card">

    <div class="announcement-icon blue">
        <i class="fa-solid fa-flask"></i>
    </div>

    <div class="announcement-content">

        <div class="announcement-top">

            <h3>Annual STEM & Science Fair 2024</h3>

            <i class="fa-solid fa-ellipsis-vertical"></i>

        </div>

        <div class="announcement-info">

            <span>
                <i class="fa-regular fa-calendar"></i>
                Oct 20, 2023
            </span>

            <span>
                <i class="fa-regular fa-user"></i>
                Posted by Dr. Vannak
            </span>

        </div>

        <p>
            Registration is now open for the annual Science Fair next Friday.
            We encourage all students from Grade 9–12 to showcase their
            innovative projects. The event will be held in the main gymnasium
            starting from 9:00 AM. Refreshments will be provided for all
            faculty and judges.
        </p>

        <div class="announcement-footer">

            <span class="tag student">
                Students
            </span>

            <span class="priority high">
                ● HIGH PRIORITY
            </span>

        </div>

    </div>

</div>


<!-- ================= Announcement Card 2 ================= -->

<div class="announcement-card">

    <div class="announcement-icon red">
        <i class="fa-solid fa-users"></i>
    </div>

    <div class="announcement-content">

        <div class="announcement-top">

            <h3>Emergency Faculty Meeting: Curriculum Review</h3>

            <i class="fa-solid fa-ellipsis-vertical"></i>

        </div>

        <div class="announcement-info">

            <span>
                <i class="fa-regular fa-calendar"></i>
                Oct 18, 2023
            </span>

            <span>
                <i class="fa-regular fa-user"></i>
                Posted by Principal's Office
            </span>

        </div>

        <p>
            The monthly faculty meeting originally scheduled for Monday has
            been moved to Wednesday at 4:00 PM in the Main Hall. Attendance
            is mandatory for all department heads.
        </p>

        <div class="announcement-footer">

            <span class="tag teacher">
                Teachers
            </span>

            <span class="priority medium">
                ● MEDIUM PRIORITY
            </span>

        </div>

    </div>

</div>


<!-- ================= Announcement Card 3 ================= -->

<div class="announcement-card">

    <div class="announcement-icon green">
        <i class="fa-solid fa-bell"></i>
    </div>

    <div class="announcement-content">

        <div class="announcement-top">

            <h3>National Holiday Observance: Independence Day</h3>

            <i class="fa-solid fa-ellipsis-vertical"></i>

        </div>

        <div class="announcement-info">

            <span>
                <i class="fa-regular fa-calendar"></i>
                Oct 15, 2023
            </span>

            <span>
                <i class="fa-regular fa-user"></i>
                Posted by HR Department
            </span>

        </div>

        <p>
            The school will be closed on November 9th in observance of
            Independence Day. Classes will resume as normal on the following
            day. We wish all students and faculty a safe and peaceful holiday.
        </p>

        <div class="announcement-footer">

            <span class="tag everyone">
                Everyone
            </span>

            <span class="priority info">
                ● INFORMATIONAL
            </span>

        </div>

    </div>

</div>


<!-- ================= Announcement Card 4 ================= -->

<div class="announcement-card">

    <div class="announcement-icon navy">
        <i class="fa-regular fa-clipboard"></i>
    </div>

    <div class="announcement-content">

        <div class="announcement-top">

            <h3>Grade 12 Mock Exam Schedule & Logistics</h3>

            <i class="fa-solid fa-ellipsis-vertical"></i>

        </div>

        <div class="announcement-info">

            <span>
                <i class="fa-regular fa-calendar"></i>
                Oct 12, 2023
            </span>

            <span>
                <i class="fa-regular fa-user"></i>
                Posted by Academic Affairs
            </span>

        </div>

        <p>
            The schedule for the upcoming Grade 12 mock examinations has been
            finalized. Students should check their exam room assignments and
            arrival times. Please bring your student ID card and required
            stationery. Mobile phones are not allowed during the examination.
        </p>

        <div class="announcement-footer">

            <span class="tag academic">
                Academic
            </span>

            <span class="priority normal">
                ● NORMAL PRIORITY
            </span>

        </div>

    </div>

</div>

<!-- ================= Pagination ================= -->

<div class="announcement-pagination">

   

    <div class="page-number">

      

    </div>

   

</div>


@endsection