<div class="page-title">
    <h2 class="title">Создать нового пользователя</h2>
</div>

<?php
	echo $this->renderPartial('_form', array('model'=>$model,'profile'=>$profile));
?>