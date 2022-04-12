var input = document.getElementsById("email");

input.oninvalid = function(event) {
	event.target.setCustomValidity('Vui lòng nhập đúng địa chỉ mail!');
}

