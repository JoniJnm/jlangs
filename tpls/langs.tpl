<div autocomplete="off" class="form-horizontal">
	{var useTextarea = false}
	{foreach self as lang}
		{#useTextarea |= lang.text && lang.text.indexOf("\n") !== -1}
	{/foreach}
	{foreach self as lang}
		<div class="form-group translation" data-id-lang="{lang.id_lang}">
			<form class="form" autocomplete="off">
				<label class="col-sm-1 control-label">{lang.lang_code}</label>
				<div class="col-md-8">
					{if useTextarea}
						<input required class="text disabled form-control" type="text" value="" />
						<textarea class="text enabled form-control">{lang.text || ''}</textarea>
					{else}
						<input required class="text enabled form-control" type="text" value="{lang.text || ''}" />
						<textarea class="text disabled form-control"></textarea>
					{/if}
				</div>
				<div class="col-md-3">
					<button tabindex="-1" class="save btn btn-success">Save</button>
					<button tabindex="-1" type="button" class="delete btn btn-danger">Clear</button>
				</div>
			</form>
		</div>
	{/foreach}
</div>