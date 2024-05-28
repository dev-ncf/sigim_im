@extends('template.template3')

@section('active-home')
	class="active"
@endsection

@section('content')
	<section class="section-home">
		<div style="display: flex; justify-content: space-between; alim-items: center;">
			<h1>Inscrições</h1>
			<form action="" id="form-search">
				<input name="student_code" type="text"
					style="height: 32px; border-radius: 5px; border: 1px solid #cccccc; padding: 10px; outline: none;"
					placeholder="Codigo do estudante...">
				<button style="cursor: pointer; padding: 10px; border-radius: 5px; border: none;">
					<i class="bi bi-search"></i>
				</button>
			</form>
		</div>
		<div style="border-bottom: 1px solid #cccccc; margin: 20px 0"></div>

		<table class="table-registration">
			<tr>
				<th>Código do estudante</th>
				<th>Nome</th>
				<th>Local de Estudo</th>
				<th>Semestre</th>
				<th>Estado de Inscrição</th>
				<!--th>Documentos</th-->
				<th>Acção</th>
			</tr>
			@foreach ($studentEnrollment as $enrollment)
				@if ($enrollment->student->extension_id === auth()->user()->extension_id)
					<tr>
						<td>
							{{ $enrollment->student->code }}
						</td>

						<td>
							{{ $enrollment->student->first_name . ' ' . $enrollment->student->last_name }}
						</td>

						<td>
							{{ $enrollment->extension->city }}
						</td>
						<td>
							{{ $enrollment->semestre }}º
						</td>

						<td>
							@if ($enrollment->enrollment_status == '2')
								<span
									style="padding: 5px; background-color: rgb(14, 180, 14); border-radius: 3px; font-size: 8pt; color: #ffffff;">Aprovada</span>
							@elseif($enrollment->enrollment_status == '1')
								<span
									style="padding: 5px; background-color: rgb(255, 182, 46); border-radius: 3px; font-size: 8pt; color: #ffffff;">Pendente</span>
							@else
								<span
									style="padding: 5px; background-color: rgb(255, 71, 71); border-radius: 3px; font-size: 8pt; color: #ffffff;">Rejeitada</span>
							@endif
						</td>
						{{-- {{ $enrollment->student->code }} --}}
						<td>
							@if ($enrollment->enrollment_status == '1')
								<button class="btn-action-student btn-success btn-aprovad-student"
									id="btn-aprovad-student" data-value="{{ $enrollment->id }}">
									<i class="bi bi-check"></i>
								</button>
								{{-- <button class="btn-action-student btn-danger">
                                    <i class="bi bi-x"></i>
                                </button> --}}
							@endif
							@if ($enrollment->enrollment_status == '2')
								<a target="_blank" href="student/{{ $enrollment->student->code }}"
									style="padding: 3.5px;" classs="btn-action-student btn-primary">
									<i class="bi bi-eye"></i>
								</a>
								<a href="{{ url('/printer/recipient-inscription/' . $enrollment->student->code).'/'.$enrollment->id }}"
									style="padding: 3.5px;" classs="btn-action-student btn-secondary">
									<i class="bi bi-printer"></i>
								</a>
							@endif
						</td>
					</tr>
				@endif
			@endforeach

		</table>

		<div style="display: flex; justify-content: center; margin-top: 15px;">
			{{ $studentEnrollment->links() }}
		</div>
	</section>
	<div id="preloader"
		style="width: 100%; height: 100vh; position: absolute; top: 0; left: 0; background: #ffffff9f; display: none; justify-content: center; align-items: center;">
		<img src="{{ asset('img/load.gif') }}" style="width: 130px;">
	</div>
@endsection

@section('javascript')
	<script>
		document.getElementById('form-search').addEventListener('submit', (form) => {
			document.getElementById('preloader').style.display = 'flex';
		});


		//Aprovando estudante
		var elements = document.getElementsByClassName('btn-aprovad-student');

		for (let index = 0; index < elements.length; index++) {
			elements[index].addEventListener('click', () => {
				//Request para aprovar estudante
				let student = window.confirm(
					'Você está prestes a aprovar este estudante?');
				if (student) {
					document.getElementById('preloader').style.display = 'flex';
					axios({
						method: 'POST',
						url: '/manager/student/aprovated',
						data: {
							enrollment_id: elements[index].dataset.value
						}
					}).then(response => {
						if (response.data.updated) {
							location.reload();
							// console.log(response)
						} else {

							document.getElementById('preloader').style.display =
								'flex';
							alert('Tenta novamente mais tarde!')
						}
					}).catch(error => {
						console.log(error)
					})
				}
			});
		}
	</script>
@endsection
