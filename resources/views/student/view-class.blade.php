@extends('layouts.student')
@section('content')


        <div class="profile-card">


            <div class="profile-top">

                <div class="profile-photo">

                    <img src="{{ asset('images/student1.jpg') }}" alt="">

                </div>

                <div class="profile-info">

                    <h2>Phearun Khun</h2>

                    <span class="badge">
                        Mathematics
                    </span>

                </div>

                <div class="profile-details">

                    <div>

                        <small>TEACHER ID</small>

                        <h4>Math2026001</h4>

                    </div>

                    <div>

                        <small>JOIN DATE</small>

                        <h4>January 2026</h4>

                    </div>

                </div>

            </div>

        </div>

        <div class="student-table">

        <table>

        <thead>

        <tr>

        <th>STUDENT NAME & ID</th>

       

        </tr>

        </thead>

        <tbody>

        <tr>

        <td>

        <div class="student-item">

        <img src="{{ asset('images/student1.jpg') }}">

        <div>

        <h4>Kalyan Bopha</h4>

        <p>ID: 2023XXXX</p>

        </div>

        </div>

        </td>

        

        </tr>

        <tr>

        <td>

        <div class="student-item">

        <img src="{{ asset('images/student2.jpg') }}">

        <div>

        <h4>Dara Phirun</h4>

        <p>ID: 2023XXXX</p>

        </div>

        </div>

        </td>

       

        </tr>

        <tr>

        <td>

        <div class="student-item">

        <img src="{{ asset('images/student3.jpg') }}">

        <div>

        <h4>Vannak Chantrea</h4>

        <p>ID: 2023XXXX</p>

        </div>

        </div>

        </td>

        

        </tr>

        <tr>

        <td>

        <div class="student-item">

        <img src="{{ asset('images/student4.jpg') }}">

        <div>

        <h4>Visal Rattanak</h4>

        <p>ID: 2023XXXX</p>

        </div>

        </div>

        </td>

        

        </tr>

        <tr>

        <td>

        <div class="student-item">

        <img src="{{ asset('images/student5.jpg') }}">

        <div>

        <h4>Serey Sokha</h4>

        <p>ID: 2023XXXX</p>

        </div>

        </div>

        </td>

        

        </tr>

        <tr>

        <td>

        <div class="student-item">

        <img src="{{ asset('images/student6.jpg') }}">

        <div>

        <h4>Bruno Mars</h4>

        <p>ID: 2023XXXX</p>

        </div>

        </div>

        </td>

        

        </tr>

        </tbody>

        </table>

        </div>


@endsection