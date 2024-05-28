@extends('template.template2')

@section('active-home')
	class="active"
@endsection

@section('content')
	<section class="section-home">
		<div
			style="display: flex; flex-direction: row; justify-content: space-between; align-items: center; flex-wrap: true">
			<h1>Minha Inscrição</h1>

			@if ($lastEnrollmentPeriod->end > date('Y-m-d'))
				@if ($movements->count() < 5)
					@if ($lastEnrollment->semestre === $lastEnrollmentPeriod->semestre)
						<p
							style="width: 50%; background-color: #1900ff2c; color: #1900ff; border-radius:5px; padding:4px 8px; font-size:12px;margin:0">
							Clique no botão a seguir para baixar a ficha de Pré-inscrição.
						</p>
						<a
							class="hover:border-1 ml-2 rounded-sm border-blue-900 bg-blue-700 px-1 py-0.5 text-white hover:bg-opacity-60 hover:text-blue-950"
							href=" {{ url('/printer/recipient-inscription/' . $student->code . '/' . $lastEnrollment->id) }}">Baixar</a>
						<img class="blinking" style="position: absolute;top:55px; right: 165px;"
							src="{{ asset('img/seta-para-baixo.png') }}" alt="seta">
					@else
						<a id="novaInscricaoLink" class="novaInscricaoLink"
							href="{{ route('enrollment-store') }}" style="">Nova
							Inscrição</a>
					@endif
				@else
					<p
						style="width: 50%; background-color: #ff88002c; color: #ff8800; border-radius:5px; padding:4px 8px; font-size:12px;margin:0">
						Olá <span style="color: #000; font-weight: bold"> Sr(a)
							{{ $student->last_name }}</span>, dirige-se a Direcção do Registo Académico para
						regularizar sua situação financeira!</p>
				@endif
			@endif
			<form id="enrollmentform" style="display: none" action="{{ route('enrollment-store') }}"
				method="post"
				class="absolute top-0 left-0 flex flex-col items-center justify-center w-full h-full p-2 bg-blue-900 rounded-md bg-opacity-40">
				@csrf
				<div class="flex w-[40rem] flex-col gap-2 rounded-md bg-white">
					<div class="flex items-center h-12 px-4 rounded-md bg-sky-200 text-sky-900">
						<span class="text-2xl">Nova inscrição</span>
					</div>
					<div class="flex flex-col w-full gap-2 p-2 px-4 mb-2 border-2">
						<span>Serviços</span>
						<select name="taxa" id="taxa"
							class="w-full h-8 border-2 border-blue-400 rounded-md outline-none"
							title="Selecione um serviço. Por favor!" required>
							<option value="">Selecione um serviço...</option>
							<option value="1000">Taxa de inscrição por disciplina (Nacional)</option>
							<option value="1200">Taxa de inscrição por disciplina (Estrangeiro)</option>
						</select>
					</div>
					<div class="flex flex-col w-full gap-2 p-2 px-4 mb-2 border-2">
						<span>Número de displinas</span>
						<input type="number" name="number"
							class="w-full h-8 px-2 border-2 border-blue-400 rounded-md outline-none"
							min="1" placeholder="Digite um número..." max="9" required>
					</div>
					<div class="flex flex-row justify-between w-full gap-2 p-2 px-4 mb-2 border-2">
						<button id="enrollmentCancel" type="button"
							class="px-4 text-xl text-white bg-red-700 rounded-md hover:bg-opacity-50">Cancel</button>
						<button type="submit"
							class="px-4 text-xl text-white bg-green-700 rounded-md hover:bg-opacity-50">Confirmar</button>
					</div>

				</div>
			</form>
		</div>

		<div style="border-bottom: 1px solid #cccccc; margin: 20px 0"></div>
		<table class="table-registration">
			<tr>
				<th>Código do estudante</th>
				<th>Local de Estudo</th>
				<th>Faculdade</th>
				<th>Curso</th>
				<th>Semestre</th>
				<th>Estado de Inscrição</th>
				<th>Acção</th>
			</tr>
			@foreach ($enrollments as $enrollment)
				<tr>
					<td>{{ $student->code }}</td>
					<td>{{ $student->studentEnrollment->extension->city }}</td>
					<td>{{ $enrollment->faculty->label }}</td>
					<td>{{ $enrollment->course->label }}</td>
					<td>{{ $enrollment->semestre }}º</td>
					<td>
						@if ($enrollment->enrollment_status == '2')
							<span
								style="padding: 5px; background-color: green; border-radius: 3px; font-size: 10pt; color: #ffffff;">aprovada</span>
						@elseif($enrollment->enrollment_status == '1')
							<span
								style="padding: 5px; background-color: orange; border-radius: 3px; font-size: 10pt; color: #ffffff;">pendente</span>
						@else
							<span
								style="padding: 5px; background-color: red; border-radius: 3px; font-size: 10pt; color: #ffffff;">rejeitada</span>
						@endif
					</td>
					<td>
						<a
							href="{{ url('/printer/recipient-inscription/' . $enrollment->student->code . '/' . $enrollment->id) }}">
							<i class="bi bi-printer"></i>
						</a>
					</td>
				</tr>
			@endforeach
		</table>
		<div class="div-100"
			style="margin-top: 50px; border-top: 1px solid #cccccc; padding:14px 0">
			<h3 style="font-weight: bold;font-size: 17px; margin: 4px 0">Linha de Pesquisa</h3>

			<p style="font-size: 14px; font-weight: normal">
				{{ $enrollment->sewingLine->label }}.</p>
		</div>
	</section>
@endsection
@section('javascript')
	<script>
		document.getElementById('novaInscricaoLink').addEventListener('click', function(event) {
			event.preventDefault(); // Evita a execução do link diretamente

			if (confirm('Deseja realmente criar uma nova inscrição?')) {
				document.getElementById('enrollmentform').style.display = 'flex';
			}
		});
		document.getElementById('enrollmentCancel').addEventListener('click', function(event) {
			event.preventDefault(); // Evita a execução do link diretamente

			document.getElementById('enrollmentform').style.display = 'none';

		});
	</script>
@endsection
