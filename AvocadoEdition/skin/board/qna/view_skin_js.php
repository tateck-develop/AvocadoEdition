<script language='JavaScript'>
function comment_wri(name, id) { 
	var layer = document.getElementById(name+id); 
	layer.style.display = (layer.style.display == "none")? "block" : "none"; 
}

function comment_delete(url)
{
    if (confirm("이 코멘트를 삭제하시겠습니까?")) location.href = url;
}
</script>
