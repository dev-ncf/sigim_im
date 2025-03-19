@extends('template.template4')

@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col">
                <h3 class="page-title">Perfil</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Estudante</a></li>
                    <li class="breadcrumb-item active">Perfil</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="profile-header">
                <div class="row align-items-center">
                    <div class="profile-image col-auto">
                        <a href="#">
                            <img class="rounded-circle" alt="User Image"
                                src="{{ $student->foto_file ? asset('storage/public/' . $student->foto_file) : asset('img/logo.jpg') }}">
                        </a>
                    </div>
                    @foreach ($student->studentEnrollment as $enrollment)
                        <div class="col ms-md-n2 profile-user-info">
                            <h4 class="user-name mb-0">{{ $student->first_name . ' ' . $student->last_name }}</h4>
                            <h6 class="text-muted">{{ $enrollment->course->label }}</h6>
                            <div class="user-Location"><i class="fas fa-school"></i> {{ $enrollment->faculty->label }}</div>
                            {{-- <div class="about-text"><i class="fas fa-book"></i> {{ $enrollment->sewingLine->label }}</div> --}}
                        </div>
                    @break
                @endforeach

                <div class="profile-btn col-auto">
                    <a href="{{ route('student-edit', $student->code) }}" class="btn btn-primary">
                        Edit
                    </a>
                </div>
            </div>
        </div>
        <div class="profile-menu">
            <ul class="nav nav-tabs nav-tabs-solid">

                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#enrollments_tab">Inscrições</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#movements_tab">Serviços</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#per_details_tab">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#password_tab">Password</a>
                </li>
            </ul>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="tab-content profile-tab-cont">

            <div class="tab-pane fade" id="per_details_tab">

                <div class="row">
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <span>Dados Pessoais</span>

                                </h5>
                                <div class="row">
                                    <p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Nome</p>
                                    <p class="col-sm-9">{{ $student->first_name . ' ' . $student->last_name }}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Data de Nacimento</p>
                                    <p class="col-sm-9">{{ $student->birth_date }}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Email </p>
                                    <p class="col-sm-9">
                                        {{ $student->email }}
                                    </p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-3 text-muted text-sm-end mb-sm-3 mb-0">Contacto</p>
                                    <p class="col-sm-9">{{ $student->phone }}</p>
                                </div>
                                <div class="row">
                                    <p class="col-sm-3 text-muted text-sm-end mb-0">Endereco</p>
                                    <p class="col-sm-9 mb-0">{{ $student->address->province->label }},<br>
                                        {{ $student->address->district->label }},<br>
                                        {{ $student->address->neighborhood }}<br>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title d-flex justify-content-between">
                                    <span>Estado da Conta</span>

                                </h5>
                                <button class="btn btn-success" type="button"><i class="fe fe-check-verified"></i>
                                    {{ $student->estado }}</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="tab-pane fade show active" id="enrollments_tab">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between">
                            <span>Inscrições</span>
                            <a class="btn btn-primary" href="{{ route('enrollment-add') }}"><i
                                    class="fa fa-plus me-1"></i>Add</a>
                        </h5>
                        <div class="table-responsive">
                            <table
                                class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
                                <thead class="student-thread">
                                    <tr>

                                        <th>Nome</th>
                                        <th>Local de Estudo</th>
                                        <th>Curso</th>
                                        <th>Semestre</th>
                                        <th>Estado</th>

                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($student->studentEnrollment as $enrollment)
                                        <tr>

                                            <td>
                                                <h2 class="table-avatar">

                                                    <a
                                                        href="">{{ $student->truncateName($student->first_name . ' ' . $student->last_name) }}</a>
                                                </h2>

                                            </td>
                                            <td>

                                                {{ $enrollment->extension->city }}

                                            </td>
                                            <td>
                                                {{ $enrollment->course->label }}

                                            </td>

                                            <td>{{ $enrollment->semestre }}</td>
                                            <td><span
                                                    style="padding: 3px 8px; {{ $enrollment->enrollment_status == 2 ? 'background-color: #0080004a; color: #009000' : ($enrollment->enrollment_status == 1 ? 'background-color: #ffa5004a; color: #ffa500' : 'background-color: #ff08004a; color: #ff0800') }}">
                                                    {{ $enrollment->enrollment_status == 2 ? 'Aprovada' : ($enrollment->enrollment_status == 1 ? 'Pendente' : 'Cancelada') }}
                                                </span>

                                            </td>
                                            <td class="text-end">
                                                <div class="actions">
                                                    @if ($enrollment->enrollment_status == 1)
                                                        <a href="{{ route('enrollment-approve', $enrollment->id) }}"
                                                            class="btn btn-sm bg-success-light me-2">
                                                            <i class="{{ 'feather-check' }}"></i>
                                                        </a>
                                                    @endif
                                                    <a href="{{ route('enrollment-print', ['code' => $student->code, 'id' => $enrollment->id]) }}"
                                                        class="btn btn-sm bg-success-light me-2">
                                                        <i class="feather-printer"></i>
                                                    </a>
                                                    <a href="{{ route('enrollment-edit', $enrollment->id) }}"
                                                        class="btn btn-sm bg-danger-light">

                                                        <i class="feather-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
            <div class="tab-pane fade" id="movements_tab">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title d-flex justify-content-between">
                            <span>Serviços</span>
                            <a class="btn btn-primary"
                                href="{{ route('propina-add', ['student_id' => $student->id]) }}"><i
                                    class="fa fa-plus me-1"></i>Add</a>
                        </h5>
                        <div class="table-responsive">
                            <table
                                class="star-student table-hover table-center datatable table-striped mb-0 table border-0">
                                <thead class="student-thread">
                                    <tr>

                                        <th>Nome</th>
                                        <th>Recibo</th>
                                        <th>Valor</th>
                                        <th>Semestre</th>
                                        <th>Mes</th>
                                        <th>Ano</th>

                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($student->studentMovement as $propina)
                                        <tr>

                                            <td>
                                                <h2 class="table-avatar">

                                                    <a
                                                        href="">{{ $propina->student->truncateName($propina->student->first_name . ' ' . $propina->student->last_name) }}</a>
                                                </h2>

                                            </td>
                                            <td>

                                                {{ $propina->receipt_number }}

                                            </td>
                                            <td>{{ $propina->total_amount }}</td>
                                            <td>{{ $propina->semestre }}</td>
                                            <td>
                                                {{ $propina->month }}
                                            </td>
                                            <td>
                                                {{ $propina->year }}
                                            </td>

                                            <td class="text-end">
                                                <div class="actions">
                                                    <a href="{{ route('propina-print', ['number' => $propina->code]) }}"
                                                        class="btn btn-sm bg-success-light me-2">
                                                        <i class="feather-printer"></i>
                                                    </a>
                                                    <a href="{{ route('propina-edit', $propina->id) }}"
                                                        class="btn btn-sm bg-danger-light">

                                                        <i class="feather-edit"></i>
                                                    </a>
                                                    <a href="#" id="delete-{{ $propina->id }}"
                                                        onclick="return confirmDeletion(event)"
                                                        class="btn btn-sm bg-danger"
                                                        enrollment-id='{{ $propina->id }}'>
                                                        <i class="feather-delete"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>

            <div id="password_tab" class="tab-pane fade">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Change Password</h5>
                        <div class="row">
                            <div class="col-md-10 col-lg-6">
                                <form action="{{ route('student-update-password', $student->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Nova Password</label>
                                        <input type="password" class="form-control" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Confirmar Password</label>
                                        <input type="password" class="form-control" name="confir_password">
                                    </div>
                                    <button class="btn btn-primary" type="submit">Salvar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div id="modal"
    style="width: 100%; height:100%; top: 0; left:0; background-color: #00000030; display: none; position: fixed; z-index: 100; justify-content: center; align-items: center;">
    <div style="background-color: white; padding:40px; box-shadow: 1px 5px 10px white; border-radius: 10px">

        <h3>Queres mesmo apagar esta Inscrição?</h3>
        <div style="display: flex; justify-content: space-between">
            <a href="#" id="confirm-delete" class="btn btn-primary">Confirmar</a>
            <button class="btn btn-danger" onclick="closeModal()">Cancelar</button>
        </div>
    </div>
</div>
<script>
    function confirmDeletion(event) {
        event.preventDefault(); // Previne o comportamento padrão do link

        // Exibe o modal
        document.getElementById('modal').style.display = 'flex';

        // Obtém o código do estudante a partir do botão clicado
        var enrollmentId = event.currentTarget.getAttribute('enrollment-id');
        var confirmLink = document.getElementById('confirm-delete');
        confirmLink.href = "{{ route('propina-delete', '') }}/" + enrollmentId;

        // Define o código no campo do modal
        document.getElementById('enrollment-id').value = enrollmentId;

    }

    function closeModal() {
        document.getElementById('modal').style.display = 'none';
    }
</script>
@endsection
