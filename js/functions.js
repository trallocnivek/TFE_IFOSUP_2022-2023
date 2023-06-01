/**
 * @site SwingShift
 * @domain http(s)://www.swingshift.be
 * @authors Collart Kevin
 * @uses files [utils-KC_ES6.js]
 * @version 2020/06/04 TO 2H24
 */
// function select_lang_show(){
	// Tools.removeClass(Tools.id('select_lang'), 'hide');
	// Tools.css(Tools.id('lang'), 'backgroundColor', 'burlywood');
	// Tools.css(Tools.id('select_lang'), 'visibility', 'visible');
	// Tools.css(Tools.id('select_lang'), 'borderColor', 'darkred');
	// Tools.css(Tools.id('select_lang'), 'backgroundColor', 'white');
// }
// function select_lang_hide(){
	// Tools.addClass(Tools.id('select_lang'), 'hide');
	// Tools.css(Tools.id('lang'), 'backgroundColor', 'darkred');
	// Tools.css(Tools.id('select_lang'), 'visibility', 'hidden');
	// Tools.css(Tools.id('select_lang'), 'borderColor', 'transparent');
	// Tools.css(Tools.id('select_lang'), 'backgroundColor', 'transparent');
// }
// function return_hover(){
	// Tools.css(Tools.query('.upReturn a'), 'color', 'burlywood');
// }
// function return_out(){
	// Tools.css(Tools.query('.upReturn a'), 'color', '#007BFF');
