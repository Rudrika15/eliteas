@extends('layouts.master')

@section('header', 'City')
@section('content')

    {{-- Message --}}

    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">City</h4>
                    <a href="{{ route('city.create') }}" class="btn btn-bg-orange btn-sm mt-3 btn-tooltip"><i
                            class="bi bi-plus-circle"></i>
                        <span class="btn-text">Add City</span></a>
                </div>

                <!-- Table with stripped rows -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Country Name</th>
                                <th>State Name</th>
                                <th>City Name</th>
                                <th>Amount</th>
                                <th>Member Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($city as $cityData)
                                <tr>
                                    <th>{{ ($city->currentPage() - 1) * $city->perPage() + $loop->index + 1 }}
                                    <td>{{ $cityData->country->countryName ?? '-' }}</td>
                                    <td>{{ $cityData->state->stateName ?? '-' }}</td>
                                    <td>{{ $cityData->cityName }}</td>
                                    <td>{{ $cityData->amount }}</td>
                                    <td>{{ $cityData->memberAmount }}</td>
                                    <td>{{ $cityData->status }}</td>
                                    <td>
                                        <a href="{{ route('city.edit', $cityData->id) }}"
                                            class="btn btn-bg-blue btn-sm btn-tooltip">
                                            <i class="bi bi-pen"></i>
                                            <span class="btn-text">Edit</span>
                                        </a>

                                        {{-- <a href="{{ route('franchise.show', $franchiseData->id) }}" class="btn btn-info">
                                    <i class="bi bi-eye"></i>
                                </a> --}}

                                        <form action="{{ route('city.delete', $cityData->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-tooltip">
                                                <i class="bi bi-trash"></i>
                                                <span class="btn-text">Delete</span>
                                                <!-- Icon for delete -->
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-end custom-pagination">
                        {!! $city->links() !!}
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
@endsection
