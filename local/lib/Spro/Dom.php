<?


namespace Spro;


class Dom
{
	public static function showField ( $field )
	{
		?>
		<div class="ui-block">
			<div class="ui-block__placeholder"><?=$field["NAME"]?></div>
			<label class="ui-label">
				<input type="text" class="ui-input" placeholder="<?=$field["DESCRIPTION"]?>"
					   name="ORDER_PROP_<?=$field["ID"]?>" value="<?=$_REQUEST[ 'ORDER_PROP_' . $field["ID"] ]?:$field['VALUE'][0]?>"/>
			</label>
		</div>
		<?php
	}
}
