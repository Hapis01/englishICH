@extends('layouts.teacher')

@section('title', 'Submissions - ' . $assessment->title)
@section('page-title', 'Submissions & Grades')
@section('page-subtitle', 'Grading for: ' . $assessment->title)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('teacher.assessments.index') }}" class="text-emerald-600 hover:text-emerald-700 flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        <span>Back to assessments</span>
    </a>
</div>

<!-- Overview Stats -->
@php
    $totalStudents = $enrolledStudents->count();
    $submittedCount = $submissions->whereNotNull('file_path')->count();
    $gradedCount = $submissions->whereNotNull('score')->count();
    $missingCount = $totalStudents - $submittedCount;
@endphp
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <p class="text-sm font-medium text-gray-500">Total Enrolled</p>
        <p class="text-2xl font-bold text-gray-900">{{ $totalStudents }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <p class="text-sm font-medium text-gray-500">Submitted</p>
        <p class="text-2xl font-bold text-blue-600">{{ $submittedCount }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <p class="text-sm font-medium text-gray-500">Missing</p>
        <p class="text-2xl font-bold text-red-600">{{ $missingCount }}</p>
    </div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <p class="text-sm font-medium text-gray-500">Graded</p>
        <p class="text-2xl font-bold text-green-600">{{ $gradedCount }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600">Student Name</th>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600">Status</th>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600">File & Notes</th>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600">Grade</th>
                <th class="px-6 py-3 text-sm font-semibold text-gray-600 text-right">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($enrolledStudents as $student)
                @php
                    $submission = $submissions->where('student_id', $student->id)->first();
                @endphp
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $student->name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    @if($submission && $submission->file_path)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Submitted</span>
                        <div class="text-xs text-gray-500 mt-1">{{ $submission->submitted_at->format('M d, Y H:i') }}</div>
                        @if($submission->submitted_at->gt($assessment->due_date->setTimeFromTimeString($assessment->due_time ?? '23:59:59')))
                            <span class="text-xs text-red-600 font-semibold block">Late</span>
                        @endif
                    @elseif($submission && $submission->score !== null)
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Manual Grade</span>
                    @else
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Missing</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($submission && $submission->file_path)
                        <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="text-blue-600 hover:underline text-sm font-medium">View File</a>
                    @else
                        <span class="text-gray-400 italic text-sm">No file</span>
                    @endif

                    @if($submission && $submission->notes)
                        <div class="text-xs text-gray-500 mt-1 italic">"{{ Str::limit($submission->notes, 50) }}"</div>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($submission && $submission->score !== null)
                        <div class="flex flex-col space-y-1">
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded font-semibold w-max">
                                {{ floatval($submission->score) }} / {{ floatval($submission->maximum_score ?? 100) }}
                            </span>
                            @if($submission->is_published)
                                <span class="text-xs font-semibold text-green-600">Published</span>
                            @else
                                <span class="text-xs font-semibold text-yellow-600">Draft</span>
                            @endif
                        </div>
                    @else
                        <span class="text-gray-400 italic text-sm">Not Graded</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    @if($submission && $submission->file_path)
                        <button onclick="openGradeModal({{ $submission->id }}, '{{ $student->name }}', '{{ $submission->score }}', '{{ $submission->maximum_score ?? 100 }}', `{{ htmlspecialchars($submission->notes) }}`, {{ $submission->is_published ? 'true' : 'false' }}, true)" class="text-emerald-600 hover:text-emerald-800 text-sm font-medium">
                            {{ $submission->score !== null ? 'Edit Grade' : 'Grade' }}
                        </button>
                    @else
                        <button onclick="openGradeModal({{ $student->id }}, '{{ $student->name }}', '{{ $submission->score ?? '' }}', '{{ $submission->maximum_score ?? 100 }}', `{{ htmlspecialchars($submission->notes ?? '') }}`, {{ ($submission && $submission->is_published) ? 'true' : 'false' }}, false)" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            {{ ($submission && $submission->score !== null) ? 'Edit Manual Grade' : 'Add Manual Grade' }}
                        </button>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-gray-500">No students enrolled in this class.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Grading Modal -->
<div id="gradeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Grade: <span id="studentName"></span></h3>
        </div>
        <form id="gradeForm" method="POST">
            @csrf
            <!-- Need to inject student_id for manual grading -->
            <input type="hidden" name="student_id" id="studentIdInput">
            <div class="p-6 space-y-4">
                <div class="flex space-x-4">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Score</label>
                        <input type="number" id="scoreInput" name="score" min="0" step="0.01" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Max Score</label>
                        <input type="number" id="maxScoreInput" name="maximum_score" min="1" step="0.01" value="100" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Feedback (Optional)</label>
                    <textarea id="feedbackInput" name="notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent"></textarea>
                </div>
                <div class="flex items-center mt-2">
                    <input type="checkbox" id="isPublishedInput" name="is_published" value="1" class="h-4 w-4 text-[#10B981] focus:ring-[#10B981] border-gray-300 rounded">
                    <label for="isPublishedInput" class="ml-2 block text-sm text-gray-900">
                        Publish Grade (Student can see it)
                    </label>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button" onclick="closeGradeModal()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-[#10B981] text-white rounded-lg hover:bg-[#0B4637] transition">Save Grade</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openGradeModal(id, studentName, currentScore, maxScore, currentFeedback, isPublished, isSubmissionUpdate) {
        document.getElementById('studentName').innerText = studentName;
        document.getElementById('scoreInput').value = currentScore || '';
        document.getElementById('maxScoreInput').value = maxScore || '100';
        document.getElementById('feedbackInput').value = currentFeedback || '';
        document.getElementById('isPublishedInput').checked = isPublished;
        
        if (isSubmissionUpdate) {
            document.getElementById('studentIdInput').value = '';
            document.getElementById('gradeForm').action = `/teacher/assessment-submissions/${id}/grade`;
        } else {
            // For manual grade, the ID passed is the student_id
            document.getElementById('studentIdInput').value = id;
            document.getElementById('gradeForm').action = `{{ route('teacher.assessments.manual-grade', $assessment) }}`;
        }
        
        document.getElementById('gradeModal').classList.remove('hidden');
    }

    function closeGradeModal() {
        document.getElementById('gradeModal').classList.add('hidden');
    }
</script>
@endpush
