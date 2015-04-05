function clearBasket()
{
	session_unset();
	session_destroy(); 
}