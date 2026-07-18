<?php

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed(); // runs DatabaseSeeder (subjects → teachers → classes → students → announcements)
});

it('renders every student portal page for a seeded student', function () {
    $student = User::where('email', 'student@school.test')->firstOrFail();
    $this->actingAs($student);

    $this->get('/student')->assertOk();
    $this->get('/student/grades')->assertOk();
    $this->get('/student/homework')->assertOk();
    $this->get('/student/schedule')->assertOk();
    $this->get('/student/attendance')->assertOk();
});

it('renders the admin dashboard and announcements feed', function () {
    $admin = User::where('email', 'admin@school.test')->firstOrFail();
    $this->actingAs($admin);

    $this->get('/admin')->assertOk();
    $this->get('/admin/announcements')->assertOk()->assertSee('Mid-Term Exam Schedule Released');
});

it('renders the teacher dashboard', function () {
    $teacher = User::where('email', 'teacher@school.test')->firstOrFail();
    $this->actingAs($teacher);

    $this->get('/teacher')->assertOk();
});

it('enforces the permission model: student blocked from admin, no student write routes', function () {
    $student = User::where('email', 'student@school.test')->firstOrFail();
    $this->actingAs($student);

    $this->get('/admin')->assertForbidden();           // role middleware = 403
    $this->post('/student/grades')->assertStatus(405); // read-only: GET-only route, no POST handler
});

it('lets an admin post an announcement', function () {
    $admin = User::where('email', 'admin@school.test')->firstOrFail();
    $this->actingAs($admin);

    $this->post('/admin/announcements', [
        'title'    => 'Smoke Test Announcement',
        'body'     => 'Hello world',
        'audience' => 'everyone',
        'priority' => 'normal',
    ])->assertRedirect(route('admin.announcements.index'));

    expect(Announcement::where('title', 'Smoke Test Announcement')->exists())->toBeTrue();
});
