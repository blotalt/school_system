@extends('layouts.student')

@section('content')

<div class="student-announcement-page">

    <!-- Welcome Banner -->

    <div class="student-banner">

        <div class="student-left">

            <div class="student-avatar"></div>

            <div>

                <h1>Hello, Bruno Mars</h1>

                <div class="student-tags">

                    <span>Grade 12 - A</span>

                    <span>Science Track</span>

                </div>

            </div>

        </div>

        <div class="student-date">

            <small>CURRENT DATE</small>

            <h2>July 4, 2026</h2>

        </div>

    </div>

    <!-- Page Header -->

<div class="announcement-top">

    <div>

        <p class="breadcrumb">
            System >
            <strong>Announcements</strong>
        </p>

        <h2>Announcements</h2>

    </div>

    <div class="announcement-filter">

        <span>FILTER:</span>

        <button class="active">All</button>

        <button>Events</button>

        <button>Academic</button>

        <button>Important</button>

    </div>

</div>

<!-- Announcement Card -->

<div class="announcement-card">

    <div class="announcement-icon">

        <i class="fa-solid fa-flask"></i>

    </div>

    <div class="announcement-content">

        <div class="announcement-title">

            <h3>Upcoming Science Fair</h3>

            <span class="tag students">
                STUDENTS
            </span>

            <span class="priority high">
                ● PRIORITY: HIGH
            </span>

        </div>

        <div class="announcement-meta">

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

            Join us for the annual Science Fair next Friday.
            Registration is now open for all students who wish
            to showcase their innovative projects. The event
            will be held in the main gymnasium starting from
            9:00 AM. Refreshments will be provided for all
            participants and guests.

        </p>

    </div>

    <div class="announcement-menu">

        <i class="fa-solid fa-ellipsis-vertical"></i>

    </div>

</div>

<!-- Announcement Card 2 -->

<div class="announcement-card">

    <div class="announcement-icon">
        <i class="fa-regular fa-calendar-check"></i>
    </div>

    <div class="announcement-content">

        <div class="announcement-title">

            <h3>Grade 12 Mock Exam Schedule</h3>

            <span class="tag academic">
                ACADEMIC
            </span>

            <span class="priority urgent">
                URGENT
            </span>

        </div>

        <div class="announcement-meta">

            <span>
                <i class="fa-regular fa-calendar"></i>
                Oct 12, 2023
            </span>

            <span>
                <i class="fa-regular fa-building"></i>
                Academic Affairs
            </span>

        </div>

        <p>

            The schedule for the upcoming mock exams has been finalized.
            Please check your portal for room assignments and timing.
            Students are reminded to bring their IDs and arrive
            15 minutes before the examination starts.

        </p>

    </div>

    <div class="announcement-menu">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </div>

</div>

<!-- Announcement Card 3 -->

<div class="announcement-card">

    <div class="announcement-icon">
        <i class="fa-solid fa-bell"></i>
    </div>

    <div class="announcement-content">

        <div class="announcement-title">

            <h3>Public Holiday Notice</h3>

            <span class="tag general">
                GENERAL
            </span>

            <span class="priority info">
                INFORMATIONAL
            </span>

        </div>

        <div class="announcement-meta">

            <span>
                <i class="fa-regular fa-calendar"></i>
                Oct 15, 2023
            </span>

            <span>
                <i class="fa-regular fa-building"></i>
                Principal's Office
            </span>

        </div>

        <p>

            The school will be closed on November 9th in observance
            of Independence Day. Classes will resume as normal on the
            following day.

        </p>

    </div>

    <div class="announcement-menu">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </div>

</div>

<!-- Announcement Card 4 -->

<div class="announcement-card">

    <div class="announcement-icon">
        <i class="fa-solid fa-futbol"></i>
    </div>

    <div class="announcement-content">

        <div class="announcement-title">

            <h3>Inter-School Sports Meet</h3>

            <span class="tag events">
                EVENTS
            </span>

            <span class="priority normal">
                NORMAL
            </span>

        </div>

        <div class="announcement-meta">

            <span>
                <i class="fa-regular fa-calendar"></i>
                Oct 18, 2023
            </span>

            <span>
                <i class="fa-regular fa-user"></i>
                Sports Department
            </span>

        </div>

        <p>

            Students interested in football, volleyball, basketball,
            and athletics are invited to register for the annual
            Inter-School Sports Competition.

        </p>

    </div>

    <div class="announcement-menu">
        <i class="fa-solid fa-ellipsis-vertical"></i>
    </div>

</div>

@endsection