@if ($stocks->count() > 0)
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="font-size:14px" class="text-dark fw-bold">#</th>
                    <th style="font-size:14px" class="text-dark fw-bold">Name</th>
                    <th style="font-size:14px" class="text-dark fw-bold text-center">Quantity</th>
                    <th style="font-size:14px" class="text-dark fw-bold">Sale</th>
                    <th style="font-size:14px" class="text-dark fw-bold">Status</th>
                    @if (Auth::user()->email == 'husnainbutt047@gmail.com')
                        <th style="font-size:14px" class="text-dark fw-bold">Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $key => $stock)
                    <tr>
                        <td class="text-dark">{{ ++$key }}</td>
                        <td style="width:37%;font-size: 16px" title="{{ $stock->name }}"><a
                                href="{{ route('stock.edit', ['id' => $stock->id]) }}" class="text-dark fw-bold">
                                {{ $stock->name }} </a> </td>
                        <td class="text-center text-dark" title="{{ number_format($stock->qty) }}">
                            {{ number_format($stock->qty) }}</td>
                        <td class="fw-bold text-dark" style="font-size: 20px"
                            title="Rs.{{ number_format($stock->sale_price) }}">
                            Rs.{{ number_format($stock->sale_price) }}</td>
                        <td>
                            @if ($stock->qty <= 0)
                                <span class="badge" style="background-color: rgb(253, 27, 27)" title="Out Of Stock">
                                    Out Of Stock </span>
                            @else
                                <span class="badge" style="background-color: rgb(1, 149, 1)" title="Available">
                                    Available </span>
                            @endif
                        </td>

                        @if (Auth::user()->email == 'husnainbutt047@gmail.com')
                            <td>
                                <div class="dropdown ms-auto"> <button class="btn btn-dark btn-sm dropdown-toggle"
                                        type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                        aria-expanded="false"> Actions </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li> <a class="dropdown-item"
                                                href="{{ route('stock.edit', ['id' => $stock->id, 'type' => request()->type]) }}">Edit</a>
                                        </li>
                                        <li> <a class="dropdown-item"
                                                href="{{ route('stock.delete', ['id' => $stock->id]) }}">Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $stocks->links('pagination::bootstrap-5') }}
    </div>
@else
    <h4 class="text-center text-dark fw-bold mt-3">No Data Found!</h4>
@endif
