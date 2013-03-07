<div class="page-title">
    <h2 class="title"><?php if (Yii::app()->controller->action->id == 'update') { echo 'Редактировать словоформу'; } else { echo 'Создать новую словоформу'; } ?></h2>
</div>
<dl class="edit-page">
    <form>
        <dt>Не правильный вариант</dt>
        <dd><input type="text" name="badWord" class="inputbox" id="bw" value="<?php if (Yii::app()->controller->action->id == 'update') { echo $wf['bw']; } ?>" /></dd>
        <dd><div class='s_e' style="display: none;"></div></dd>
        <dt>Правильный вариант</dt>
        <dd><input type="text" name="badWord" class="inputbox" id="rw" value="<?php if (Yii::app()->controller->action->id == 'update') { echo $wf['rw']; } ?>" /></dd>
        <dd><div class='s_e' style="display: none;"></div></dd>
        <input type="hidden" name="id" value="<?php if (Yii::app()->controller->action->id == 'update') { echo $wf['id']; } ?>" id="wf" />
    </form>
</dl>
<div class="button-box">
    <table class="field-statistics">
        <tr>
            <td class="l"><a href="<?php echo Yii::app()->createUrl('admin/wordform'); ?>">Закрыть без сохранения</a></td>
            <td class="r"><input type="submit" value="Сохранить" id="wfSubmit"  /></td>
        </tr>
    </table>
</div>