@extends('backend.layouts.master-profile')

@section('breadcrumb')

@endsection
@section('content')

<ul class="breadcrumb">
	<li><a href="#">Home</a></li>
	<li class="active">Profile</li>
</ul>
<!-- END BREADCRUMB -->                                                

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

	<div class="row">
		
		<!-- PROFILE WIDGET -->
		<div class="col-md-4">

			<div class="panel panel-default">
				<div class="panel-body profile bg-info">

					<div class="profile-image">
						<img src="assets/images/users/user2.jpg" alt="John Doe">
					</div>
					<div class="profile-data">
						<div class="profile-data-name">John Doe</div>
						<div class="profile-data-title">UI/UX Designer</div>
					</div>
					<div class="profile-controls">
						<a href="#" class="profile-control-left"><span class="fa fa-twitter"></span></a>
						<a href="pages-messages.html" class="profile-control-right"><span class="fa fa-envelope"></span></a>
					</div>

				</div>
				<div class="panel-body list-group">
					<a href="#" class="list-group-item"><span class="fa fa-user"></span> Profile</a>
					<a href="#" class="list-group-item"><span class="fa fa-cog"></span> Settings</a>
					<a href="#" class="list-group-item"><span class="fa fa-bar-chart-o"></span> Activity</a>
					<a href="#" class="list-group-item"><span class="fa fa-sign-out"></span> Logoff</a>
				</div>                            
			</div>

		</div>
		<!-- END PROFILE WIDGET -->

	</div>

</div>
<!-- END PAGE CONTENT WRAPPER -->     

@endsection
@section('footer')
@endsection