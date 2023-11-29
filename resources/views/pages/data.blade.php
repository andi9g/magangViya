@extends('layout.master')

@section("judul", "Data Video")

@section('content')
    <div id="tambahdata" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="my-modal-title">Tambah <Datag></Datag></h5>
                    <button class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('data.store', []) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="namadata">Nama File</label>
                            <input id="namadata" class="form-control" type="text" name="namadata">
                        </div>

                        <div class="form-group">
                            <label for="data">Pilih File Video</label>
                            <input id="data" class="form-control" type="file" name="data">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success px-4">
                            Tambah Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#tambahdata">Tambah Data</button>
                        </div>
                        <div class="col-md-6">
                            <form action="{{ url()->current() }}">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="keyword" placeholder="masukan nama" value="{{ $keyword }}" aria-label="keyword" aria-describedby="keyword">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-secondary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th width="5px">No</th>
                                    <th>Nama Data</th>
                                    <th>Size</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($data as $item)
                                    <tr>
                                        <td align="center">{{ $loop->iteration }}</td>
                                        <td class="text-capitalize">{{ $item->nama }}</td>
                                        <td>{{ round($item->ukuran/1024) }}KB</td>
                                        <td>
                                            <form action="{{ route('data.destroy', [$item->iddata]) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="badge badge-danger border-0 py-1">
                                                    <i class="fa fa-trash"></i> 
                                                </button>
                                            </form>

                                            <form action="{{ route('data.download', [$item->iddata]) }}" method="post" class="d-inline">
                                                @csrf
                                                <button type="submit" class="badge border-0 py-1 badge-success">
                                                    <i class="fa fa-download"></i> Download
                                                </button>
                                            </form>

                                            <a class="badge py-1 border-0 badge-primary" href="{{ url('gambar', [$item->namadata]) }}" target="_blank">
                                                <i class="fa fa-eye"></i>
                                                Lihat Video
                                            </a>
                                        </td>
                                    </tr>


                                    
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection