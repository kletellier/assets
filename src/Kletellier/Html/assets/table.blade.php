@if($table->getIsResponsive())
<div class="table-responsive">
@endif
<table id="{{ $table->getId() }}" class="{{ $table->donneClasses() }}">
	<thead>
		<tr>
			@foreach ($table->getColonnes() as $colonne)
			<th class="{{ $colonne->donneClassesHead() }}">{!! $colonne->getTHEAD_Html() !!}</th>		
			@endforeach			 
		</tr>		
	</thead>
	<tbody id="{{ $table->getIdTbody() }}">
		@foreach ($table->getData() as $row)
		<tr>
			@foreach ($table->getColonnes() as $col)
				<td class="{{ $col->donneClasses() }} {!! $col->donneClassesFromData($row) !!} ">{!! $col->donneValeurTD($row) !!}</td>				 				
			@endforeach
		</tr>   
		@endforeach
	</tbody>
	@if($table->getHasFooter())
	<tfoot>
		<tr>
			@foreach ($table->getColonnes() as $colonne)
			<th class="{{ $colonne->donneClassesFooter() }}">{!! $colonne->getFooterValue() !!}</th>		
			@endforeach			 
		</tr>	
	</tfoot>
	@endif
</table>
@if($table->getIsResponsive())
</div>
@endif