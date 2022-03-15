@extends('layouts.main')
@section('pageName')
    Liste des utilisateurs
@endsection
@section('bigTitle')
    Liste des utilisateurs
@endsection
@section('main')
    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ $message }}
        </div>
    @endif
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ $message }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Liste des commandes</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Auteur</th>
                        <th>Produits</th>
                        <th>Date et heure</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($commands as $command)
                        <tr>
                            <td>{{ $command['author']->firstname . ' ' . $command['author']->lastname }}</td>
                            <td>
                                @foreach ($command['products'] as $key => $product_detail)
                                    <span>{{ $product_detail['product']->name . '(' .$product_detail['number'] . ')' }}</span><br>
                                @endforeach
                            </td>
                            <td><strong>{{ date('d/M/Y', strtotime($command['created_at'])) }}</strong> à <strong>{{ date('H:i', strtotime($command['created_at'])) }}</strong></td>
                            <td class="d-flex">
                                <form action="{{ route('commands.update', $command['uuid']) }}" method="post" class="mr-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_id" value="3" required>
                                    <button class="btn btn-success">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('commands.update', $command['uuid']) }}" method="POST" class="mr-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_id" value="2" required>
                                    <button class="btn btn-warning text-white">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <form action="{{ route('commands.destroy', $command['uuid']) }}" method="post" class="mr-1">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        <tr>
                        @empty
                        <tr>
                            <td>Il n'y a aucune commande!</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
