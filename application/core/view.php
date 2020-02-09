<?php

class View
{
	public $template_view; // шаблон по умолчанию.
	
	/**
     * Геренируем view
     *
	 * $content_file - виды отображающие контент страниц;
	 * $template_file - общий для всех страниц шаблон;
	 * $data - массив, содержащий элементы контента страницы. Обычно заполняется в модели.
	 */
	function generate($content_view, $template_view, $data = null)
	{
		
		if (!empty($data))
		if(is_array($data)) {			
			// преобразуем элементы массива в переменные
			extract($data);
		}

		include 'application/views/'.$template_view;
	}
}
