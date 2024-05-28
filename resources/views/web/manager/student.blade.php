@extends('template.template3')

@section('active-home')
	class="active"
@endsection

@section('content')
	<section class="section-home">
		<div style="display: flex; justify-content: space-between; alim-items: center;">
			<h1 style="font-size: 14pt;">[ {{ $student->code }} ] -
				{{ $student->first_name . ' ' . $student->last_name }}</h1>
			<a href="#">
				<i style="font-size: 20pt;" class="bi bi-printer"></i>
			</a>
		</div>
		<div style="border-bottom: 1px solid #cccccc; margin: 20px 0"></div>
		<div>
			<h2 style="margin-bottom: 10px; font-weight: 400; font-size: 14pt;">Informação do Curso
			</h2>
			<table class="table-registration">
				<tr>
					<th>Local de Estudo</th>
					<th>Faculdade</th>
					<th>Curso</th>
					<th>Linha de Pesquisa</th>
				</tr>
				<tr>
					<td>
						{{ $student->studentEnrollment->extension->city }}
					</td>
					<td>
						{{ $student->studentEnrollment->faculty->label }}
					</td>
					<td>
						{{ $student->studentEnrollment->course->label }}
					</td>
					<td>
						{{ $student->studentEnrollment->sewingLine->label }}
					</td>
				</tr>
			</table>
		</div>
		<div style="border-bottom: 1px solid #cccccc; margin: 20px 0"></div>
		<div>
			<div
				style="display: flex; justify-content: space-between; alim-items: center; margin-bottom: 15px;">
				<h2 style="margin-bottom: 10px; font-weight: 400; font-size: 14pt;">Situação Financeira
				</h2>
				<button class="btn-new-finance-student" id="btn-new-finance-student">Nova</button>
			</div>
			<table class="table-registration">
				<tr>
					<th>Número de Recibo</th>
					<th>Método</th>
					<th>Montante</th>
					<th>Mês</th>
					<th>Semestre</th>
					<th>Ano</th>
					<th>Estado</th>
					<th>Acção</th>
				</tr>
				@foreach ($student->movements as $movement)
					<tr>
						<td>
							{{ $movement->code }}
						</td>
						<td>
							{{ $movement->payment->label }}
						</td>
						<td>
							{{ number_format($movement->total_amount, 2, '.', ',') }} MT
						</td>
						<td>
							{{ $movement->month }}
						</td>
						<td>
							{{ $movement->semestre }}º
						</td>
						<td>
							{{ $movement->year }}
						</td>
						<td>
							@if ($movement->status == '2')
								<span
									style="padding: 5px; background-color: rgb(14, 180, 14); border-radius: 3px; font-size: 8pt; color: #ffffff;">Pago</span>
							@elseif($movement->status == '1')
								<span
									style="padding: 5px; background-color: rgb(255, 182, 46); border-radius: 3px; font-size: 8pt; color: #ffffff;">Pendente</span>
							@else
								<span
									style="padding: 5px; background-color: rgb(255, 71, 71); border-radius: 3px; font-size: 8pt; color: #ffffff;">Cancelado</span>
							@endif
						</td>
						<td>
							<a href="receipt-payment/{{ $movement->code }}" class="btn"
								style="cursor: pointer;">
								<i class="bi bi-printer"></i>
							</a>
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</section>
	<div id="preloader"
		style="width: 100%; height: 100vh; position: absolute; top: 0; left: 0; background: #ffffff9f; display: none; justify-content: center; align-items: center;">
		<img src="{{ asset('img/load.gif') }}" style="width: 130px;">
	</div>

	<div id="div-modal-movement"
		style="position: absolute; width: 100%; height: 100vh; top:0; left:0; display: none; justify-content: center; align-items: center; background-color: #00000057;">
		<div
			style="position: relative; width: 750px; background-color: #ffffff; border-radius: 5px;">

			<div
				style="display: flex; justify-content: space-between; align-items: center; background-color: #3997bc; height: 40px; border-radius: 5px 5px 0 0; padding: 0 20px;">

				<h1 style="font-size: 13pt; font-weight: 400; color: #ffffff;">Novo movimento</h1>
				<button
					style="width: 25px; height: 25px; border-radius: 50%; border: none; background-color: red; color: #ffffff; cursor: pointer;"
					id="btn-close-movement-modal">
					<i class="bi bi-x"></i>
				</button>
			</div>

			<div style="width: 100%; display: flex; padding: 25px;">
				<div style="width: 40%; border-right: 1px solid #000000; padding: 0 15px 0 0; ">

					<form class="form-group-new-movement" id="form-new-service">
						<label class="label-form-new-movement"><span class="required">*</span>
							Serviços</label>
						<select id="service-movement" class="input-form-new-movement" required>
							<option value="" selected>escolha...</option>
							@foreach ($services as $service)
								{{-- @if ($service->code != 0006)
                                    <option value="{{ $service }}">{{ $service->description }}</option>
                                @endif --}}
								@if ($lastEnrollment->semestre > 1)
									@if (
										$service->description != 'Taxa de Matrícula (Nacional)' &&
											$service->description != 'Taxa de Matrícula (Estrangeiro)')
										<option value="{{ $service }}">{{ $service->description }}</option>
									@endif
								@else
									<option value="{{ $service }}">{{ $service->description }}</option>
								@endif
							@endforeach
						</select>
						<input type="number" min="1" class="input-form-new-movement"
							style="margin-top: 10px; display: none;" id="subject-number"
							placeholder="Numero de disciplinas">
						<button id="btn-service-movement" type="submit" class="btn-new-finance-student"
							style="width: 100%; margin-top: 10px;">Adcionar</button>
					</form>

				</div>
				<div style="width: 60%; padding: 0 15px;">
					<h1 style="font-size: 14pt; font-weight: 500;">Ordem</h1>
					<div id="order-dinamic">
						<h4>Nenhum serviço escolhido</h4>
					</div>
					<form id='formProcess'
						style="display: none; justify-content: space-between; flex-wrap: wrap;">
						<select style="padding: 4px; margin: 4px 0" form="formProcess" id="form-payment"
							required>
							<option value="">escolha...</option>
							@foreach ($form_payments as $payment)
								<option value="{{ $payment->id }}">{{ $payment->label }}</option>
							@endforeach
						</select>
						<input style="padding: 4px; margin: 4px 0" form="formProcess" id="receipt-number"
							type="number" placeholder='No do Talao' required />
						<input style="padding: 4px; margin: 4px 0" form="formProcess" id="date-receipt"
							type="date" min="2023-05-10" max="{{ date('Y-m-d') }}" required />
						<input type="hidden" value="{{ $student->id }}" id="input-student" required>
						<input style="padding: 4px; margin: 4px 0" form="formProcess" id="month"
							type="number" placeholder="Digite o mês (MM) a pagar"
							oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
							maxlength="2" required />

						<input style="padding: 4px; margin: 4px 0" form="formProcess" id="year"
							type="number" placeholder="Digite o ano (YYYY) a pagar"
							oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
							maxlength="4" required />

						<select style="padding: 4px; margin: 4px 0" form="formProcess" id="semestre"
							required onchange="updateOptions(this)">
							<option value="">Semestre...</option>
							@for ($i = 1; $i <= $lastEnrollment->semestre; $i++)
								<option value="{{ $i }}"
									@if ($i === $lastEnrollment->semestre) selected @endif>
									{{ $i }}º
								</option>
							@endfor
						</select>

						<button type="submit" class="btn-new-finance-student"
							style="width: 100%; margin-top: 10px;">Processar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	<script>
		/*document.getElementById('form-search').addEventListener('submit', (form) => {
																						            document.getElementById('preloader').style.display = 'flex';
																						        });*/



		//Trabalhando com o carinho de compra

		//Variavel que armazena o nosso carinho de servicos
		var cart_services = [];

		//Capturando o servico
		let new_service = document.getElementById('service-movement');

		let input_subject_number = document.getElementById('subject-number');

		new_service.addEventListener('change', (input) => {
			//codigo capturado do input selecionansdo
			if (JSON.parse(input.srcElement.value).code == 0003 || JSON.parse(input
					.srcElement.value).code == 0004) {
				input_subject_number.style.display = 'block';
			} else {
				input_subject_number.style.display = 'none';
			}
		});


		//Capturando e atribuindo o numero de paginas
		var subject_number;

		input_subject_number.addEventListener('keyup', (element) => {
			subject_number = element.srcElement.value;
		});

		//Escutando o botao de adcionar
		document.getElementById('form-new-service').addEventListener('submit', (form) => {
			form.preventDefault();

			var service_exist;
			if (new_service.value) {
				service_exist = checkServiceCart(new_service.value);
			}


			if (new_service.value && service_exist == false) {

				//verificando se e o servico de inscricao por disciplina
				if (JSON.parse(new_service.value).code == 0003 || JSON.parse(new_service
						.value).code == 0004) {
					if (subject_number) {
						let service = JSON.parse(new_service.value);
						service.amount = service.amount * subject_number;

						cart_services.push(service);
						subject_number = '';
						input_subject_number.style.display = 'none';

						renderCart();
						new_service.value = '';
					} else {
						alert('Preencha o número de disciplinas')
					}
				} else {
					cart_services.push(JSON.parse(new_service.value));
					renderCart();
					new_service.value = '';
				}
			} else {
				new_service.value = '';
				input_subject_number.style.display = 'none';
			}
		});


		//Funcao para verificar se o servico a ser adcionado no carinho existe
		function checkServiceCart(service) {

			for (var i = 0; i < cart_services.length; i++) {
				if (JSON.parse(service).id === cart_services[i].id) {
					alert('Você não pode adicionar 2 vezes o mesmo serviço!');
					return true;
					break;
				}
			}

			return false;
		}




		//Funcao de Remocao de Elementos dentro do carinho
		function removeService(id) {
			var new_cart_services = cart_services.filter((element) => id !== element.id);
			cart_services = new_cart_services;
			renderCart();
		}


		//Funcao para renderizacao do carinho\
		function renderCart() {
			let div = document.getElementById('order-dinamic');

			//Verificando o comprimento de servicos no carinho
			if (cart_services.length >= 1) {
				var table = `
                    <table id="table-order" class='table-order'>
                        <tr>
                            <th>Referente a:</th>
                            <th>Motante (subtotal)</th>
                            <th>Acção</th>
                        </tr>
                `;

				//variavel para armazenar as linhas
				var line = '';
				var total = 0;

				for (var i = 0; i < cart_services.length; i++) {
					line = line + `
                        <tr>
                            <td>${cart_services[i].description}</td>
                            <td>${cart_services[i].amount}</td>
                            <td>
                                <button onclick="removeService(${cart_services[i].id})" style="background-color: red; width: 25px; height: 25px; border-radius: 50%; border: none; color: #ffffff; cursor: pointer; display: flex; justify-content: center; align-items: center;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
					total = total + cart_services[i].amount;
				}

				table = table + line + `
                        <tr>
                            <td style="font-weight: 600; ">Total</td>
                            <td>${total}</td>
                        </tr>
                    </table>
                    <br/>
                `;

				div.innerHTML = table;
				document.getElementById('formProcess').style.display = 'flex';
			} else {
				div.innerHTML = '<h4>Nenhum serviço escolhido</h4>';
				document.getElementById('formProcess').style.display = 'none';
			}
		}


		//Funcao para exibir o modal  de novos movimentos
		document.getElementById('btn-new-finance-student').addEventListener('click', (
			element) => {
			document.getElementById('div-modal-movement').style.display = 'flex';
			//console.log(element.srcElement.style.display = '');
		});

		//Funcao para ocultar o modal  de novos movimentos
		document.getElementById('btn-close-movement-modal').addEventListener('click', (
			element) => {
			closeModal();
			cart_services = [];
		});

		//funcao para fechar modal de novo movimebnto
		function closeModal() {

			document.getElementById('div-modal-movement').style.display = 'none';
			document.getElementById('order-dinamic').innerHTML =
				'<h4>Nenhum serviço escolhido</h4';
			document.getElementById('formProcess').style.display = 'none'
			//console.log(element.srcElement.style.display = '');
		}


		//Submetendo o formulario de processamento de servico
		document.getElementById('formProcess').addEventListener('submit', function(e) {

			document.getElementById('preloader').style.display = 'flex';
			closeModal();
			e.preventDefault();

			let form_payment = document.getElementById('form-payment');
			let receipt_number = document.getElementById('receipt-number');
			let date_receipt = document.getElementById('date-receipt');
			let month = document.getElementById('month');
			let year = document.getElementById('year');
			let semestre = document.getElementById('semestre');

			//cadastrando os movimentos
			var student = document.getElementById('input-student');

			axios({
				method: 'POST',
				url: '/manager/student/payment',
				data: {
					payment_id: form_payment.value,
					receipt_number: receipt_number.value,
					date_receipt: date_receipt.value,
					month: month.value,
					year: year.value,
					semestre: semestre.value,
					student_id: student.value,
					items: cart_services
				}
			}).then(response => {
				if (response.data.created == true) {
					location.reload();
				} else {
					document.getElementById('preloader').style.display = 'none';
					alert('Tenta novamente mais tarde!');
				}
			}).catch(error => {
				console.log(error)
			})
		});
	</script>
@endsection
