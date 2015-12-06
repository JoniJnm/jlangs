<div autocomplete="off" class="form-horizontal">
	{foreach self as lang}
		<div class="form-group translation" data-id-lang="{lang.id_lang}">
			<form class="form" autocomplete="off">
				<label class="col-sm-1 control-label">{lang.lang_code}</label>
				<div class="col-md-8">
					<input required class="text form-control" type="text" value="{lang.text || ''}" />
				</div>
				<div class="col-md-3">
					<button class="btn btn-succes">Save</button>
					<button type="button" class="delete btn btn-danger">Delete</button>
				</div>
			</form>
		</div>
	{/foreach}
</div>