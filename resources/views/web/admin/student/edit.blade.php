@extends('template.template4')

@section('content')
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col-sm-12">
				<div class="page-sub-header">
					<h3 class="page-title">Edit Students</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="students.html">Student</a></li>
						<li class="breadcrumb-item active">Edit Students</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12">
			<div class="card comman-shadow">
				<div class="card-body">
					<form>
						<div class="row">
							<div class="col-12">
								<h5 class="form-title student-info">Student Information <span><a
											href="javascript:;"><i class="feather-more-vertical"></i></a></span></h5>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>First Name <span class="login-danger">*</span></label>
									<input class="form-control" type="text" value="{{ $student->first_name }}">
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Last Name <span class="login-danger">*</span></label>
									<input class="form-control" type="text" value="{{ $student->last_name }}">
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Gender <span class="login-danger">*</span></label>
									<select class="form-control select">

										@foreach ($genders as $index => $gender)
											<option {{ $index + 1 == $student->gender_id ? 'selected' : '' }}>
												{{ $gender->label }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms calendar-icon">
									<label>Date Of Birth <span class="login-danger">*</span></label>
									<input class="form-control datetimepicker" type="text" placeholder="DD-MM-YYYY"
										value="{{ $student->birth_date }}">
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Faculty </label>
									<input class="form-control" type="text"
										value="{{ $student->studentEnrollment->faculty->label }}">
								</div>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>E-Mail <span class="login-danger">*</span></label>
									<input class="form-control" type="text" value="{{ $student->email }}">
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Course <span class="login-danger">*</span></label>

									<select class="form-control select">
										@foreach ($courses as $index => $course)
											<option
												{{ $index + 1 == $student->studentEnrollment->course_id ? 'selected' : '' }}>
												{{ $course->label }}</option>
										@endforeach
									</select>

								</div>
							</div>

							<div class="col-12 col-sm-4">
								<div class="form-group local-forms">
									<label>Phone </label>
									<input class="form-control" type="text" value="+258 {{ $student->phone }}">
								</div>
							</div>
							<div class="col-12 col-sm-4">
								<div class="form-group students-up-files">
									<label>Upload Student Photo (150px X 150px)</label>
									<div class="uplod">
										<label class="file-upload image-upbtn mb-0">
											Choose File <input type="file">
										</label>
									</div>
								</div>
							</div>
							<div class="col-12">
								<div class="student-submit">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
