$(function() {
	$('#block-add').on('hidden.bs.modal', function () {
		$('#block-add .modal-body').html('');
	});
	/*delete item block*/
	$(document).on('click', '.deleteItemBlock', function() {
		let _tr = $(this).closest('tr');
		let _name_form = _tr.attr('id').split('-')[0];
		$(_tr).remove();
		checkResidual($(this), _name_form, '');
	});
	$(document).on('click', '#close-popup-btn, #close-popup', function() {
		$('#bg-popup').fadeOut('normal');
		$('#block-add-product').fadeOut('normal');
	});
	/*save form partner*/
	$(document).on("submit", "#form-partner", function(event) {
		event.preventDefault();
		if(validateBlockAdd(1)) {
			$.ajax({
				url: $(this).attr("action"),
				type: $(this).attr("method"),
				dataType: "JSON",
				data: new FormData(this),
				processData: false,
				contentType: false,
				success: function (resp)
				{
					if(resp.msg == undefined) {
						let _class = 'even';
						if($('#block-partner tr').length%2 == 0)
							_class = 'odd';
						let _id = resp.data.id;
						let _name = resp.data.name;
						let tr = '<tr role="row" id="partner-'+_id+'" class="'+_class+'">';
						tr += '<td style="text-align: left !important;">'+_name+'</td>';
						tr += '<td><input type="number" name="partner['+_id+'][start]" class="form-control partner-start" value="" onkeyup="changeInputBlock(this, \'partner\', \'start\')"></td>';
						tr += '<td><input type="number" name="partner['+_id+'][amount]" class="form-control partner-amount" value="" onkeyup="changeInputBlock(this, \'partner\', \'amount\')"></td>';
						tr += '<td><input type="number" name="partner['+_id+'][end]" class="form-control partner-end" value="" onchange="checkSerialEnd(this)" onkeyup="changeInputBlock(this, \'partner\', \'end\')"></td>';
						tr += '<td class="text-center">';
						tr += '<a href="javascript: void(0);" class="deleteItemBlock" title="Xóa"><i class="fa fa-fw fa-remove"></i></a>';
						tr += '</td>';
						tr += '</tr>';
						$('#block-partner tbody').append(tr);
					} else {
						jAlert(resp.msg, 'Thông báo');
						return false;
					}
					$('#block-add').modal('hide');
				}
			});     
		}   
	});
	/*save form product*/
	$(document).on("submit", "#form-product", function(event) {
		event.preventDefault();
		if(validateBlockAdd(2)) {
			$.ajax({
				url: $(this).attr("action"),
				type: $(this).attr("POST"),
				dataType: "JSON",
				data: new FormData(this),
				processData: false,
				contentType: false,
				success: function (resp)
				{
					if(resp.msg == undefined) {
						let _class = 'even';
						if($('#block-product tr').length%2 == 0)
							_class = 'odd';
						let _id = resp.data.id;
						let _name = resp.data.name;
						let _code = resp.data.code;
						let _img = resp.data.introimage;
						let tr = '<tr role="row" id="product-'+_id+'" class="'+_class+'">'
						tr += '<td class="text-center">';
						if(_img != '') {
							tr += '<img src="'+_img+'" alt="" style="width: 50px; height: 50px">';
						}
						tr += '</td>';
						tr += '<td class="text-left">'+_code+'</td>';
						tr += '<td class="text-left">'+_name+'</td>';
						tr += '<td><input type="number" name="product['+_id+'][start]" class="form-control product-start" value="" onkeyup="changeInputBlock(this, \'product\', \'start\')"></td>';
						tr += '<td><input type="number" name="product['+_id+'][amount]" class="form-control product-amount" value="" onkeyup="changeInputBlock(this, \'product\', \'amount\')"></td>';
						tr += '<td><input type="number" name="product['+_id+'][end]" class="form-control product-end" value="" onchange="checkSerialEnd(this)" onkeyup="changeInputBlock(this, \'product\', \'end\')"></td>';
						tr += '<td>';
						tr += '<select class="form-control" id="protected_time_of_tem_'+_id+'" name="product['+_id+'][protected_time_of_tem]">';
						for(let i=1;i<100;i++) {
							tr += '<option value="'+i+'">' + i + ' tháng</option>';
						}
						tr += '</select></td>';
						tr += '<td class="text-center">';
						tr += '<a href="javascript: void(0);" class="deleteItemBlock" title="Xóa"><i class="fa fa-fw fa-remove"></i></a>';
						tr += '</td>';
						tr += '</tr>';
						$('#block-product tbody').append(tr);
					} else {
						jAlert(resp.msg, 'Thông báo');
						return false;
					}
					$('#bg-popup').fadeOut('normal');
					$('#block-add-product').fadeOut('normal');
				}
			});     
		}   
	});

	/*save form winning*/
	$(document).on("submit", "#form-winning", function(event) {
		event.preventDefault();
		if(validateBlockAdd(2)) {
			$.ajax({
				url: $(this).attr("action"),
				type: $(this).attr("method"),
				dataType: "JSON",
				data: new FormData(this),
				processData: false,
				contentType: false,
				success: function (resp)
				{
					if(resp.msg == undefined) {
						jAlert('Thêm giải thưởng thành công!', 'Thông báo');
					} else {
						jAlert(resp.msg, 'Thông báo');
						return false;
					}
					$('#bg-popup').fadeOut('normal');
					$('#block-add-product').fadeOut('normal');
				}
			});     
		}   
	});


});

