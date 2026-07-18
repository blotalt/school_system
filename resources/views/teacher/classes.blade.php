@extends('layouts.teacher')

@section('content')
    

<div class="schedule-page">

    <!-- ================= Header ================= -->

    <div class="schedule-header">

        <div class="header-left">
    <h1>Weekly Class Schedule</h1>

        <p>Manage your assigned classes</p>
  
</div>

        <div class="header-right">

            <!-- Select Class -->

            <div class="header-group">

                <label> SELECT CLASS</label>

                <select>
                    <option>Grade 12 - ALL</option>
                    <option>Grade 11</option>
                    <option>Grade 10</option>
                </select>

            </div>

            <div class="header-group">
                <label>SHIFT SELECTION</label>
            <div class="shift-toggle">

    <button id="morningBtn" class="shift-btn active" data-shift="morning">
        Morning shift
    </button>

    <button id="afternoonBtn" class="shift-btn" data-shift="afternoon">
        Afternoon shift
    </button>

        </div>

        </div>

    </div>

    <!-- Part 2 will start here -->

</div>


<!-- ================= Weekly Timetable ================= -->

<div class="schedule-table">

    <table>

        <thead>
            <tr>
                <th class="time-head">Time</th>
                <th>MONDAY</th>
                <th>TUESDAY</th>
                <th>WEDNESDAY</th>
                <th>THURSDAY</th>
                <th>FRIDAY</th>
            </tr>
        </thead>

        <tbody>

            <!-- P1 -->

            <tr>

                <td class="period">
                    <strong>P1</strong>
                    <span>7:10 - 8:00</span>
                </td>

                <td>
                    <div class="card science">
                        <h4>Chemistry</h4>
                        <small>SK</small>
                    </div>
                </td>

                <td>
                    <div class="card math">
                        <h4>Math</h4>
                        <small>BK</small>
                    </div>
                </td>

                <td>
                    <div class="card science">
                        <h4>Chemistry</h4>
                        <small>SK</small>
                    </div>
                </td>

                <td>
                    <div class="card math">
                        <h4>Math</h4>
                        <small>BK</small>
                    </div>
                </td>

                <td>
                    <div class="empty-card">
                        +
                    </div>
                </td>

            </tr>

            <!-- Break -->

            <tr class="break-row">

                <td colspan="6">
                    ☕ 10 MIN BREAK (8:00 - 8:10 AM)
                </td>

            </tr>

            <!-- P2 -->

            <tr>

                <td class="period">
                    <strong>P2</strong>
                    <span>8:10 - 9:00</span>
                </td>

                <td>
                    <div class="card language">
                        <h4>Khmer</h4>
                        <small>SR</small>
                    </div>
                </td>

                <td>
                    <div class="card other">
                        <h4>Physics</h4>
                        <small>LV</small>
                    </div>
                </td>

                <td>
                    <div class="card other">
                        <h4>Physics</h4>
                        <small>LV</small>
                    </div>
                </td>

                <td>
                    <div class="card language">
                        <h4>Khmer</h4>
                        <small>SR</small>
                    </div>
                </td>

                <td>
                    <div class="card math">
                        <h4>Math</h4>
                        <small>BK</small>
                    </div>
                </td>

            </tr>

            <!-- Break -->

            <tr class="break-row">

                <td colspan="6">
                    ☕ 10 MIN BREAK (9:00 - 9:10 AM)
                </td>

            </tr>

            <!-- P3 -->

           

            <!-- Break -->

            <tr class="break-row">

                <td colspan="6">
                    ☕ 10 MIN BREAK (10:00 - 10:10 AM)
                </td>

            </tr>

            <!-- P4 -->

            <tr>

                <td class="period">
                    <strong>P4</strong>
                    <span>10:10 - 11:00</span>
                </td>

                <td>
                    <div class="card other">
                        <h4>Physics</h4>
                        <small>LV</small>
                    </div>
                </td>

                <td>
                    <div class="card language">
                        <h4>Khmer</h4>
                        <small>SR</small>
                    </div>
                </td>

                <td>
                    <div class="card math">
                        <h4>Math</h4>
                        <small>BK</small>
                    </div>
                </td>

                <td>
                    <div class="card science">
                        <h4>Chemistry</h4>
                        <small>SK</small>
                    </div>
                </td>

                <td>
                    <div class="card language">
                        <h4>History</h4>
                        <small>NN</small>
                    </div>
                </td>

            </tr>

            <!-- Break -->

            <tr class="break-row">

                <td colspan="6">
                    ☕ 10 MIN BREAK (11:00 - 11:10 AM)
                </td>

            </tr>

            <!-- P5 -->

            <tr>

                <td class="period">
                    <strong>P5</strong>
                    <span>11:10 - 11:50</span>
                </td>

                <td>
                    <div class="card language">
                        <h4>Khmer Lit</h4>
                        <small>SR</small>
                    </div>
                </td>

                <td>
                    <div class="card science">
                        <h4>Geography</h4>
                        <small>CH</small>
                    </div>
                </td>

                <td>
                    <div class="card other">
                        <h4>Civics</h4>
                        <small>KO</small>
                    </div>
                </td>

                <td>
                    <div class="card math">
                        <h4>English</h4>
                        <small>JS</small>
                    </div>
                </td>

                <td>
                    <div class="card science">
                        <h4>Earth Sci</h4>
                        <small>LV</small>
                    </div>
                </td>

            </tr>

        </tbody>

    </table>

</div>




   

        

      

    </div>

</div>



</div>


@endsection