@if (count($breadcrumbs))

    <nav class="mb-4">

        <ol class="flex flex-wrap">
            @foreach ($breadcrumbs as $item)
            
                <li class="text-sm leading-normal text-theme-medium {{ !$loop->first ? "pl-2 before:float-left before:pr-2 before:content-['/'] before:text-theme-light" : '' }}">
                    
                    @isset($item['href'])
                        <a href="{{$item['href']}}" class="opacity-70 hover:opacity-100 hover:text-theme-accent transition-colors">
                            {{ $item['name'] }}
                        </a>
                    @else
                        <span class="text-theme-black font-medium">{{ $item['name'] }}</span>
                    @endisset

                </li>

            @endforeach

        </ol>

        @if (count($breadcrumbs) > 1)
            
            <h6 class="font-bold text-theme-black">
                {{ end($breadcrumbs)['name'] }}
            </h6>

        @endif
    </nav>

@endif