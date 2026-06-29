@extends('layouts.admin')

@section('title', 'Certificate Management')
@section('page-title', 'Certificates')
@section('page-subtitle', 'Manage and publish student certificates')

@section('content')
<div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6">
    <!-- List of Certificates -->
    <div class="flex-1 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Published Certificates</h3>
            <form method="GET" action="{{ route('admin.certificates') }}" class="flex items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="text-sm px-3 py-1.5 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-[#10B981] focus:border-transparent">
                <button type="submit" class="px-3 py-1.5 bg-[#0B4637] text-white rounded-r-lg hover:bg-[#10B981] transition text-sm">
                    Search
                </button>
            </form>
        </div>
        <div class="overflow-x-auto flex-1">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Cert No.</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Class</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($certificates as $cert)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $cert->certificate_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-medium text-gray-900">{{ $cert->student->name ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $cert->schoolClass->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                {{ $cert->final_score }} ({{ $cert->letter_grade }})
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full {{ $cert->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($cert->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm flex items-center space-x-3">
                                @if(Auth::user()->role !== 'owner')
                                <form action="{{ route('admin.certificates.revoke', $cert->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-[{{ $cert->status === 'active' ? '#dc2626' : '#10B981' }}] hover:underline font-medium">
                                        {{ $cert->status === 'active' ? 'Revoke' : 'Activate' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.certificates.destroy', $cert->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this certificate?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline font-medium">
                                        Delete
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500 text-sm">No certificates found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($certificates->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $certificates->links() }}
            </div>
        @endif
    </div>

    <!-- Pending Certificates -->
    <div class="w-full md:w-1/3 bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Pending Certificates</h3>
            <p class="text-xs text-gray-500 mt-1">Grades published by teachers waiting for certificate generation.</p>
        </div>
        
        <div class="overflow-y-auto max-h-[600px] p-4 space-y-4">
            @forelse($pendingGrades as $grade)
                <div class="border border-gray-100 rounded-lg p-4 hover:shadow-sm transition bg-gray-50">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <p class="font-medium text-gray-900 text-sm">{{ $grade->student->name ?? 'Unknown Student' }}</p>
                            <p class="text-xs text-gray-500">{{ $grade->schoolClass->name ?? 'Unknown Class' }}</p>
                        </div>
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-bold">Score: {{ $grade->average }}</span>
                    </div>
                    @if(Auth::user()->role !== 'owner')
                    <form action="{{ route('admin.certificates.store') }}" method="POST" class="mt-3">
                        @csrf
                        <input type="hidden" name="grade_id" value="{{ $grade->id }}">
                        <button type="submit" class="w-full px-3 py-1.5 bg-[#0B4637] text-white rounded hover:bg-[#10B981] transition text-sm font-medium">
                            Generate & Publish
                        </button>
                    </form>
                    @endif
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 text-sm">
                    No pending certificates.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
