@extends('layouts.teacher')

@section('content')
    

<div class="schedule-page">

    <!-- ================= Header ================= -->

    <div class="schedule-header">

        <div class="header-left">

            <h1>Weekly Class Schedule</h1>

            <p>Managing Grade 12 - Section A weekly schedule</p>

        </div>

        <div class="header-right">

            <!-- Select Class -->

            <div class="header-group">

                <label>SELECT CLASS</label>

                <select>
                    <option>Grade 12 - A</option>
                    <option>Grade 12 - B</option>
                    <option>Grade 11 - A</option>
                </select>

            </div>

            <!-- Shift -->

            <div class="header-group">

                <label>SHIFT SELECTION</label>

                <div class="shift-box">

                    <button class="shift-btn active">
                        Morning<br>shift
                    </button>

                    <button class="shift-btn">
                        Afternoon<br>shift
                    </button>

                    <button class="setting-btn">
                        <i class="fa-solid fa-gear"></i>
                    </button>

                </div>

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

            <tr>

                <td class="period">
                    <strong>P3</strong>
                    <span>9:10 - 10:00</span>
                </td>

                <td>
                    <div class="card math">
                        <h4>Math</h4>
                        <small>BK</small>
                    </div>
                </td>

                <td>
                    <div class="card science">
                        <h4>Biology</h4>
                        <small>TM</small>
                    </div>
                </td>

                <td>
                    <div class="empty-card">
                        +
                    </div>
                </td>

                <td>
                    <div class="card other">
                        <h4>Physics</h4>
                        <small>LV</small>
                    </div>
                </td>

                <td>
                    <div class="card science">
                        <h4>Biology</h4>
                        <small>TM</small>
                    </div>
                </td>

            </tr>

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




<div class="control-panel">

    <div class="control-item">

    </div>

    <div class="control-buttons">

        <button class="save-btn">
            <i class="fa-regular fa-floppy-disk"></i>
            Save Timetable
        </button>

        <button class="reset-btn">
            Reset
        </button>

    </div>

</div>

<!-- ================= Subject Modal ================= -->

<div class="modal" id="subjectModal">

    <div class="modal-content">

        <div class="modal-header">
            <h2>Add Subject</h2>

            <span class="close-btn">&times;</span>
        </div>

        <div class="modal-body">

            <div class="form-group">
                <label>Subject Name</label>
                <input type="text" placeholder="Mathematics">
            </div>

            <div class="form-group">
                <label>Teacher</label>
                <input type="text" placeholder="Mr. Sok">
            </div>

            <div class="form-group">
                <label>Room</label>
                <input type="text" placeholder="Room 302">
            </div>

            <div class="form-group">
                <label>Color</label>

                <select>
                    <option>Blue</option>
                    <option>Green</option>
                    <option>Orange</option>
                    <option>Purple</option>
                </select>

            </div>

            <button class="save-subject">
                Save Subject
            </button>

        </div>

    </div>

</div>


@endsection