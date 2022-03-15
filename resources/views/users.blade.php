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
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-label="Prénom: activate to sort column ascending">Prénom</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label="Role: activate to sort column descending">Role
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label="Email: activate to sort column descending">Email
                                    </th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                        colspan="1" aria-sort="ascending"
                                        aria-label="Téléphone: activate to sort column descending">Téléphone
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Avatar: activate to sort column ascending">Avatar</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                        aria-label="Action: activate to sort column ascending">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($users as $user)
                                  <tr>
                                    <td>{{ $user->lastname }}</td>
                                    <td>{{ $user->firstname }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" width="40">
                                    </td>
                                    <td class="d-flex border-0">
                                        <button class="btn btn-info" data-toggle="modal" data-target="#edit_{{ $user->uuid }}">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger ml-1" data-toggle="modal" data-target="#destroy_{{ $user->uuid }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        {{-- Suppression --}}
                                    <div class="modal fade" id="destroy_{{ $user->uuid }}" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="modal-title">
                                                        <h4>Supprimer l'utilisateur</h4>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('users.destroy', $user->uuid) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-body">
                                                        <h1 class="text-danger">ATTENTION !!</h1>
                                                        <p>Vous êtes sur le point de supprimer l'utilisateur <strong>{{ $user->firstname . ' ' . $user->lastname }}</strong>.</p>
                                                        <p>Êtes vous sûr de vouloir procéder à la suppression ?</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-danger modal_form_submit_btn">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Fin suppression --}}
                                    </td>
                                    {{-- Edition --}}
                                    <div class="modal fade" id="edit_{{ $user->uuid }}" aria-hidden="true" style="display: none;">
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
                                                <form action="{{ route('users.update', $user->uuid) }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                      <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                          <label for="latname">Nom: </label>
                                                          <input type="text" name="lastname" id="lastname" class="form-control" value="{{ $user->lastname }}" placeholder="Entrez le nom de l'utilisateur" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                          <label for="firstname">Prénom: </label>
                                                          <input type="text" name="firstname" id="firstname" class="form-control" value="{{ $user->firstname }}" placeholder="Entrez le prénom de l'utilisateur" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                          <label for="name">Rôle: </label>
                                                          <select name="role_id" id="role_id" class="form-control" required>
                                                              @foreach ($roles as $role)
                                                                @if ($role->id === $user->role->id)
                                                                <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                                                @else
                                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                                @endif
                                                              @endforeach
                                                          </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                          <label for="email">Adresse email: </label>
                                                          <input type="text" name="email" id="email" class="form-control" value="{{ $user->email }}" placeholder="Entrez l'adresse email" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                          <label for="phone">Numéro de téléphone: </label>
                                                          <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}" placeholder="Entrez le numéro de téléphone" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label for="avatar">Avatar</label>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" name="avatar"
                                                                        class="custom-file-input" id="avatar"
                                                                        accept="image/jpeg, .image/jpg, image/png">
                                                                    <label class="custom-file-label"
                                                                        for="image">Choisir une image</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            <div class="form-group">
                                                                <label for="password">Mot de passe: </label>
                                                                <input type="password"class="form-control" name="password" id="password" placeholder="Entrez le mot de passe">
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label for="confirm_password">Mot de passe: </label>
                                                                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Entrez le mot de passe à nouveau">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                          <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                          <button type="submit" class="btn btn-primary modal_form_submit_btn">Ajouter</button>
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
                  <h4 class="modal-title">Ajout d'un utilisateur</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
              </div>
              <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                  <div class="modal-body">
                    <div class="form-group mb-3">
                      <label for="lastname">Nom: </label>
                      <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Entrez le nom de l'utilisateur" required>
                    </div>
                    <div class="form-group mb-3">
                      <label for="firstname">Prénom: </label>
                      <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Entrez le prénom de l'utilisateur" required>
                    </div>
                    <div class="form-group mb-3">
                      <label for="role_id">Rôle: </label>
                      <select name="role_id" id="role_id" class="form-control" required>
                          <option class="d-none" required>Choississez un role</option>
                          @foreach ($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                          @endforeach
                      </select>
                    </div>
                    <div class="form-group mb-3">
                      <label for="email">Adresse email: </label>
                      <input type="email" name="email" id="email" class="form-control" placeholder="Entrez l'adresse email" required>
                    </div>
                    <div class="form-group mb-3">
                      <label for="phone">Numéro de téléphone: </label>
                      <input type="tel" name="phone" id="phone" class="form-control" placeholder="Entrez le numéro de téléphone" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="avatar">Avatar: </label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="avatar"
                                    class="custom-file-input" id="avatar"
                                    accept="image/jpeg, .image/jpg, image/png">
                                <label class="custom-file-label"
                                    for="avatar">Choisir une image</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Mot de passe: </label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Entrez le mot de passe" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Mot de passe: </label>
                        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Entrez le mot de passe à nouveau" required>
                    </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                      <button type="submit" class="btn btn-primary modal_form_submit_btn">Ajouter</button>
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
