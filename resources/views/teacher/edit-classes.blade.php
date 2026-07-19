<button type="button" id="editBtn" class="add-btn" style="margin:16px 0;" onclick="enterEditMode()">
    <i class="fa-solid fa-pen"></i> Edit Schedule
</button>

@foreach(['morning' => $morningPeriods, 'afternoon' => $afternoonPeriods] as $shiftKey => $periods)
<div class="timetable-container shift-grid" data-shift="{{ $shiftKey }}" style="{{ $shiftKey === 'afternoon' ? 'display:none;' : '' }}">
    <table class="schedule-table-grid">
        <thead>
            <tr>
                <th class="time-head">Time</th>
                @foreach($days as $day)
                    <th>{{ strtoupper($day) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($periods as $row)
                @if(isset($row['break']))
                    <tr class="break-row">
                        <td colspan="6"><i class="fa-regular fa-clock"></i> {{ $row['break'] }}</td>
                    </tr>
                @else
                    <tr>
                        <td class="time-box">{{ $row['label'] }}<br><small>{{ $row['time'] }}</small></td>
                        @foreach($row['slots'] as $slot)
                            <td>
                                @if($slot)
                                    @php [$subj, $initials, $color] = explode('|', $slot); @endphp
                                    <div class="subject-card subject-{{ $color }}">
                                        <strong>{{ $subj }}</strong><br>
                                        <span>{{ $initials }}</span>
                                    </div>
                                @else
                                    <div class="empty-slot" onclick="openSlotModal(this)"><i class="fa-solid fa-plus"></i></div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endforeach

<div class="grid-actions" id="gridActions" style="display:none;">
    <button type="button" class="save-btn" onclick="applyChanges()"><i class="fa-solid fa-floppy-disk"></i> Apply Changes</button>
    <button type="button" class="cancel-btn" onclick="resetGrid()">Reset Grid</button>
</div>

<!-- Add Subject Modal -->
<div id="slotModal" class="slot-modal-overlay" style="display:none;">
    <div class="slot-modal">
        <h3>Add Subject</h3>
        <div class="form-group">
            <label>Subject</label>
            <select id="modalSubject">
                <option value="Chemistry|chemistry">Chemistry</option>
                <option value="Math|math">Math</option>
                <option value="Physics|physics">Physics</option>
                <option value="Biology|biology">Biology</option>
                <option value="Khmer|khmer">Khmer</option>
                <option value="History|khmer">History</option>
            </select>
        </div>
        <div class="form-group">
            <label>Teacher Initials</label>
            <input type="text" id="modalInitials" placeholder="e.g. SK" maxlength="3">
        </div>
        <div class="form-actions">
            <button type="button" class="cancel-btn" onclick="closeSlotModal()">Cancel</button>
            <button type="button" class="save-btn" onclick="confirmAddSubject()">Add</button>
        </div>
    </div>
</div>