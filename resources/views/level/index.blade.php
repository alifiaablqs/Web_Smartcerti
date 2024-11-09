@extends('layouts.template') 

@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">{{ $page->title }}</h3> 
        <div class="card-tools"> 
           <!-- Tambah Ajax Button -->
           <button onclick="modalAction(`{{ url('/level/create_ajax') }}`)" class="btn btn-success">Tambah Level</button>
        </div> 
      </div> 
      <div class="card-body"> 
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }} </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }} </div>
        @endif
        <div class="row">
          <div class="col-md-12">
            <div class="form-group row">
              <label class="col-1 control-label col-form-label">Filter: </label>
              <div class="col-3">
                <select class="form-control" id="id_level" name="id_level" required>
                  <option value="">- Semua -</option>
                  @foreach ($level as $item)
                    <option value="{{ $item->id_level }}">{{ $item->nama_level }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <table class="table table-bordered table-striped table-hover table-sm" id="table_user"> 
          <thead> 
            <tr>
            <th>ID</th>
                        <th>Kode Level</th>
                        <th>Nama Level</th>
                        <th>Aksi</th>
            </tr> 
          </thead> 
      </table> 
    </div> 
  </div> 
@endsection 

@push('css') 
@endpush 

@push('js') 
  <script> 
    $(document).ready(function() { 
      var dataUser = $('#table_user').DataTable({ 
          // serverSide: true, jika ingin menggunakan server side processing 
          serverSide: true,      
          ajax: { 
              "url": "{{ url('level/list') }}", 
              "dataType": "json", 
              "type": "POST" ,
              "data": function (d){
                d.id_level = $('#id_level').val();
              }
          }, 
          columns: [ 
            { 
              // nomor urut dari laravel datatable addIndexColumn() 
              data: "DT_RowIndex",             
              className: "text-center", 
              orderable: false, 
              searchable: false     
            },{ 
              data: "kode_level",                
              className: "",  
              orderable: true,     
              searchable: true     
            },{ 
              data: "nama_level",                
              className: "", 
              orderable: true,     
              searchable: true     
            },{ 
              data: "aksi",                
              className: "", 
              orderable: false,     
              searchable: false     
            } 
          ] 
      }); 
      $('#id_level').on('change', function() {
        dataUser.ajax.reload();
      })
    }); 
  </script> 
@endpush