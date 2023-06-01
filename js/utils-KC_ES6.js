/**
 * @class Tools
 * @static
 * @see public
 * @description tools class for code facilities
 * @property
 * 	[static public]
 * 		- ajax_default
 * 		- date
 * 		- data
 * @method
 * 	! NO CONSTRUCTOR()
 * 	[static public]
 * 		- attr()
 * 		- setAttr()
 * 		- addEvent()
 * 		- id()
 * 		- toggle_check()
 * 		- select_check()
 * 		- class()
 * 		- getClass()
 * 		- itemClass()
 * 		- addClass()
 * 		- replaceClass()
 * 		- removeClass()
 * 		- toggleClass()
 * 		- start_app()
 *   	- end_app()
 *	   	- classe()
 *		- methode()
 *		- KC_ev()
 *		- css()
 *		- format_n2c()
 *		- get_date()
 *		- get_date_format()
 *		- date_bissextile()
 *		- date_format_utc()
 *		- date_format_short()
 *		- date_format_long()
 *		- date_format_perso()
 *		- date()
 *		- date_kc_print()
 *		- day_name_or_num()
 *		- month_name_or_num()
 *		- hover()
 *		- test()
 *		- resize_img()
 *		- resize_figure_img()
 *		- initElem()
 *		- getJSON()
 *		- setJSON()
 *		- list_callback_loop()
 *		- query_loop()
 *		- name()
 *		- nodeLoop()
 *		- addAdjHtml()
 *  	- removeHtml()
 *		- mathx()
 *		- min_max_random()
 *		- fnum()
 *		- calcPercent()
 *		- calcTotal()
 *		- tva()
 *		- pay_no_emprunt()
 *		- pay_rest()
 *		- taux_mois()
 *		- pay_emprunt()
 *		- query()
 *		- queryAll()
 *		- local_data()
 *		- htmlspecialchars()
 *		- netChaineTXT()
 *		- doubleSynchro()
 *		- in_array()
 *		- is_array()
 *		- doubleCompTable()
 *		- isInTable()
 *		- builtTable()
 *		- array_moyenne()
 *		- tag()
 *		- redirect()
 *		- reload()
 *		- ancre()
 *		- url_data()
 *		- getValue()
 *		- setValue()
 *		- addValue()
 *		- getHtml()
 *		- setHtml()
 *		- addHtml()
 *		- getText()
 *		- setText()
 *		- addText()
 *		- setTextContent()
 *		- setWrite()
 *		- addWrite()
 *		- ajax()
 *		- xhr()
 *		- responseHTML()
 *		- responseJSON()
 *		- responseTEXT()
 *		- responseXML()
 * @site SwingShift
 * @domain http(s)://www.swingshift.be
 * @authors Collart Kevin
 * @api JS utils
 * @uses < none >
 * @version 2021/06/04 TO 2H44
 */