// }
function change_frame(url){
	Tools.setAttr(Tools.id('partosch'), 'src', url);
}
function verif_pseudo(regexp, elem){
	console.log(regexp);
}
function verif_regexp(type, elem){
	// console.log('xhr start');
	// 
	Tools.ajax({
		url: './php/form/ajax_regexp.php', // required
		params: { // REQUEST data default: null
			regexp: type,
			value: elem.value
		},
		function: {
			name: `verif_${type}`,
			params: elem
		}
	});
	// 
	/*var xhr = new XMLHttpRequest();
	var data = {
		regexp: type,
		value: elem.value
	};
	xhr.open('post', './php/form/ajax_regexp.php', true);
	xhr.setRequestHeader("Content-Type", "application/json");
	xhr.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			window[`verif_${type}`](JSON.parse(this.responseText), elem);
		}
	};
	xhr.send(JSON.stringify(data));*/
	// console.log('xhr', xhr.responseText);
}
function toggle_fold(cl, span_id){
	// let list_id = 'fold_conditions', 'fold_rgpd', 'fold_cookies';
	let list_id = [
		{cl: 'conditions_generales', id: 'fold_conditions'},
		{cl: 'RGPD', id: 'fold_rgpd'},
		{cl: 'cookies', id: 'fold_cookies'}
	];
	list_id.forEach(e => {
		if(span_id != e.id){
			Tools.query_loop(Tools.queryAll('article.' + e.cl), 'addClass', 'unfold');
			if(Tools.getClass(Tools.query('article.' + e.cl), 'unfold')) Tools.setHtml(Tools.id(e.id), 'V');
			else Tools.setHtml(Tools.id(e.id), 'X');	
		}
	});
	Tools.query_loop(Tools.queryAll('article.' + cl), 'toggleClass', 'unfold');
	if(Tools.getClass(Tools.query('article.' + cl), 'unfold')) Tools.setHtml(Tools.id(span_id), 'V');
	else Tools.setHtml(Tools.id(span_id), 'X');
}
function add_task(){ // pour afficher le formulaire
	console.log('add_task');
	Tools.css(Tools.id('add_task_form'), 'display', 'block');
}
function del_task(id){
	console.log('del task');
	Tools.ajax({
		url: './php/form/ajax_admin.php',
		params: {
			data_type: 'task',
			action: 'delete',
			id: id
		}
	});
	print_task();
}
function print_task(){
	console.log('print tasks');
	Tools.ajax({
		url: './php/form/ajax_admin.php',
		params: {
			data_type: 'task',
			action: 'read'
		},
		function: {
			name: 'build_task_list'
		}
	});
}
function build_task_list(data){
	data = Tools.getJSON(data);
	console.log(['data', data.length]);
	console.log(data.length != 0 ? data : 'null');
	let html = '';
	if(data == 0) html = '<article><p>No task !</p></article>';
	else data.forEach(e => {
		html += '<article style="border: 1px solid white; padding: 0 1rem; margin-bottom: 1rem;">'
            + '<h4>' + e['name'] + '<span class="close right pointer" onclick="del_task(' + e['id'] + ')">X</span></h4>'
            + '<hr>'
            + '<p>' + e['description'] + '</p>'
            + '<hr>'
            + '<p>'
            + '<small>created at : ' + e['created_at'] + '</small><br>'
            + '<small>updated at : ' + e['updated_at'] + '</small>'
            + '</p>'
            + '</article>'
        ;
	}, html);
    console.log(html);
    Tools.setHtml(Tools.id('task_list'), html);
    Tools.css(Tools.query('#task_list article:last-of-type'), 'marginBottom', '0');
}
function send_task(form){
	console.log('send task');
	let valid = true;
	let data = {
		data_type: 'task',
		action: 'add',
		user: form.user_id.value,
		name: form.task.value,
		description: form.description.value
	};
	console.table(data);
	// if(data.length != 0) valid = true;
	if(valid){
		try{
			Tools.ajax({
				url: './php/form/ajax_admin.php',
				params: data
			});
			console.log('SUCCESS SEND OK !');
			Tools.css(Tools.id('add_task_form'), 'display', 'none');
			print_task();
			return true;
		}catch(e){
			console.log('ERROR NO SEND !');
			return false;
		}
	} else return false;
}
function close(){
	console.log('close');
	Tools.css(Tools.id('add_task_form'), 'display', 'none');
}
function user_infos_change(user_id, input_id){
	let name = '';
	let table = 'swing_' + name;
	let col = '';
	let value = Tools.id(input_id).value;
	Tools.ajax({
		url: './php/db/db_users.php',
		params: {
			id: user_id,
			table: table,
			col: col,
			value: value
		}
	});
}
function check_form(e, form, mode, page){
	// console.log('check_form()');
	let no_error = false;
	let error_list = [];
	if(form != undefined){
		// alert('form not null');
		// console.log(mode);
		if(mode == 'admin' && page == 'gestion_site'){
			let title = form.db_elem_title.value;
			let auth = form.auth_id.value;
			let url = form.url.value;
			let action = form.action.value;
			let regex_title = /^[a-z0-9_]+$/i;
			let regex_auth = /^[1-6]$/;
			let regex_url = /^\?page=[a-zA-Z0-9_]+(&mode=admin)?(&action=(read|view|update|create|delete))?$/;
			if(action == 'create'){
				if(title.match(regex_title)){
					Tools.removeClass(form.db_elem_title, 'border_red');
					Tools.addClass(form.db_elem_title, 'border_lime');
					error_list.push(true);
				}else{
					Tools.removeClass(form.db_elem_title, 'border_lime');
					Tools.addClass(form.db_elem_title, 'border_red');
					error_list.push(false);
				}
				if(auth.match(regex_auth)){
					Tools.removeClass(form.auth_id, 'border_red');
					Tools.addClass(form.auth_id, 'border_lime');
					error_list.push(true);
				}else{
					Tools.removeClass(form.auth_id, 'border_lime');
					Tools.addClass(form.auth_id, 'border_red');
					error_list.push(false);
				}
				if(url.match(regex_url)){
					Tools.removeClass(form.auth_id, 'border_red');
					Tools.addClass(form.auth_id, 'border_lime');
					error_list.push(true);
				}else{
					Tools.removeClass(form.url, 'border_lime');
					Tools.addClass(form.url, 'border_red');
					error_list.push(false);
				}
			}else if(action == 'update'){

			}
		}
	}
	// console.table(error_list);
	for(let i = 0; i < error_list.length; i++){
		if(error_list[i]) no_error = true;
		else{
			no_error = false;
			break;
		}
	}
	// console.log('result = ' + no_error);
	if(no_error) return form.submit();
	else return e;
}