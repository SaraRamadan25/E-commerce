@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center">Reviews for {{ request()->route('productName') }}</h1>

        @if($formattedReviews->isEmpty())
            <div class="alert alert-warning text-center" role="alert">
                No reviews found.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-sm">
                    <thead class="thead-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Rate</th>
                        <th>Review</th>
                        <th>Product Name</th>
                        <th>Username</th>
                        <th>Owner Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($formattedReviews as $review)
                        <tr class="text-center">
                            <td>{{ $review['id'] }}</td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review['rate'])
                                        <span class="text-warning">&#9733;</span> <!-- Filled star -->
                                    @else
                                        <span class="text-muted">&#9734;</span> <!-- Empty star -->
                                    @endif
                                @endfor
                            </td>
                            <td>{{ Str::limit($review['review'], 50) }}</td> <!-- Limit review text length -->
                            <td>{{ $review['productName'] }}</td>
                            <td>{{ $review['Username'] }}</td>
                            <td>{{ $review['OwnerName'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
