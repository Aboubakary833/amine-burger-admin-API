@extends('layouts.main')
@section('pageName')
    Liste des produits
@endsection
@section('bigTitle')
    Liste des produits
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
            <div class="card-tools">
              <button class="btn btn-primary" data-toggle="modal" data-target="#modal_add_product">Ajouter un produit</button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="data_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row mt-1">
                    <div class="col-sm-12">
                        <table id="productsData" class="table table-bordered table-striped dataTable dtr-inline"
                            aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Nom: activate to sort column ascending">Nom</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label="Image: activate to sort column descending">Image
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label="Description: activate to sort column descending">Description
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Prix: activate to sort column ascending">Prix</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Action: activate to sort column ascending">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($products as $product)
                                  <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50">
                                    </td>
                                    <td style="max-width: 606px;">{{ $product->description }}</td>
                                    <td>{{ $product->price }} FCFA</td>
                                    <td class="d-flex border-0">
                                        <button class="btn btn-info" data-toggle="modal" data-target="#edit_{{ $product->uuid }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger ml-1" data-toggle="modal" data-target="#destroy_{{ $product->uuid }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        {{-- Suppression --}}
                                    <div class="modal fade" id="destroy_{{ $product->uuid }}" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="modal-title">
                                                        <h4>Supprimer le produit</h4>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('products.destroy', $product->uuid) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        <h1 class="text-danger">ATTENTION !!</h1>
                                                        <p>Vous êtes sur le point de supprimer le produit {{ $product->name }}.</p>
                                                        <p>Êtes vous sûr de vouloir procéder à la suppression ?</p>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                            <button type="submit" class="btn btn-danger modal_form_submit_btn">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Fin suppression --}}
                                    </td>
                                    {{-- Edition --}}
                                    <div class="modal fade" id="edit_{{ $product->uuid }}" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="modal-title">
                                                        <h4>Modifier le produit</h4>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('products.update', $product->uuid) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                      <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                        <div class="form-group mb-3">
                                                          <label for="name">Nom du produit: </label>
                                                          <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" placeholder="Entrez le nom du produit" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="image">Image du produit</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" name="image"
                                                                        class="custom-file-input" id="profile"
                                                                        accept="image/jpeg, .image/jpg, image/png">
                                                                    <label class="custom-file-label"
                                                                        for="image">Choisir une image</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                          <label for="description">Description du produit: </label>
                                                          <textarea name="description" id="description" cols="30" rows="5" placeholder="Entrez la description du produit" class="form-control" required>{{$product->description}}</textarea>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                          <label for="price">Prix du produit: </label>
                                                          <input type="number" name="price" id="price" class="form-control"value="{{ $product->price }}" placeholder="Entrez le prix du produit" required>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                          <button type="submit" class="btn btn-primary modal_form_submit_btn">Ajouter</button>
                                                        </div>
                                                      </div>
                                                  </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Fin édition --}}

                                    
                                  </tr>
                              @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="modal fade" id="modal_add_product" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title">Ajout de produit</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
              </div>
              <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                  <div class="modal-body">
                    <div class="form-group mb-3">
                    <div class="form-group mb-3">
                      <label for="name">Nom du produit: </label>
                      <input type="text" name="name" id="name" class="form-control" placeholder="Entrez le nom du produit" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="image">Image du produit</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image"
                                    class="custom-file-input" id="profile"
                                    accept="image/jpeg, .image/jpg, image/png" required>
                                <label class="custom-file-label"
                                    for="image">Choisir une image</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                      <label for="description">Description du produit: </label>
                      <textarea name="description" id="description" cols="30" rows="5" placeholder="Entrez la description du produit" class="form-control" required></textarea>
                    </div>
                    <div class="form-group mb-3">
                      <label for="price">Prix du produit: </label>
                      <input type="number" name="price" id="price" class="form-control" placeholder="Entrez le prix du produit" required>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                      <button type="submit" class="btn btn-primary modal_form_submit_btn">Ajouter</button>
                    </div>
                  </div>
              </form>
          </div>
      </div>
    </div>
@endsection

@section('additional_script')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(function() {
            $("#productsData").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": true,
                "lengthMenu": [10, 25, 50, 75, 100],
                "buttons": ["excel", "pdf"],
                "language": {
                    "searchPlaceholder": "Rechercher un produit...",
                    "lengthMenu": "Afficher _MENU_ enregistrement par page",
                    "zeroRecords": "Aucun produit trouvé",
                    "info": "Showing page _PAGE_ of _PAGES_",
                    "infoEmpty": "",
                    "infoFiltered": "(Filtré à partir de la liste _MAX_.)",
                    "lengthMenu": "Show _MENU_ entries",
                    "loadingRecords": "Chargement...",
                    "processing": "En cours...",
                    "search": "_INPUT_",
                    "placeholder": "Rechercher",
                    "info": "_TOTAL_ enregistrement(s)",
                    "infoEmpty": "0 enregistrement",
                    "zeroRecords": "Aucun enregistrement trouvé",
                    "paginate": {
                        "first": "Premier",
                        "last": "Dernier",
                        "next": "Suivant",
                        "previous": "Précédent"
                    },
                }
            }).buttons().container().appendTo('#data_wrapper .col-md-6:eq(0)');
        });
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@endsection