/*add item to block*/
function addItemToBlock(el, type) {
	if(type == 1) {
		let _class = 'even';
		if($('#block-partner tr').length%2 == 0)
			_class = 'odd';
		let _id = $(el).attr('data-id');
		let _name = $(el).attr('data-name');
		let tr = '<tr role="row" id="partner-'+_id+'" class="'+_class+'">';
		tr += '<td style="text-align: left !important;">'+_name+'</td>';
		tr += '<td><input type="number" name="partner['+_id+'][start]" class="form-control partner-start" value="" onchange="checkResidual(this, \'partner\', \'start\')" onkeyup="changeInputBlock(this, \'partner\', \'start\')"></td>';
		tr += '<td><input type="number" name="partner['+_id+'][amount]" class="form-control partner-amount" value="" onchange="checkResidual(this, \'partner\', \'amount\')" onkeyup="changeInputBlock(this, \'partner\', \'amount\')"></td>';
		tr += '<td><input type="number" name="partner['+_id+'][end]" class="form-control partner-end" value="" onchange="checkResidual(this, \'partner\', \'end\')" onkeyup="changeInputBlock(this, \'partner\', \'end\')"></td>';
		tr += '<td class="text-center">';
		tr += '<a href="javascript: void(0);" class="deleteItemBlock" title="Xóa"><i class="fa fa-fw fa-remove"></i></a>';
		tr += '</td>';
		tr += '</tr>';
		$('#block-partner tbody').append(tr);
		$(el).closest('tr').remove();
		if($('#block-list-partner tr').length == 0) {
			$('#block-add').modal('hide');
		}
	} else {
		let _class = 'even';
		if($('#block-product tr').length%2 == 0)
			_class = 'odd';
		let _id = $(el).attr('data-id');
		let _name = $(el).attr('data-name');
		let _code = $(el).attr('data-code');
		let _img = $(el).attr('data-img');
		let tr = '<tr role="row" id="product-'+_id+'" class="'+_class+'">'
		tr += '<td class="text-center">';
		if(_img != '') {
			tr += '<img src="'+_img+'" alt="" style="width: 50px; height: 50px">';
		}
		tr += '</td>';
		tr += '<td class="text-left">'+_code+'</td>';
		tr += '<td class="text-left">'+_name+'</td>';
		tr += '<td><input type="number" name="product['+_id+'][start]" class="form-control product-start" value="" onchange="checkResidual(this, \'product\', \'start\')" onkeyup="changeInputBlock(this, \'product\', \'start\')"></td>';
		tr += '<td><input type="number" name="product['+_id+'][amount]" class="form-control product-amount" value="" onchange="checkResidual(this, \'product\', \'amount\')" onkeyup="changeInputBlock(this, \'product\', \'amount\')"></td>';
		tr += '<td><input type="number" name="product['+_id+'][end]" class="form-control product-end" value="" onchange="checkResidual(this, \'product\', \'end\')" onkeyup="changeInputBlock(this, \'product\', \'end\')"></td>';
		tr += '<td>';
		tr += '<select class="form-control" id="protected_time_of_tem_'+_id+'" name="product['+_id+'][protected_time_of_tem]">';
		for(let i=1;i<100;i++) {
			tr += '<option value="'+i+'">' + i + ' tháng</option>';
		}
		tr += '</select></td>';
		tr += '<td class="text-center">';
		tr += '<a href="javascript: void(0);" class="deleteItemBlock" title="Xóa"><i class="fa fa-fw fa-remove"></i></a>';
		tr += '</td>';
		tr += '</tr>';
		$('#block-product tbody').append(tr);
		$('select[id^="protected_time_of_tem"]').select2();
		$(el).closest('tr').remove();
		if($('#block-list-product tr').length == 0) {
			$('#block-add').modal('hide');
		}
	}
}
function checkResidual(el, name_form, name_el) {
	let _parent = $(el).closest('tr');
	if(name_el == 'end' && parseInt($(el).val()) < parseInt($('input[name*="start"]',$(_parent)).val())) {
		jAlert('Serial cuối phải lớn hơn hoặc bằng Serial đầu', 'Thông báo', function(){
			$(el).val('').focus();
		});
		return false;
	}
	let check = true;
	let msg = '';
	if(name_el != 'amount') {
		$('#block-'+name_form+' tbody tr').each(function(){
			if($(_parent).attr('id') != $(this).attr('id')) {
				if(parseInt($(el).val()) == parseInt($('input[name*="start"]',$(this)).val()) || parseInt($(el).val()) == parseInt($('input[name*="end"]',$(this)).val())) {
					check = false;
					msg = 'Số serial đã tồn tại';
					return false;
				}
				if(parseInt($(el).val()) > parseInt($('input[name*="start"]',$(this)).val()) && parseInt($(el).val()) < parseInt($('input[name*="end"]',$(this)).val())) {
					check = false;
					msg = 'Số serial không nằm trong các khối khả dụng';
					return false;
				}
			}
		});
	}
	if(check == false) {
		jAlert(msg, 'Thông báo', function(){
			$(el).val('').focus();
		});
		return false;
	} else {
		let used_arr = new Array();
		let arr = new Array();
		$('#block-'+name_form+' tbody tr').each(function(){
			if($('input[name*="start"]',$(this)).val() != '' && $('input[name*="end"]',$(this)).val() != '') {
				used_arr.push(parseInt($('input[name*="start"]',$(this)).val()));
				used_arr.push(parseInt($('input[name*="end"]',$(this)).val()));
			}
		});
		if(used_arr.length == 0) {
			arr.push([parseInt($('#block_start').val()), parseInt($('#block_end').val())]);
		} else {
			used_arr.sort(function(a,b){return a-b});
			let tmp_used = new Array();
			for(let i=0;i<used_arr.length;i+=2) {
				tmp_used.push([used_arr[i], used_arr[i+1]]);
			}
			$.each(tmp_used, function(idx) {
				if(idx == 0 && tmp_used[idx][0] > $('#block_start').val()) {
					arr.push([$('#block_start').val(),(tmp_used[idx][0] - 1)]);
				}
				if(idx > 0 && (tmp_used[idx][0]-1) > tmp_used[idx-1][1]) {
					arr.push([(tmp_used[idx-1][1] + 1), (tmp_used[idx][0] - 1)]);
				}
				if(idx == (tmp_used.length - 1) && tmp_used[idx][1] < $('#block_end').val()) {
					arr.push([(tmp_used[idx][1] + 1), $('#block_end').val()]);
				}
			});
		}
		for(let i=0;i<arr.length;i++) {
			arr[i] = '[' + arr[i].join('-') + ']';
		}
		$('#residual_'+name_form).text(arr.join(','));
	}
}
/*change amount*/
function changeInputBlock(el,name_form, name_el) {	
	let _parent = $(el).closest('tr');
	let _start = parseInt($('.'+name_form+'-start', $(_parent)).val());
	let _amount = parseInt($('.'+name_form+'-amount', $(_parent)).val());
	let _end = parseInt($('.'+name_form+'-end', $(_parent)).val());

	if($(el).val() != '') {
		if ((name_el == 'start' && _amount !== 'NaN') || (name_el == 'amount' && _start !== 'NaN')) {
			$('.'+name_form+'-end', $(_parent)).val((_start + _amount - 1));
		} else if ((name_el == 'start' && _end !== 'NaN') || (name_el == 'end' && _start !== 'NaN')) {
			$('.'+name_form+'-amount', $(_parent)).val((_end - _start + 1));
		}
		let total = 0;
		$('#block-' + name_form +' .'+name_form+'-amount').each(function() {
			if($(this).val() != '') {
				total += parseInt($(this).val());
			}
		});
		if(total > parseInt($('#block_end').val() - $('#block_start').val() + 1)) {
			jAlert('Tổng số tem vượt quá mức cho phép!', 'Thông báo', function(){
				$('.'+name_form+'-end', $(_parent)).val('');
				$('.'+name_form+'-amount', $(_parent)).val('');
				$(el).focus();
			});
			return false;
		} else {
			$('#total-block'+name_form).text(total);
		}
	}
}

