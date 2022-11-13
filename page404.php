<?php
use Views\Layout;
Layout::Header('Страница не найдена');
?>
	<div style="display: flex; flex-direction: column;align-items: center;width: 100%;">
		<h1 style="font-size: 50px;margin-top: 50px;font-weight: bold">Ошибка 404</h1>
		<span style="font-size: 25px">Такой страницы не существует</span>
	</div>
<?php
Layout::Footer();