@extends('layouts.master')

@section('header', 'Database Backup')

@section('content')
    <div class="card border-0 shadow">
        <div class="card-body text-center">
            <h5 class="card-title mb-3">Database Backup</h5>

            <!-- Export Backup Button -->
            <a href="{{ route('db.export') }}" class="btn btn-bg-blue">Download Database Backup</a>

            <!-- List of Backup Files -->
            @if ($backupFiles)
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>Filename</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($backupFiles as $file)
                            <tr>
                                <td>{{ basename($file) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('db.download', basename($file)) }}" class="btn btn-success btn-sm">Download</a>
                                    <form action="{{ route('db.delete', basename($file)) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="mt-5">Backup will download in your browser.</p>
            @endif
        </div>
    </div>
@endsection
