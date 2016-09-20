@foreach($items as $item)
    <li @if($item->hasChildren())class ="dropdown"@endif>
        @if($item->getLink()!="") <a @if($item->hasChildren()) class="dropdown-toggle" data-toggle="dropdown" @endif href="{{ $item->getLink() }}">
            {!! $item->getTitle() !!}
            @if($item->hasChildren()) <b class="caret"></b> @endif
        </a>
        @else
            {!! $item->getTitle() !!}
        @endif
        @if($item->hasChildren())
            <ul class="dropdown-menu">
                @foreach($item->getChildren() as $child)
                    <li><a href="{{ $child->getLink() }}">{!! $child->getTitle() !!}</a></li>
                     @if($child->getDivider()==true)
                        <li class="divider"></li>
                    @endif
                @endforeach
            </ul>
        @endif
    </li>
   
@endforeach