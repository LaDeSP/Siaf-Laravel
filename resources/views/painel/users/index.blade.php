@extends('layouts.admin-master')

@push('styles')
<link rel="stylesheet" href="{{asset('assets/modules/datatables/datatables.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
@endpush

@section('title')
Manage Users
@endsection

@section('content')
<section class="section">
  <div class="section-header">
    <h1>Manage Users</h1>
  </div>
  <div class="section-body">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped" id="table-1">
          <thead>                                 
            <tr>
              <th>
                #
              </th>
              <th>Nome</th>
              <th>Dufsfse Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>                                 
            <tr>
              <td>
                1
              </td>
              <td>Create a mobile app</td>

              <td>2018-01-20</td>
              <td class="text-right">
                    <button class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                    <button class="btn btn-primary">
                            <i class="fa fa-edit"></i>
                        </button>
                </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script src="{{ asset('assets/modules/datatables/datatables.min.js')}}"></script>
<script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
<script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/page/modules-datatables.js')}}"></script>
@endpush
