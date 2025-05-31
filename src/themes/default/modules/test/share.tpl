<!-- BEGIN: main -->
<style>
body {
	background-color: #ddd
}
</style>
<div class="container box-content">
	<div class="row">
		<!-- 
        <div class="col-xs-24 col-sm-24 col-md-8 col-lg-8 user-details">
            <div class="user-image">
                <img src="http://www.gravatar.com/avatar/2ab7b2009d27ec37bffee791819a090c?s=100&d=mm&r=g" alt="Karan Singh Sisodia" title="Karan Singh Sisodia" class="img-circle">
            </div>
            <div class="user-info-block">
                <div class="user-heading">
                    <h3>Nguyễn Văn A</h3> 
                    <span class="help-block">Chandigarh, IN</span>
                </div>
                <ul class="navigation">
                    <li class="active col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <a data-toggle="tab" href="#information" class="col-xs-24 col-sm-24 col-md-24 col-lg-24">
                            <span class="glyphicon glyphicon-user"></span>
                        </a>
                    </li>
                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <a data-toggle="tab" href="#settings" class="col-xs-24 col-sm-24 col-md-24 col-lg-24">
                            <span class="glyphicon glyphicon-cog"></span>
                        </a>
                    </li>
                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <a data-toggle="tab" href="#email" class="col-xs-24 col-sm-24 col-md-24 col-lg-24">
                            <span class="glyphicon glyphicon-envelope"></span>
                        </a>
                    </li>
                    <li class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <a data-toggle="tab" href="#events" class="col-xs-24 col-sm-24 col-md-24 col-lg-24">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </a>
                    </li>
                </ul>
                <div class="user-body">
                    <div class="tab-content">
                        <div id="information" class="tab-pane active">
                            <h4 class="text-center">Mức độ thông thạo tiếng anh</h4>
                            <div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 text-center score-box">
                                <svg id="animatedhh" viewbox="0 0 100 100">
                                    <circle cx="50" cy="50" r="45" fill="#428BCA"/>
                                    <path id="progresshh" stroke-linecap="round" stroke-width="5" stroke="#fff" fill="none" d="M50 10 a 40 40 0 0 1 0 80 a 40 40 0 0 1 0 -80"></path>
                                    <text id="counthh" x="50" y="50" text-anchor="middle" dy="7" font-size="14">80</text>
                                </svg>
                            </div>
                        </div>
                        <div id="settings" class="tab-pane">
                            <h4>Bảng xếp hạng</h4>
                            <div role="tabpanel">
                                <ul class="nav nav-tabs col-xs-8 col-sm-8 col-md-8 col-lg-24" role="tablist">
                                    <li role="presentation" class="active col-xs-8 col-sm-8 col-md-8 col-lg-8 nomargin nopadding">
                                        <a href="#tuan" aria-controls="tuan" role="tab" data-toggle="tab">Tuần</a>
                                    </li>
                                    <li role="presentation" class="col-xs-8 col-sm-8 col-md-8 col-lg-8 nomargin nopadding">
                                        <a href="#thang" aria-controls="thang" role="tab" data-toggle="tab">Tháng</a>
                                    </li>
                                    <li role="presentation" class="col-xs-8 col-sm-8 col-md-8 col-lg-8 nomargin nopadding">
                                        <a href="#tcong" aria-controls="tcong" role="tab" data-toggle="tab">Tổng cộng</a>
                                    </li>
                                </ul>
                            
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="tuan">
                                        <div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 text-center">
                                            <button type="button" class="btn btn-info mrg-btn">Tìm bạn trên Facebook</button>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="thang">
                                        <div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 text-center">
                                            <button type="button" class="btn btn-info mrg-btn">Tìm bạn trên Facebook</button>
                                        </div>                                        
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="tcong">
                                        <div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 text-center">
                                            <button type="button" class="btn btn-info mrg-btn">Tìm bạn trên Facebook</button>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="email" class="tab-pane">
                            <h4>Theo dõi Aztest</h4>
                            <div class="row">
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    
                                </div>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    
                                </div>
                            </div>
                        </div>
                        <div id="events" class="tab-pane">
                            <h4>Events</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->
		<div class="col-xs-24 col-sm-24 col-md-16 col-lg-16 user-details clear-fl">
			<div class="user-image">
				<img src="{INFO.photo}" width="100px" height="100px" alt="Karan Singh Sisodia" title="Karan Singh Sisodia" class="img-circle" width="100px">
			</div>
			<div class="user-info-block">
				<div class="user-heading">
					<h3>{INFO.fullname}</h3>
				</div>
				<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 title-header-panel">
					<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24">
						<h1>{EXAM_INFO.title}</h1>
					</div>
					<div class="col-xs-24 col-sm-24 col-md-12 col-lg-12">
						<table class="panel-exam-header">
							<tr>
								<td><p>Tổng số câu hỏi</p></td>
								<td><p>: {EXAM_INFO.num_question}</p></td>
							</tr>
							<tr>
								<td><p>Thời gian làm bài</p></td>
								<td><p>: {EXAM_INFO.timer} phút</p></td>
							</tr>
						</table>
					</div>
					<div class="col-xs-24 col-sm-24 col-md-12 col-lg-12 text-center">
						<a href="{EXAM_INFO.link}" class="btn margin-btn text-center btn-test" title="Kiểm tra">Kiểm tra</a>
					</div>
				</div>
				<div class="panel-body bg-panel-quiz col-xs-24 col-sm-24 col-md-24 col-lg-24">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-8 col-md-push-16 col-sm-8">
								<center>
									<div class="progress-pie-chart" data-percent="{INFO.percent}">
										<!--Pie Chart -->
										<div class="ppc-progress">
											<div class="ppc-progress-fill"></div>
										</div>
										<div class="ppc-percents">
											<div class="pcc-percents-wrapper">
												<span>Điểm</span>
											</div>
										</div>
									</div>
								</center>
								<!--End Chart -->
							</div>
							<div class="col-md-16 col-md-pull-8 col-sm-16">
								<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 nopadding nomargin">
									<div class="skillbar-title" style="background: #d35400;">
										<p class="text-nowrap">Số câu đúng</p>
									</div>
									<div class="skillbar clearfix " data-percent="{INFO.count_true}">
										<div class="skillbar-bar" style="background: #e67e22;"></div>
										<div class="skill-bar-percent">{INFO.count_true}</div>
									</div>
								</div>
								<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 nopadding nomargin">
									<div class="skillbar-title" style="background: #2980b9;">
										<p>Số câu sai</p>
									</div>
									<div class="skillbar clearfix " data-percent="{INFO.count_false}">
										<div class="skillbar-bar" style="background: #3498db;"></div>
										<div class="skill-bar-percent">{INFO.count_false}</div>
									</div>
								</div>
								<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 nopadding nomargin">
									<div class="skillbar-title" style="background: #2c3e50;">
										<p>Số câu chưa làm</p>
									</div>
									<div class="skillbar clearfix " data-percent="{INFO.count_skeep}">
										<div class="skillbar-bar" style="background: #2c3e50;"></div>
										<div class="skill-bar-percent">{INFO.count_skeep}</div>
									</div>
								</div>
								<!-- BEGIN: rating -->
								<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 nopadding nomargin">
									<div class="skillbar-title" style="background: #46465e;">
										<p>Xếp loại</p>
									</div>
									<div class="skillbar clearfix " data-percent="100%">
										<div class="skillbar-bar" style="background: #5a68a5;"></div>
										<div class="skill-bar-percent">{INFO.rating.title}</div>
									</div>
								</div>
								<!-- END: rating -->
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24">
							<div class="col-md-24">
								<h1 class="text-center">{LANG.share_now}</h1>
							</div>
							<div class="col-xs-24 col-sm-24 col-md-24 col-lg-24 text-center">
								<ul class="social-network social-circle">
									<li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={EXAM_INFO.url_share}" class="icoFacebook" title="Facebook"><i class="fa fa-facebook"></i></a></li>
									<li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={EXAM_INFO.url_share}" class="icoTwitter" title="Twitter"><i class="fa fa-twitter"></i></a></li>
									<li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={EXAM_INFO.url_share}" class="icoGoogle" title="Google +"><i class="fa fa-google-plus"></i></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	// cau tra loi
	jQuery(document).ready(function() {
		jQuery('.skillbar').each(function() {
			jQuery(this).find('.skillbar-bar').animate({
				width : jQuery(this).attr('data-percent')
			}, 2000);
		});
	});