/*check and save block residual*/
/*function checkDuplicateAndCalculateBlockResidual(id_tbl) {
	$('#'+id_tbl).
}*/

/*load form add new partner, product; add item to block */
function blockAddForm(type) {
	if(type == 1) {
		$('#block-modal-title').text('Thêm nhà phân phối');
	} else if(type == 2) {
		$('#block-popup-title').text('Thêm sản phẩm');
	} else if(type == 3) {
		$('#block-modal-title').text('Thêm nhà phân phối vào khối');
	} else {
		$('#block-modal-title').text('Thêm sản phẩm vào khối');
	}
	$.ajax({
		type: 'GET',
		url: $('#getFormUrl').val() + '/'+type+'/'+$('#partner-company-id').val()+'/'+$('#partner-guid').val(),
		dataType: 'json',
		success: function(resp) {
			if(type == 2) {
				$('#block-add-product .popup-body').html(resp.html);
				$('#block-add-product .popup-body').css({'max-height': $('#main-content').css('min-height'),'overflow-y': 'auto'});
				$('#bg-popup').fadeIn();
				$('#block-add-product').fadeIn();
			} else {
				$('#block-add .modal-body').html(resp.html);
				$('#block-add .modal-body').css({'max-height': $('#main-content').css('min-height'),'overflow-y': 'auto'});
				$('#block-add').modal('show');
			}
			if(type == 3 || type == 4) {
				$('#block-add .modal-body tr').each(function() {
					if($('tr#'+ $(this).attr('id')).length > 1) {
						$(this).remove();
					}
				});
				if($('#block-add .modal-body tr').length == 0) {
					let txt = type == 3 ? 'Không có nhà phân phối nào' : 'Không có sản phẩm nào';
					$('#block-add .modal-body').text(txt);
				}
			}
		}
	});
}

