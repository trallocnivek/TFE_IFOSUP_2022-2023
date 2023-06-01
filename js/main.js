/**
 * @site SwingShift
 * @domain http(s)://www.swingshift.be
 * @authors Collart Kevin
 * @uses files [utils-KC_ES6.js]
 * @version 2020/12/17 TO 13H27
 */
// NAV MANAGER (HAMBUEGER)
var header = Tools.query('header');
var nav = Tools.query('#hamburger_main');
var obj = Tools.query('#hamburger img');
var event = 'click';
function nav_hamburger(){
	// alert('KCtest function hamburger');
	if(obj != undefined && obj != null && nav != undefined && nav != null){
		// alert('exist');
		Tools.toggleClass(header, 'hamburger');
		Tools.toggleClass(nav, 'unfold');
	}else{
		console.log("ERROR #hamburger_main not exist !");
	}
};
Tools.addClass(header, 'hamburger');
Tools.addClass(nav, 'unfold');
Tools.addEvent(obj, event, nav_hamburger);