class Tools{
	/*static ajax_default = {
    	async: true,
    	class: null,
    	format: 'json',
		functions: {
			action: 'setHtml',
			response: 'response',
			xhr: 'onreadystatechange'
		},
		headers: {
			cache: '',
			mime: ''
		},
    	id: null,
		method: 'post',
		timeout: null,
		url: {
			action: '',
			param: ''
		},
    	success: null,
    	warning: null,
    	error: null
	};*/
	static ajax_default = {
		async: true,
		format: 'json',
		method: 'post',
		url: './',
		params: {},
		xhr: 'onreadystatechange',
		function: {
			name: null,
			params: null
		},
		user: null,
		password: null
	};
	static date = {
		date: null,
		year: null,
		month: null,
		day: null,
		monthNum: null,
		dayNum: null,
		houre: null,
		min: null,
		sec: null,
		milliSec: null
	};
	static data = null;
	// ATTRIBUTE
	static attr(obj, val){
		return obj.attribute = val;
	}
	static setAttr(obj, attr, val){
		return obj.setAttribute(attr, val);
	}
	// EVENT
	static addEvent(obj, event, func){
		return obj.addEventListener(event, func);
	}
	// ID
	static id(id){
		return document.getElementById(id);
	}
	// CHECKBOX
	static toggle_check(source, elem, fct = null){
		var checkboxes = this.queryAll('input[type="checkbox"]');
  		for(var i = 0; i < checkboxes.length; i++){
  			if(checkboxes[i] != source){
    			checkboxes[i].checked = source.checked;
    			elem[i - 1].check = source.checked;
    		}	
  		}
  		if(fct != null) fct();
	}
	static select_check(elem, i, fct = null){
		var x = 'check' + i;
		if(this.id(x).checked == true){
			elem[i].check = true;
		}else{
			elem[i].check = false;
		}	
  		if(fct != null) fct();
	}
	// CLASS
	static class(obj, cl){
		return obj.getElementsByClassName(cl);
	}
	static getClass(obj, cl){
		return obj.classList.contains(cl);
	}
	static itemClass(obj, cl){
		return obj.classList.item(cl);
	}
	static addClass(obj, cl){
		return obj.classList.add(cl);
	}
	static replaceClass(obj, cl, replace){
		return obj.classList.replace(cl, replace);
	}
	static removeClass(obj, cl){
		return obj.classList.remove(cl);
	}
	static toggleClass(obj, cl){
		return obj.classList.toggle(cl);
	}
	// CONSOLE
	/*start_app(x){
        console.log('%c ' + x + ' OK ! ', 'color: lime; background: black; font-weight: bold');
    }*/
    /*end_app(x){
        console.log('%c ' + x + ' OK ! ', 'color: red; background: black; font-weight: bold');
    }*/
    /*classe(x, cl = '', v = ''){
        console.log(
        	x + ' %c => ' + cl + ' imported ! ', 
        	'color: yellow;' 
        	+ (
        		v === 'v' ? 'background: #00ff0077' 
        		: v === 'y' ? 'background: #ffff0077' 
        		: v === 's' ? 'background: #fa8072aa' 
        		: v === 'b' ? 'background: #87ceebaa' 
        		: v === 'g' ? 'background: #ffffff77' 
        		: v === 'o' ? 'background: #ffa50077' 
        		: ''
        	)
        );
    }*/
    /*methode(cl, x){
        console.log(
        	' ' + cl + ' => %c ' + x + ' executed ! ', 
        	'color: orange;background:' 
        	+ (
        		cl === 'controller' ? '#00ff0077' 
        		: cl === 'UIController' ? '#87ceebaa' 
        		: cl === 'budgetController' ? '#fa8072aa' 
        		: cl === 'KC_SELECTOR' ? '#ffa50077' 
        		: 'transparent'
        	)
        );
    }*/
    /*KC_ev(x){
        console.log('%c ' + x + ' OK ! ', 'color: salmon');
    }*/
	// CSS
	static css(obj, property, val){
		return obj.style[property] = val;
	}
	// FORMAT
	static format_n2c(x){
		return ((x < 10) ? '0' : '') + x;
	}
	// DATE
	static get_date(x = null, lang = 'fr'){
		this.date(x, lang);
		return this.date;
	}
	/*static get_date_format(format = 'short', x = null, lang = 'fr'){
		let result;
		this.get_date(x, lang);
		switch(format){
			case 'utc': result = date.;
			case 'short': result = date.;
			case 'long': result = date.;
			case 'perso': result = date.;
			default: 
		}
	}*/
	/*static date_bissextile(date){
		return new Date(new Date(date).getFullYear(), 2, 0).getDate() >= 29;
	}
	static date_format_utc(lang){}
	static date_format_short(lang){}
	static date_format_long(lang){}
	static date_format_perso(lang){}
	static date(x = null, lang = 'fr'){
		let date;
		if(typeof x === 'object' && !Array.isArray(x)) date = new Date(`${x.year}-${x.month}-${x.day}`);
		else date = new Date.now();
		this.date = {
			date: date,
			year: date.getFullYear(),
			monthIndex: date.getMonth(),
			monthNum: this.month_name_or_num(date.getMonth(), lang, true, true),
			monthName: this.month_name_or_num(date.getMonth(), lang, true, false),
			dayIndex: date.getDay(),
			dayNum: this.day_name_or_num(date.getDay(), lang, true, true),
			dayName: this.day_name_or_num(date.getDay(), lang, true, false),
			houre: date.getHours(),
			min: date.getMinutes(),
			sec: date.getSeconds(),
			milliSec: date.getMilliseconds(),
			time: date.time()
		};
	}
	static date_kc_print(v){
		var x = parseInt(v);
		var d = new Date();
		var j = d.getDate();
		var m = d.getMonth() + 1;
		var a = d.getFullYear();
		var date = '';
		if(v === null){
			date = this.format_n2c(j) + '/' + this.format_n2c(m) + '/' + this.format_n2c(a);
			return date;
		}else if(v >= 0){
			var J = 25;
			var M = d.getMonth() + x + 1;
			var A = d.getFullYear();
			var Y = A;
			for(var i = 0; i < x; i++){
				if(M >= 12){
					if (M > 12) {
						var testAnnee = M / 12;
						testAnnee = parseInt(testAnnee);
						var okAnnee = 0;
						if((M / testAnnee) === 12) okAnnee = testAnnee - 1;
						else okAnnee = testAnnee;
						M = M % 12;
						if(M === 0) M = 12;
						Y += okAnnee;
					}
				}
			}
			date = this.format_n2c(J) + '/' + this.format_n2c(M) + '/' + this.format_n2c(Y);
			return date;
		}
	}
	static day_name_or_num(x, lang = 'fr', index = true, parse = false){
		const name = {
			fr: ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'],
			en: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
			nl: ['maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag', 'zondag']
		};
		if(typeof x === 'string' && !index) return parseInt(name[lang].indexOf(x))++;
		else if(typeof x === 'string' && index) return name[lang].indexOf(x);
		else if(typeof x === 'number' && !index && !parse) return name[lang][--x];
		else if(typeof x === 'number' && index && !parse) return name[lang][x];
		else if(typeof x === 'number' && index && parse) return parseInt(x)++;
		else return false;
	}
	static month_name_or_num(x, lang = 'fr', index = false, parse = false){
		const name = {
			fr: ['janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
			en: ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'],
			nl: ['januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december']
		};
		if(typeof x === 'string' && !index) return parseInt(name[lang].indexOf(x))++;
		else if(typeof x === 'string' && index) return name[lang].indexOf(x);
		else if(typeof x === 'number' && !index && !parse) return name[lang][--x];
		else if(typeof x === 'number' && index && !parse) return name[lang][x];
		else if(typeof x === 'number' && index && parse) return parseInt(x)++;
		else return false;
	}*/
	// HOVER
	/*static hover(data){
	// Tools.addEvent(this, 'onmouseenter', Tools.css(this, 'backgroundColor', '#FFFFFF55'));
	// Tools.addEvent(this, 'onmouseleave', Tools.css(this, 'backgroundColor', 'transparent'));
		if(typeof data === 'array'){
			for(let elem in array){
				if(typeof elem === 'array'){
					// if(this.id())
					this.addEvent(obj, 'onmouseenter', this.addClass(obj, 'hover'));
					this.addEvent(obj, 'onmouseleave', this.removeClass(obj, 'hover'));
				}else{

				}
			}
		}else{

		}
	}*/
	/*static test(){
		return 'Tools.test()';
	}*/
	// IMG
	static resize_img(img, width, height){
		this.css(img, 'width', width + (width != 'auto' ? 'px' : ''));
	}
	static resize_figure_img(data, func = 'queryAll'){
		var this_array = ['queryAll'];
		if(this.in_array(this_array, func)) this[func](data).forEach(e => {
			let child = e.childNodes[0];
			let figure = {
				'width' : e.offsetWidth,
				'height' : e.offsetHeight
			};
			let img = {
				'width' : child.offsetWidth,
				'height' : child.offsetHeight
			};
			let ratio = img.height / img.width;
			this.css(e, 'textAlign', 'center');
			this.css(e, 'overflow', 'hidden');
			this.css(child, 'display', 'block');
			if(img.width > img.height) this.resize_img(child, figure.width / ratio);
			else this.resize_img(child, figure.width * ratio);
			if(e.offsetWidth < child.offsetWidth){
				let margin = (child.offsetWidth - e.offsetWidth) / 2;
				this.css(child, 'marginLeft', '-' + margin + 'px');
			}
		}, this);
	}
	// INIT
	static initElem(elem, val = null){
		if(val != null) elem.value.reset();
		else elem.reset();
	}
	// JSON
	static getJSON(json){
		return JSON.parse(json);
	}
	static setJSON(json){
		return JSON.stringify(json);
	}
	// LOOP
	static list_callback_loop(list, callback){
		for(var i = 0; i < list.length; i++) callback(list[i], i);
	}
	static query_loop(query_list, callback, value, this_mode = true){
		query_list.forEach(e => {
			if(this_mode) this[callback](e, value);
			else callback(e, value);
		}, this);
	}
	// NAME
	static name(name){
		return document.getElementsByName(name);
	}
	// NODE
	static nodeLoop(obj, node, nbrLoop, key = null){
		let result = obj;
		for(let i = 0; i < nbrLoop; i++) result = result[node];
		if(key != null) result = result[key];
		return result;
	}
	static addAdjHtml(obj, type, html){
		return obj.insertAdjacentHTML(type, html);
	}
	static removeHtml(obj, node){
		return obj[node].removeChild(obj);
	}
	// NUMBER
	static mathx(type, x){
		var o = Math;
		var r = undefined;
		switch(type){
			case 'a': r = o.abs(x); break;
			case 'c': r = o.cos(x); break;
			case 'f': r = o.floor(x); break;
			case 'M': r = o.max(x); break;
			case 'p': r = o.pow(x); break;
			case 'r': r = o.random(x); break;
			case 's': r = o.sqrt(x); break;
			case 't': r = o.trunc(x); break;
			default: r = o.x;
		}
		return r;
	}
	static min_max_random(min, max){
		min = Math.ceil(min);
  		max = Math.floor(max);
  		return Math.floor(Math.random() * (max - min)) + min;
	}
	static fnum(nbr, type){
        var nbrSplit, entier, decimal, result;
        nbr = Math.abs(nbr).toFixed(2);
        nbrSplit = nbr.split('.');
        entier = nbrSplit[0];
        decimal = nbrSplit[1];
        result = new Intl.NumberFormat().format(entier);
        return (type === 'exp' && nbr != 0 ? '-' : nbr != 0 ? '+' : '') + ' ' + result + '.' + decimal;
    }
	/*static calcPercent(inc, e){
		if(inc > 0) e.pour = Math.round((e.val / inc) * 100);
		else e.pour = -1;
	}*/
	/*static calcTotal(list){
		let somme = 0;
		list.foreach(function(e){somme += e.val;});
		return somme;
	}*/
	static tva(prix, taux){
		return prix * taux;
	}
	/*static pay_no_emprunt(value, accompte, finance){
		var a = accompte;
		var t = finance;
		for(var i = 0; i < value; i++){
			a += t;
		}
		return a.toFixed(2);
	}*/
	/*static pay_rest(value, accompte, finance, total){
		var d = pay_no_emprunt(value, accompte, finance);
		var t = total;
		t -= d;
		return t.toFixed(2);
	}*/
	/*static taux_mois(v, tauxBanque){
		var x = parseInt(v);
		var test = 0;
		var tauxParMois = 0.5;
		var t = 0;
		for(var i = 0; i < x; i++){
			if (x >= 12) {
				if (x > 12) {
					var testAnnee = x / 12;
					testAnnee = parseInt(testAnnee);
					var okAnnee = 0;
					if ((x / testAnnee) === 12) {
						okAnnee = testAnnee - 1;
					}else{	
						okAnnee = testAnnee;
					}
					x = x % 12;
					if (x === 0) {
						x = 12;
					}
					test += okAnnee;
				}
			}
		}
		t = tauxBanque + test * 0.5;
		return t.toFixed(2);
	}*/
	/*static pay_emprunt(value, accompte, total, mensu){
		var x = parseInt(value);
		var y = this.taux_mois(x);
		var a = accompte;
		var t = ((total - accompte) * y) / mensu;
		for(var i = 0; i < x; i++){
			a += t;
			if(a >= total){
				a = total;
			}
		}
		return a.toFixed(2);
	}*/
	// QUERY
	static query(query){
		return document.querySelector(query);
	}
	static queryAll(query){
		return document.querySelectorAll(query);
	}
	// STORAGE
	local_data(type, e, data){
		if(type === 'set') localStorage.setItem(e, this.setJSON(data));
		else if(type === 'get') this.data = this.getJSON(localStorage.getItem(e));
		else if(type === 'del') localStorage.removeItem(e);
		else if(type === 'del_all') localStorage.clear();
		else "error";
	}
	// STRING SANITIZE
	static htmlspecialchars(str) {
    	return String(str)
    		.replace(/&/g, '&amp;')
    		.replace(/</g, '&lt;')
    		.replace(/>/g, '&gt;')
    		.replace(/"/g, '&quot;')
    		.replace(/'/g, "&#039;")
    	;
	}
	static netChaineTXT(chaine, n){
		var chaineFinale = "";
		chaine.split();
		for(var i = 0; i < chaine.length; i++) if(chaine[i] != n) chaineFinale += chaine[i];
		return chaineFinale;
	}
	// SYNCHRONIZE
	static doubleSynchro(s, elem1, elem2){
		s.elem1.selectIndex = s.selectIndex;
		s.elem2.selectIndex = s.selectIndex;
	}
	// TABLE || array
	static in_array(list, val){
		return list.includes(val);
	}
	static is_array(array, type = null){
		if(Array.isArray(array)){
			if(type == 'assoc'){
				if(Object.values(array).length === 0) return false;
				for(let elem in array){
					if(/^[0-9]+$/.test(elem)) return false;
				}
				return true;
			} else return true;
		} else return false;
	}
	static doubleCompTable(x, a, y, b){
		return x.a > y.b ? 1 : x.a < y.b ? -1 : 0;
	}
	static isInTable(id, table, col, elem){
		for(var i in table) if(table[i].col == elem) return i;
		return -1;
	}
	static builtTable(id, cl, colId, colCl, col, elem, event, t, l, c){
		var colonne = function(col, colId, colCl, elem){
			return col === 'h' 
				? '<th id="' + colId + '" class="' + colCl + '"' + event + '>' + elem + '</th>' 
				: '<td id="' + colId + '" class="' + colCl + '"' + event + '>' + elem + '</td>'
			;	
		};
		var ligne = '<tr>' + colonne + '</tr>';
		var table = '<table id="' + id + '">' + ligne + '</table>';
		return t === true ? table : l === true ? ligne : c === true ? colonne : '';
	}
	static array_moyenne(array){
		var total = 0;
		var count = 0;
		var i = 0;
		for(i; i < array.length; i++){
			total += parseFloat(array[i]);
			count++;
		}
		var moyenne = total / count;
		return moyenne;
	}
	// TAG
	static tag(tag){
		return document.getElementsByTagName(tag);
	}
	// URL
	static redirect(url){
		location.assign(url);
	}
	static reload(){
		location.reload();
	}
	static ancre(url){
		return location.href;
	}
	static url_data(param_name){
		var url = new URL(location.href);
		var param_value = url.searchParams.get(param_name);
		return param_value != undefined || param_value != null ? param_value : null;
	}
	// VALUE
	static getValue(obj){
		return obj.value;
	}
	static setValue(obj, val){
		return obj.value = val;
	}
	static addValue(obj, val){
		return obj.value += val;
	}
	// WRITE
	static getHtml(obj){
		return obj.innerHTML;
	}
	static setHtml(obj, html){
		return obj.innerHTML = html;
	}
	static addHtml(obj, html){
		return obj.innerHTML += html;
	}
	static getText(obj){
		return obj.innerText;
	}
	static setText(obj, txt){
		return obj.innerText = text;
	}
	static addText(obj, txt){
		return obj.innerText += text;
	}
	static setTextContent(obj, txt){
		return obj.textContent = v;
	}
	static setWrite(obj, write){
		return obj.write = text;
	}
	static addWrite(obj, write){
		return obj.write += text;
	}
	// XMLHTTPREQUEST
	/* ajax
	Tools.ajax({
		method: 'post', // required
		url: './php/form/ajax_regexp.php', // required
		format: 'json', // required
		async: true, // default: true
		user: null, // default: null
		password: null, // default: null
		data: { // REQUEST data default: null
			regexp: type,
			value: elem.value
		}
		function: window[`verif_${type}`],
		params: ['RESPONSE', eleem]
	});

	static ajax_default = {
    	async: true,
    	class: null,
    	format: 'json',
		functions: {
			action: 'setHtml',
			response: 'response',
			xhr: 'onreadystatechange'
		},
		headers: {
			cache: '',
			mime: ''
		},
    	id: null,
		method: 'post',
		timeout: null,
		url: {
			action: '',
			param: ''
		},
    	success: null,
    	warning: null,
    	error: null
	};
	 */
	static ajax(ajax){
		let data = this.ajax_default;
		Object.keys(ajax).forEach(e => {
			data[e] = ajax[e];
		});
		return this.xhr(data);
	}
	/*
	static ajax_default = {
		async: true,
		format: 'json',
		method: 'post',
		url: './',
		params: {},
		xhr: 'onreadystatechange',
		function: {
			name: null,
			params: null
		},
		user: null,
		password: null
	};
	*/
	static xhr_object(){
		let xhr;
		try{
			try{
    			xhr = new ActiveXObject("Msxml2.XMLHTTP");
			}catch(e0){
    			try{
    				xhr = new ActiveXObject("Microsoft.XMLHTTP");
				}catch(e1){
    				xhr = new XMLHttpRequest();
				}
			}
		}catch(e){
			xhr = false;
		}
		return xhr;
	}
	static xhr(data){
		let format_list = {
			html: 'text/html',
			json: 'application/json',
			text: 'text/plain',
			xml: 'application/xml'
		};
		try{
			// let xhr = new XMLHttpRequest();
			let xhr = this.xhr_object();
			xhr.open(data.method, data.url + (data.method.toLowerCase() == 'get' ? '?' + data.params : ''), data.async, data.user, data.password);
			xhr.setRequestHeader("Content-Type", format_list[data.format.toLowerCase()]);
			xhr[data.xhr] = function(){
				if(xhr.readyState == 4 && xhr.status == 200){
					if(data.function.name != null) return window[data.function.name](this.responseText, data.function.params);
				} else return false;
			};
			xhr.send(data.method.toLowerCase() === 'post' ? this.setJSON(data.params) : '');
			return true;
		}catch(e){
			return false;
		}
    }
    /*static responseHTML(xhr, data){
		xhr.setRequestHeader("Content-Type", "text/html");
		xhr[data.xhr] = function(){
    		if(xhr.readyState == 4 && xhr.status == 200){
        		return this[ajax.functions.action.toLowerCase()](this.id(ajax.id), xhr.responseText);
        	} else return false;
		}
    }
    static responseJSON(xhr, data, key = 0){
		xhr.setRequestHeader("Content-Type", "application/json");
    	if(xhr.readyState == 4 && xhr.status == 200){
        	return this[ajax.functions.action.toLowerCase()](this.id(ajax.id), this.getJSON(xhr.responseText)[key]);
        } else return false;	
    }
    static responseTEXT(xhr, data, key = 0){
		xhr.setRequestHeader("Content-Type", "text/plain");
    	if(xhr.readyState == 4 && xhr.status == 200){
        	return this[ajax.functions.action.toLowerCase()](this.id(ajax.id), this.htmlspecialchars(xhr.responseText));
        } else return false;	
    }
    static responseXML(xhr, data, key = 0){
		xhr.setRequestHeader("Content-Type", "application/xml");
    	if(xhr.readyState == 4 && xhr.status == 200){
        	return this[ajax.functions.action.toLowerCase()](this.id(ajax.id), xhr.responseText.parseXML);
        } else return false;
    }*/
}
/*
// ===== fonctions XMLHttpRequest

function xhrReqJson(url, fct, id){
// passe la réponse de la requête ajax demandant la ressource url
// à la fonction fct pour l'élément id
  var xhr = new XMLHttpRequest(); // instancier XMLHttpRequest
  xhr.open('get', url, true);  	  // préparer
  xhr.onload =                    // callback : fonction anonyme
    function(){ 
      // invoque fct et formate le résultat json pour l'élément id  
      fct(JSON.parse(xhr.responseText), id); 
    }
  xhr.send()			  // envoyer
}
function xhrReqHtml(url, id, fct){
// place dans l'élément html d'identifiant id
// la réponse de la requête ajax demandant la ressource url
  var xhr = new XMLHttpRequest(); // instancier XMLHttpRequest
  xhr.open('get', url, true);  	  // préparer
  xhr.onload =                    // callback : fonction anonyme
    function(){  
      // place la réponse dans l'élément id
      setElem(id, xhr.responseText);  
      // s'il y a une fonction, l'invoquer  
      if(fct) fct();    
    }
  xhr.send()			  // envoyer
}
function xhrReqAtom(url, fct){
// invoque la fonction fct 
// et lui passe la réponse de la requête ajax demandant la ressource url
  var r;
  var xhr = new XMLHttpRequest(); // instancier XMLHttpRequest
  xhr.open('get', url, true);  	  // préparer
  xhr.onload =                    // callback : fonction anonyme
    function(){  
      // la réponse est atomique (un Array d'un seul objet avec une seule propriété)
      var r = JSON.parse(xhr.responseText)[0]; // le seul objet (le premier)
      r = r[Object.keys(r)];                   // la valeur de sa propriété
      // invoquer fct en lui passant cette valeur
      fct(r);      
    }
  xhr.send()			  // envoyer
}

-----------------------------------------------
// video
window.onload = function() {
	// Get the video.	
	var video = document.getElementById("myVideo");

	// Get the buttons.
	var playBtn = document.getElementById("playBtn");
	var pauseBtn = document.getElementById("pauseBtn");
	var seekBar = document.getElementById("seekBar");
	var volumeControl = document.getElementById("volume");
	var muteBtn = document.getElementById("muteBtn");

	// Add an event listener for the play button.
	playBtn.addEventListener("click", function(e) {
		// Play the video.
		video.play();
	});

	// Add an event listener for the pause button.
	pauseBtn.addEventListener("click", function(e) {
		// Pause the video.
		video.pause();
	});

	// Add an event listener for the seek bar.
	seekBar.addEventListener("change", function(e) {
		// Calculate the time in the video that playback 
    // should be moved to.
   	var time = video.duration * ( seekBar.value / 100 );

  	// Update the current time in the video.
  	video.currentTime = time;
	});

	// Update the seek bar as the video plays.
	video.addEventListener("timeupdate", function(e) {
		// Calculate the slider value.
		var value = ( 100 / video.duration ) * video.currentTime;

		// Updte the slider value.
		seekBar.value = value;
	});

	// Pause playback when the user starts seeking.
	seekBar.addEventListener("mousedown", function(e) {
		// Pause the video.
		video.pause();
	});

	// Continue playback when the user stops seeking.
	seekBar.addEventListener("mouseup", function(e) {
		// Play the video.
		video.play();
	});

	// Add an event listener for the volume control.
	volumeControl.addEventListener("change", function(e) {
		// Update the videos volume property.
		video.volume = volumeControl.value;
	});

	// Add an event listener for the mute button.
	muteBtn.addEventListener("click", function(e) {
		// Toggle the muted value.
		if (video.muted == true) {
			video.muted = false;
			muteBtn.textContent = "Mute";
		} else {
			video.muted = true;
			muteBtn.textContent = "Unmute";
		}
	});
}
 */


		/*try{
			try{
    			xhr = new ActiveXObject("Msxml2.XMLHTTP");
			}catch(e0){
    			try{
    				xhr = new ActiveXObject("Microsoft.XMLHTTP");
				}catch(e1){
    				xhr = new XMLHttpRequest();
				}
			}
		}catch(e){
			xhr = false;
		}finally{
			if(xhr){
				xhr[x.functions.xhr.toLowerCase()] = function(){
        			//Tools[x.format.toUpperCase() + x.functions.response.toLowerCase()](this, x);
        		}
				xhr.open(x.method.toLowerCase(), 
					x.url.action.toLowerCase() 
						+ (x.method.toLowerCase() == 'get' ? x.url.params.toLowerCase() : '')
					, x.async
				);
				xhr.send(x.method.toLowerCase() == 'post' ? x.url.params.toLowerCase() : '');
			} else return 'error !';
		}*/