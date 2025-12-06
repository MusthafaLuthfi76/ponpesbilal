@extends('layouts.app')

@section('page_title', 'Rapor')

@section('content')

    {{-- HEADER --}}
    <div class="card-header text-white d-flex align-items-center"
        style="
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            font-size: 1.4rem;
            background-color: #1f4b2c;
        ">
        <h5 class="mb-0 p-3 fw-bold">Rapor</h5>
    </div>

    <div class="container-fluid bg-light p-4">

        {{-- TITLE + SEARCH --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0">Cetak Rapor Santri</h5>

            <form method="GET" action="{{ url()->current() }}" class="d-flex" style="width: 250px;" id="searchForm">
                <input type="text"
                       name="search"
                       id="searchInput"
                       class="form-control"
                       placeholder="Search..."
                       value="{{ request('search') }}">
            </form>

        </div>

        {{-- CARD WRAPPER --}}
        <div class="card p-3 shadow-sm">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 70px;">No</th>
                        <th>Nama Lengkap</th>
                        <th class="text-center" style="width: 100px;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($santri as $index => $s)
                        <tr>
                            <td>{{ $santri->firstItem() + $index }}</td>
                            <td>{{ $s->nama }}</td>

                            {{-- ICON CETAK --}}
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <a href="{{ route('rapor.cetak', $s->nis) }}"
                                       class="btn btn-primary d-flex justify-content-center align-items-center"
                                       style="width:36px; height:36px; border-radius:50%;">
                                        <i class="bi bi-printer-fill" style="font-size:16px;"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $santri->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

    {{-- SEARCH DEBOUNCE SCRIPT --}}
    <script>
        let delayTimer;
        const form = document.getElementById('searchForm');
        const input = document.getElementById('searchInput');

        input.addEventListener('input', () => {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(() => {
                form.submit();
            }, 400); // jeda 400ms biar tidak berat
        });
    </script>

@endsection
