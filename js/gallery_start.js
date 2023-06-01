class gallery{
	index = 0;
	img = [];
	url = '';
	title = '';
	get_gallery(id){
		try{
			let xhr = new XMLHttpRequest();
			xhr.open('get', './php/db/ajax_db_get.php?table=gallery_img&id=' + id, true);
			xhr.onreadystatechange = function(){
				if(this.readyState == 4 && this.status == 200){
					jean_pierre.img = JSON.parse(this.responseText);
					jean_pierre.print();
				}
			};
			xhr.send();
		}catch(e){
			Tools.css(Tools.id('loading'), 'display',  'none');
			Tools.css(Tools.id('defile_img'), 'display', 'none');
		}	
	}
	backward(){
		if(this.index == 0) this.index = this.img.length - 1;
		else this.index--;
		this.print();
	}
	forward(){
		if(this.index == this.img.length - 1) this.index = 0;
		else this.index++;
		this.print();
	}
	print(){
		let img = this.img[this.index];
		try{
			Tools.css(Tools.id('no_charge'), 'display', 'none');
			Tools.css(Tools.id('loading'), 'display',  'block');
			Tools.id('gallery_img_print').src = '.' + img.url;
			Tools.id('gallery_img_print').alt = img.url;
			Tools.id('gallery_img_print').title = img.url;
			Tools.id('gallery_img_descr').innerHTML = img.description;
			setTimeout(function(){jean_pierre.resize()}, 3000);
		}catch(e){
			Tools.css(Tools.id('no_charge'), 'display', 'block');
			Tools.css(Tools.id('loading'), 'display',  'none');
			Tools.css(Tools.id('gallery_img_print'), 'width', '50%');
			Tools.css(Tools.id('gallery_img_print'), 'margin', '0 auto');
		}
	}
	resize(){
		let figure = Tools.query('#print_img figure');
		let img = Tools.id('gallery_img_print');
		let figure_size = {x: figure.offsetWidth, y: figure.offsetHeight};
		let img_size = {x: img.offsetWidth, y: img.offsetHeight};
		let ratio = img.y / img.x;
		if(img_size.x < figure_size.x && img_size.y < figure_size.y){
			if(img_size.y > img_size.x) Tools.resize_img(img, figure_size.y * ratio);
			else Tools.resize_img(img, figure_size.x);
		}else if(img_size.x > figure_size.x || img_size.y > figure_size.y){
			if(img_size.y > img_size.x) Tools.resize_img(img, img_size.x / (img_size.y / figure_size.y));
			else Tools.resize_img(img, figure_size.x);
		}else console.log('rien');
		if(img.offsetWidth < figure.offsetWidth){
			let margin = (img.offsetWidth - figure.offsetWidth) / 2;
			Tools.css(img, 'margin',  '0 auto');
		}
		Tools.css(Tools.id('loading'), 'display',  'none');
	}
}