/*load form add new winning to block */
function blockAddWinning() {
	$('#block-popup-title').text('Thêm giải thưởng');
	$.ajax({
		type: 'GET',
		url: $('#url-add-winning').val(),
		data: {
			company_id: $('#product-company-id').val(), 
			guid: $('#product-guid').val()
		},
		dataType: 'json',
		success: function(resp) {
			$('#block-add-product .popup-body').html(resp.html);
			$('#block-add-product .popup-body').css({'max-height': $('#main-content').css('min-height'),'overflow-y': 'auto'});
			$('#bg-popup').fadeIn();
			$('#block-add-product').fadeIn();
		}
	});
}

function validateBlockAdd(type) {
	var check = true;
	if(type == 1) {
		$('input#name, input[name="company_id"]', $('#form-partner')).each(function() {
			if($(this).val() == '') {
				jAlert($(this).attr('placeholder') + ' không được để trống', 'Thông báo');
				check = false;
				return false;
			}
		});
	} else {
		$('input#name, input[name="company_id"]', $('#form-product')).each(function() {
			if($(this).val() == '') {
				jAlert($(this).attr('placeholder') + ' không được để trống', 'Thông báo');
				check = false;
				return false;
			}
		});
	}
	return check;
}

function saveBlockPartner() {
	$.ajax({
		type: 'POST',
		url: $('#form-saveBlockPartner').attr('action'),
		data: $('#form-saveBlockPartner').serialize(),
		dataType: 'json',
		success: function(resp) {
			if(resp.msg != undefined) {
				jAlert(resp.msg, 'Thông báo');
				return false;
			}
		}
	});
}

function saveBlockProduct() {
	$.ajax({
		type: 'POST',
		url: $('#form-saveBlockProduct').attr('action'),
		data: $('#form-saveBlockProduct').serialize(),
		dataType: 'json',
		success: function(resp) {
			
			toastr.success('Lưu thành công!');
			window.location.reload();

		}
	});
}