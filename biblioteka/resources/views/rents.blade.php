@extends('layouts.app')

@section('content')
    <div class="bg-books">
        <div class="container bg-default ">
            <table id="datatable" class="table table-bordered table-striped ">
                <thead>
                    <tr>
                        <th width="10%">Id iznajmljivanja</th>
                        <th width="10%">Korisnik</th>
                        <th width="10%">Datum i vreme</th>
                        <th width="20%">Cena iznajmljivanja</th>
                        <th width="20%">Knjiga</th>
                        <th width="10%">Status iznajmljivanja</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    @if (Auth::user()->isAdmin())
        <script>
            $(document).ready(function() {

                loadDataTable();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function humanizeDate(date_str) {
                    month = ['Januar', 'Feburar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar',
                        'Oktobar', 'Novembar', 'Decembar'
                    ];

                    date_arr = date_str.split('-');
                    return month[Number(date_arr[1]) - 1] + " " + date_arr[2].split('T')[0] + ", " + date_arr[0]
                }

                function loadDataTable() {
                    $('#datatable').dataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "http://127.0.0.1:8000/api/admin/rents"
                        },
                        columns: [{
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'user.name',
                                name: 'user'
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                render: function(data, type, row, meta) {

                                    return humanizeDate(data);
                                }
                            },
                            {
                                data: 'book.price',
                                name: 'price'
                            },
                            {
                                data: 'book.title',
                                name: 'book_name'
                            },
                            {
                                data: 'status',
                                name: 'rent',
                                render: function(data, type, row, meta) {

                                    return `<div class="mb-3">
                                        <label for="" class="form-label"></label>
                                        <select class="form-select rent-status" id="${row['id']}">
                                            <option ${'IZNAJMLJENA' === data ? ' selected' : ''} value="IZNAJMLJENA">IZNAJMLJENA</option>
                                            <option ${'VRACENA' === data ? ' selected' : ''} value="VRACENA">VRACENA</option>
                                        </select>
                                </div>`
                                }
                            }
                        ]
                    })
                }

            });

            $('body').on('change', '.rent-status', function(e) {
                e.preventDefault();


                $.ajax({
                    type: "PUT",
                    url: "http://127.0.0.1:8000/api/admin/rents/" + e.target.id,
                    data: {
                        status: $(this).val()
                    },
                    dataType: "JSON",
                    success: function(response) {
                        alert(response.message)
                    },
                });

            });
        </script>

    @else

        <script>
            $(document).ready(function() {

                loadDataTable();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function humanizeDate(date_str) {
                    month = ['Januar', 'Feburar', 'Mart', 'April', 'Maj', 'Jun', 'Jul', 'Avgust', 'Septembar',
                        'Oktobar', 'Novembar', 'Decembar'
                    ];

                    date_arr = date_str.split('-');
                    return month[Number(date_arr[1]) - 1] + " " + date_arr[2].split('T')[0] + ", " + date_arr[0]
                }

                function loadDataTable() {
                    $('#datatable').dataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "http://127.0.0.1:8000/api/rents"
                        },
                        columns: [{
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'user.name',
                                name: 'user'
                            },
                            {
                                data: 'created_at',
                                name: 'created_at',
                                render: function(data, type, row, meta) {

                                    return humanizeDate(data);
                                }
                            },
                            {
                                data: 'book.price',
                                name: 'price'
                            },
                            {
                                data: 'book.title',
                                name: 'book_name'
                            },
                            {
                                data: 'status',
                                name: 'rent'
                            }
                        ]
                    })
                }

            });
        </script>
    @endif
@endsection
