@isset($all)
@if (!empty($all))
<option value="0" data-desc=""{!! (App\Models\Util::collection_is_zero($selected) ? ' selected="selected"': '') !!}>
	{{ $all }}
</option>
@endif
@endisset
<?php
$cat = '';
?>
@foreach ($rows as $row)
	@isset($category)
		@if ($cat != $row[$category])
			<?php
				$cat = $row[$category];
			?>
			@if (!empty($cat))
				</optgroup>
			@endif
			<optgroup label="{{ $row[$category] }}">
		@endif
	@endisset
	<?php
	$tooltip = '';
	if (isset($desc)) {
		$tooltip = 'data-desc="'.e($row[$desc]).'"';
	}
	?>
<option value="{{ $row[$value] }}"{!! $tooltip !!} {!! (App\Models\Util::collection_has_value($selected, $row[$value]) ? ' selected="selected"': '') !!}>
@isset($prelabel)
	{{ (strlen($prelabel) > 0 ? $row[$prelabel].' : ' : '') }}
@endisset
{{ $row[$label] }}
</option>
@endforeach
@isset($category)
	</optgroup>
@endisset