</script>
<script>
	$(function() {
		var $ppc = $('.progress-pie-chart'), percent = parseInt($ppc
				.data('percent')), deg = 360 * percent / 100;
		if (percent > 50) {
			$ppc.addClass('gt-50');
		}
		$('.ppc-progress-fill').css('transform', 'rotate(' + deg + 'deg)');
		$('.ppc-percents span').html('{INFO.score} Điểm');
	});

	// tinh diem
	// var count = $(('#count'));
	// var diem = {INFO.score};
	// $({ Counter: 0 }).animate({ Counter: count.text() }, {
	// duration: 5000,
	// easing: 'linear',
	// step: function () {
	// count.text(Math.ceil(this.Counter)+ " Điểm sdsd");
	// }
	// });
	// var s = Snap('#animated');
	// var progress = s.select('#progress');
	// progress.attr({strokeDasharray: '0, 251.2'});
	// // border outline
	// Snap.animate(0,80.2, function( value ) {
	// progress.attr({ 'stroke-dasharray':value+',251.2'});
	// }, 5000);

	// // muc do thong thao
	// var counthh = $(('#counthh'));
	// $({ counthher: 0 }).animate({ counthher: counthh.text() }, {
	// duration: 5000,
	// easing: 'linear',
	// step: function () {
	// counthh.text(Math.ceil(this.counthher)+ " Điểm");
	// }
	// });
	// var s = Snap('#animatedhh');
	// var progresshh = s.select('#progresshh');
	// progresshh.attr({strokeDasharray: '0, 251.2'});
	// // border outline
	// Snap.animate(0,180.2, function( value ) {
	// progresshh.attr({ 'stroke-dasharray':value+',251.2'});
	// }, 5000);
	// //animated mdtt progressmdtt   count mdtt
</script>
<!-- END: main -->