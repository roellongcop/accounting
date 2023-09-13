let rotation = 0;
function rotateImg() {
	document.querySelector("#img").style.transform = 'rotate('+ rotation +'deg)';;
}

$('.rotate-left-btn').click(function() {
	rotation = rotation - 90;
	rotateImg();
});

$('.rotate-right-btn').click(function() {
	rotation = rotation + 90;
	rotateImg();
});