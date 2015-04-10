function searchToBookTransition(bookID)
{
	document.location.href = "book.php?id=" + bookID;
}

function removeFromCartButton(bookID)
{
	document.location.href = "basket.php?id=" + bookID;
}