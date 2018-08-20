@extends('backend.layouts.master-profile')

@section('breadcrumb')

@endsection

@section('content')
<div class="page-content-wrap">

	<!-- START WIDGETS -->
	<div class="row">
		<div class="col-md-3">

			<!-- START WIDGET CLOCK -->
			<div class="widget widget-info widget-padding-sm">
				<div class="widget-big-int plugin-clock">00:00</div>
				<div class="widget-subtitle plugin-date">Loading...</div>
				<div class="widget-controls">
					<a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a>
				</div>
				<div class="widget-buttons widget-c3">
					<div class="col">
						<a href="#"><span class="fa fa-clock-o"></span></a>
					</div>
					<div class="col">
						<a href="#"><span class="fa fa-bell"></span></a>
					</div>
					<div class="col">
						<a href="#"><span class="fa fa-calendar"></span></a>
					</div>
				</div>
			</div>
			<!-- END WIDGET CLOCK -->

		</div>

		<div class="col-md-3">

			<!-- START WIDGET SLIDER -->
			<div class="widget widget-default widget-carousel">
				<div class="owl-carousel" id="owl-example">
					<div>
						<div class="widget-title">Nhiệm vụ</div>
						<div class="widget-subtitle">27/08/2014 15:23</div>
						<div class="widget-int">5</div>
					</div>
					<div>
						<div class="widget-title">Đã hoàn thành</div>
						<div class="widget-subtitle">Được giao</div>
						<div class="widget-int">2</div>
					</div>
					<div>
						<div class="widget-title">Nhiệm vụ mới</div>
						<div class="widget-subtitle">Được giao</div>
						<div class="widget-int">3</div>
					</div>
				</div>
				<div class="widget-controls">
					<a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
				</div>
			</div>
			<!-- END WIDGET SLIDER -->

		</div>
		<div class="col-md-3">

			<!-- START WIDGET MESSAGES -->
			<div class="widget widget-default widget-item-icon" onclick="location.href='#';">
				<div class="widget-item-left">
					<span class="fa fa-envelope"></span>
				</div>
				<div class="widget-data">
					<div class="widget-int num-count">4</div>
					<div class="widget-title">Tin nhắn</div>
					<div class="widget-subtitle">Trong mail của bạn</div>
				</div>
				<div class="widget-controls">
					<a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
				</div>
			</div>
			<!-- END WIDGET MESSAGES -->

		</div>
		<div class="col-md-3">

			<!-- START WIDGET REGISTRED -->
			<div class="widget widget-default widget-item-icon" onclick="location.href='#';">
				<div class="widget-item-left">
					<span class="fa fa-user"></span>
				</div>
				<div class="widget-data">
					<div class="widget-int num-count">5</div>
					<div class="widget-title">Nhiệm vụ</div>
					<div class="widget-subtitle">Trong tổng số mà bạn làm</div>
				</div>
				<div class="widget-controls">
					<a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
				</div>
			</div>
			<!-- END WIDGET REGISTRED -->

		</div>

	</div>
	<!-- END WIDGETS -->

	<div class="row">
		<div class="col-md-8">

			<!-- START SALES BLOCK -->
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="panel-title-box">
						<h3>Nhiệm vụ</h3>
						<span>Nhiệm vụ được giao</span>
					</div>
					<ul class="panel-controls" style="margin-top: 2px;">
						<li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
						<li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span></a></li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span> Thu gọn</a></li>
								<li><a href="#" class="panel-remove"><span class="fa fa-times"></span> Ẩn</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<div class="panel-body panel-body-table">

					<div class="table-responsive">
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th width="50%">Nhiệm vụ</th>
									<th width="20%">Trạng thái</th>
									<th width="30%">Hành động</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><strong>Nhiệm vụ giáo dục đào tạo phổ cập công nghệ thông tin cho cấp bậc mầm non</strong></td>
									<td><span class="label label-warning">Đang tiến hành</span></td>
									<td>
										<div class="progress progress-small progress-striped active">
											<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">85%</div>
										</div>
									</td>
								</tr>
								<tr>
									<td><strong>Giải pháp với mục tiêu đưa KH&CN phục vụ trực tiếp cho phát triển các ngành</strong></td>
									<td><span class="label label-warning">Đang tiến hành</span></td>
									<td>
										<div class="progress progress-small progress-striped active">
											<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">40%</div>
										</div>
									</td>
								</tr>
								<tr>
									<td><strong>Hỗ trợ phát triển các sản phẩm nông nghiệp</strong></td>
									<td><span class="label label-warning">Đang tiến hành</span></td>
									<td>
										<div class="progress progress-small progress-striped active">
											<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 72%;">72%</div>
										</div>
									</td>
								</tr>
								<tr>
									<td><strong>Hỗ trợ doanh nghiệp ứng dụng, đổi mới công nghệ</strong></td>
									<td><span class="label label-success">Hoàn thành</span></td>
									<td>
										<div class="progress progress-small progress-striped active">
											<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
										</div>
									</td>
								</tr>
								<tr>
									<td><strong>Cải thiện môi trường kinh doanh của doanh nghiệp</strong></td>
									<td><span class="label label-success">Hoàn thành</span></td>
									<td>
										<div class="progress progress-small progress-striped active">
											<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">100%</div>
										</div>
									</td>
								</tr>

							</tbody>
						</table>
					</div>

				</div>
			</div>
			<!-- END SALES BLOCK -->

		</div>
		<div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-content">
				<ul class="list-inline item-details">
					<li><a href="http://themifycloud.com/downloads/janux-premium-responsive-bootstrap-admin-dashboard-template/">Admin templates</a></li>
					<li><a href="http://themescloud.org">Bootstrap themes</a></li>
				</ul>
			</div>
		</div>

		<div class="col-md-4">

			<!-- START SALES & EVENTS BLOCK -->
			<div class="panel panel-default">
				<div class="panel-heading ui-draggable-handle">
					<h3 class="panel-title">Tin mới nhất</h3>
					<ul class="panel-controls">
						<li><a href="#" class="control-danger"><span class="fa fa-pencil"></span></a></li>
					</ul>
				</div>
				<div class="panel-body scroll mCustomScrollbar _mCS_4 mCS-autoHide" style="height: 250px;"><div id="mCSB_4" class="mCustomScrollBox mCS-light mCSB_vertical mCSB_inside" tabindex="0"><div id="mCSB_4_container" class="mCSB_container" style="position:relative; top:0; left:-10px;" dir="ltr">
				<div class="col-md-12">
					<h6>Đẩy mạnh thương mại hóa công nghệ trong lĩnh vực nông nghiệp tại Việt Nam</h6>
					<p>
						Hà Nội. Sự kiện nằm trong khuôn khổ Triển lãm quốc tế Thiết bị và Công nghệ Nông – Lâm – Ngư nghiệp 2017 (GROWTECH 2017).
						<span class="text-muted"><i class="fa fa-clock-o"></i> 14:15 Hôm nay</span>
					</p>
					<h6>MỜI DOANH NGHIỆP THAM DỰ HỘI CHỢ VÀ TRIỂN LÃM QUỐC TẾ THƯỜNG NIÊN ẤN ĐỘ LẦN THỨ 37</h6>
					<p>
						Từ ngày 14/27/11/2017, tại thủ đô New Delhi, Ấn Độ sẽ diễn ra Hội chợ và triển lãm quốc tế Ấn Độ lần thứ 37, do Tổ chức xúc tiến thương mại IPTO (thuộc Bộ Thương mại Ấn Độ) tổ chức. Đây là Hội chợ hàng năm lớn nhất của Ấn Độ với sự tham gia của 7000 công ty từ 29 bang, 47 Bộ, ngành Ấn Độ và khoảng hơn 300 công ty nước ngoài từ 30 quốc gia.
						<span class="text-muted"><i class="fa fa-clock-o"></i> 10:22 Hôm nay</span>
					</p>
					<h6>‘Advance Saigon’, sự kiện Demo Day dành cho start-up Hàn Quốc và Việt Nam diễn ra từ ngày 12 đến 14 tháng 4, 2017 tại Sài Gòn.</h6>
					<p>
						‘Advance Saigon’ là sự kiện 3 ngày bắt đầu từ ngày 12 với Kick-Off Party, khởi động chuyến đi hệ sinh thái ở Việt Nam, cũng như ăn tối networking trên tàu giữa start-up và các nhà đầu tư vào ngày 13. Quan trọng nhất, Demo Day ngày 14 bao gồm các bài diễn thuyết quan trọng, các buổi hội thảo chuyên sâu, thảo luận nhóm và cuộc thi pitching. Start-up có nhiều cơ hội để xây dựng mối quan hệ chặt chẽ với các nhà đầu tư không chỉ từ Việt Nam mà từ Mỹ và Châu Âu.
						<span class="text-muted"><i class="fa fa-clock-o"></i> 09:58 Hôm nay</span>
					</p>
					<h6>Vườn Ươm H-Camp Vietnam Batch 2 của Hebronstar Ventures mở đơn đăng ký</h6>
					<p>
						H-Camp Việt Nam là một chương trình tăng tốc khởi nghiệp kéo dài 12 tuần, nhằm lựa chọn ra các startup tiềm năng, giúp họ hoàn thiện mô hình kinh doanh và cung cấp các kiến thức và kỹ năng để nâng cao khả năng gọi vốn thành công cho startup. H-Camp còn là nơi kết nối mạng lưới khởi nghiệp từ khắp nơi trên thế giới, mang đến cơ hội thu hút đầu tư và mở rộng kinh doanh trong và ngoài nước cho các startup.
						<span class="text-muted"><i class="fa fa-clock-o"></i> 06:33 Hôm nay</span>
					</p>
					</div>
				</div><div id="mCSB_4_scrollbar_vertical" class="mCSB_scrollTools mCSB_4_scrollbar mCS-light mCSB_scrollTools_vertical" style="display: block;"><div class="mCSB_draggerContainer"><div id="mCSB_4_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 159px; max-height: 190px;" oncontextmenu="return false;"><div class="mCSB_dragger_bar" style="line-height: 30px;"></div></div><div class="mCSB_draggerRail"></div></div></div></div></div>
			</div>
			<!-- END SALES & EVENTS BLOCK -->

		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body panel-body-map">
								<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.3144049622238!2d105.85361931511773!3d21.020102286003098!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135abed964d9913%3A0x5689fab751831efa!2zNTIgVHLhuqduIEjGsG5nIMSQ4bqhbywgUGhhbiBDaHUgVHJpbmgsIEhvw6BuIEtp4bq_bSwgSMOgIE7hu5lpLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1534394204264" width="100%" height="200" frameborder="0" style="border:0"></iframe>
            </div>
            <div class="panel-body">
                <h3><span class="fa fa-map-marker"></span> Bộ khoa học công nghệ</h3>
                <p>52 Trần Hưng Đạo, Hàng Bài, Hoàn Kiếm, Hà Nội, Việt Nam</p>
            </div>
        </div>
    </div>

		<div class="col-md-4">
	      <div class="panel panel-default">
	          <div class="panel-body panel-body-image">
	              <img src="assets/images/ocean.jpg" alt="Ocean">
	              <a href="#" class="panel-body-inform">
	                  <span class="fa fa-heart-o"></span>
	              </a>
	          </div>
	          <div class="panel-body">
	              <h3>Đề án nâng cấp đường truyền mạng cáp quang năm 2019</h3>
	              <p>On Earth, an ocean is one of the major conventional divisions of the World Ocean, which occupies two-thirds.</p>
	          </div>
	      </div>

	  </div>
	</div>


</div>

</div>
@endsection
@section('footer')
